<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TicketTypeFactory extends Factory
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
            // $table->id();
            // $table->foreignId('event_id')->constrained('events');
            // $table->string('name');
            // $table->decimal('price');
            // $table->unsignedInteger('no_of_available_tickets');
            // $table->timestamps();

            'event_id' => $this->faker->randomElement([1, 5]),
            'name' => $this->faker->name,
            'price'  => 100,
            'no_of_available_tickets' => 2
        ];
    }
}
