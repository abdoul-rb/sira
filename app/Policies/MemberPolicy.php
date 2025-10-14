<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Member;
use App\Models\User;

class MemberPolicy
{
    /**
     * Autorise tout aux super-admins.
     */
    public function before(User $user, $ability)
    {
        /* if ($user->hasRole('super-admin')) {
        } */
        return true;
    }

    /**
     * Voir la liste des employés de sa company.
     */
    public function viewAny(User $user)
    {
        return $user->company_id !== null;
    }

    /**
     * Voir un employé de sa company.
     */
    public function view(User $user, Member $member)
    {
        return $user->company_id === $member->company_id;
    }

    /**
     * Créer un employé dans sa company.
     */
    public function create(User $user)
    {
        return $user->company_id !== null;
    }

    /**
     * Mettre à jour un employé de sa company.
     */
    public function update(User $user, Member $member)
    {
        return $user->company_id === $member->company_id;
    }

    /**
     * Supprimer un employé de sa company.
     */
    public function delete(User $user, Member $member)
    {
        return $user->company_id === $member->company_id;
    }
} 