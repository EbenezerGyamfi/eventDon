<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Http;

class IsValidOtp implements Rule
{
    protected $phone;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($phoneNumber)
    {
        $this->phone = $phoneNumber;
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
        $response = Http::withHeaders([
            'api-key' => config('arkesel.apiKey'),
        ])
            ->acceptJson()
            ->post(config('arkesel.apiUrl').'/otp/verify', [
                'code' => $value,
                'number' => $this->phone,
            ]);

        if ($response->ok()) {
            $data = $response->json();

            if ($data['code'] == '1100') {
                return true;
            } else {
                return false;
            }
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The code is invalid';
    }
}
