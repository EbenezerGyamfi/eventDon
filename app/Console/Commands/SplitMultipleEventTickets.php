<?php

namespace App\Console\Commands;

use App\Jobs\SendMultitpleTicketPurchaseSms;
use App\Models\Event;
use App\Models\Ticket;
use App\Support\Events\TicketService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SplitMultipleEventTickets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'eventsdon:split-tickets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Split multiptle ticket purchases into single ones';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $eventId = $this->ask('Please enter the event id');

        $event = Event::find($eventId);

        if (is_null(($event))) {
            $this->info('Event not found');

            return 0;
        }

        $tickets = $event->tickets()->where('no_of_tickets', '>', 1)->get();

        if ($tickets->count() == 0) {
            $this->info('This event doesn\'t have one ticket code for multiple tickets');

            return 0;
        }

        return DB::transaction(function () use ($tickets, $event) {
            foreach ($tickets as $ticket) {
                for ($i = 0, $n = $ticket->no_of_tickets - 1; $i < $n; $i++) {
                    $event->tickets()->create([
                        'transaction_id' => $ticket->transaction->id,
                        'ticket_type_id' => $ticket->ticket_type_id,
                        'no_of_tickets' => 1,
                        'code' => (new TicketService)->generateTicketCode(),
                        'status' => Ticket::$UNUSED,
                        'amount' => $ticket->amount / $ticket->no_of_tickets,
                        'buyer_contact' => $ticket->buyer_contact,
                        'created_at' => $ticket->created_at,
                        'updated_at' => $ticket->updated_at,
                    ]);
                }

                $ticket->update([
                    'no_of_tickets' => 1,
                    'amount' => $ticket->amount / $ticket->no_of_tickets,
                ]);

                SendMultitpleTicketPurchaseSms::dispatch($ticket->transaction);
            }

            $this->info('Tickets separated successfully');

            return 0;
        });
    }
}
