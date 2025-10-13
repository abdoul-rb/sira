<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Deposit extends Model
{
    /** @use HasFactory<\Database\Factories\DepositFactory> */
    use HasFactory;

    protected $fillable = [
        'company_id',
        'reference',
        'label',
        'amount',
        'deposited_at',
        'bank',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'deposited_at' => 'date',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    #[Scope]
    protected function forCompany(Builder $query, int $companyId): void
    {
        $query->where('company_id', $companyId);
    }
}
