<?php

namespace Database\Seeders;

use App\Models\UssdExtension;
use Illuminate\Database\Seeder;

class UssdExtensionSeeder extends Seeder
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

        foreach ($codes as $code) {
            UssdExtension::factory()->create([
                'code' => $code,
            ]);
        }

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
