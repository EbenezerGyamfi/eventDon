<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPreRegistrationToEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->foreignId('pre_registration_ussd_extension_id')
                ->nullable()
                ->after('ussd_extension_id')
                ->constrained('ussd_extensions');
            $table->boolean('can_pre_register')
                ->after('program_lineup')->default(false);
            $table->boolean('ask_pre_registration_questions')
                ->after('can_pre_register')->default(false);
            $table->timestamp('pre_registration_start_time')
                ->after('ask_pre_registration_questions')->nullable();
            $table->timestamp('pre_registration_end_time')
                ->after('pre_registration_start_time')->nullable();
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
            $table->dropColumn([
                'can_pre_register',
                'ask_pre_registration_questions',
                'pre_registration_start_time',
                'pre_registration_end_time',
            ]);
            $table->dropConstrainedForeignId('pre_registration_ussd_extension_id');
        });
    }
}
