<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class SubCategorySeeder extends Seeder
{
    public function run(): void
    {
        // Define subcategories grouped by category name
        $subCategories = [
            'Electronics' => [
                ['name' => 'Smartphones', 'description' => 'Latest Android and iOS phones.'],
                ['name' => 'Laptops', 'description' => 'Gaming and business laptops.'],
                ['name' => 'Cameras', 'description' => 'Digital, DSLR, and mirrorless cameras.'],
            ],
            'Fashion' => [
                ['name' => 'Men\'s Clothing', 'description' => 'Shirts, pants, jackets, and more.'],
                ['name' => 'Women\'s Clothing', 'description' => 'Sarees, kurtis, tops, and more.'],
                ['name' => 'Footwear', 'description' => 'Casual, sports, and formal shoes.'],
            ],
            'Home & Kitchen' => [
                ['name' => 'Furniture', 'description' => 'Tables, sofas, beds, and chairs.'],
                ['name' => 'Cookware', 'description' => 'Pots, pans, pressure cookers.'],
                ['name' => 'Home Decor', 'description' => 'Curtains, lamps, wall art.'],
            ],
            'Books & Stationery' => [
                ['name' => 'Fiction', 'description' => 'Novels, stories, and literature.'],
                ['name' => 'Academic', 'description' => 'School and college books.'],
                ['name' => 'Stationery', 'description' => 'Notebooks, pens, and supplies.'],
            ],
        ];

        foreach ($subCategories as $categoryName => $subs) {
            $category = DB::table('categories')->where('name', $categoryName)->first();

            if ($category) {
                foreach ($subs as $sub) {
                    DB::table('sub_categories')->insert([
                        'category_id' => $category->id,
                        'name' => $sub['name'],
                        'slug' => Str::slug($sub['name']),
                        'description' => $sub['description'],
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                }
            }
        }
    }
}
