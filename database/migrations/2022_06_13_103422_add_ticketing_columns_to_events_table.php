<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTicketingColumnsToEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->boolean('ticketing')
                ->after('pre_registration_end_time')
                ->default(false);

            $table->foreignId('ticketing_ussd_extension_id')
                ->after('pre_registration_ussd_extension_id')
                ->nullable()
                ->constrained('ussd_extensions');

            $table->decimal('ticket_price')
                ->after('ticketing')
                ->nullable();

            $table->unsignedInteger('no_of_available_tickets')
                ->after('ticket_price')
                ->nullable();

            $table->timestamp('ticketing_start_time')
                ->after('ticketing_ussd_extension_id')->nullable();

            $table->timestamp('ticketing_end_time')
                ->after('ticketing_start_time')->nullable();
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
                'ticketing',
                'ticketing_ussd_extension_id',
                'ticket_price',
                'no_of_available_tickets',
                'ticketing_start_time',
                'ticketing_end_time',
            ]);
        });
    }
}
