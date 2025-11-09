<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\SettingController;
use App\Livewire\Auth\SetupPassword;
use App\Livewire\Dashboard\Agent\AddModal as AddAgentModal;
use App\Livewire\Dashboard\Agent\Edit as AgentEdit;
use App\Livewire\Dashboard\Agent\Index as AgentIndex;
use App\Livewire\Dashboard\Customers\Index as CustomerIndex;
use App\Livewire\Dashboard\Members\Create as MemberCreate;
use App\Livewire\Dashboard\Members\Edit as MemberEdit;
use App\Livewire\Dashboard\Members\Index as MemberIndex;
use App\Livewire\Dashboard\Order\Create as OrderCreate;
use App\Livewire\Dashboard\Order\Edit as OrderEdit;
use App\Livewire\Dashboard\Order\Index as OrderIndex;
use App\Livewire\Dashboard\Products\Create as ProductCreate;
use App\Livewire\Dashboard\Products\Edit as ProductEdit;
use App\Livewire\Dashboard\Products\Index as ProductIndex;
use App\Livewire\Dashboard\Settings\Shop as ShopSetting;
use App\Livewire\Dashboard\Settings\Suppliers\Index as SupplierIndex;
use App\Livewire\Dashboard\Settings\Deposits\Index as DepositIndex;
use App\Livewire\Dashboard\Settings\Expenses\Index as ExpenseIndex;
use App\Livewire\Dashboard\Settings\Warehouses\Index as WarehouseIndex;
use App\Livewire\Profile\Index as ProfileIndex;
use App\Livewire\Public\Shop as ShopPublic;
use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard\Purchase\Index as PurchaseIndex;

Route::view('/', 'welcome')->name('home');

require __DIR__ . '/auth.php';

// domain('{tenant}.' . config('app.url'))
// Route::prefix('{tenant}/dashboard')->name('dashboard.')
Route::prefix('{tenant}')
    ->middleware(['auth', 'tenant'])
    ->group(function () {
    Route::name('dashboard.')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('index');

        Route::prefix('dashboard')->group(function () {
            Route::get('profile', ProfileIndex::class)->name('profile.index');

            // Purchases
            Route::prefix('purchases')->name('purchases.')->group(function () {
                Route::get('', PurchaseIndex::class)->name('index');
            });

            // CRUD Customer (Livewire)
            Route::get('customers', CustomerIndex::class)->name('customers.index');

            // CRUD Agent (Livewire)
            Route::prefix('agents')->name('agents.')->group(function () {
                Route::get('', AgentIndex::class)->name('index');
                Route::get('create', AddAgentModal::class)->name('create');
                Route::get('{agent}/edit', AgentEdit::class)->name('edit');
            });

            // CRUD Product (Livewire)
            Route::prefix('products')->name('products.')->group(function () {
                Route::get('', ProductIndex::class)->name('index');
                Route::get('create', ProductCreate::class)->name('create');
                Route::get('{product}/edit', ProductEdit::class)->name('edit');
            });

            // CRUD Order (Livewire)
            Route::prefix('orders')->name('orders.')->group(function () {
                Route::get('', OrderIndex::class)->name('index');
                Route::get('create', OrderCreate::class)->name('create');
                Route::get('{order}/edit', OrderEdit::class)->name('edit');
            });

            // CRUD Membre (Livewire)
            Route::prefix('members')->name('members.')->group(function () {
                Route::get('', MemberIndex::class)->name('index');
                Route::get('create', MemberCreate::class)->name('create');
                Route::get('{member}/edit', MemberEdit::class)->name('edit');
            });

            // Paramètres / settings.suppliers.index
            Route::prefix('settings')->name('settings.')->group(function () {
                Route::get('', [SettingController::class, 'index'])->name('index');

                // Warehouse (Livewire)
                Route::get('warehouses', WarehouseIndex::class)->name('warehouses.index');

                // Fournisseurs
                Route::get('suppliers', SupplierIndex::class)->name('suppliers.index');

                // Versements
                Route::get('deposits', DepositIndex::class)->name('deposits.index');

                // Dépenses
                Route::get('expenses', ExpenseIndex::class)->name('expenses.index');

                // Shop (Livewire)
                Route::get('shop', ShopSetting::class)->name('shop');
            });

            // Route pour la configuration du mot de passe des employés
            Route::get('member/setup-password/{user}', SetupPassword::class)->name('members.setup-password');

        });
    });

    Route::get('shop/{shopSlug}', ShopPublic::class)->name('shop.public');
});
