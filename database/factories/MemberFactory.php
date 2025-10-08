<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Company;
use App\Models\Member;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Member>
 */
class MemberFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Member::class;

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
            'firstname' => $this->faker->firstName(),
            'lastname' => $this->faker->lastName(),
            'phone_number' => $this->faker->optional()->phoneNumber(),
        ];
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
