<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Actions\CreatePwaInstallation;
use App\Http\Controllers\Controller;
use App\Models\PwaInstallation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PwaInstallationController extends Controller
{
    public function store(Request $request, CreatePwaInstallation $action): JsonResponse
    {
        $fingerprint = $request->input('device_fingerprint');

        if ($fingerprint && PwaInstallation::isDeviceRegistered($fingerprint)) {
            return response()->json([
                'success' => true,
                'message' => 'Appareil déjà enregistré.',
                'already_registered' => true,
            ]);
        }

        $installation = $action->handle($request);

        if (! $installation) {
            return response()->json([
                'success' => true,
                'already_registered' => true,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Installation PWA enregistrée.',
            'installation_id' => $installation->id,
            'already_registered' => false,
        ]);
    }

    public function check(Request $request): JsonResponse
    {
        $fingerprint = $request->input('device_fingerprint');

        return response()->json([
            'registered' => $fingerprint ? PwaInstallation::isDeviceRegistered($fingerprint) : false,
        ]);
    }

    public function stats(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'stats' => PwaInstallation::getStats(),
        ]);
    }
}
