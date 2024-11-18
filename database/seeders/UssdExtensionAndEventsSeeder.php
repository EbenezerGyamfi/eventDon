<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\User;
use App\Models\UssdExtension;
use Illuminate\Database\Seeder;

class UssdExtensionAndEventsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $codes = collect([
            '*928*20#',
            '*928*21#',
            '*928*22#',
            '*928*23#',
            '*928*24#',
            '*928*25#',
            '*928*26#',
            '*928*27#',
            '*928*28#',
            '*928*29#',
        ]);

        User::where('role', 'client')
            ->limit(4)
            ->get()
            ->each(
                fn ($user, $index) => UssdExtension::factory()
                    ->count(1)
                    ->state([
                        'code' => $codes[$index],
                    ])
                    ->has(
                        Event::factory()
                            ->count(random_int(1, 4))
                            ->hasQuestions(2)
                            ->for($user)
                    )->create()
            );

        $preRegistrationRangeStart = 30;

        $preRegistrationRangeEnd = 45;

        for ($i = $preRegistrationRangeStart; $i < $preRegistrationRangeEnd; $i++) {
            UssdExtension::create([
                'code' => '*928*'.$i.'#',
                'type' => UssdExtension::$REGISTRATION,
            ]);
        }

        $ticketingRangeStart = 46;

        $ticketingRangeEnd = 60;

        for ($i = $ticketingRangeStart; $i < $ticketingRangeEnd; $i++) {
            UssdExtension::create([
                'code' => '*928*'.$i.'#',
                'type' => UssdExtension::$TICKETING,
            ]);
        }
    }
}
