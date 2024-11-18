<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Attendee;
use App\Models\Event;
use Illuminate\Database\Seeder;

class AttendeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Event::all()
            ->filter(fn (Event $event) => $event->status === 'completed')
            ->each(function (Event $event) {
                Attendee::factory()
                    ->count(100)
                    ->has(
                        Answer::factory()
                            ->count(1)
                            ->for($event->questions->random())
                    )
                    ->for($event)
                    ->create();
            });
    }
}
