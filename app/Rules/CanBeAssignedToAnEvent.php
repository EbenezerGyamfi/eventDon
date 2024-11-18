<?php

namespace App\Rules;

use App\Support\Users\UserService;
use Illuminate\Contracts\Validation\Rule;

class CanBeAssignedToAnEvent implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $user = auth()->user();

        $service = new UserService;

        $teller = $user->tellers()->where('id', $value)->first();

        return is_null($teller)
            ? false
            : $service->isTellerAvailable($teller);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The selected teller has been assigned to an event that is currently ongoing. Please select a different teller';
    }
}
