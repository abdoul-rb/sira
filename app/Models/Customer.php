<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\CustomerType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Customer extends Model
{
    /** @use HasFactory<\Database\Factories\CustomerFactory> */
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'company_id',
        'title',
        'firstname',
        'lastname',
        'email',
        'phone_number',
        'type',
        'address',
        'city',
        'zip_code',
        'country',
        'converted_at',
    ];

    protected $casts = [
        'type' => CustomerType::class,
        'converted_at' => 'datetime',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function (Customer $customer) {
            $customer->uuid = Str::uuid();
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

    public function quotations(): HasMany
    {
        return $this->hasMany(Quotation::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeLeads($query)
    {
        return $query->where('type', CustomerType::LEAD);
    }

    public function scopeCustomers($query)
    {
        return $query->where('type', CustomerType::CUSTOMER);
    }

    /*
    |--------------------------------------------------------------------------
    | Methods
    |--------------------------------------------------------------------------
    */

    public function getFullNameAttribute(): string
    {
        return trim($this->firstname . ' ' . $this->lastname);
    }

    public function convertToCustomer(): void
    {
        $this->update([
            'type' => CustomerType::CUSTOMER,
            'converted_at' => now(),
        ]);
    }

    public function isLead(): bool
    {
        return $this->type === CustomerType::LEAD;
    }

    public function isCustomer(): bool
    {
        return $this->type === CustomerType::CUSTOMER;
    }
}
