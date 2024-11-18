<?php

namespace App\Support\Payment;

use App\Jobs\AttemptTheTellerPayment;
use App\Models\Transaction;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Unicodeveloper\Paystack\Paystack;

class PaymentService
{
    public static $PROVIDER_ARKESEL = 'arkesel';

    public static $PROVIDER_PAYSTACK = 'paystack';

    public static $PROVIDER_THETELLER = 'theteller';

    public static $PROVIDER_HUBTEL = 'hubtel';

    public function __construct(private string $provider)
    {
    }

    public function charge($paymentData): array
    {
        $paymentData = array_merge($paymentData, [
            'reference' => $this->generateReference(),
        ]);

        $transaction = Transaction::create([
            'reference' => $paymentData['reference'],
            'user_id' => auth()->id(),
            'wallet_id' => $paymentData['metadata']['itemId'] ?? null,
            'amount' => match ($this->provider) {
                'paystack' => $paymentData['amount'] / 100,
                default => $paymentData['amount']
            },
            'status' => Transaction::$PENDING,
            'description' => $paymentData['description'],
            'metadata' => $paymentData['metadata'],
            'provider' => $this->provider,
        ]);

        return match ($this->provider) {
            static::$PROVIDER_ARKESEL => $this->attemptArkeselPaymentCharge($paymentData, $transaction),
            static::$PROVIDER_PAYSTACK => $this->attemptPaystackCharge($paymentData),
            static::$PROVIDER_THETELLER => $this->attemptTheTellerCharge($paymentData, $transaction),
            static::$PROVIDER_HUBTEL => $this->attemptHubtelCharge($paymentData, $transaction)
        };
    }

    private function generateReference(): string
    {
        $reference = '';

        switch ($this->provider) {
            case static::$PROVIDER_THETELLER:
                $number = mt_rand(0, 999999999999);
                $reference = Str::padRight($number, 12, '0');
                break;

            default:
                $reference = (new Paystack)->genTranxRef();
        }

        return $reference;
    }

    public function attemptPaystackCharge($paymentData): array
    {
        $endpoint = config('paystack.paymentUrl').'/transaction/initialize';

        $response = $response = Http::asJson()
        ->withToken(config('paystack.secretKey'))
        ->post($endpoint, [
            'amount' => $paymentData['amount'],
            'email' => $paymentData['email'],
            'currency' => $paymentData['currency'] ?? 'GHS',
            'reference' => $paymentData['reference'],
            'metadata' => $paymentData['metadata'],
            'callback_url' => $paymentData['callback_url'],
            'channels' => ['card'],
        ]);

        $url = $response->json()['data']['authorization_url'];

        return [
            'redirect_url' => $url,
        ];
    }

    public function attemptArkeselPaymentCharge($paymentData, $transaction): array
    {
        $data = [
            'account_number' => $paymentData['account_number'],
            'merchant_reference' => $paymentData['reference'],
            'channel' => 'mobile-money',
            'provider' => $paymentData['provider'],
            'transaction_type' => 'debit',
            'amount' => $paymentData['amount'],
            'purpose' => $paymentData['description'],
            'service_name' => config('arkesel.payment.serviceName'),
            'currency' => 'GHS',
            'callback_url' => $paymentData['callback_url'],
        ];

        $response = Http::withHeaders([
            'api-key' => config('arkesel.payment.apiKey'),
        ])
            ->post(
                config('arkesel.payment.apiUrl').'/v1/payment/charge/initiate',
                $data
            );

        return $this->formatPaymentResponse(
            $response,
            $transaction
        );
    }

    public function attemptHubtelCharge($paymentData, $transaction): array
    {
        $authorization = 'Basic '.base64_encode(
            config('services.hubtel.api_id').':'.
            config('services.hubtel.key')
        );

        $endpoint = 'https://rmp.hubtel.com/merchantaccount/merchants/'
            .config('services.hubtel.sales_number')
            .'/receive/mobilemoney';

        $response = Http::withHeaders([
            'Authorization' => $authorization,
        ])
        ->post($endpoint, [
            'ClientReference' => $transaction->reference,
            'CustomerMsisdn' => $paymentData['account_number'],
            'Channel' => $this->getHubtelChannel($paymentData['provider']),
            'Amount' => $transaction->amount,
            'Description' => $transaction->description,
            'PrimaryCallbackURL' => route('payment.hubtel.webhook'),
        ]);

        if ($response->json('ResponseCode') == '0001') {
            $transaction->update([
                'hubtel_transaction_id' => $response->json('Data.TransactionId'),
            ]);
        } else {
            $transaction->update([
                'hubtel_transaction_id' => $response->json('Data.TransactionId'),
                'status' => Transaction::$FAILED,
            ]);
        }

        return $this->formatPaymentResponse($response, $transaction);
    }

    private function getHubtelChannel(string $channel): string
    {
        return match ($channel) {
            'mtn' => 'mtn-gh',
            'vodafone' => 'vodafone-gh',
            'airteltigo' => 'tigo-gh'
        };
    }

    public function attemptTheTellerCharge($paymentData, $transaction)
    {
        $rSwitch = $this->getTheTellerRSwitch($paymentData);

        $amount = Str::padLeft(
            $paymentData['amount'] * 100,
            12,
            '0'
        );

        $data = [
            'amount' => $amount,
            'processing_code' => config('theteller.codes.momoPayment'),
            'transaction_id' => $paymentData['reference'],
            'desc' => $paymentData['description'],
            'merchant_id' => config('theteller.merchantId'),
            'subscriber_number' => $paymentData['account_number'],
            'r-switch' => $rSwitch,
        ];

        $response = [];

        AttemptTheTellerPayment::dispatch($transaction, $data);

        return $this->formatPaymentResponse(
            $response,
            $transaction
        );
    }

    private function getTheTellerRSwitch($paymentData): string
    {
        $rSwitch = '';
        if ($paymentData['provider'] === 'airteltigo') {
            $phoneNumber = $paymentData['account_number'];
            if (
                str_contains($phoneNumber, '23326') ||
                str_contains($phoneNumber, '23356')
            ) {
                // Airtel number
                $rSwitch = 'ATL';

                return $rSwitch;
            }

            if (
                str_contains($phoneNumber, '23327') ||
                str_contains($phoneNumber, '23357')
            ) {
                // Tigo number
                $rSwitch = 'TGO';
            }
        } else {
            $rSwitch = match ($paymentData['provider']) {
                'mtn' => 'MTN',
                'vodafone' => 'VDF',
            };
        }

        return $rSwitch;
    }

    private function formatPaymentResponse($response, $transaction): array
    {
        $data = [];

        switch ($this->provider) {
            case static::$PROVIDER_THETELLER:
                $data = [
                    'status' => 'success',
                    'transaction' => $transaction,
                ];
                break;

            case static::$PROVIDER_ARKESEL:
                $data = [
                    'status' => $response->json('status'),
                    'transaction' => $transaction,
                    'providerResponse' => array_merge(
                        [],
                        $response->json()
                    ),
                ];
                break;

            case static::$PROVIDER_HUBTEL:
                $data = [
                    'status' => $response->json('ResponseCode') == '0001' ? 'success' : 'failed',
                    'transaction' => $transaction,
                    'providerResponse' => $response->json(),
                ];
        }

        return $data;
    }
}
