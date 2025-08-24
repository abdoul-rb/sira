<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shop>
 */
class ShopFactory extends Factory
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
            'name' => $this->faker->company(),
            'slug' => $this->faker->slug(),
            'logo_path' => $this->faker->imageUrl(),
            'description' => $this->faker->paragraph(),
            'facebook_url' => $this->faker->url(),
            'instagram_url' => $this->faker->url(),
        ];
    }

    public function active(): static
    {
        return $this->state(function (array $attributes) {
            return ['active' => true];
        });
    }

    public function inactive(): static
    {
        return $this->state(function (array $attributes) {
            return ['active' => false];
        });
    }
}
