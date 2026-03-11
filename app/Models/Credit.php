<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\CreditStatus;
use App\Models\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ScopedBy([TenantScope::class])]
class Credit extends Model
{
    /** @use HasFactory<\Database\Factories\CreditFactory> */
    use HasFactory;

    protected $fillable = [
        'company_id',
        'order_id',
        'due_date',
        'status',
    ];

    protected $casts = [
        'due_date' => 'date',
        'status' => CreditStatus::class,
    ];

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    /**
     * L'entreprise à laquelle appartient ce crédit.
     *
     * @return BelongsTo<Company, Credit>
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * La commande associée à ce crédit.
     *
     * @return BelongsTo<Order, Credit>
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Les versements effectués sur ce crédit.
     *
     * @return HasMany<CreditPayment, Credit>
     */
    public function payments(): HasMany
    {
        return $this->hasMany(CreditPayment::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Accesseurs dynamiques
    |--------------------------------------------------------------------------
    */

    /**
     * Montant total versé (avance + versements).
     */
    public function getTotalPaidAttribute(): float
    {
        $advance = (float) ($this->order?->advance ?? 0);
        $payments = (float) $this->payments->sum('amount');

        return $advance + $payments;
    }

    /**
     * Montant restant à payer.
     * Ne pas stocker — calculer dynamiquement.
     */
    public function getRemainingAmountAttribute(): float
    {
        $total = (float) ($this->order?->total_amount ?? 0);
        $advance = (float) ($this->order?->advance ?? 0);
        $payments = (float) $this->payments->sum('amount');

        return max(0, $total - $advance - $payments);
    }

    /**
     * Statut dynamique du crédit.
     * Seuls 'pending' et 'paid' sont stockés en base.
     * 'overdue' est calculé ici à la volée.
     */
    public function getComputedStatusAttribute(): CreditStatus
    {
        if ($this->remaining_amount <= 0) {
            return CreditStatus::PAID;
        }

        if ($this->due_date && $this->due_date->isPast()) {
            return CreditStatus::OVERDUE;
        }

        return CreditStatus::PENDING;
    }

    /*
    |--------------------------------------------------------------------------
    | Méthodes
    |--------------------------------------------------------------------------
    */

    /**
     * Vérifie si le crédit est entièrement soldé.
     */
    public function isFullyPaid(): bool
    {
        return $this->remaining_amount <= 0;
    }

    /**
     * Marque le crédit comme soldé en base.
     */
    public function markAsPaid(): void
    {
        $this->update(['status' => CreditStatus::PAID]);
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    /**
     * Filtrer les crédits non encore soldés.
     */
    #[Scope]
    protected function unsettled(Builder $query): void
    {
        $query->where('status', CreditStatus::PENDING);
    }
}
