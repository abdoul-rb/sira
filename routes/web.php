<?php

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Middleware\TenantMiddleware;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

require __DIR__ . '/auth.php';

Route::domain('{tenant}.' . config('app.url'))->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
});