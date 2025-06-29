<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Middleware\TenantMiddleware;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

require __DIR__ . '/auth.php';

Route::domain('{tenant}.' . config('app.url'))->name('dashboard.')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('index');

    // CRUD Customer (Livewire)
    Route::prefix('dashboard')->group(function () {
        Route::prefix('customers')->name('customers.')->group(function () {
            Route::get('', \App\Livewire\Dashboard\Customer\Index::class)->name('index');
            Route::get('/create', \App\Livewire\Dashboard\Customer\Create::class)->name('create');
            Route::get('/{customer}/edit', \App\Livewire\Dashboard\Customer\Edit::class)->name('edit');
        });
    });
});