<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\RoleEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Création des permissions de base
        $permissions = [
            // Gestion des agents
            'view-agents',
            'create-agent',
            'edit-agent',
            'delete-agent',

            // Permissions globales (super admin)
            'view-all-companies',
            'manage-all-companies',
            'view-system-settings',
            'manage-system-settings',

            // Gestion des companies
            'view-company-settings',
            'edit-company-settings',

            // Gestion des customers
            'view-customers',
            'create-customer',
            'edit-customer',
            'delete-customer',

            // Gestion des deposits / Versements
            'view-deposits',
            'create-deposit',
            'edit-deposit',
            'delete-deposit',

            // Gestion des expenses / Dépenses
            'view-expenses',
            'create-expense',
            'edit-expense',
            'delete-expense',

            // Gestion des employés membres
            'view-members',
            'create-member',
            'edit-member',
            'delete-member',

            // Gestion des commandes
            'view-orders',
            'create-order',
            'edit-order',
            'delete-order',
            
            // Gestion des produits
            'view-products',
            'create-product',
            'edit-product',
            'delete-product',

            // Gestion des purchases / achats
            'view-purchases',
            'create-purchase',
            'edit-purchase',
            'delete-purchase',
            
            // Gestion des quotation / devis
            'view-quotations',
            'create-quotation',
            'edit-quotation',
            'delete-quotation',
            'approve-quotation',
            
            // Gestion des Shop

            // Gestion des suppliers / Fournisseurs
            'view-suppliers',
            'create-supplier',
            'edit-supplier',
            'delete-supplier',

            // Gestion des users

            // Gestion des warehouses / emplacements
            'view-warehouses',
            'create-warehouse',
            'edit-warehouse',
            'delete-warehouse',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Création des rôles
        $superAdminRole = Role::create(['name' => RoleEnum::SUPERADMIN->value]);
        $managerRole = Role::create(['name' => RoleEnum::MANAGER->value]);
        $operatorRole = Role::create(['name' => RoleEnum::OPERATOR->value]);

        // Super Admin : toutes les permissions
        $superAdminRole->givePermissionTo(Permission::all());

        // Manager : permissions de sa company
        $managerRole->givePermissionTo([
            // 'view-agents', 'create-agent', 'edit-agent', 'delete-agent',
            'view-company-settings', 'edit-company-settings',
            'view-customers', 'create-customer', 'edit-customer', 'delete-customer',
            'view-deposits', 'create-deposit', 'edit-deposit', 'delete-deposit',
            'view-expenses', 'create-expense', 'edit-expense', 'delete-expense',
            'view-members', 'create-member', 'edit-member', 'delete-member',
            'view-orders', 'create-order', 'edit-order', 'delete-order',
            'view-products', 'create-product', 'edit-product', 'delete-product',
            'view-purchases', 'create-purchase', 'edit-purchase', 'delete-purchase',
            // 'view-quotations', 'create-quotation', 'edit-quotation', 'delete-quotation', 'approve-quotation',
            // shop
            'view-suppliers', 'create-supplier', 'edit-supplier', 'delete-supplier',
            'view-warehouses', 'create-warehouse', 'edit-warehouse', 'delete-warehouse',
        ]);

        // Member : permissions limitées
        $operatorRole->givePermissionTo([
            // 'view-agents'
            // 'view-company-settings'
            'view-customers', 'create-customer', 'edit-customer',
            'view-deposits', 'create-deposit', 'edit-deposit', 'delete-deposit',
            'view-expenses', 'create-expense', 'edit-expense', 'delete-expense',
            // 'view-members' : rien 
            'view-orders', 'create-order',
            'view-products',
            // Achats : rien
            // 'view-quotations',
            // shop
            'view-suppliers', 'create-supplier', 'edit-supplier', 'delete-supplier',
            // emplacements
        ]);
    }
}
