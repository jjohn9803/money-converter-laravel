<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Transaction;

class TransactionFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = Transaction::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'from_acc' => $this->faker->word,
            'to_acc_id' => \App\Models\BankAccount::factory(),
            'from_bank' => $this->faker->word,
            'to_bank_id' => \App\Models\Bank::factory(),
            'fx_id' => \App\Models\Fx::factory(),
            'from_amount' => $this->faker->randomFloat(),
            'to_amount' => $this->faker->randomFloat(),
            'status' => $this->faker->randomNumber(),
        ];
    }
}
