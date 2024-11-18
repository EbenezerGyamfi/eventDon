<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class DonationTransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //

            'msisdn' => $this->faker->word,
            'event_id' => $this->faker->randomElement([1, 2, 3, 4, 5]),
            'attendee_id' => $this->faker->randomElement([1, 2, 3, 4, 5]),
            'status' => $this->faker->randomElement(['pending', 'failed', 'success']),
            'description' => $this->faker->sentence,
            'amount' => $this->faker->numberBetween(100, 1000),
            'transaction_id' => $this->faker->randomElement([1, 2, 3, 4, 5]),
            'amount_after_charges' => $this->faker->numberBetween(100, 1000),
            'reference_id' => Str::random(7),
            'status_message' => Str::random(7),
        ];
    }
}
