<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;

    use HasRoles;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'company_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    /**
     * Relation avec la Company (nullable pour les super admins)
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Relation avec Employee
     */
    public function employee()
    {
        return $this->hasOne(Employee::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Méthodes utilitaires
    |--------------------------------------------------------------------------
    */

    /**
     * Vérifie si l'utilisateur est un super admin
     */
    public function isSuperAdmin(): bool
    {
        return is_null($this->company_id);
    }

    /**
     * Vérifie si l'utilisateur est un manager de sa company
     */
    public function isManager(): bool
    {
        return $this->hasRole('manager');
    }

    /**
     * Vérifie si l'utilisateur est un employé standard
     */
    public function isEmployee(): bool
    {
        return $this->hasRole('employee');
    }

    /**
     * Vérifie si l'utilisateur a un profil employé
     */
    public function hasEmployeeProfile(): bool
    {
        return $this->employee()->exists();
    }
}
