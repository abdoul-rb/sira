<?php

namespace App\Models\Scopes;

use App\Enums\RoleEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class TenantScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        /**
         * @var User $user
         */
        $user = Auth::user();

        dd($user->member);

        if (Auth::check() && !$user->hasRole(RoleEnum::SUPERADMIN)) {
            $builder->where('company_id', $user->member?->company_id);
        }
    }
}
