<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\OrderStatus;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Quotation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $subtotal = $this->faker->randomFloat(2, 100, 5000);
        $taxAmount = $subtotal * 0.18; // 18% de TVA
        $shippingCost = $this->faker->randomFloat(2, 0, 50);
        $totalAmount = $subtotal + $taxAmount + $shippingCost;

        return [
            'company_id' => Company::factory(),
            'customer_id' => Customer::factory(),
            'quotation_id' => null, // Peut être lié à un devis ou non
            'order_number' => 'CMD-' . $this->faker->unique()->numberBetween(1000, 9999),
            'status' => $this->faker->randomElement([
                OrderStatus::PENDING,
                OrderStatus::CONFIRMED,
                OrderStatus::IN_PREPARATION,
                OrderStatus::SHIPPED,
                OrderStatus::DELIVERED,
            ]),
            'subtotal' => $subtotal,
            'tax_amount' => $taxAmount,
            'shipping_cost' => $shippingCost,
            'total_amount' => $totalAmount,
            'shipping_address' => $this->faker->address(),
            'billing_address' => $this->faker->address(),
            'notes' => $this->faker->optional()->paragraph(),
            'confirmed_at' => null,
            'shipped_at' => null,
            'delivered_at' => null,
            'cancelled_at' => null,
        ];
    }

    /**
     * Indicate that the order is pending.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => OrderStatus::PENDING,
            'confirmed_at' => null,
            'shipped_at' => null,
            'delivered_at' => null,
            'cancelled_at' => null,
        ]);
    }

    /**
     * Indicate that the order is confirmed.
     */
    public function confirmed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => OrderStatus::CONFIRMED,
            'confirmed_at' => $this->faker->dateTimeBetween('-30 days', 'now'),
            'shipped_at' => null,
            'delivered_at' => null,
            'cancelled_at' => null,
        ]);
    }

    /**
     * Indicate that the order is in preparation.
     */
    public function inPreparation(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => OrderStatus::IN_PREPARATION,
            'confirmed_at' => $this->faker->dateTimeBetween('-30 days', '-1 day'),
            'shipped_at' => null,
            'delivered_at' => null,
            'cancelled_at' => null,
        ]);
    }

    /**
     * Indicate that the order has been shipped.
     */
    public function shipped(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => OrderStatus::SHIPPED,
            'confirmed_at' => $this->faker->dateTimeBetween('-30 days', '-2 days'),
            'shipped_at' => $this->faker->dateTimeBetween('-2 days', 'now'),
            'delivered_at' => null,
            'cancelled_at' => null,
        ]);
    }

    /**
     * Indicate that the order has been delivered.
     */
    public function delivered(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => OrderStatus::DELIVERED,
            'confirmed_at' => $this->faker->dateTimeBetween('-30 days', '-3 days'),
            'shipped_at' => $this->faker->dateTimeBetween('-3 days', '-1 day'),
            'delivered_at' => $this->faker->dateTimeBetween('-1 day', 'now'),
            'cancelled_at' => null,
        ]);
    }

    /**
     * Indicate that the order has been cancelled.
     */
    public function cancelled(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => OrderStatus::CANCELLED,
            'confirmed_at' => null,
            'shipped_at' => null,
            'delivered_at' => null,
            'cancelled_at' => $this->faker->dateTimeBetween('-30 days', 'now'),
        ]);
    }

    /**
     * Indicate that the order is from a quotation.
     */
    public function fromQuotation(): static
    {
        return $this->state(fn (array $attributes) => [
            'quotation_id' => Quotation::factory()->accepted(),
        ]);
    }
}
