<?php

namespace App\Rules;

use App\Models\User;
use App\Support\Phone\PhoneService;
use Illuminate\Contracts\Validation\Rule;

class IsUniquePhoneNumber implements Rule
{
    public function __construct(private ?int $ignoreId = null)
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
        $number = PhoneService::formatPhoneNumber($value);

        if (! is_null($this->ignoreId)) {
            return User::where('phone', $number)
                ->whereNotIn('id', [$this->ignoreId])
                ->doesntExist();
        }

        return User::where('phone', $number)->doesntExist();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The phone number has already been taken';
    }
}
