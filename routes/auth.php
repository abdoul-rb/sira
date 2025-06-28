<?php

use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\LogoutController;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Passwords\Confirm;
use App\Livewire\Auth\Passwords\Email;
use App\Livewire\Auth\Passwords\Reset;
use App\Livewire\Auth\Register;
use App\Livewire\Auth\Verify;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest'])->prefix('auth')->group(function () {
    Route::domain('{tenant}.' . config('app.url'))->group(function () {
        Route::get('login', Login::class)->middleware(['throttle:6,1'])->name('login');
    });

    Route::get('register', Register::class)->name('register');
});

Route::domain('{tenant}.' . config('app.url'))->group(function () {
    Route::get('password/reset', Email::class)->name('password.request');
    Route::get('password/reset/{token}', Reset::class)->name('password.reset');
});

Route::middleware(['auth'])->group(function () {
    Route::get('email/verify', Verify::class)->middleware(['throttle:6,1'])->name('verification.notice');
    Route::get('password/confirm', Confirm::class)->name('password.confirm');
});

Route::middleware(['auth'])->group(function () {
    Route::get('email/verify/{id}/{hash}', EmailVerificationController::class)->middleware('signed')->name('verification.verify');
    Route::post('logout', LogoutController::class)->name('logout');
});
