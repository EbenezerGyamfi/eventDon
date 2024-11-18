<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            UserSeeder::class,
            UssdExtensionAndEventsSeeder::class,
            AttendeeSeeder::class,
            FeatureSeeder::class,
            PlanSeeder::class,
            TransactionSeeder::class,
            TickerSeeder::class,
            TicketTypeSeeder::class
        ]);

        
    }
}
