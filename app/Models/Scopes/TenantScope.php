<?php

declare(strict_types=1);

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
     * Applique automatiquement le filtre company_id sur toutes les requêtes
     */
    public function apply(Builder $builder, Model $model): void
    {
        /**
         * @var User $user
         */
        $user = Auth::user();

        if (Auth::check() && !$user->hasRole(RoleEnum::SUPERADMIN)) {
            $builder->where($model->getTable() . '.company_id', $user->member?->company_id);
        }
    }
}
