<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttendeeToDonate extends Model
{
    use HasFactory;

    protected $table = 'attendees_to_donate';

    protected $fillable = ['attendee_id', 'phone', 'event_id', 'ussd_session_id'];

    public function attendee(): BelongsTo
    {
        return $this->belongsTo(Attendee::class);
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
