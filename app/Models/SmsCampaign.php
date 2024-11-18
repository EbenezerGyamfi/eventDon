<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SmsCampaign extends Model
{
    use HasFactory;
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event_id',
        'sender',
        'number_of_recipients',
        'scheduled_time',
        'completion_time',
        'status',
        'cost',
        'total_delivered',
    ];

    public function scopeScheduled(Builder $query): Builder
    {
        return $query->where('status', 'SCHEDULED');
    }

    public function scopeReady(Builder $query): Builder
    {
        return $query->where('status', 'SCHEDULED')
            ->where('scheduled_time', now()->toDateTimeString());
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function smsHistories(): HasMany
    {
        return $this->hasMany(SmsHistory::class);
    }
}
