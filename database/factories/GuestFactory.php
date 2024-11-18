<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\Guest;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class GuestFactory extends Factory
{
    protected $model = Guest::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'assigned_table_number' => $this->faker->word(),
            'phone' => $this->faker->phoneNumber(),
            'verified' => $this->faker->word(),
            'verified_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'event_id' => Event::factory(),
        ];
    }
}
