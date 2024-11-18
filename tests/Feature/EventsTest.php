<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\FeatureSeeder;
use Database\Seeders\PlanSeeder;
use Database\Seeders\UssdExtensionSeeder;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EventsTest extends TestCase
{
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(UssdExtensionSeeder::class);
        $this->seed(FeatureSeeder::class);
        $this->seed(PlanSeeder::class);
    }

    public function test_an_event_can_be_created()
    {
        $user = $this->createUser();

        $response = $this->actingAs($user)
            ->post(
                route('events.store'),
                $this->generateEventData()
            );

        $response->assertSessionDoesntHaveErrors();

        $this->assertCount(1, $user->fresh()->events);
    }

    public function test_an_event_cant_be_deleted()
    {
        $user = $this->createUser();

        $this->createEvent($user);

        $response = $this->delete(route('events.destroy', $user->events()->first()->id));

        $response->assertSessionDoesntHaveErrors();

        $this->assertCount(1, $user->events);
    }

    public function test_an_event_can_be_updated()
    {
        $user = $this->createUser();

        $this->createEvent($user);

        $newName = $this->faker()->word();

        $event = $user->events()->first();

        $oldName = $event->name;

        $response = $this->post(
            route('events.update', $event->id),
            array_merge([
                'name' => $newName,
            ], $event->only(['venue', 'greeting_message', 'goodbye_message']))
        );

        $response->assertSessionDoesntHaveErrors();
        $this->assertNotEquals($oldName, $event->fresh()->name);
    }

    public function test_event_duration_can_be_updated()
    {
        $this->markTestSkipped();

        $user = $this->createUser();

        $this->createEvent($user);

        $event = $user->events()->first();

        $start_time = $event->start_time->toDateTimeString();

        $end_time = $event->end_time->toDateTimeString();

        $response = $this->post(
            route('events.update', $event->id),
            array_merge(
                [
                    'start_time' => now()->toDateTimeString(),
                    'end_time' => now()->addHours(12)->toDateTimeString(),
                ],
                $event->only([
                    'venue', 'greeting_message',
                    'goodbye_message', 'name',
                ])
            )
        );

        $response->assertSessionDoesntHaveErrors();

        $response->assertRedirect(route('events.index'));

        $this->assertNotEquals($start_time, $event->fresh()->start_time->toDateTimeString());

        $this->assertNotEquals($end_time, $event->fresh()->end_time->toDateTimeString());
    }

    private function createEvent($user, $attributes = [])
    {
        return $this->actingAs($user)
            ->post(
                route('events.store'),
                $this->generateEventData($attributes)
            );
    }

    private function generateEventData($attributes = [])
    {
        $data = [
            'name' => $this->faker->unique()->word(),
            'venue' => $this->faker->streetAddress(),
            'start_time' => now()->toDateTimeString(),
            'end_time' => now()
                ->addHours(20)
                ->toDateTimeString(),
            'expected_attendees' => $this->faker->randomElement(['100', '300', '1000']),
            'greeting_message' => $this->faker->sentence(),
            'goodbye_message' => $this->faker->sentence(),
            'questions' => [
                [
                    'title' => 'Name',
                    'question' => 'What is your name?',
                    'order' => 1,
                ],
            ],
            'type' => 'other',
        ];

        $data = array_merge($data, $attributes);

        return $data;
    }

    private function createUser()
    {
        $user = User::factory()->create([
            'role' => 'client',
        ]);

        $user->phone_number_verified = '1';

        $user->save();

        $user->wallets()->create([
            'balance' => config('eventsdon.eventCost') * 10,
            'currency' => 'GHS',
        ]);

        return $user;
    }
}
