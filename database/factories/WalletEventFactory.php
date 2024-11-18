<?php

namespace Database\Factories;

use App\Models\WalletEvent;
use Illuminate\Database\Eloquent\Factories\Factory;

class WalletEventFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = WalletEvent::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'description' => $this->faker->randomElement([
                'Paid for an event',
                'Sent an SMS message',
                'Sent a voice message',
                'Balance top up',
            ]),
            'before_balance' => $this->faker->randomNumber(2),
            'type' => $this->faker->randomElement(['credited', 'debited']),
            'transaction_amount' => $this->faker->randomNumber(2),
            'after_balance' => $this->faker->randomNumber(2),
        ];
    }
}
