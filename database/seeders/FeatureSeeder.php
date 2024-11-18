<?php

namespace Database\Seeders;

use App\Models\Feature;
use Illuminate\Database\Seeder;

class FeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $features = [
            'number_of_attendees',
            'sms_credits',
        ];

        foreach ($features as $feature) {
            Feature::firstOrCreate([
                'name' => $feature,
            ]);
        }
    }
}
