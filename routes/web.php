<?php

declare(strict_types=1);

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\InvoiceController;
use App\Http\Controllers\Dashboard\SettingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SubscriptionController;
use App\Livewire\Auth\SetupPassword;
use App\Livewire\Dashboard\Agent\Index as AgentIndex;
use App\Livewire\Dashboard\Customers\Index as CustomerIndex;
use App\Livewire\Dashboard\Members\Index as MemberIndex;
use App\Livewire\Dashboard\Orders\Edit as OrderEdit;
use App\Livewire\Dashboard\Orders\Index as OrderIndex;
use App\Livewire\Dashboard\Products\Index as ProductIndex;
use App\Livewire\Dashboard\Purchases\Index as PurchaseIndex;
use App\Livewire\Dashboard\Receivables\Index as ReceivableIndex;
use App\Livewire\Dashboard\Settings\Deposits\Index as DepositIndex;
use App\Livewire\Dashboard\Settings\Expenses\Index as ExpenseIndex;
use App\Livewire\Dashboard\Settings\Shop as ShopSetting;
use App\Livewire\Dashboard\Settings\Suppliers\Index as SupplierIndex;
use App\Livewire\Dashboard\Settings\Warehouses\Index as WarehouseIndex;
use App\Livewire\Dashboard\Transactions\Index as TransactionIndex;
use App\Livewire\Profile\Index as ProfileIndex;
use App\Livewire\Public\Shop as ShopPublic;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

// DEBUG: Test Route Model Binding avec binding explicite
Route::get('test-binding/{company}', function (Company $company) {
    return 'Company: ' . $company->name;
});

Route::get('/{user}/test', function (User $user) {
    return "User: {$user->id} / {$user->email}";
});

require __DIR__ . '/auth.php';

// Routes multi-tenant avec le préfixe {company}
Route::prefix('{company}')
    ->middleware(['auth', 'tenant'])
    ->group(function () {
        // Dashboard accessible même si l'entreprise est inactive
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

        // Toutes les autres routes nécessitent une entreprise active
        Route::prefix('dashboard')->name('dashboard.')
            ->middleware(['company.active'])
            ->group(function () {
                Route::get('profile', ProfileIndex::class)->name('profile.index');

                // Purchases
                Route::get('purchases', PurchaseIndex::class)->name('purchases.index');

                // Customers
                Route::get('customers', CustomerIndex::class)->name('customers.index');

                // Agents
                Route::get('agents', AgentIndex::class)->name('agents.index');

                // Products
                Route::get('products', ProductIndex::class)->name('products.index');

                // Orders
                Route::prefix('orders')->name('orders.')->group(function () {
                    Route::get('', OrderIndex::class)->name('index');
                    Route::get('{order}/edit', OrderEdit::class)->name('edit');
                    Route::get('{order}/invoice', [InvoiceController::class, 'show'])->name('invoice');
                });

                // Receivables: Créances
                Route::get('receivables', ReceivableIndex::class)->name('receivables.index');

                // Transactions: mouvements de caisse
                Route::get('transactions', TransactionIndex::class)->name('transactions.index');

                // Membres
                Route::get('members', MemberIndex::class)->name('members.index');

                // Dépenses
                Route::get('expenses', ExpenseIndex::class)->name('expenses.index');

                // Paramètres
                Route::prefix('settings')->name('settings.')->group(function () {
                    Route::get('', [SettingController::class, 'index'])->name('index');

                    // Warehouse
                    Route::get('warehouses', WarehouseIndex::class)->name('warehouses.index');

                    // Fournisseurs
                    Route::get('suppliers', SupplierIndex::class)->name('suppliers.index');

                    // Versements
                    Route::get('deposits', DepositIndex::class)->name('deposits.index');

                    // Shop
                    Route::get('shop', ShopSetting::class)->name('shop');
                });

                // Route pour la configuration du mot de passe des employés
                Route::get('member/setup-password/{user}', SetupPassword::class)->name('members.setup-password');
            });

        Route::get('shop/{shopSlug}', ShopPublic::class)->name('shop.public');
    });

// Checkout
Route::get('checkout/{company:uuid}', SubscriptionController::class)->name('checkout.index');
