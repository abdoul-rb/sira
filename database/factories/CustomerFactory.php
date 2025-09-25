<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\CustomerType;
use App\Enums\TitleEnum;
use App\Models\Company;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'company_id' => Company::factory(),
            'type' => $this->faker->randomElement([CustomerType::LEAD, CustomerType::CUSTOMER]),
            'firstname' => $this->faker->firstName(),
            'lastname' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone_number' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'city' => $this->faker->city(),
            'zip_code' => $this->faker->postcode(),
            'country' => $this->faker->country(),
            'converted_at' => null,
        ];
    }

    /**
     * Indicate that the customer is a lead.
     */
    public function lead(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => CustomerType::LEAD,
            'converted_at' => null,
        ]);
    }

    /**
     * Indicate that the customer is a converted customer.
     */
    public function customer(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => CustomerType::CUSTOMER,
            'converted_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ]);
    }
}
