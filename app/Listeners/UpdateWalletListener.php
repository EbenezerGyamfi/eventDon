<?php

namespace App\Listeners;

use App\Events\PaymentSuccessful;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Models\WalletEvent;
use Illuminate\Support\Facades\DB;

class UpdateWalletListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PaymentSuccessful  $event
     * @return void
     */
    public function handle(PaymentSuccessful $event)
    {
        $this->processWalletTopUp($event->paymentDetails['data']);
    }

    public function processWalletTopUp($data)
    {
        $wallet = Wallet::find($data['metadata']['itemId']);

        $prevBalance = $wallet->balance;

        $reference = $data['reference'];

        $transaction = Transaction::where('reference', $reference)->first();

        if (is_null($transaction)) {
            return;
        }

        if ($transaction->status == Transaction::$SUCCESS) {
            return;
        }

        DB::transaction(function () use ($prevBalance, $wallet, $transaction) {
            $wallet->increment('balance', $transaction->amount);

            WalletEvent::create([
                'wallet_id' => $wallet->id,
                'before_balance' => $prevBalance,
                'after_balance' => $prevBalance + $transaction->amount,
                'transaction_amount' => $transaction->amount,
                'type' => 'credited',
                'description' => 'Topup',
            ]);

            $transaction->update(['status' => Transaction::$SUCCESS]);
        }, 5);
    }
}
