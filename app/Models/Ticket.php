<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id', 'event_id', 'ticket_type_id',
        'code', 'status', 'no_of_tickets',
        'amount', 'buyer_contact', 'verified_by',
        'created_at', 'updated_at',
    ];

    protected $casts = [
        'created_at' => 'immutable_datetime:Y-m-d H:i:s',
    ];

    public static $UNUSED = 'unused';

    public static $USED = 'used';

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    public function ticketType(): BelongsTo
    {
        return $this->belongsTo(TicketType::class);
    }

    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
