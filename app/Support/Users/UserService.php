<?php

namespace App\Support\Users;

use App\Models\Transaction;
use App\Models\User;
use App\Models\WalletEvent;
use Illuminate\Support\Str;

class UserService
{
    public function isTellerAvailable(
        User $teller
    ): bool {
        $ongoingAssignedEvents = $teller->assignedEvents()->ongoing()->count();

        // user has been assigned to an ongoing event ?
        if ($ongoingAssignedEvents > 0) {
            // then bail
            return false;
        }

        return true;
    }

    public function chargeWallet(float $amount, string $description)
    {
        $wallet = auth()->user()->mainWallet;

        WalletEvent::create([
            'wallet_id' => $wallet->id,
            'before_balance' => $wallet->balance,
            'after_balance' => $wallet->balance - $amount,
            'transaction_amount' => $amount,
            'type' => 'debited',
            'description' => $description,
        ]);

        $wallet->decrement('balance', $amount);

        $reference = Str::random(12);

        while (! Transaction::where('reference', $reference)->doesntExist()) {
            $reference = Str::random(12);
        }

        Transaction::create([
            'reference' => $reference,
            'amount' => $amount,
            'wallet_id' => $wallet->id,
            'user_id' => auth()->id(),
            'description' => $description,
            'status' => Transaction::$SUCCESS,
        ]);
    }
}
