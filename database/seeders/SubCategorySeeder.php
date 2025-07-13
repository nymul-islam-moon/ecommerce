<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class SubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Ensure there are categories available
        $categories = Category::all();
        if ($categories->isEmpty()) {
            $this->command->error('No categories found. Please seed categories first.');
            return;
        }

        foreach (range(1, 10) as $i) {
            $category = $categories->random();

            $name = $faker->unique()->words(2, true); // e.g., "mobile phones"
            $slug = Str::slug($name) . '-' . $category->slug;

            SubCategory::create([
                'name' => $name,
                'slug' => $slug,
                'description' => $faker->sentence(),
                'category_id' => $category->id,
            ]);
        }
    }
}
