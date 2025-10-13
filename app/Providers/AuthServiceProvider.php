<?php

namespace App\Providers;

use App\Enums\RoleEnum;
use App\Models\Customer;
use App\Models\Member;
use App\Models\User;
use App\Policies\CustomerPolicy;
use App\Policies\MemberPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Customer::class => CustomerPolicy::class,
        Member::class => MemberPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Implicitly grant "Super-Admin" role all permission checks using can()
        Gate::before(function (User $user, string $ability) {
            if ($user->hasRole(RoleEnum::SUPERADMIN)) {
                return true;
            }
        });
    }
} 