<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\ProductCategory;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Coffee Beans' => ['Light Roast', 'Medium Roast', 'Dark Roast', 'Espresso Roast'],
            'Ready to Drink' => ['Cold Brew', 'Nitro Cold Brew', 'Instant Coffee'],
            'Brewing Equipment' => ['Pour Over', 'French Press', 'Espresso Machines'],
        ];

        foreach ($categories as $parentName => $children) {
            $parent = ProductCategory::create([
                'name' => $parentName,
                'slug' => Str::slug($parentName),
                'parent_id' => null,
            ]);

            foreach ($children as $childName) {
                ProductCategory::create([
                    'name' => $childName,
                    'slug' => Str::slug($childName),
                    'parent_id' => $parent->id,
                ]);
            }
        }
    }
}
