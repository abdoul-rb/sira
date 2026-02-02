<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\PwaInstallation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

final class CreatePwaInstallation
{
    public function handle(Request $request): ?PwaInstallation
    {
        return DB::transaction(function () use ($request) {
            $fingerprint = $request->input('device_fingerprint');

            if ($fingerprint && PwaInstallation::isDeviceRegistered($fingerprint)) {
                return null;
            }

            return PwaInstallation::create([
                'user_id' => Auth::id(),
                'platform' => PwaInstallation::detectPlatform($request->userAgent()),
                'user_agent' => $request->userAgent(),
                'ip_address' => $request->ip(),
                'device_fingerprint' => $fingerprint,
                'installed_at' => now(),
            ]);
        });
    }
}
