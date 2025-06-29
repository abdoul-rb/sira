<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Middleware\TenantMiddleware;
use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard\Customer\Index;
use App\Livewire\Dashboard\Customer\Create;
use App\Livewire\Dashboard\Customer\Edit;


Route::view('/', 'welcome')->name('home');

require __DIR__ . '/auth.php';

Route::domain('{tenant}.' . config('app.url'))->name('dashboard.')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('index');

    // CRUD Customer (Livewire)
    Route::prefix('dashboard')->group(function () {
        Route::prefix('customers')->name('customers.')->group(function () {
            Route::get('', Index::class)->name('index');
            Route::get('create', Create::class)->name('create');
            Route::get('{customer}/edit', Edit::class)->name('edit');
        });
    });
});