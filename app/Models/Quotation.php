<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\QuotationStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Quotation extends Model
{
    /** @use HasFactory<\Database\Factories\QuotationFactory> */
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'company_id',
        'customer_id',
        'reference',
        'status',
        'subtotal',
        'tax_amount',
        'total_amount',
        'notes',
        'valid_until',
        'sent_at',
        'accepted_at',
        'rejected_at',
    ];

    protected $casts = [
        'status' => QuotationStatus::class,
        'subtotal' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'valid_until' => 'date',
        'sent_at' => 'datetime',
        'accepted_at' => 'datetime',
        'rejected_at' => 'datetime',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function (Quotation $quotation) {
            $quotation->reference = Str::uuid();
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

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_quotation')
            ->withPivot(['quantity', 'unit_price', 'total_price', 'notes'])
            ->withTimestamps();
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

    public function scopeDraft($query)
    {
        return $query->where('status', QuotationStatus::DRAFT);
    }

    public function scopeSent($query)
    {
        return $query->where('status', QuotationStatus::SENT);
    }

    public function scopeAccepted($query)
    {
        return $query->where('status', QuotationStatus::ACCEPTED);
    }

    public function scopeRejected($query)
    {
        return $query->where('status', QuotationStatus::REJECTED);
    }

    public function scopeExpired($query)
    {
        return $query->where('status', QuotationStatus::EXPIRED);
    }

    /*
    |--------------------------------------------------------------------------
    | Methods
    |--------------------------------------------------------------------------
    */

    public function markAsSent(): void
    {
        $this->update([
            'status' => QuotationStatus::SENT,
            'sent_at' => now(),
        ]);
    }

    public function markAsAccepted(): void
    {
        $this->update([
            'status' => QuotationStatus::ACCEPTED,
            'accepted_at' => now(),
        ]);
    }

    public function markAsRejected(): void
    {
        $this->update([
            'status' => QuotationStatus::REJECTED,
            'rejected_at' => now(),
        ]);
    }

    public function markAsExpired(): void
    {
        $this->update([
            'status' => QuotationStatus::EXPIRED,
        ]);
    }

    public function isExpired(): bool
    {
        return $this->valid_until && $this->valid_until->isPast();
    }

    public function canBeConvertedToOrder(): bool
    {
        return $this->status === QuotationStatus::ACCEPTED;
    }

    public function calculateTotals(): void
    {
        $subtotal = $this->products->sum(function ($product) {
            return $product->pivot->total_price;
        });

        $taxAmount = $this->tax_amount ?? 0;

        $this->update([
            'subtotal' => $subtotal,
            'total_amount' => $subtotal + $taxAmount,
        ]);
    }
}
