<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Employee;
use App\Models\User;

class EmployeePolicy
{
    /**
     * Autorise tout aux super-admins.
     */
    public function before(User $user, $ability)
    {
        if ($user->hasRole('super-admin')) {
            return true;
        }
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
    public function view(User $user, Employee $employee)
    {
        return $user->company_id === $employee->company_id;
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
    public function update(User $user, Employee $employee)
    {
        return $user->company_id === $employee->company_id;
    }

    /**
     * Supprimer un employé de sa company.
     */
    public function delete(User $user, Employee $employee)
    {
        return $user->company_id === $employee->company_id;
    }
} 