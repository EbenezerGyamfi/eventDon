<?php

use App\Models\Event;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class MoveAssignedUserColumnDataToEventTellersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('event_tellers')) {
            $events = Event::select('id', 'assigned_user')
                ->whereDoesntHave('tellers')
                ->whereNotNull('assigned_user')
                ->get()
                ->each(function ($event) {
                    $event->tellers()->attach($event->assigned_user);
                });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
