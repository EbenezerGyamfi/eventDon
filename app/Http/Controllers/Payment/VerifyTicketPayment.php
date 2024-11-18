<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessTicketPayment;
use App\Models\Transaction;
use Illuminate\Http\Request;

class VerifyTicketPayment extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $transaction = Transaction::where('reference', $request->merchant_reference)->first();

        if (is_null($transaction)) {
            return;
        }

        if ($transaction->status == Transaction::$SUCCESS) {
            return;
        }

        $transaction->update([
            'status' => match ($request->status) {
                'success' => Transaction::$SUCCESS,
                'failed' => Transaction::$FAILED
            },
        ]);

        ProcessTicketPayment::dispatch($transaction);

        return response()->noContent();
    }
}
