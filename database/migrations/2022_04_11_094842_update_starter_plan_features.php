<?php

use App\Models\Plan;
use Illuminate\Database\Migrations\Migration;

class UpdateStarterPlanFeatures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $plan = Plan::where('name', 'starter')->first();

        if (! is_null($plan)) {
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
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
