<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

class AddPlanIdToEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // seed the plans and features
        Artisan::call('db:seed', [
            '--class' => 'FeatureSeeder',
            '--force' => true,
        ]);

        Artisan::call('db:seed', [
            '--class' => 'PlanSeeder',
            '--force' => true,
        ]);

        Schema::table('events', function (Blueprint $table) {
            $table->foreignId('plan_id')
                ->default(1) // default to free plan
                ->after('contact_group_id')
                ->constrained('plans');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropConstrainedForeignId('plan_id');
        });
    }
}
