<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Company;
use App\Models\Member;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class TenantScopeTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_scopes_orders_by_tenant_using_bound_tenant()
    {
        // Create two companies
        $companyA = Company::factory()->create(['name' => 'Company A']);
        $companyB = Company::factory()->create(['name' => 'Company B']);

        // Create a user belonging to Company A
        $user = User::factory()->create();
        Member::factory()->create([
            'user_id' => $user->id,
            'company_id' => $companyA->id,
        ]);

        // Create orders for both companies
        $orderA = Order::factory()->create(['company_id' => $companyA->id]);
        $orderB = Order::factory()->create(['company_id' => $companyB->id]);

        // Login as the user
        $this->actingAs($user);
        
        // Simulate middleware binding
        app()->instance('currentTenant', $companyA);

        // Fetch all orders
        $orders = Order::all();

        // Assert that only Company A's order is returned
        $this->assertTrue($orders->contains($orderA));
        $this->assertFalse($orders->contains($orderB));
        $this->assertCount(1, $orders);
    }

    #[Test]
    public function it_scopes_orders_by_tenant_without_bound_tenant_fallback()
    {
        // Create two companies
        $companyA = Company::factory()->create(['name' => 'Company A']);
        $companyB = Company::factory()->create(['name' => 'Company B']);

        // Create a user belonging to Company A
        $user = User::factory()->create();
        Member::factory()->create([
            'user_id' => $user->id,
            'company_id' => $companyA->id,
        ]);

        // Create orders for both companies
        $orderA = Order::factory()->create(['company_id' => $companyA->id]);
        $orderB = Order::factory()->create(['company_id' => $companyB->id]);

        // Login as the user
        $this->actingAs($user);
        
        // Ensure currentTenant is NOT bound
        if (app()->bound('currentTenant')) {
            unset(app()['currentTenant']);
        }

        // Fetch all orders
        $orders = Order::all();

        // Assert that only Company A's order is returned
        $this->assertTrue($orders->contains($orderA));
        $this->assertFalse($orders->contains($orderB));
        $this->assertCount(1, $orders);
    }

    #[Test]
    public function it_returns_all_orders_if_unauthenticated()
    {
        // Create two companies
        $companyA = Company::factory()->create(['name' => 'Company A']);
        $companyB = Company::factory()->create(['name' => 'Company B']);

        // Create orders for both companies
        $orderA = Order::factory()->create(['company_id' => $companyA->id]);
        $orderB = Order::factory()->create(['company_id' => $companyB->id]);

        // No login

        // Fetch all orders
        $orders = Order::all();

        // Assert that ALL orders are returned
        $this->assertTrue($orders->contains($orderA));
        $this->assertTrue($orders->contains($orderB));
        $this->assertCount(2, $orders);
    }

    #[Test]
    public function it_returns_all_orders_for_superadmin()
    {
        // Create two companies
        $companyA = Company::factory()->create(['name' => 'Company A']);
        $companyB = Company::factory()->create(['name' => 'Company B']);

        // Create a superadmin user
        $user = User::factory()->create();
        // Assuming RoleEnum::SUPERADMIN exists and role seeding is done or we create it
        \Spatie\Permission\Models\Role::create(['name' => \App\Enums\RoleEnum::SUPERADMIN->value]);
        $user->assignRole(\App\Enums\RoleEnum::SUPERADMIN);

        // Create orders for both companies
        $orderA = Order::factory()->create(['company_id' => $companyA->id]);
        $orderB = Order::factory()->create(['company_id' => $companyB->id]);

        // Login as superadmin
        $this->actingAs($user);

        // Fetch all orders
        $orders = Order::all();

        // Assert that ALL orders are returned
        $this->assertTrue($orders->contains($orderA));
        $this->assertTrue($orders->contains($orderB));
        $this->assertCount(2, $orders);
    }
}
