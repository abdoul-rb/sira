<?php

declare(strict_types=1);

namespace App\Models\Scopes;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

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

        if (Auth::check() && ! $user->hasRole(RoleEnum::SUPERADMIN)) {
            if (! $user->relationLoaded('member')) {
                $user->load('member');
            }
            
            $member = $user->getRelation('member');
            $builder->where($model->getTable() . '.company_id', $member?->company_id);
        }
    }
}
