<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\RoleEnum;
use App\Models\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

#[ScopedBy([TenantScope::class])]
class Member extends Model
{
    /** @use HasFactory<\Database\Factories\MemberFactory> */
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'company_id',
        'firstname',
        'lastname',
        'phone_number',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function (Member $member) {
            $member->uuid = Str::uuid();
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    /**
     * Get the member's user.
     *
     * @return BelongsTo<User, Member>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the member's company.
     *
     * @return BelongsTo<Company, Member>
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

    /*
    |--------------------------------------------------------------------------
    | Méthodes utilitaires
    |--------------------------------------------------------------------------
    */

    /**
     * Get the member's full name.
     */
    public function getFullnameAttribute(): string
    {
        return "{$this->firstname} {$this->lastname}";
    }

    /**
     * Get the member's initials.
     */
    public function getInitialsAttribute(): string
    {
        return strtoupper(substr($this->firstname, 0, 1) . substr($this->lastname, 0, 1));
    }

    /**
     * Get the member's roles names.
     */
    public function getRolesName(): Collection
    {
        if (! $this->user) {
            return collect();
        }

        return $this->user
            ->getRoleNames()
            ->map(fn (string $role) => RoleEnum::tryFrom($role)?->label())
            ->filter()
            ->values();
    }
}
