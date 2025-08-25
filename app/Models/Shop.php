<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Shop extends Model
{
    /** @use HasFactory<\Database\Factories\ShopFactory> */
    use HasFactory;

    protected $fillable = [
        'company_id',
        'name',
        'slug',
        'logo_path',
        'description',
        'facebook_url',
        'instagram_url',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function (Shop $shop) {
            $shop->slug = Str::slug($shop->name);
        });

        static::updating(function (Shop $shop) {
            $shop->slug = Str::slug($shop->name);
        });
    }

    public function getLogoPath()
    {
        return str_starts_with($this->logo_path, 'http')
            ? $this->logo_path
            : Storage::disk('public')->url($this->logo_path);
    }

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
