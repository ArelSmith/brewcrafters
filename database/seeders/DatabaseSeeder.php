<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $adminUser = User::create([
            'name' => 'Admin',
            'email' => 'admin@brewcrafters.com',
            'password' => Hash::make('admin#1234'),
        ]);

        $guestUser = User::create([
            'name' => "Shida",
            'email' => 'shida@gmail.com',
            'password' => Hash::make('shida#1234'),
        ]);

        Role::create(['name' => 'guest']);
        Role::create(['name' => 'member']);
        Role::create(['name' => 'writer']);
        Role::create(['name' => 'admin']);

        $adminUser->assignRole('admin');
        $guestUser->assignRole('guest');

    }
}
