<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Company;
use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class WarehouseFactory extends Factory
{
    protected $model = Warehouse::class;

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
            'location' => $this->faker->address(),
            'default' => $this->faker->boolean(),
        ];
    }

    public function default(): static
    {
        return $this->state(fn (array $attributes) => [
            'default' => true,
        ]);
    }
}
