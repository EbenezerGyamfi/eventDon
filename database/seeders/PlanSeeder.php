<?php

namespace Database\Seeders;

use App\Models\Feature;
use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $plans = [
            [
                'name' => 'starter',
                'price' => 0,
            ],
            [
                'name' => 'basic',
                'price' => 50,
            ],
            [
                'name' => 'mini',
                'price' => 100,
            ],
            [
                'name' => 'max',
                'price' => 250,
            ],
        ];

        // if(Plan::count()) {
        //     return;
        // }

        foreach ($plans as $p) {
            $plan = Plan::firstOrCreate($p);

            $plan->features()->attach(Feature::all());
            if ($p['name'] == 'starter') {
                foreach ($plan->features as $feature) {
                    if ($feature->name == 'number_of_attendees') {
                        $feature->pivot->value = 30;
                        $feature->pivot->save();
                    }

                    if ($feature->name == 'sms_credits') {
                        $feature->pivot->value = 0;
                        $feature->pivot->save();
                    }
                }
            }

            if ($p['name'] == 'basic') {
                $plan->features()->attach(Feature::all());

                foreach ($plan->features as $feature) {
                    if ($feature->name == 'number_of_attendees') {
                        $feature->pivot->value = 100;
                        $feature->pivot->save();
                    }

                    if ($feature->name == 'sms_credits') {
                        $feature->pivot->value = 600;
                        $feature->pivot->save();
                    }
                }
            }

            if ($p['name'] == 'mini') {
                $plan->features()->attach(Feature::all());

                foreach ($plan->features as $feature) {
                    if ($feature->name == 'number_of_attendees') {
                        $feature->pivot->value = 300;
                        $feature->pivot->save();
                    }

                    if ($feature->name == 'sms_credits') {
                        $feature->pivot->value = 1800;
                        $feature->pivot->save();
                    }
                }
            }

            if ($p['name'] == 'max') {
                $plan->features()->attach(Feature::all());

                foreach ($plan->features as $feature) {
                    if ($feature->name == 'number_of_attendees') {
                        $feature->pivot->value = 1000;
                        $feature->pivot->save();
                    }

                    if ($feature->name == 'sms_credits') {
                        $feature->pivot->value = 6000;
                        $feature->pivot->save();
                    }
                }
            }
        }
    }
}
