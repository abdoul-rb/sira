<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class DepositFactory extends Factory
{
    public function definition(): array
    {
        return [
            'company_id' => Company::factory(),
            'reference' => $this->faker->unique()->numberBetween(1000, 9999),
            'label' => $this->faker->words(3, true),
            'amount' => $this->faker->randomFloat(2, 100, 1000),
            'deposited_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'bank' => $this->faker->words(2, true),
        ];
    }
}
