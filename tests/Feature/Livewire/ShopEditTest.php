<?php

declare(strict_types=1);

namespace Tests\Feature\Livewire;

use App\Livewire\Dashboard\Shop\Edit;
use App\Models\Company;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ShopEditTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_shop(): void
    {
        $company = Company::factory()->create();
        $user = User::factory()->create(['company_id' => $company->id]);

        $this->be($user);

        Livewire::test(Edit::class, ['tenant' => $company])
            ->set('name', 'Ma Boutique')
            ->set('description', 'Description de ma boutique')
            ->set('facebook_url', 'https://facebook.com/maboutique')
            ->set('instagram_url', 'https://instagram.com/maboutique')
            ->set('active', true)
            ->call('save')
            ->assertDispatched('close-modal', id: 'edit-shop')
            ->assertDispatched('shop-updated');

        $this->assertDatabaseHas('shops', [
            'company_id' => $company->id,
            'name' => 'Ma Boutique',
            'description' => 'Description de ma boutique',
            'facebook_url' => 'https://facebook.com/maboutique',
            'instagram_url' => 'https://instagram.com/maboutique',
            'active' => true,
        ]);
    }
}
