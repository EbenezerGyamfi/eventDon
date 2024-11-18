<?php

namespace App\Rules;

use App\Support\Phone\PhoneService;
use Illuminate\Contracts\Validation\Rule;

class IsUniqueAccountNumber implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(protected ?string $type)
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
        if ($this->type == 'mobile') {
            $number = PhoneService::formatPhoneNumber($value);

            return auth()->user()->accounts()->where('account_number', $number)->doesntExist();
        } else {
            return auth()->user()->accounts()->where('account_number', $value)->doesntExist();
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->type == 'mobile' ? 'The phone number has already been taken' : 'The account number has already been taken';
    }
}
