<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Concerns\HasSubscription;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;
use Laravel\Cashier\Billable;

class Company extends Model
{
    use Billable;

    /** @use HasFactory<\Database\Factories\CompanyFactory> */
    use HasFactory;

    use HasSubscription;

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
        'stripe_id',
        'pm_type',
        'pm_last_four',
        'trial_ends_at',
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

    /**
     * Get all of the company's customers.
     *
     * @return HasMany<Customer, Company>
     */
    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class);
    }

    /**
     * Get all of the company's products.
     *
     * @return HasMany<Product, Company>
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get all of the company's orders.
     *
     * @return HasMany<Order, Company>
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get all of the company's members.
     *
     * @return HasMany<Member, Company>
     */
    public function members(): HasMany
    {
        return $this->hasMany(Member::class);
    }

    /**
     * Get all of the company's users.
     *
     * @return BelongsToMany<User, Member, Company>
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'members')
            ->withPivot(['firstname', 'lastname', 'phone_number'])
            ->withTimestamps();
    }

    /**
     * Get all of the company's warehouses.
     *
     * @return HasMany<Warehouse, Company>
     */
    public function warehouses(): HasMany
    {
        return $this->hasMany(Warehouse::class);
    }

    /**
     * Get all of the company's suppliers.
     *
     * @return HasMany<Supplier, Company>
     */
    public function suppliers(): HasMany
    {
        return $this->hasMany(Supplier::class);
    }

    /**
     * Get all of the company's deposits.
     *
     * @return HasMany<Deposit, Company>
     */
    public function deposits(): HasMany
    {
        return $this->hasMany(Deposit::class);
    }

    /**
     * Get all of the company's purchases.
     *
     * @return HasMany<Purchase, Company>
     */
    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class);
    }

    /**
     * Get the company's shop.
     *
     * @return HasOne<Shop, Company>
     */
    public function shop(): HasOne
    {
        return $this->hasOne(Shop::class);
    }

    /**
     * Get all of the company's quotations.
     *
     * @return HasMany<Quotation, Company>
     */
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

    /**
     * Get the company's default warehouse.
     *
     * @return HasOne<Warehouse, Company>
     */
    public function defaultWarehouse(): ?Warehouse
    {
        return $this->warehouses()->default()->first();
    }

    /**
     * Get the company's main supplier.
     *
     * @return HasOne<Supplier, Company>
     */
    public function mainSupplier(): ?Supplier
    {
        return $this->suppliers()->main()->first();
    }
}
