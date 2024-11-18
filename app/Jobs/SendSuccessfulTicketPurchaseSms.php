<?php

namespace App\Jobs;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;

class SendSuccessfulTicketPurchaseSms implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(private Ticket $ticket)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $event = $this->ticket->event;
        $qrUrl = URL::signedRoute(
            'ticket.scanQRCode',
            $this->ticket->id
        );
        $message = "You have purchased {$this->ticket->no_of_tickets} {$this->ticket->ticketType->name} ticket for {$event->name}  at {$event->venue} on {$event->start_time->format('F j, Y H:i A')}.\nPlease use this at the gate for verification.\nTicket Code {$this->ticket->code}\nTicket QR {$qrUrl}";

        Http::withHeaders([
            'api-key' => config('arkesel.apiKey'),
        ])->post(
            config('arkesel.apiUrl').'/v2/sms/send',
            [
                'message' => $message,
                'recipients' => [
                    $this->ticket->buyer_contact,
                ],
                'sender' => config('app.sender'),
                'sandbox' => config('arkesel.sandbox'),
            ]
        );
    }
}
