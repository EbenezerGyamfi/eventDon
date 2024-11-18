<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Rules\IsPhoneNumber;
use App\Rules\IsUniquePhoneNumber;
use App\Rules\IsValidGoogleCaptcha;
use App\Support\Phone\PhoneService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make(
            $input,
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    Rule::unique(User::class),
                ],
                'password' => $this->passwordRules(),
                'phone' => [
                    'required',
                    'string',
                    new IsPhoneNumber,
                    new IsUniquePhoneNumber,
                ],
                'g-recaptcha-response' => ['required', new IsValidGoogleCaptcha],
            ],
            customAttributes: [
                'g-recaptcha-response' => 'captcha',
            ]
        )->validate();

        $number = PhoneService::formatPhoneNumber($input['phone']);

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'role' => 'client',
            'phone' => $number,
        ]);

        return $user;
    }
}
