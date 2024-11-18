<?php

namespace App\Jobs;

use App\Models\Event;
use App\Models\Ticket;
use App\Models\Transaction;
use App\Support\Events\TicketService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class ProcessTicketPayment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(private Transaction $transaction)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(TicketService $ticketService)
    {
        DB::transaction(function () use ($ticketService) {
            if ($this->transaction->status == Transaction::$SUCCESS) {
                $event = Event::find($this->transaction->metadata['event_id']);
                $numberOfTickets = (int) $this->transaction->metadata['number_of_tickets'];

                for ($i = 0; $i < $numberOfTickets; $i++) {
                    $ticket = $event->tickets()->create([
                        'transaction_id' => $this->transaction->id,
                        'ticket_type_id' => $this->transaction->metadata['ticket_type_id'],
                        'no_of_tickets' => 1,
                        'code' => $ticketService->generateTicketCode(),
                        'status' => Ticket::$UNUSED,
                        'amount' => $this->transaction->amount / $numberOfTickets,
                        'buyer_contact' => $this->transaction->metadata['buyer_contact'],
                    ]);

                    if ($numberOfTickets == 1) {
                        SendSuccessfulTicketPurchaseSms::dispatch($ticket);
                    }
                }

                if ($numberOfTickets > 1) {
                    SendMultitpleTicketPurchaseSms::dispatch($this->transaction);
                }
            }
        });
    }
}
