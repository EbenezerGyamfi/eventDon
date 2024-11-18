<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessTicketPayment;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;

class HandleHubtelWebhook extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $transaction = Transaction::where('reference', $request->Data['ClientReference'])
            ->firstOrFail();

        if ($transaction->status != Transaction::$PENDING) {
            return response()->noContent();
        }

        if ($request->ResponseCode == '0000') {
            $transaction->update([
                'status' => Transaction::$SUCCESS,
            ]);

            if (isset($transaction->metadata['itemId'])) {
                $wallet = Wallet::findOrFail($transaction->metadata['itemId']);
                $wallet->deposit($transaction->amount, 'Topup');

                return;
            } else {
                ProcessTicketPayment::dispatch($transaction);
            }
        } else {
            $transaction->update([
                'status' => Transaction::$FAILED,
            ]);
        }

        return response()->noContent();
    }
}
