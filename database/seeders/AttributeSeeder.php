<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $attributes = [
            'Color',
            'Size',
            'Material',
            'Weight',
            'RAM',
            'Storage',
            'Screen Size',
            'Battery Capacity',
            'Operating System',
            'Warranty',
        ];

        foreach ($attributes as $name) {
            DB::table('attributes')->insert([
                'name' => $name,
                'slug' => Str::slug($name),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
