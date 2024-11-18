<?php

namespace App\Http\Controllers\Payment\Client;

use App\Events\PaymentSuccessful;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Paystack;

class VerifyPaystackPayment extends Controller
{
    public function __invoke()
    {
        try {
            $paymentDetails = Paystack::getPaymentData();

            event(new PaymentSuccessful($paymentDetails));

            return redirect(route('wallet-events.index'))->withMessage('Top up successfull');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            abort('404');
        }
    }
}
