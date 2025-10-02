<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Company;
use App\Models\Supplier;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Purchase>
 */
class PurchaseFactory extends Factory
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
            'supplier_id' => Supplier::factory(),
            'amount' => $this->faker->randomFloat(2, 100, 1000),
            'details' => $this->faker->optional()->paragraph(),
            'purchased_at' => $this->faker->optional()->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
