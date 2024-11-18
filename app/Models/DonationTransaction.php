<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DonationTransaction extends Model
{
    use HasFactory;

    protected $fillable = ['msisdn', 'event_id', 'attendee_id', 'status', 'description', 'amount', 'transaction_id', 'amount_after_charges', 'reference_id', 'status_message'];

    protected $casts = [
        'created_at' => 'immutable_datetime',
        'updated_at' => 'immutable_datetime',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function attendee(): BelongsTo
    {
        return $this->belongsTo(Attendee::class);
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->where(['status' => 'pending']);
    }

    public function scopeFailed(Builder $query): Builder
    {
        return $query->where(['status' => 'failed']);
    }

    public function scopeSuccess(Builder $query): Builder
    {
        return $query->where(['status' => 'success']);
    }
}
