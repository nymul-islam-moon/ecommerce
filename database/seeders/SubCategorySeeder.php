<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subCategories = [
            [
                'name' => 'Fiction',
                'slug' => 'fiction',
                'description' => 'Fictional books of various genres',
                'category_id' => 1, // Assuming 1 is the ID for Books category
            ],
            [
                'name' => 'Smartphones',
                'slug' => 'smartphones',
                'description' => 'Latest smartphones from top brands',
                'category_id' => 2, // Assuming 2 is the ID for Electronics category
            ],
            [
                'name' => 'Men\'s Clothing',
                'slug' => 'mens-clothing',
                'description' => 'Stylish clothing',
                'category_id' => 3, // Assuming 3 is the ID for Clothing category
            ],
            [
                'name' => 'Kitchen Appliances',
                'slug' => 'kitchen-appliances',
                'description' => 'Essential kitchen appliances',
                'category_id' => 4, // Assuming 4 is the ID for Home Appliances category
            ],
            [
                'name' => 'Football Gear',
                'slug' => 'football-gear',
                'description' => 'Equipment for football enthusiasts',
                'category_id' => 5, // Assuming 5 is the ID for Sports Equipment category
            ],
            [
                'name' => 'Educational Toys',
                'slug' => 'educational-toys',
                'description' => 'Toys that promote learning',
                'category_id' => 6, // Assuming 6 is the ID for Toys category
            ],
            [
                'name' => 'Skincare Products',
                'slug' => 'skincare-products',
                'description' => 'Products for healthy skin',
                'category_id' => 7, // Assuming 7 is the ID for Beauty Products category
            ],
            [
                'name' => 'Living Room Furniture',
                'slug' => 'living-room-furniture',
                'description' => 'Comfortable furniture for your living room',
                'category_id' => 8, // Assuming 8 is the ID for Furniture category
            ],
            [
                'name' => 'Gardening Tools',
                'slug' => 'gardening-tools',
                'description' => 'Tools and supplies for gardening enthusiasts',
                'category_id' => 9, // Assuming 9 is the ID for Gardening Supplies category
            ]

        ];

        foreach ($subCategories as $subCategory) {
            \App\Models\SubCategory::create($subCategory);
        }
    }
}
