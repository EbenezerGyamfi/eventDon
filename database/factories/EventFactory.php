<?php

namespace Database\Factories;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Event::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $startTime = new Carbon($this->faker->dateTimeBetween('-1 months', '+1 months'));
        $endTime = $startTime->copy()->addHours($this->faker->randomDigitNotZero());

        return [
            'name' => $this->faker->unique()->word(),
            'description' => $this->faker->paragraph(2),
            'venue' => $this->faker->streetAddress(),
            'start_time' => $startTime,
            'end_time' => $endTime,
            'expected_attendees' => $this->faker->randomNumber(3),
            'greeting_message' => $this->faker->sentence(),
            'goodbye_message' => $this->faker->sentence(),
        ];
    }
}
