<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\User;
use App\Support\Phone\PhoneService;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AccountTest extends TestCase
{
    use WithFaker;

    /**
     * @test
     */
    public function an_account_of_type_mobile_can_be_created()
    {
        $user = $this->createUser();

        $response = $this->actingAs($user)
            ->post(route('accounts.store'), [
                'name' => 'MTN momo',
                'type' => 'mobile',
                'account_number' => '0593393701',
                'network' => 'mtn',
            ]);

        $response->assertSessionDoesntHaveErrors();
        $this->assertCount(1, Account::all());
    }

    /**
     * @test
     */
    public function an_account_of_type_bank_can_be_created()
    {
        $user = $this->createUser();

        $response = $this->actingAs($user)
            ->post(route('accounts.store'), [
                'name' => 'Ecobank',
                'type' => 'bank',
                'account_number' => '002865933932381',
                'bank_name' => 'Ecobank',
                'bank_branch' => 'Kasoa',
            ]);

        $response->assertSessionDoesntHaveErrors();
        $this->assertCount(1, Account::all());
    }

    /**
     * @test
     */
    public function an_account_of_type_card_can_be_created()
    {
        $user = $this->createUser();

        $response = $this->actingAs($user)
            ->post(route('accounts.store'), [
                'name' => 'Card',
                'type' => 'card',
                'account_number' => $this->faker->creditCardNumber('Visa'),
                'card_type' => 'visa',
            ]);

        $response->assertSessionDoesntHaveErrors();
        $this->assertCount(1, Account::all());
    }

    /**
     * @test
     */
    public function an_account_of_type_wallet_can_be_created()
    {
        $user = $this->createUser();

        $response = $this->actingAs($user)
            ->post(route('accounts.store'), [
                'name' => 'Card',
                'type' => 'wallet',
            ]);

        $response->assertSessionDoesntHaveErrors();

        $this->assertCount(1, Account::all());
    }

    /**
     * @test
     */
    public function an_account_can_be_deleted()
    {
        $user = $this->createUser();

        $account = Account::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)
            ->get(route('accounts.destroy', $account->id));

        $response->assertSessionDoesntHaveErrors();
        $this->assertCount(0, Account::all());
    }

    /**
     * @test
     */
    public function an_account_of_type_card_can_be_edited()
    {
        $user = $this->createUser();

        $account = Account::factory()->create([
            'user_id' => $user->id,
        ]);

        $newAccountNumber = $this->faker->creditCardNumber('Visa');

        $response = $this->actingAs($user)
            ->put(route('accounts.update', $account->id), [
                'name' => $account->name,
                'type' => $account->type,
                'account_number' => $newAccountNumber,
                'card_type' => $account->details['card_type'],
            ]);

        $response->assertSessionDoesntHaveErrors();
        $this->assertEquals($newAccountNumber, Account::first()->account_number);
    }

    /**
     * @test
     */
    public function an_account_of_type_bank_can_be_edited()
    {
        $user = $this->createUser();

        $account = Account::create([
            'name' => 'Ecobank',
            'type' => 'bank',
            'account_number' => '002865933932381',
            'details' => [
                'bank_name' => 'Ecobank',
                'bank_branch' => 'Kasoa',
            ],
            'user_id' => $user->id,
        ]);

        $newAccountNumber = '002865893932381';

        $response = $this->actingAs($user)
            ->put(route('accounts.update', $account->id), [
                'name' => $account->name,
                'type' => $account->type,
                'account_number' => $newAccountNumber,
                'bank_name' => $account->details['bank_name'],
                'bank_branch' => $account->details['bank_branch'],
            ]);

        $response->assertSessionDoesntHaveErrors();
        $this->assertEquals($newAccountNumber, Account::first()->account_number);
    }

    /**
     * @test
     */
    public function an_account_of_type_mobile_can_be_edited()
    {
        $user = $this->createUser();

        $account = Account::create([
            'name' => 'MTN momo',
            'type' => 'mobile',
            'account_number' => '0593393701',
            'details' => [
                'network' => 'mtn',
            ],
            'user_id' => $user->id,
        ]);

        $newAccountNumber = '0266222234';

        $response = $this->actingAs($user)
            ->put(route('accounts.update', $account->id), [
                'name' => $account->name,
                'type' => $account->type,
                'account_number' => $newAccountNumber,
                'network' => 'airteltigo',
            ]);

        $response->assertSessionDoesntHaveErrors();
        $this->assertEquals(PhoneService::formatPhoneNumber($newAccountNumber), Account::first()->account_number);
    }

    private function createUser()
    {
        $user = User::factory()->create([
            'role' => 'client',
        ]);

        $user->phone_number_verified = '1';

        $user->save();

        return $user;
    }
}
