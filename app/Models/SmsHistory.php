<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class SmsHistory extends Model
{
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'user_id',
        'event_id',
        'campaign_id',
        'sms_id',
        'sender',
        'phone',
        'status',
        'message',
        'cost',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function smsCampaign(): BelongsTo
    {
        return $this->belongsTo(SmsCampaign::class);
    }
}
