<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AttributeValueSeeder extends Seeder
{
    public function run(): void
    {
        // Map of attribute name => array of values
        $attributeValues = [
            'Color' => ['Red', 'Blue', 'Green', 'Black', 'White', 'Yellow'],
            'Size' => ['Small', 'Medium', 'Large', 'XL', 'XXL'],
            'Material' => ['Cotton', 'Leather', 'Plastic', 'Metal', 'Wood'],
            'Weight' => ['1kg', '2kg', '500g', '250g'],
            'RAM' => ['2GB', '4GB', '8GB', '16GB'],
            'Storage' => ['64GB', '128GB', '256GB', '512GB', '1TB'],
            'Screen Size' => ['5.5 inch', '6.1 inch', '6.7 inch', '15.6 inch'],
            'Battery Capacity' => ['3000mAh', '4000mAh', '5000mAh'],
            'Operating System' => ['Android', 'iOS', 'Windows', 'macOS', 'Linux'],
            'Warranty' => ['6 Months', '1 Year', '2 Years'],
        ];

        foreach ($attributeValues as $attributeName => $values) {
            // Get the attribute by name
            $attribute = DB::table('attributes')->where('name', $attributeName)->first();

            if ($attribute) {
                foreach ($values as $value) {
                    DB::table('attribute_values')->insertOrIgnore([
                        'attribute_id' => $attribute->id,
                        'value' => $value,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                }
            }
        }
    }
}
