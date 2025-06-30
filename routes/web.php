<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Middleware\TenantMiddleware;
use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard\Customer\Index as CustomerIndex;
use App\Livewire\Dashboard\Customer\Create as CustomerCreate;
use App\Livewire\Dashboard\Customer\Edit as CustomerEdit;
use App\Livewire\Dashboard\Product\Index as ProductIndex;
use App\Livewire\Dashboard\Product\Create as ProductCreate;
use App\Livewire\Dashboard\Product\Edit as ProductEdit;


Route::view('/', 'welcome')->name('home');

require __DIR__ . '/auth.php';

Route::domain('{tenant}.' . config('app.url'))->name('dashboard.')->group(function () {
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

    });
});