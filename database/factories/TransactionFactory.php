<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
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

            // le->foreignId('user_id');
            // $table->foreignId('wallet_id');
            // $table->string('reference');
            // $table->double(column:'amount', places:2);
            // $table->string('description');
            // id	user_id	wallet_id	reference	amount	description	status	metadata	provider	hubtel_transaction_id	created_at	updated_at	
            'user_id' => $this->faker->randomElement([1, 5]),
            'wallet_id' => $this->faker->randomElement([1, 5]),
            'reference' => 'reference',
            'amount' => $this->faker->randomElement([100, 200]),
            'description' => 'description',
            'status' => $this->faker->randomElement(['pending', 'failed', 'success']),
            'metadata' => 'data',
            'provider' => 'provider',
            'hubtel_transaction_id' => 1

        ];
    }
}

