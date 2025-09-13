<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Hash;
use Illuminate\Database\Seeder;
use App\Models\ProductCategory;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $guestUser = User::create([
            'name' => 'Shida',
            'email' => 'shida@gmail.com',
            'password' => Hash::make('shida#1234'),
        ]);
        $adminUser = User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@brewcrafters.test',
            'password' => Hash::make('admin#1234'),
        ]);

        $this->call(ProductCategorySeeder::class);

        $permissions = [
            // User Management
            'view users',
            'create users',
            'edit users',
            'delete users',
            'assign users',

            // Product Management
            'view products',
            'create products',
            'edit products',
            'delete products',

            // Category Management
            'view categories',
            'create categories',
            'edit categories',
            'delete categories',

            // Blog Management
            'view posts',
            'create posts',
            'edit posts',
            'delete posts',

            // Order management
            'view orders',
            'update orders',
            'cancel orders',
            'refund orders',
            'add to cart',

            // Reports
            'view user reports',
            'reply user reports',

            // Filament dashboard
            'access admin panel',
            'access user panel',

            // Settings
            'manage settings',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        $adminRole = Role::firstOrCreate([
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        $guestRole = Role::firstOrCreate([
            'name' => 'guest',
            'guard_name' => 'web',
        ]);

        $customerRole = Role::firstOrCreate([
            'name' => 'customer',
            'guard_name' => 'web',
        ]);

        $writerRole = Role::firstOrCreate([
            'name' => 'writer',
            'guard_name' => 'web',
        ]);

        $adminRole->givePermissionTo(Permission::all());

        $guestRole->givePermissionTo(['view products', 'view posts', 'view categories']);

        $customerRole->givePermissionTo(['view products', 'view posts', 'view categories', 'add to cart', 'view orders', 'cancel orders']);

        $writerRole->givePermissionTo(['create posts', 'edit posts']);

        $adminUser->assignRole($adminRole);
        $guestUser->assignRole($guestRole);
    }
}
