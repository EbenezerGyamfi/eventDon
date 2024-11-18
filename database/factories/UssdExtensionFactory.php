<?php

namespace Database\Factories;

use App\Models\UssdExtension;
use Illuminate\Database\Eloquent\Factories\Factory;

class UssdExtensionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UssdExtension::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code' => $this->faker->unique()->randomElement([
                '*928*20#',
                '*928*21#',
                '*928*22#',
                '*928*23#',
                '*928*24#',
                '*928*25#',
                '*928*26#',
                '*928*27#',
                '*928*28#',
                '*928*29#',
            ]),
        ];
    }
}
