<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

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
