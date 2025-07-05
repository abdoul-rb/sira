<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Création des permissions de base
        $permissions = [
            // Gestion des employés
            'view-employees',
            'create-employees',
            'edit-employees',
            'delete-employees',
            
            // Gestion des clients
            'view-customers',
            'create-customers',
            'edit-customers',
            'delete-customers',
            
            // Gestion des produits
            'view-products',
            'create-products',
            'edit-products',
            'delete-products',
            
            // Gestion des devis
            'view-quotations',
            'create-quotations',
            'edit-quotations',
            'delete-quotations',
            'approve quotations',
            
            // Gestion des commandes
            'view-orders',
            'create-orders',
            'edit-orders',
            'delete-orders',
            
            // Gestion de la company
            'view-company-settings',
            'edit-company-settings',
            
            // Permissions globales (super admin)
            'view-all-companies',
            'manage-all-companies',
            'view-system-settings',
            'manage-system-settings',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Création des rôles
        $superAdminRole = Role::create(['name' => 'super-admin']);
        $managerRole = Role::create(['name' => 'manager']);
        // $employeeRole = Role::create(['name' => 'employee']);

        // Attribution des permissions aux rôles

        // Super Admin : toutes les permissions
        $superAdminRole->givePermissionTo(Permission::all());

        // Manager : permissions de sa company
        $managerRole->givePermissionTo([
            'view-employees', 'create-employees', 'edit-employees', 'delete-employees',
            'view-customers', 'create-customers', 'edit-customers', 'delete-customers',
            'view-products', 'create-products', 'edit-products', 'delete-products',
            'view-quotations', 'create-quotations', 'edit-quotations', 'delete-quotations', 'approve-quotations',
            'view-orders', 'create-orders', 'edit-orders', 'delete-orders',
            'view-company-settings', 'edit-company-settings',
        ]);

        // Employee : permissions limitées
        /* $employeeRole->givePermissionTo([
            'view-customers', 'create-customers', 'edit-customers',
            'view-products',
            'view-quotations', 'create-quotations', 'edit-quotations',
            'view-orders', 'create-orders', 'edit-orders',
        ]); */
    }
}
