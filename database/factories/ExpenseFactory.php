<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\ExpenseCategory;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Expense>
 */
class ExpenseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'company_id' => Company::factory(),
            'name' => $this->faker->words(3, true),
            'amount' => $this->faker->randomFloat(2, 100, 1000),
            'category' => $this->faker->randomElement(ExpenseCategory::cases()),
            'spent_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
