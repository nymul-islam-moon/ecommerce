<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ChildCategorySeeder extends Seeder
{
    public function run(): void
    {
        // Group child categories by subcategory name
        $childCategories = [
            'Smartphones' => [
                ['name' => 'Android Phones', 'description' => 'Latest Android phones from top brands.'],
                ['name' => 'iPhones', 'description' => 'Apple iPhones from different generations.'],
                ['name' => 'Gaming Phones', 'description' => 'High performance smartphones for gaming.'],
            ],
            'Laptops' => [
                ['name' => 'Gaming Laptops', 'description' => 'High-end laptops for gaming.'],
                ['name' => 'Ultrabooks', 'description' => 'Slim and lightweight laptops.'],
                ['name' => 'Business Laptops', 'description' => 'Laptops for office and business use.'],
            ],
            'Men\'s Clothing' => [
                ['name' => 'T-Shirts', 'description' => 'Casual and printed t-shirts.'],
                ['name' => 'Formal Shirts', 'description' => 'Shirts for office and events.'],
                ['name' => 'Jeans', 'description' => 'Denim and stretch-fit jeans.'],
            ],
            'Furniture' => [
                ['name' => 'Sofas', 'description' => 'Single, double, and L-shaped sofas.'],
                ['name' => 'Beds', 'description' => 'Wooden and metal beds with storage.'],
                ['name' => 'Dining Tables', 'description' => '2, 4, and 6-seater dining tables.'],
            ],
            'Fiction' => [
                ['name' => 'Mystery & Thriller', 'description' => 'Crime, suspense, and thriller novels.'],
                ['name' => 'Science Fiction', 'description' => 'Sci-fi and futuristic themed novels.'],
                ['name' => 'Fantasy', 'description' => 'Magical worlds and heroic adventures.'],
            ],
        ];

        foreach ($childCategories as $subCategoryName => $children) {
            $subcategory = DB::table('sub_categories')->where('name', $subCategoryName)->first();

            if ($subcategory) {
                foreach ($children as $child) {
                    DB::table('child_categories')->insert([
                        'subcategory_id' => $subcategory->id,
                        'name' => $child['name'],
                        'slug' => Str::slug($child['name']),
                        'description' => $child['description'],
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                }
            }
        }
    }
}
