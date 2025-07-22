<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        // Menu sub-menu action
        // [0] => menu
        // [1] => sub-menu
        // [2] => action
        // notes : 
        // 1. dipisahkan dengan koma 
        // 2. apabila memiliki dua suku kata sambungkan dengan (-), contoh "master-menu kategori-produk lihat"
        
        // Dashboard Menu
        Permission::create(['name' => 'dashboard-menu']);

        // Master Menu
        Permission::create(['name' => 'master-menu']);
            // Product Category
            Permission::create(['name' => 'master-menu product-category create']);
            Permission::create(['name' => 'master-menu product-category read']);
            Permission::create(['name' => 'master-menu product-category update']);
            Permission::create(['name' => 'master-menu product-category delete']);
            // Product Unit
            Permission::create(['name' => 'master-menu product-unit create']);
            Permission::create(['name' => 'master-menu product-unit read']);
            Permission::create(['name' => 'master-menu product-unit update']);
            Permission::create(['name' => 'master-menu product-unit delete']);
            // Product
            Permission::create(['name' => 'master-menu product create']);
            Permission::create(['name' => 'master-menu product read']);
            Permission::create(['name' => 'master-menu product update']);
            Permission::create(['name' => 'master-menu product delete']);

        // Customer Menu
        Permission::create(['name' => 'customer-menu']);
            // Customer
            Permission::create(['name' => 'customer-menu customer create']);
            Permission::create(['name' => 'customer-menu customer read']);
            Permission::create(['name' => 'customer-menu customer update']);
            Permission::create(['name' => 'customer-menu customer delete']);

        // Supplier Menu
        Permission::create(['name' => 'supplier-menu']);
            // Supplier
            Permission::create(['name' => 'supplier-menu supplier create']);
            Permission::create(['name' => 'supplier-menu supplier read']);
            Permission::create(['name' => 'supplier-menu supplier update']);
            Permission::create(['name' => 'supplier-menu supplier delete']);

        // Transaction Menu
        Permission::create(['name' => 'transaction-menu']);
            // Transaction In
            Permission::create(['name' => 'transaction-menu transaction-in create']);
            Permission::create(['name' => 'transaction-menu transaction-in read']);
            Permission::create(['name' => 'transaction-menu transaction-in update']);
            Permission::create(['name' => 'transaction-menu transaction-in delete']);
            // Transaction Out
            Permission::create(['name' => 'transaction-menu transaction-out create']);
            Permission::create(['name' => 'transaction-menu transaction-out read']);
            Permission::create(['name' => 'transaction-menu transaction-out update']);
            Permission::create(['name' => 'transaction-menu transaction-out delete']);

        // Stock Menu
        Permission::create(['name' => 'stock-menu']);
            // Stock In
            Permission::create(['name' => 'stock-menu stock-in create']);
            Permission::create(['name' => 'stock-menu stock-in read']);
            Permission::create(['name' => 'stock-menu stock-in update']);
            Permission::create(['name' => 'stock-menu stock-in delete']);
            // Stock Out
            Permission::create(['name' => 'stock-menu stock-out create']);
            Permission::create(['name' => 'stock-menu stock-out read']);
            Permission::create(['name' => 'stock-menu stock-out update']);
            Permission::create(['name' => 'stock-menu stock-out delete']);

        // Report Menu
        Permission::create(['name' => 'report-menu']);
            // Report
            Permission::create(['name' => 'report-menu report create']);
            Permission::create(['name' => 'report-menu report read']);
            // Permission::create(['name' => 'report-menu report update']);
            // Permission::create(['name' => 'report-menu report delete']);
            
        // Setting Menu
        Permission::create(['name' => 'setting-menu']);
            // User
            Permission::create(['name' => 'setting-menu user create']);
            Permission::create(['name' => 'setting-menu user read']);
            Permission::create(['name' => 'setting-menu user update']);
            Permission::create(['name' => 'setting-menu user delete']);
            // Role
            Permission::create(['name' => 'setting-menu role create']);
            Permission::create(['name' => 'setting-menu role read']);
            Permission::create(['name' => 'setting-menu role update']);
            Permission::create(['name' => 'setting-menu role delete']);
            // Access
            // Permission::create(['name' => 'setting-menu access create']);
            Permission::create(['name' => 'setting-menu access read']);
            // Permission::create(['name' => 'setting-menu access update']);
            // Permission::create(['name' => 'setting-menu access delete']);
            // Configuration
            Permission::create(['name' => 'setting-menu config create']);
            Permission::create(['name' => 'setting-menu config read']);
            Permission::create(['name' => 'setting-menu config update']);
            Permission::create(['name' => 'setting-menu config delete']);
        

        $sa_role = Role::create(['name' => 'Super-Admin']);
        $kasir_ole = Role::create(['name' => 'Kasir']);

        $user = \App\Models\User::factory()->create([
            'name' => 'Super-Admin User',
            'email' => 'superadmin@example.com',
            'password' => bcrypt('12345')
        ]);

        $user->assignRole($sa_role);
    }
}
