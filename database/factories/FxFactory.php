<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Fx;

class FxFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = Fx::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'currency_id' => \App\Models\Currency::factory(),
            'fx_rate' => $this->faker->randomFloat(),
            'status' => $this->faker->randomNumber(),
        ];
    }
}
