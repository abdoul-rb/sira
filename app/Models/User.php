<?php

declare(strict_types=1);

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\RoleEnum;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
// use Illuminate\Database\Eloquent\SoftDeletes;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser, HasName
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;

    use HasRoles;
    use Notifiable;
    // use SoftDeletes;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'uuid',
        'name',
        'email',
        'password',
        'last_login_at',
        'last_login_ip',
    ];

    /**
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'last_login_at',
        'last_login_ip',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_login_at' => 'datetime',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function (User $user) {
            $user->uuid = Str::uuid();
        });
    }

    public function isSuper(): bool
    {
        return in_array($this->email, explode(',', config('auth.admin_emails')));
    }

    /*
    |--------------------------------------------------------------------------
    | Filament
    |--------------------------------------------------------------------------
    */

    /**
     * Retourne le nom d'utilisateur pour l'affichage dans Filament.
     */
    public function getFilamentName(): string
    {
        return $this->name;
    }

    /**
     * Check if the user can access the panel.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->isSuper(); // $this->hasVerifiedEmail();
    }

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    /**
     * Relation avec le membre de l'entreprise
     *
     * @return HasOne<Member, User>
     */
    public function member(): HasOne
    {
        return $this->hasOne(Member::class);
    }

    // Get the company of the user à travers le member
    public function company()
    {
        return $this->member()->company();
    }

    /*
    |--------------------------------------------------------------------------
    | Méthodes utilitaires
    |--------------------------------------------------------------------------
    */

    /**
     * Get the initials of the user.
     */
    public function getInitialsAttribute(): string
    {
        return strtoupper(substr($this->name, 0, 1));
    }

    /**
     * Get the role labels of the user.
     */
    public function roleLabels(): string
    {
        return $this->getRoleNames()
            ->map(fn ($role) => RoleEnum::tryFrom($role)?->label() ?? $role
            )
            ->join(', ');
    }
}
