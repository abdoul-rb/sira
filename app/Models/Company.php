<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;

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

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function members(): HasMany
    {
        return $this->hasMany(Member::class);
    }

    public function warehouses(): HasMany
    {
        return $this->hasMany(Warehouse::class);
    }

    public function suppliers(): HasMany
    {
        return $this->hasMany(Supplier::class);
    }

    public function deposits(): HasMany
    {
        return $this->hasMany(Deposit::class);
    }

    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class);
    }

    public function shop(): HasOne
    {
        return $this->hasOne(Shop::class);
    }

    public function quotations(): HasMany
    {
        return $this->hasMany(Quotation::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */
    
    #[Scope]
    protected function active(Builder $query): void
    {
        $query->where('active', true);
    }

    /*
    |--------------------------------------------------------------------------
    | Attributes & Methods
    |--------------------------------------------------------------------------
    */
    public function getInitialsAttribute(): string
    {
        return Str::upper(Str::substr($this->name, 0, 2));
    }

    public function defaultWarehouse(): ?Warehouse
    {
        return $this->warehouses()->default()->first();
    }

    public function mainSupplier(): ?Supplier
    {
        return $this->suppliers()->main()->first();
    }
}
