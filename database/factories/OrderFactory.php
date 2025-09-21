<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Quotation;
use App\Models\Warehouse;
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
        $discount = $this->faker->randomFloat(2, 0, $subtotal * 0.1); // Max 10% de remise
        $advancePaid = $this->faker->randomFloat(2, 0, $subtotal + $taxAmount - $discount);
        $totalAmount = $subtotal + $taxAmount - $discount;

        return [
            'company_id' => Company::factory(),
            'customer_id' => Customer::factory(),
            'warehouse_id' => Warehouse::factory(),
            'order_number' => 'CMD-' . $this->faker->unique()->numberBetween(1000, 9999),
            'status' => $this->faker->randomElement([
                OrderStatus::PENDING,
                OrderStatus::PAID,
                OrderStatus::DELIVERED,
                OrderStatus::CANCELLED,
            ]),
            'subtotal' => $subtotal,
            'discount' => $discount,
            'advance' => $advancePaid,
            'payment_status' => $this->faker->randomElement(PaymentStatus::cases()),
            'total_amount' => $totalAmount,
            'paid_at' => $this->faker->optional()->dateTimeBetween('-30 days', 'now'),
            'delivered_at' => null,
            'cancelled_at' => null,
        ];
    }

    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => OrderStatus::PENDING,
        ]);
    }

    /**
     * Indicate that the order is pending.
     */
    public function paid(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => OrderStatus::PAID,
            'paid_at' => $this->faker->dateTimeBetween('-30 days', 'now'),
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
            'paid_at' => $this->faker->dateTimeBetween('-30 days', '-3 days'),
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
            'paid_at' => null,
            'delivered_at' => null,
            'cancelled_at' => $this->faker->dateTimeBetween('-30 days', 'now'),
        ]);
    }
}
