<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ScopedBy([TenantScope::class])]
class Supplier extends Model
{
    /** @use HasFactory<\Database\Factories\SupplierFactory> */
    use HasFactory;

    protected $fillable = [
        'company_id',
        'name',
        'main',
        'email',
        'phone_number',
    ];

    protected $casts = [
        'main' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    /**
     * Get the company associated with the supplier.
     *
     * @return BelongsTo<Company, Supplier>
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Mark the supplier as main.
     */
    public function markAsMain(): void
    {
        $this->update(['main' => true]);
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    #[Scope]
    protected function main(Builder $query): void
    {
        $query->where('main', true);
    }

    #[Scope]
    protected function forCompany(Builder $query, int $companyId): void
    {
        $query->where('company_id', $companyId);
    }
}
