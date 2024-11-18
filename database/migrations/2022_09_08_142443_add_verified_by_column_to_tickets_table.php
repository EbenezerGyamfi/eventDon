<?php

use App\Models\Event;
use App\Models\Ticket;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVerifiedByColumnToTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->foreignId('verified_by')
                ->nullable()
                ->after('event_id')
                ->constrained('users', 'id');
        });

        $events = Event::select(['id', 'user_id'])
            ->has('tickets')
            ->where('ticketing', true)
            ->get();

        foreach ($events as $event) {
            $event->tickets()
                ->where('status', Ticket::$USED)
                ->update([
                    'verified_by' => $event->user_id,
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
            $table->dropConstrainedForeignId('verified_by');
        });
    }
}
