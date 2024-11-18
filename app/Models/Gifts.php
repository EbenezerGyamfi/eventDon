<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Gifts extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'code',
        'type',
        'attendee_id',
        'name',
        'quantity',
        'received_by',
        'description',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function donor(): BelongsTo
    {
        return $this->belongsTo(Attendee::class, 'attendee_id', 'id');
    }

    public function teller(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'received_by');
    }

    public function updatedTeller(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }
}
