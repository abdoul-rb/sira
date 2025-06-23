<?php

use App\Http\Controllers\Dashboard\DashboardController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

require __DIR__ . '/auth.php';

Route::domain('{company}.' . config('app.url'))/* ->middleware(['auth']) */->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
});