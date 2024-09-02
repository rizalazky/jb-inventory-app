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

        // Permission::create(['name' => 'manage kategori produk']);
        Permission::create(['name' => 'lihat kategori produk']);
        Permission::create(['name' => 'tambah kategori produk']);
        Permission::create(['name' => 'update kategori produk']);
        Permission::create(['name' => 'hapus kategori produk']);

        // Permission::create(['name' => 'manage unit produk']);
        Permission::create(['name' => 'lihat unit produk']);
        Permission::create(['name' => 'hapus unit produk']);
        Permission::create(['name' => 'update unit produk']);
        Permission::create(['name' => 'tambah unit produk']);

        // Permission::create(['name' => 'manage produk']);
        Permission::create(['name' => 'lihat produk']);
        Permission::create(['name' => 'hapus produk']);
        Permission::create(['name' => 'update produk']);
        Permission::create(['name' => 'tambah produk']);

        // Permission::create(['name' => 'manage customer']);
        Permission::create(['name' => 'lihat customer']);
        Permission::create(['name' => 'hapus customer']);
        Permission::create(['name' => 'update customer']);
        Permission::create(['name' => 'tambah customer']);
        
        // Permission::create(['name' => 'manage supplier']);
        Permission::create(['name' => 'lihat supplier']);
        Permission::create(['name' => 'hapus supplier']);
        Permission::create(['name' => 'update supplier']);
        Permission::create(['name' => 'tambah supplier']);

        // Permission::create(['name' => 'manage transaksi']);

        // Permission::create(['name' => 'manage transaksi masuk']);
        Permission::create(['name' => 'lihat transaksi masuk']);
        Permission::create(['name' => 'hapus transaksi masuk']);
        Permission::create(['name' => 'update transaksi masuk']);
        Permission::create(['name' => 'tambah transaksi masuk']);

        // Permission::create(['name' => 'manage transaksi keluar']);
        Permission::create(['name' => 'lihat transaksi keluar']);
        Permission::create(['name' => 'hapus transaksi keluar']);
        Permission::create(['name' => 'update transaksi keluar']);
        Permission::create(['name' => 'tambah transaksi keluar']);


        // Permission::create(['name' => 'manage stok']);

        // Permission::create(['name' => 'manage stok masuk']);
        Permission::create(['name' => 'lihat stok masuk']);
        Permission::create(['name' => 'hapus stok masuk']);
        Permission::create(['name' => 'update stok masuk']);
        Permission::create(['name' => 'tambah stok masuk']);

        // Permission::create(['name' => 'manage stok keluar']);
        Permission::create(['name' => 'lihat stok keluar']);
        Permission::create(['name' => 'hapus stok keluar']);
        Permission::create(['name' => 'update stok keluar']);
        Permission::create(['name' => 'tambah stok keluar']);
        
        // Permission::create(['name' => 'manage laporan']);
        Permission::create(['name' => 'lihat laporan']);
        
        // Permission::create(['name' => 'manage user']);
        Permission::create(['name' => 'lihat user']);
        Permission::create(['name' => 'hapus user']);
        Permission::create(['name' => 'update user']);
        Permission::create(['name' => 'tambah user']);

        // Permission::create(['name' => 'manage role']);
        Permission::create(['name' => 'lihat role']);
        Permission::create(['name' => 'hapus role']);
        Permission::create(['name' => 'update role']);
        Permission::create(['name' => 'tambah role']);

       

        // Permission::create(['name' => 'manage akses']);
        Permission::create(['name' => 'lihat akses']);

        $role = Role::create(['name' => 'Super-Admin']);

        $user = \App\Models\User::factory()->create([
            'name' => 'Super-Admin User',
            'email' => 'superadmin@example.com',
            'password' => bcrypt('12345')
        ]);

        $user->assignRole($role);
    }
}
