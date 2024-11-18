<?php

use App\Models\Event;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events');
            $table->string('name');
            $table->decimal('price');
            $table->unsignedInteger('no_of_available_tickets');
            $table->timestamps();
        });

        $events = Event::where('ticketing', true)->get();

        foreach ($events as $event) {
            $event->ticketTypes()->create([
                'name' => 'regular',
                'price' => $event->ticket_price,
                'no_of_available_tickets' => $event->no_of_available_tickets,
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
        Schema::dropIfExists('ticket_types');
    }
}
