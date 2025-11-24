<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Agent>
 */
class AgentFactory extends Factory
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
            'firstname' => $this->faker->firstName(),
            'lastname' => $this->faker->lastName(),
            'phone_number' => $this->faker->optional()->phoneNumber(),
            'localization' => $this->faker->optional()->address(),
            'active' => $this->faker->boolean(100),
        ];
    }
}
