<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends Model
{
    use HasFactory;

    public static string $SUCCESS = 'SUCCESS';

    public static string $PROCESSING = 'PROCESSING';

    public static string $PENDING = 'PENDING';

    public static string $FAILED = 'FAILED';

    protected $fillable = [
        'user_id', 'wallet_id', 'amount',
        'reference', 'description', 'paidAt',
        'status', 'metadata', 'provider',
        'hubtel_transaction_id',
    ];

    protected $casts = [
        'created_at' => 'immutable_datetime:Y-m-d H:i:s',
        'metadata' => 'array',
    ];

    public function scopeFilter(Builder $query, ?string $search): Builder
    {
        return $query->when($search, function ($query, $search) {
            return $query->where('reference', 'like', '%'.$search.'%');
        });
    }

    public function scopeDoesntExist(Builder $query): bool
    {
        return $query->count() === 0;
    }

    public function scopeSuccess(Builder $query): Builder
    {
        return $query->where('status', Transaction::$SUCCESS);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }
}
