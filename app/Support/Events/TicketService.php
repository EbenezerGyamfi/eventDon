<?php

namespace App\Support\Events;

use App\Models\Ticket;

class TicketService
{
    public function generateTicketCode(): string
    {
        do {
            $bytes = random_bytes(5);
            $code = bin2hex($bytes);
        } while (Ticket::where('code', $code)->exists());

        return $code;
    }
}
