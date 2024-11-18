<?php

namespace App\Rules;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class IsValidEventEndTime implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(private ?string $startTime)
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
        $endTime = Carbon::parse($value);
        $startTime = Carbon::parse($this->startTime);

        if ($startTime->floatDiffInDays($endTime) > 1) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The event duration must be a maximum of 24 hours';
    }
}
