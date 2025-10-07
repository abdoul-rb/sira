<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\SettingController;
use App\Livewire\Auth\SetupPassword;
use App\Livewire\Dashboard\Agent\AddModal as AddAgentModal;
use App\Livewire\Dashboard\Agent\Edit as AgentEdit;
use App\Livewire\Dashboard\Agent\Index as AgentIndex;
use App\Livewire\Dashboard\Customer\Edit as CustomerEdit;
use App\Livewire\Dashboard\Customer\Index as CustomerIndex;
use App\Livewire\Dashboard\Employee\Create as EmployeeCreate;
use App\Livewire\Dashboard\Employee\Edit as EmployeeEdit;
use App\Livewire\Dashboard\Employee\Index as EmployeeIndex;
use App\Livewire\Dashboard\Order\Create as OrderCreate;
use App\Livewire\Dashboard\Order\Edit as OrderEdit;
use App\Livewire\Dashboard\Order\Index as OrderIndex;
use App\Livewire\Dashboard\Product\Create as ProductCreate;
use App\Livewire\Dashboard\Product\Edit as ProductEdit;
use App\Livewire\Dashboard\Product\Index as ProductIndex;
use App\Livewire\Dashboard\Settings\Shop as ShopSetting;
use App\Livewire\Dashboard\Settings\Suppliers\Index as SupplierIndex;
use App\Livewire\Dashboard\Settings\Deposits\Index as DepositIndex;
use App\Livewire\Dashboard\Settings\Expenses\Index as ExpenseIndex;
use App\Livewire\Dashboard\Settings\Warehouse\Index as WarehouseIndex;
use App\Livewire\Profile\Index as ProfileIndex;
use App\Livewire\Public\Shop as ShopPublic;
use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard\Purchase\Index as PurchaseIndex;

Route::view('/', 'welcome')->name('home');

require __DIR__ . '/auth.php';

Route::domain('{tenant}.' . config('app.url'))->middleware(['auth'])->group(function () {
    // Route publique pour les boutiques
    Route::get('shop/{shopSlug}', ShopPublic::class)->name('shop.public');

    Route::name('dashboard.')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('index');

        Route::prefix('dashboard')->group(function () {
            Route::get('profile', ProfileIndex::class)->name('profile.index');

            // Purchases
            Route::prefix('purchases')->name('purchases.')->group(function () {
                Route::get('', PurchaseIndex::class)->name('index');
            });

            // CRUD Customer (Livewire)
            Route::prefix('customers')->name('customers.')->group(function () {
                Route::get('', CustomerIndex::class)->name('index');
                Route::get('{customer}/edit', CustomerEdit::class)->name('edit');
            });

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

            // CRUD Employee (Livewire)
            Route::prefix('employees')->name('employees.')->group(function () {
                Route::get('', EmployeeIndex::class)->name('index');
                Route::get('create', EmployeeCreate::class)->name('create');
                Route::get('{employee}/edit', EmployeeEdit::class)->name('edit');
            });

            // Paramètres / settings.suppliers.index
            Route::prefix('settings')->name('settings.')->group(function () {
                Route::get('', [SettingController::class, 'index'])->name('index');

                // Warehouse (Livewire)
                Route::prefix('warehouses')->name('warehouses.')->group(function () {
                    Route::get('', WarehouseIndex::class)->name('index');
                });

                // Fournisseurs
                Route::prefix('suppliers')->name('suppliers.')->group(function () {
                    Route::get('', SupplierIndex::class)->name('index');
                });

                // Versements
                Route::prefix('deposits')->name('deposits.')->group(function () {
                    Route::get('', DepositIndex::class)->name('index');
                });

                // Dépenses
                Route::prefix('expenses')->name('expenses.')->group(function () {
                    Route::get('', ExpenseIndex::class)->name('index');
                });

                // Shop (Livewire)
                Route::get('shop', ShopSetting::class)->name('shop');
            });

            // Route pour la configuration du mot de passe des employés
            Route::get('employee/setup-password/{user}', SetupPassword::class)->name('employee.setup-password');

        });
    });
});
