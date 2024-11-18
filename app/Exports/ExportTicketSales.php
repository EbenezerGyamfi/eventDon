<?php

namespace App\Exports;

use App\Models\Event;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExportTicketSales implements FromCollection, WithMapping
{
    private $event;

    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->event->tickets;
    }

    public function map($ticket): array
    {
        return [
            $ticket->buyer_contact,
            $ticket->status,
            $ticket->ticketType->name,
            $ticket->transaction->reference,
            $ticket->amount,
            $ticket->no_of_tickets,
        ];
    }
}
