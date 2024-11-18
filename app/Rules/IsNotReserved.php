<?php

namespace App\Rules;

use App\Models\Event;
use Illuminate\Contracts\Validation\Rule;

class IsNotReserved implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(private ?string $startTime = null, private ?string $endTime = null)
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
        return $this->notReserved($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This code has been reserved for this time period. Kindly pick a different code!';
    }

    private function notReserved(string $code): bool
    {
        if (! $this->startTime || ! $this->endTime) {
            return false;
        }

        return Event::with('ussdExtension')
            ->whereHas('ussdExtension', fn ($query) => $query->where('code', $code))
            ->InPeriod($this->startTime, $this->endTime)
            ->doesntExist();
    }
}
