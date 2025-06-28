<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Employee::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'company_id' => Company::factory(),
            'position' => fake()->jobTitle(),
            'department' => fake()->randomElement(['Ventes', 'Marketing', 'RH', 'Finance', 'IT', 'Opérations']),
            'hire_date' => fake()->dateTimeBetween('-2 years', 'now'),
            'active' => true,
        ];
    }

    /**
     * Indique que l'employé est inactif
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'active' => false,
        ]);
    }

    /**
     * Crée un employé avec un utilisateur et une company existants
     */
    public function forUserAndCompany(User $user, Company $company): static
    {
        return $this->state(fn (array $attributes) => [
            'user_id' => $user->id,
            'company_id' => $company->id,
        ]);
    }
}
