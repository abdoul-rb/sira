<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PwaInstallation extends Model
{
    protected $fillable = [
        'user_id',
        'platform',
        'user_agent',
        'ip_address',
        'device_fingerprint',
        'installed_at',
        'uninstalled_at',
    ];

    protected $casts = [
        'installed_at' => 'datetime',
        'uninstalled_at' => 'datetime',
    ];

    /**
     * @return BelongsTo<User, PwaInstallation>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function detectPlatform(?string $userAgent): string
    {
        if (! $userAgent) {
            return 'unknown';
        }

        $userAgent = strtolower($userAgent);

        if (str_contains($userAgent, 'android')) {
            return 'android';
        }

        if (str_contains($userAgent, 'iphone') || str_contains($userAgent, 'ipad')) {
            return 'ios';
        }

        if (str_contains($userAgent, 'windows') || str_contains($userAgent, 'macintosh') || str_contains($userAgent, 'linux')) {
            return 'desktop';
        }

        return 'unknown';
    }

    public static function isDeviceRegistered(string $fingerprint): bool
    {
        return self::where('device_fingerprint', $fingerprint)
            ->whereNull('uninstalled_at')
            ->exists();
    }

    /**
     * @return array<string, mixed>
     */
    public static function getStats(): array
    {
        return [
            'total' => self::active()->count(),
            'by_platform' => self::active()
                ->selectRaw('platform, COUNT(*) as count')
                ->groupBy('platform')
                ->pluck('count', 'platform')
                ->toArray(),
            'last_7_days' => self::active()
                ->where('installed_at', '>=', now()->subDays(7))
                ->count(),
            'last_30_days' => self::active()
                ->where('installed_at', '>=', now()->subDays(30))
                ->count(),
        ];
    }

    /**
     * @param  Builder<PwaInstallation>  $query
     */
    #[Scope]
    protected function scopeActive(Builder $query): void
    {
        $query->whereNull('uninstalled_at');
    }
}
