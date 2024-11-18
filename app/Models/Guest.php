<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class Guest extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = ['phone', 'name', 'event_id', 'verified', 'verified_at', 'assigned_table_number'];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
