<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Account::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'type' => 'card',
            'account_number' => $this->faker->creditCardNumber('Visa'),
            'details' => ['card_type' => 'visa'],
            'user_id' => User::select('id')->inRandomOrder()->first()->id,
        ];
    }
}
