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
            'Coffee Beans' => [
                'Manual Brew' => [
                    'Light Roast' => $this->getProcess(),
                    'Medium Roast' => $this->getProcess(),
                ],
                'Espresso Brew' => [
                    'Dark Roast',
                ],
            ],
            'Ready to Drink' => [
                'Cold Brew',
                'Nitro Cold Brew',
                'Instant Coffee',
            ],
            'Brewing Equipment' => [
                'Pour Over',
                'French Press',
                'Espresso Machines',
            ],
        ];

        $this->createCategories($categories);
    }

    private function createCategories(array $categories, $parentId = null)
    {
        foreach ($categories as $key => $value) {
            if (is_array($value)) {
                // Key is parent name
                $category = ProductCategory::create([
                    'name' => $key,
                    'slug' => Str::slug($key),
                    'parent_id' => $parentId,
                ]);
                $this->createCategories($value, $category->id);
            } else {
                // Value is single child name
                ProductCategory::create([
                    'name' => $value,
                    'slug' => Str::slug($value),
                    'parent_id' => $parentId,
                ]);
            }
        }
    }

    private function getProcess() {
        return [
            'Natural',
            'Anaerobic Natural',
            'Carbonic Maceration',
            'Yellow Honey Process',
            'Red Honey Process',
            'Black Honey Process',
            'Semi Washed',
            'Full Washed',
            'Wet Hulled',
        ];
    }
}
