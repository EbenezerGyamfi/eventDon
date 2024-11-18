<?php

namespace Database\Factories;
use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
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

            // $table->foreignId('transaction_id')->constrained('transactions');
            // $table->foreignId('event_id')->constrained('events');
            // $table->string('code')->unique();
            // $table->string('status'); // USED & UNUSED
            // $table->integer('no_of_tickets');
            // $table->decimal('amount');
            // $table->string('buyer_contact');


            'transaction_id' => $this->faker->randomElement([1, 5]),
            'event_id' => $this->faker->randomElement([1, 5]),
            'code' => Str::random(10),
            'status' => $this->faker->randomElement(['USED', 'UNUSED']),
            'no_of_tickets' => $this->faker->randomElement([1,10]),
            'amount' => $this->faker->randomElement([100, 1000]),
            'buyer_contact' => '+233'
        ];
    }
}
