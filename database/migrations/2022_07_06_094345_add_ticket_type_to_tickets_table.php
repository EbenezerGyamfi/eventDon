<?php

use App\Models\Event;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTicketTypeToTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->foreignId('ticket_type_id')
                ->nullable()
                ->after('event_id')
                ->constrained('ticket_types');
        });

        $events = Event::with('ticketTypes')
            ->where('ticketing', true)
            ->whereHas('tickets')
            ->get();

        foreach ($events as $event) {
            $event->tickets()->update([
                'ticket_type_id' => $event->ticketTypes->first()->id,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropConstrainedForeignId('ticket_type_id');
        });
    }
}
