<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'balance',
        'currency',
    ];

    protected $casts = [
        'balance' => 'decimal:2',
    ];

    public function deposit(float|int $amount, string $description)
    {
        $this->walletEvents()->create([
            'before_balance' => $this->balance,
            'after_balance' => $this->balance + $amount,
            'transaction_amount' => $amount,
            'type' => 'credited',
            'description' => $description,
        ]);

        $this->increment('balance', $amount);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function walletEvents(): HasMany
    {
        return $this->hasMany(WalletEvent::class);
    }
}
