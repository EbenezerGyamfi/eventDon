<?php

namespace App\Actions\Fortify;

use App\Rules\IsPhoneNumber;
use App\Rules\IsUniquePhoneNumber;
use App\Support\Phone\PhoneService;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    public function update($user, array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'phone' => [
                'bail',
                'required',
                'string',
                new IsPhoneNumber,
                new IsUniquePhoneNumber(auth()->id()),
            ],
            'avatar' => [
                'nullable',
                'image',
                'max:2048', // 2mb
                'mimes:jpeg,jpg,png',
            ],
        ])->validate();

        $newPhoneNumber = PhoneService::formatPhoneNumber($input['phone']);

        if ($newPhoneNumber != $user->phone) {
            $user->phone_number_verified = '0';
        }

        if (
            $input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail
        ) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill([
                'name' => $input['name'],
                'email' => $input['email'],
                'phone' => $newPhoneNumber,
            ])->save();
        }

        if (isset($input['avatar'])) {
            $path = $input['avatar']->store('avatars/'.$user->id, 'public');
            $user->update(['avatar' => $path]);
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  mixed  $user
     * @param  array  $input
     * @return void
     */
    protected function updateVerifiedUser($user, array $input)
    {
        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'phone' => PhoneService::formatPhoneNumber($input['phone']),
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
