<?php

namespace App\Http\Controllers\Payment\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentRequest;
use App\Models\Transaction;
use App\Support\Payment\PaymentService;
use App\Support\Phone\PhoneService;

class PaymentController extends Controller
{
    public function store(PaymentRequest $request)
    {
        try {
            $paymentProvider = match ($request->input('channel')) {
                'mobile_money' => PaymentService::$PROVIDER_HUBTEL,
                default => 'paystack'
            };

            $data = [
                'currency' => $request->currency,
                'email' => auth()->user()->email,
                'channels' => [$request->channel],
                'metadata' => [
                    'itemId' => $request->itemId,
                ],
                'description' => 'wallet top up',
            ];

            $data = match ($paymentProvider) {
                PaymentService::$PROVIDER_PAYSTACK => array_merge($data, [
                    'amount' => floatval($request->amount) * 100,
                    'callback_url' => route('payment.confirm'),
                ]),
                PaymentService::$PROVIDER_THETELLER => array_merge($data, [
                    'amount' => floatval($request->amount),
                    'account_number' => substr(
                        PhoneService::formatPhoneNumber($request->account_number),
                        '1'
                    ),
                    'provider' => $request->provider,
                ]),
                PaymentService::$PROVIDER_HUBTEL => array_merge($data, [
                    'amount' => floatval($request->amount),
                    'account_number' => substr(
                        PhoneService::formatPhoneNumber($request->account_number),
                        '1'
                    ),
                    'provider' => $request->provider,
                ])
            };

            $paymentService = new PaymentService($paymentProvider);

            $response = $paymentService->charge($data);

            if ($paymentProvider === 'paystack') {
                return redirect($response['redirect_url']);
            } else {
                return match ($response['status']) {
                    'success' => redirect()->route('payment.show', $response['transaction']->id),
                    default => back()->with('error', 'The payment could not be initiated. Please refresh your page and try again')
                };
            }
        } catch (\Exception $e) {
            report($e);

            return back()->withErrors(['error' => 'The payment could not be initiated. Please refresh your page and try again']);
        }
    }

    public function show(Transaction $transaction)
    {
        if ($transaction->status != Transaction::$PENDING) {
            return redirect()->route('wallet-events.index');
        }

        return view('client.payment.show', [
            'transaction' => $transaction,
            'page_title' => 'Confirm payment',
        ]);
    }

    public function status(Transaction $transaction)
    {
        return response()->json(['status' => $transaction->status]);
    }
}
