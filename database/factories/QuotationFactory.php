<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\QuotationStatus;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Quotation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Quotation>
 */
class QuotationFactory extends Factory
{
    protected $model = Quotation::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $subtotal = $this->faker->randomFloat(2, 100, 5000);
        $taxAmount = $subtotal * 0.18; // 18% de TVA
        $totalAmount = $subtotal + $taxAmount;

        return [
            'company_id' => Company::factory(),
            'customer_id' => Customer::factory(),
            'status' => $this->faker->randomElement([
                QuotationStatus::DRAFT,
                QuotationStatus::SENT,
                QuotationStatus::ACCEPTED,
                QuotationStatus::REJECTED,
            ]),
            'subtotal' => $subtotal,
            'tax_amount' => $taxAmount,
            'total_amount' => $totalAmount,
            'notes' => $this->faker->optional()->paragraph(),
            'valid_until' => $this->faker->dateTimeBetween('now', '+30 days'),
            'sent_at' => null,
            'accepted_at' => null,
            'rejected_at' => null,
        ];
    }

    /**
     * Indicate that the quotation is a draft.
     */
    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => QuotationStatus::DRAFT,
            'sent_at' => null,
            'accepted_at' => null,
            'rejected_at' => null,
        ]);
    }

    /**
     * Indicate that the quotation has been sent.
     */
    public function sent(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => QuotationStatus::SENT,
            'sent_at' => $this->faker->dateTimeBetween('-30 days', 'now'),
            'accepted_at' => null,
            'rejected_at' => null,
        ]);
    }

    /**
     * Indicate that the quotation has been accepted.
     */
    public function accepted(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => QuotationStatus::ACCEPTED,
            'sent_at' => $this->faker->dateTimeBetween('-30 days', '-1 day'),
            'accepted_at' => $this->faker->dateTimeBetween('-1 day', 'now'),
            'rejected_at' => null,
        ]);
    }

    /**
     * Indicate that the quotation has been rejected.
     */
    public function rejected(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => QuotationStatus::REJECTED,
            'sent_at' => $this->faker->dateTimeBetween('-30 days', '-1 day'),
            'accepted_at' => null,
            'rejected_at' => $this->faker->dateTimeBetween('-1 day', 'now'),
        ]);
    }
}
