<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberUtil;

class IsPhoneNumber implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(protected  ?string $carrier = null)
    {
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
        $phoneUtil = PhoneNumberUtil::getInstance();
        try {
            $number = $phoneUtil->parse($value, 'GH');

            return $phoneUtil->isValidNumber($number);
        } catch (NumberParseException $e) {
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The phone number is invalid';
    }
}
