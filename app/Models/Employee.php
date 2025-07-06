<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Employee extends Model
{
    /** @use HasFactory<\Database\Factories\EmployeeFactory> */
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'company_id',
        'firstname',
        'lastname',
        'phone_number',
        'position',
        'department',
        'hire_date',
        'active',
    ];

    protected $casts = [
        'hire_date' => 'date',
        'active' => 'boolean',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function (Employee $employee) {
            $employee->uuid = Str::uuid();
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    /**
     * Relation avec User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation avec Company
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Méthodes utilitaires
    |--------------------------------------------------------------------------
    */

    /**
     * Scope pour les employés actifs
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function scopeConnectedEmployees($query): Builder
    {
        return $query->whereNotNull('user_id');
    }

    public function scopeOfflineEmployees($query): Builder
    {
        return $query->whereNull('user_id');
    }

    public function getFullnameAttribute(): string
    {
        return "{$this->firstname} {$this->lastname}";
    }

    public function getRoleAttribute(): string
    {
        return match ($this->user->roles->first()?->name) {
            'employee' => 'Employé',
            'manager' => 'Manager',
            default => 'Employé',
        };
    }
}
