<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $permissions = [
            'users' => [
                'create-user',
                'view-user',
                'edit-user',
                'delete-user',
            ],
            'products' => [
                'create-product',
                'edit-product',
                'delete-product',
                'view-product',
            ],
            'posts' => [
                'create-post',
                'edit-post',
                'delete-post',
                'view-post',
            ],
            'orders' => [
                'create-order',
                'edit-order',
                'delete-order',
                'view-order',
            ],
            'categories' => [
                'create-category',
                'edit-category',
                'delete-category',
                'view-category',
            ],
            'settings' => [
                'edit-settings',
            ]
        ];

        $roles = [
            'admin',
            'writer',
            'member',
            'guest',
        ];

        foreach($roles as $role) {
            Role::create([
                'name' => $role,
                'guard_name' => 'web',
            ]);
        }

        foreach($permissions as $group => $perms) {
            foreach($perms as $perm) {
                Permission::firstOrCreate([
                    'name' => $perm,
                    'guard_name' => 'web',
                ]);
            }
        }

        $adminRole = Role::where('name', 'admin')->first();
        $adminRole->givePermissionTo(Permission::all());

        $writerRole = Role::where('name', 'writer')->first();
        $writerRole->givePermissionTo(['create-post', 'edit-post', 'delete-post', 'view-post']);

        $guestRole = Role::where('name', 'guest')->first();
        $guestRole->givePermissionTo(['view-post', 'view-product', 'edit-settings']);

        User::create([
            'name' => 'admin',
            'email' => 'admin@brewcrafters.test',
            'password' => Hash::make('admin#1234'),
        ])->assignRole('admin');

        User::create([
            'name' => 'user',
            'email' => 'user@brewcrafters.test',
            'password' => Hash::make('user#1234'),
        ])->assignRole('guest');


    }
}
