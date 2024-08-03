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

        
        Permission::create(['name' => 'lihat user']);
        Permission::create(['name' => 'hapus user']);
        Permission::create(['name' => 'update user']);
        Permission::create(['name' => 'buat user']);

        Permission::create(['name' => 'lihat role']);
        Permission::create(['name' => 'hapus role']);
        Permission::create(['name' => 'update role']);
        Permission::create(['name' => 'buat role']);

        Permission::create(['name' => 'lihat laporan']);

        Permission::create(['name' => 'lihat akses']);

        Permission::create(['name' => 'lihat kategori produk']);
        Permission::create(['name' => 'hapus kategori produk']);
        Permission::create(['name' => 'update kategori produk']);
        Permission::create(['name' => 'buat kategori produk']);

        Permission::create(['name' => 'lihat unit produk']);
        Permission::create(['name' => 'hapus unit produk']);
        Permission::create(['name' => 'update unit produk']);
        Permission::create(['name' => 'buat unit produk']);

        Permission::create(['name' => 'lihat produk']);
        Permission::create(['name' => 'hapus produk']);
        Permission::create(['name' => 'update produk']);
        Permission::create(['name' => 'buat produk']);


        Permission::create(['name' => 'lihat customer']);
        Permission::create(['name' => 'hapus customer']);
        Permission::create(['name' => 'update customer']);
        Permission::create(['name' => 'buat customer']);

        Permission::create(['name' => 'lihat supplier']);
        Permission::create(['name' => 'hapus supplier']);
        Permission::create(['name' => 'update supplier']);
        Permission::create(['name' => 'buat supplier']);

        Permission::create(['name' => 'lihat transaksi masuk']);
        Permission::create(['name' => 'hapus transaksi masuk']);
        Permission::create(['name' => 'update transaksi masuk']);
        Permission::create(['name' => 'buat transaksi masuk']);

        Permission::create(['name' => 'lihat transaksi keluar']);
        Permission::create(['name' => 'hapus transaksi keluar']);
        Permission::create(['name' => 'update transaksi keluar']);
        Permission::create(['name' => 'buat transaksi keluar']);

        $role = Role::create(['name' => 'Super-Admin']);

        $user = \App\Models\User::factory()->create([
            'name' => 'Super-Admin User',
            'email' => 'superadmin@example.com',
            'password' => bcrypt('12345')
        ]);

        $user->assignRole($role);
    }
}
