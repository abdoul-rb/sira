<?php

declare(strict_types=1);

namespace App\Models\Concerns;

use App\Enums\RoleEnum;
use App\Models\Company;
use App\Models\Member;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait HasSubscription
{
    /**
     * Récupère uniquement les utilisateurs payants (ceux qui ont un rôle billable)
     *
     * @return BelongsToMany<User, Member, Company>
     */
    public function billableUsers(): BelongsToMany
    {
        return $this->users()->whereHas('roles', function ($query) {
            $query->whereIn('name', [RoleEnum::OPERATOR, RoleEnum::MANAGER]);
        });
    }

    /**
     * Compte le nombre de sièges à facturer
     */
    public function getBillableSeatCount(): int
    {
        $count = $this->billableUsers()->count();

        // On facture toujours au minimum 1 siège (le créateur), même si techniquement 0
        return max(1, $count);
    }

    /**
     * Vérifie si l'entreprise est sur l'offre Gratuite (Non abonnée)
     */
    public function isFreeTier(): bool
    {
        // Si elle n'a pas d'abonnement actif, elle est en Free Tier
        return ! $this->subscribed('default');
    }

    /**
     * Vérifie si l'entreprise a atteint sa limite de produits gratuits
     */
    public function hasReachedFreeLimit(): bool
    {
        $limit = 5;

        // 1. Si abonnée (ou en période d'essai temporelle Stripe), pas de limite.
        if ($this->subscribed('default') || $this->onTrial()) {
            return false;
        }

        // 2. Sinon, on compte les produits.
        return $this->products()->count() > $limit;
    }
}
