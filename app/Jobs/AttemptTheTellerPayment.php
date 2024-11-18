<?php

namespace App\Jobs;

use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class AttemptTheTellerPayment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     * Need to set this to at least 5 minutes or the job
     * will be killed before we get a response from
     * TheTeller's API
     */
    public $timeout = 360;

    private $paymentResponse;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        private Transaction $transaction,
        private array $paymentData
    ) {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $key = base64_encode(
            config('theteller.username')
                .':'
                .config('theteller.apiKey')
        );

        $endpoint = config('theteller.apiUrl')
            .'/v1.1/transaction/process';

        $this->paymentResponse = Http::withHeaders([
            'Authorization' => 'Basic '.$key,
        ])
            ->asJson()
            ->post($endpoint, $this->paymentData);

        if ($this->paymentResponse->json('code') != '000') {
            ReportFailedTheTellerPayment::dispatch($this->paymentResponse->json());
            $this->transaction->update([
                'status' => Transaction::$FAILED,
            ]);

            return;
        }

        $this->transaction->update([
            'status' => Transaction::$SUCCESS,
        ]);

        if (isset($this->transaction->metadata['itemId'])) {
            $wallet = Wallet::findOrFail($this->transaction->metadata['itemId']);
            $wallet->deposit($this->transaction->amount, 'Topup');

            return;
        } else {
            ProcessTicketPayment::dispatch($this->transaction);
        }
    }
}
