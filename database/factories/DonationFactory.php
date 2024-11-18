<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DonationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

            'event_id' => $this->faker->randomElement([1, 2, 3, 4, 5]),
            'user_id' => $this->faker->randomElement([1, 2, 3, 4, 5]),
            'attendee_id' => $this->faker->randomElement([1, 2, 3, 4, 5]),
            'name' => $this->faker->name,
            'phone' => $this->faker->phoneNumber(),
            'amount' => $this->faker->randomNumber(2),
        ];
    }
}
