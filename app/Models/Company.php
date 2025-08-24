<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class Company extends Model
{
    /** @use HasFactory<\Database\Factories\CompanyFactory> */
    use HasFactory;

    protected $fillable = [
        'uuid',
        'slug',
        'name',
        'email',
        'phone_number',
        'website',
        'active',
        'logo_path',
        'address',
        'city',
        'zip_code',
        'country',
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

        static::creating(function (Company $company) {
            $company->slug = Str::slug($company->name);
            $company->uuid = Str::uuid();
        });

        static::updating(function (Company $company) {
            $company->slug = Str::slug($company->name);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function quotations(): HasMany
    {
        return $this->hasMany(Quotation::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }

    public function shop(): HasOne
    {
        return $this->hasOne(Shop::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Attributes
    |--------------------------------------------------------------------------
    */
    public function getInitialsAttribute(): string
    {
        return Str::upper(Str::substr($this->name, 0, 2));
    }
}
