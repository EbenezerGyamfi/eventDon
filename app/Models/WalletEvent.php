<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WalletEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'wallet_id',
        'description',
        'type',
        'before_balance',
        'after_balance',
        'transaction_amount',
    ];

    public function wallets(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }
}
