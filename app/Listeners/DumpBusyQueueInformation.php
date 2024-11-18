<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\Events\QueueBusy;

class DumpBusyQueueInformation implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(QueueBusy $event)
    {
        // Notification::route('mail', config('eventsdon.devMail'))
        //     ->notify(new QueueHasLongWaitTime(
        //         $event->connection,
        //         $event->queue,
        //         $event->size
        //     ));

        dump(
            'Queue is busy! ',
            $event->connection,
            $event->queue,
            $event->size
        );
    }
}
