<?php

declare(strict_types=1);

use App\Http\Controllers\API\PushSubscriptionController;
use App\Http\Controllers\API\PwaInstallationController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth'])->group(function () {
    // Push Subscriptions
    Route::post('push-subscriptions', [PushSubscriptionController::class, 'store']);
    Route::delete('push-subscriptions', [PushSubscriptionController::class, 'destroy']);

    // PWA Stats (admin)
    Route::get('pwa-installations/stats', [PwaInstallationController::class, 'stats']);
});

// PWA Installation Tracking (peut être appelé sans auth)
Route::post('pwa-installations', [PwaInstallationController::class, 'store']);
Route::post('pwa-installations/check', [PwaInstallationController::class, 'check']);
