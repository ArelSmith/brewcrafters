<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Hash;
use Illuminate\Database\Seeder;
use App\Models\ProductCategory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@brewcrafters.test',
            'password' => Hash::make('admin#1234')
        ]);

        $this->call(ProductCategorySeeder::class);

        // ProductCategory::create([
        //     'name' => 'Coffee Beans',
        //     'slug' => 'coffee-beans'
        // ]);

        // ProductCategory::create([
        //     'name' => 'Coffee Tools',
        //     'slug' => 'coffee-tools'
        // ]);
    }
}
