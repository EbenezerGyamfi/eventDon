<?php

namespace Tests\Feature;

use App\Models\Transaction;
use App\Models\User;
use App\Support\Payment\PaymentService;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    public function test_payment_using_card_can_be_initiated()
    {
        $this->withoutExceptionHandling();

        $user = $this->createUser();

        Http::fake([
            config('paystack.paymentUrl').'/transaction/initialize' => Http::response(
                [
                    'status' => true,
                    'message' => 'Authorization URL created',
                    'data' => [
                        'authorization_url' => 'https://checkout.paystack.com/0peioxfhpn',
                        'access_code' => '0peioxfhpn',
                        'reference' => '7PVGX8MEk85tgeEpVDtD',
                    ],
                ],
                200
            ),
        ]);

        $response = $this->actingAs($user)
            ->post(route('payment.store'), [
                'amount' => 10,
                'channel' => 'card',
                'currency' => 'GHS',
                'itemId' => $user->mainWallet->id,
            ]);

        $response->assertSessionDoesntHaveErrors();

        $response->assertRedirect('https://checkout.paystack.com/0peioxfhpn');
    }

    public function test_payment_using_mobile_money_can_be_initiated()
    {
        $this->withoutExceptionHandling();

        $user = $this->createUser();

        Http::fake([
            'rmp.hubtel.com/*' => Http::response(
                [
                    'Message' => 'Transaction pending. Expect callback request for final state.',
                    'ResponseCode' => '0001',
                    'Data' => [
                        'TransactionId' => '5613515613131131315351351',
                        'Description' => 'wallet top up',
                        'ClientReference' => 'somerandomresferenece',
                        'Amount' => 0.11,
                        'Charges' => 0.01,
                        'AmountAfterCharges' => 0.1,
                        'AmountCharged' => 0.11,
                        'DeliveryFee' => 0,
                    ],
                ],
                200
            ),
        ]);

        $response = $this->actingAs($user)
            ->post(route('payment.store'), [
                'amount' => 10,
                'channel' => 'mobile_money',
                'currency' => 'GHS',
                'itemId' => $user->mainWallet->id,
                'account_number' => '0200200201',
                'provider' => 'vodafone',
            ]);

        $response->assertSessionDoesntHaveErrors();

        $transaction = Transaction::first();

        $this->assertEquals('5613515613131131315351351', $transaction->hubtel_transaction_id);

        $response->assertRedirect(route('payment.show', $transaction->id));
    }

    public function test_payment_wallet_top_using_hubtel_webhook()
    {
        $this->withoutExceptionHandling();

        $user = $this->createUser();

        $transaction = Transaction::factory()->create([
            'reference' => 'somereference',
            'user_id' => $user->id,
            'wallet_id' => $user->mainWallet->id,
            'amount' => 10,
            'status' => Transaction::$PENDING,
            'description' => 'wallet top up',
            'metadata' => [
                'itemId' => $user->mainWallet->id,
            ],
            'provider' => PaymentService::$PROVIDER_HUBTEL,
            'hubtel_transaction_id' => '02202353335353553',
        ]);

        $this->assertEquals(0.0, $user->mainWallet->balance);

        $response = $this->actingAs($user)
            ->post(route('payment.hubtel.webhook'), [
                'ResponseCode' => '0000',
                'Message' => 'success',
                'Data' => [
                    'Amount' => 10.1,
                    'Charges' => 0.1,
                    'AmountAfterCharges' => 10,
                    'Description' => 'The Vodafone Cash payment has been approved and processed successfully',
                    'ClientReference' => 'somereference',
                    'TransactionId' => '5313135313153351bkbk53335',
                    'ExternalTransactionId' => '02202353335353553',
                    'AmountCharged' => 10.1,
                    'OrderId' => '5313135313153351bkbk53335',
                ],
            ]);

        $response->assertSuccessful();

        $transaction = $transaction->fresh();

        $this->assertEquals(Transaction::$SUCCESS, $transaction->status);

        $this->assertEquals(10, $user->mainWallet->fresh()->balance);
    }

    public function test_wallet_wont_top_up_twice_using_hubtel_webhook()
    {
        $this->withoutExceptionHandling();

        $user = $this->createUser();

        $transaction = Transaction::factory()->create([
            'reference' => 'somereference',
            'user_id' => $user->id,
            'wallet_id' => $user->mainWallet->id,
            'amount' => 10,
            'status' => Transaction::$PENDING,
            'description' => 'wallet top up',
            'metadata' => [
                'itemId' => $user->mainWallet->id,
            ],
            'provider' => PaymentService::$PROVIDER_HUBTEL,
            'hubtel_transaction_id' => '02202353335353553',
        ]);

        $this->assertEquals(0.0, $user->mainWallet->balance);

        $this->actingAs($user)
            ->post(route('payment.hubtel.webhook'), [
                'ResponseCode' => '0000',
                'Message' => 'success',
                'Data' => [
                    'Amount' => 10.1,
                    'Charges' => 0.1,
                    'AmountAfterCharges' => 10,
                    'Description' => 'The Vodafone Cash payment has been approved and processed successfully',
                    'ClientReference' => 'somereference',
                    'TransactionId' => '5313135313153351bkbk53335',
                    'ExternalTransactionId' => '02202353335353553',
                    'AmountCharged' => 10.1,
                    'OrderId' => '5313135313153351bkbk53335',
                ],
            ]);

        $response = $this->actingAs($user)
            ->post(route('payment.hubtel.webhook'), [
                'ResponseCode' => '0000',
                'Message' => 'success',
                'Data' => [
                    'Amount' => 10.1,
                    'Charges' => 0.1,
                    'AmountAfterCharges' => 10,
                    'Description' => 'The Vodafone Cash payment has been approved and processed successfully',
                    'ClientReference' => 'somereference',
                    'TransactionId' => '5313135313153351bkbk53335',
                    'ExternalTransactionId' => '02202353335353553',
                    'AmountCharged' => 10.1,
                    'OrderId' => '5313135313153351bkbk53335',
                ],
            ]);

        $response->assertSuccessful();

        $transaction = $transaction->fresh();

        $this->assertEquals(Transaction::$SUCCESS, $transaction->status);

        $this->assertEquals(10, $user->mainWallet->fresh()->balance);
    }

    public function test_payment_was_successfull()
    {
        $this->markTestSkipped();
        $user = $this->createUser();

        $response = $this->get(route('payment.confirm').'?reference=pusg2d0fr7&trxref=pusg2d0fr7');

        $response->assertRedirect(route('wallet-events.index'));
        $this->assertEquals(10.0, $user->wallets()->first()->balance);
    }

    private function createUser()
    {
        $user = User::factory()->create([
            'role' => 'client',
        ]);

        $user->phone_number_verified = '1';

        $user->save();

        $user->wallets()->create([
            'balance' => 0.00,
            'currency' => 'GHS',
        ]);

        return $user;
    }
}
