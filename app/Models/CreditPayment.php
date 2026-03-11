<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\CreditPaymentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CreditPayment extends Model
{
    /** @use HasFactory<CreditPaymentFactory> */
    use HasFactory;

    protected $fillable = [
        'credit_id',
        'amount',
        'payment_method',
        'paid_at',
        'created_by',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    /**
     * Le crédit auquel ce versement appartient.
     *
     * @return BelongsTo<Credit, CreditPayment>
     */
    public function credit(): BelongsTo
    {
        return $this->belongsTo(Credit::class);
    }

    /**
     * L'utilisateur ayant enregistré ce versement.
     *
     * @return BelongsTo<User, CreditPayment>
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
