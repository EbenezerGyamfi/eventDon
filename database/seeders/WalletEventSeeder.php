<?php

namespace Database\Seeders;

use App\Models\WalletEvent;
use Illuminate\Database\Seeder;

class WalletEventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        WalletEvent::factory()->count(10)->create();
    }
}
