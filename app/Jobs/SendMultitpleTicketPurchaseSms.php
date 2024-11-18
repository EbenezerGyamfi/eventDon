<?php

namespace App\Jobs;

use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;

class SendMultitpleTicketPurchaseSms implements ShouldQueue
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
    public function handle()
    {
        $tickets = $this->transaction
            ->tickets()->with(['event', 'ticketType'])->get();

        $event = $tickets->first()->event;

        $messages = [];

        for ($i = 0, $n = $tickets->count(); $i < $n; $i++) {
            $message = "{$event->name}  at {$event->venue} on {$event->start_time->format('F j, Y H:i A')}.\nPlease use this at the gate for verification.\n\n";

            $ticketNumber = $i + 1;
            $ticket = $tickets[$i];

            $qrUrl = URL::signedRoute(
                'ticket.scanQRCode',
                $ticket->id
            );

            $message = $message."Ticket {$ticketNumber}\nTicket Code {$ticket->code}\nTicket QR {$qrUrl}\n";

            array_push($messages, $message);
        }

        for ($i = 0; $i < count($messages); $i++) {
            Http::withHeaders([
                'api-key' => config('arkesel.apiKey'),
            ])->post(
                config('arkesel.apiUrl').'/v2/sms/send',
                [
                    'message' => $messages[$i],
                    'recipients' => [
                        $this->transaction->metadata['buyer_contact'],
                    ],
                    'sender' => config('app.sender'),
                    'sandbox' => config('arkesel.sandbox'),
                ]
            );
        }
    }
}
