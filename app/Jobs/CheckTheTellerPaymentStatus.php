<?php

namespace App\Jobs;

use App\Models\Transaction;
use App\Models\Wallet;
use App\Support\Payment\PaymentService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Client\Pool;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CheckTheTellerPaymentStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
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
        $transactions = Transaction::where([
            ['provider', '=', PaymentService::$PROVIDER_THETELLER],
            ['status', '=', Transaction::$PENDING],
        ])
            ->get();

        if (! $transactions->count()) {
            return;
        }

        $transactions->toQuery()->update(['status' => Transaction::$PROCESSING]);

        $responses = Http::pool(function (Pool $pool) use ($transactions) {
            $requests = [];

            $merchantId = config('theteller.merchantId');

            foreach ($transactions as $transaction) {
                array_push(
                    $requests,
                    $pool->as($transaction->reference)
                        ->withHeaders([
                            'Merchant-Id' => $merchantId,
                        ])
                        ->get(
                            config('theteller.apiUrl')
                                ."/v1.1/users/transactions/{$transaction->reference}/status"
                        )
                );
            }

            return $requests;
        });

        foreach ($responses as $reference => $response) {
            if (! $response->ok()) {
                Log::error($response);

                return;
            }

            $transaction = $transactions->where('reference', $reference)
                ->first();

            if (is_null($transaction)) {
                // report this
                return;
            }

            DB::transaction(function () use ($transaction, $response) {
                $status = match ($response->json('code')) {
                    '000' => Transaction::$SUCCESS,
                    '101', '105', '102' => Transaction::$FAILED,
                    '103', '104', '105' => Transaction::$FAILED,
                    '107', '114', '200' => Transaction::$FAILED,
                    // theteller returns 999 as number not a string
                    '100', 999 => Transaction::$FAILED,
                    default => Transaction::$PENDING
                };

                $transaction->update(['status' => $status]);

                if ($transaction->status != Transaction::$SUCCESS) {
                    return;
                }

                if (isset($transaction->metadata['itemId'])) {
                    $wallet = Wallet::findOrFail($transaction->metadata['itemId']);
                    $wallet->deposit($transaction->amount, 'Topup');

                    return;
                } else {
                    ProcessTicketPayment::dispatch($transaction);
                }
            });
        }
    }
}
