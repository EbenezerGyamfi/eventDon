<?php

namespace App\Jobs;

use App\Models\Transaction;
use App\Models\WalletEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class ProcessArkeselPayment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(private array $data)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $transaction = Transaction::where('reference', $this->data['merchant_reference'])->first();

        if (is_null($transaction)) {
            return;
        }

        if ($transaction->status == Transaction::$SUCCESS) {
            return;
        }

        DB::transaction(function () use ($transaction) {
            $transaction->update([
                'status' => match ($this->data['status']) {
                    'success' => Transaction::$SUCCESS,
                    'failed' => Transaction::$FAILED
                },
            ]);

            if ($this->data['status'] == 'success') {
                $wallet = $transaction->wallet;

                WalletEvent::create([
                    'wallet_id' => $wallet->id,
                    'before_balance' => $wallet->balance,
                    'after_balance' => $wallet->balance + $transaction->amount,
                    'transaction_amount' => $transaction->amount,
                    'type' => 'credited',
                    'description' => 'Topup',
                ]);

                $wallet->increment('balance', $transaction->amount);
            }
        });
    }
}
