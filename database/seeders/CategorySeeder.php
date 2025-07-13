<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;


class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $categories = [
            [
                'name' => 'Books',
                'slug' => 'books',
                'description' => 'All kinds of books',
            ],
            [
                'name' => 'Electronics',
                'slug' => 'electronics',
                'description' => 'All kinds of electronic items',
            ],
            [
                'name' => 'Clothing',
                'slug' => 'clothing',
                'description' => 'Fashionable clothing for all ages',
            ],
            [
                'name' => 'Home Appliances',
                'slug' => 'home-appliances',
                'description' => 'Essential appliances for your home',
            ],
            [
                'name' => 'Sports Equipment',
                'slug' => 'sports-equipment',
                'description' => 'Gear and equipment for all sports',
            ],
            [
                'name' => 'Toys',
                'slug' => 'toys',
                'description' => 'Fun and educational toys for children',
            ],
            [
                'name' => 'Beauty Products',
                'slug' => 'beauty-products',
                'description' => 'Skincare and makeup products',
            ],
            [
                'name' => 'Furniture',
                'slug' => 'furniture',
                'description' => 'Stylish and comfortable furniture for your home',
            ],
            [
                'name' => 'Gardening Supplies',
                'slug' => 'gardening-supplies',
                'description' => 'Tools and supplies for gardening enthusiasts',
            ],
            [
                'name' => 'Automotive',
                'slug' => 'automotive',
                'description' => 'Car accessories and parts',
            ],
            [
                'name' => 'Health Supplements',
                'slug' => 'health-supplements',
                'description' => 'Vitamins and supplements for a healthy lifestyle',
            ],
            [
                'name' => 'Pet Supplies',
                'slug' => 'pet-supplies',
                'description' => 'Food and accessories for your pets',
            ],
            [
                'name' => 'Jewelry',
                'slug' => 'jewelry',
                'description' => 'Elegant and stylish jewelry for all occasions',
            ],
            [
                'name' => 'Musical Instruments',
                'slug' => 'musical-instruments',
                'description' => 'Instruments for music lovers and professionals',
            ],
            [
                'name' => 'Office Supplies',
                'slug' => 'office-supplies',
                'description' => 'Everything you need for your office',
            ],
            [
                'name' => 'Travel Accessories',
                'slug' => 'travel-accessories',
                'description' => 'Essential items for your travels',
            ],
            [
                'name' => 'Kitchenware',
                'slug' => 'kitchenware',
                'description' => 'Cookware and utensils for your kitchen',
            ],
            [
                'name' => 'Photography',
                'slug' => 'photography',
                'description' => 'Cameras and accessories for photography enthusiasts',
            ],
            [
                'name' => 'Gaming',
                'slug' => 'gaming',
                'description' => 'Video games and gaming accessories',
            ],
            [
                'name' => 'Health & Wellness',
                'slug' => 'health-wellness',
                'description' => 'Products for health and wellness',
            ],
            [
                'name' => 'Baby Products',
                'slug' => 'baby-products',
                'description' => 'Everything for your baby\'s needs',
            ]
        ];

        // Insert all at once
        Category::insert($categories);
    }
}
