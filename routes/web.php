<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Livewire\Public\Shop;
use App\Livewire\Auth\SetupPassword;
use App\Livewire\Dashboard\Customer\Create as CustomerCreate;
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
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

require __DIR__ . '/auth.php';

Route::domain('{tenant}.' . config('app.url'))->name('dashboard.')->group(function () {
    // Route publique pour les boutiques
    Route::get('shop/{shopSlug}', Shop::class)->name('shop.public');

    Route::get('dashboard', [DashboardController::class, 'index'])->name('index');

    Route::prefix('dashboard')->group(function () {
        // CRUD Customer (Livewire)
        Route::prefix('customers')->name('customers.')->group(function () {
            Route::get('', CustomerIndex::class)->name('index');
            Route::get('create', CustomerCreate::class)->name('create');
            Route::get('{customer}/edit', CustomerEdit::class)->name('edit');
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

        // Route pour la configuration du mot de passe des employés
        Route::get('employee/setup-password/{user}', SetupPassword::class)->name('employee.setup-password');

    });
});
