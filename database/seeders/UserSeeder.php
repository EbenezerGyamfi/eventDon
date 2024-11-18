<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\ContactGroup;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletEvent;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()
            ->has(
                Wallet::factory()
                    ->has(WalletEvent::factory()->count(3))
                    ->count(1),
            )
            ->has(
                ContactGroup::factory()
                    ->has(Contact::factory()->count(20))
                    ->count(2),
            )
            ->count(10)
            ->create();

        $this->command->call('create:user', [
            'role' => 'admin',
        ]);
    }
}
