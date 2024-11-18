<?php

namespace App\Rules;

use App\Models\UssdExtension;
use Illuminate\Contracts\Validation\Rule;

class UssdCodeNotInUse implements Rule
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
        $ussdExtension = UssdExtension::where('code', $value);

        $end_date = $ussdExtension->events()->orderByDesc('end_date')->first()->end_time;

        return now()->diff($end_date)->invert ? true : false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This code is still in use please try again later';
    }
}
