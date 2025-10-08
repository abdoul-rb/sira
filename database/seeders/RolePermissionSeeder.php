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
            'view-members',
            'create-member',
            'edit-member',
            'delete-member',
            
            // Gestion des clients
            'view-customers',
            'create-customer',
            'edit-customer',
            'delete-customer',
            
            // Gestion des produits
            'view-products',
            'create-product',
            'edit-product',
            'delete-product',
            
            // Gestion des devis
            'view-quotations',
            'create-quotation',
            'edit-quotation',
            'delete-quotation',
            'approve-quotation',
            
            // Gestion des commandes
            'view-orders',
            'create-order',
            'edit-order',
            'delete-order',
            
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
        $memberRole = Role::create(['name' => 'member']);

        // Attribution des permissions aux rôles

        // Super Admin : toutes les permissions
        $superAdminRole->givePermissionTo(Permission::all());

        // Manager : permissions de sa company
        $managerRole->givePermissionTo([
            'view-members', 'create-member', 'edit-member', 'delete-member',
            'view-customers', 'create-customer', 'edit-customer', 'delete-customer',
            'view-products', 'create-product', 'edit-product', 'delete-product',
            'view-quotations', 'create-quotation', 'edit-quotation', 'delete-quotation', 'approve-quotation',
            'view-orders', 'create-order', 'edit-order', 'delete-order',
            'view-company-settings', 'edit-company-settings',
        ]);

        // Member : permissions limitées
        $memberRole->givePermissionTo([
            'view-customers', 'create-customer', 'edit-customer', 'delete-customer',
            'view-products',
            'view-quotations', 'create-quotation', 'edit-quotation', 'delete-quotation', 'approve-quotation',
            'view-orders', 'create-order', 'edit-order', 'delete-order',
        ]);
    }
}
