<?php

namespace Database\Seeders;

use App\Models\ProductVariant;
use Illuminate\Database\Seeder;

class ProductVariantSeeder extends Seeder
{
    public function run(): void
    {
        $variants = [
            [
                'product_id' => 2, // Cotton T-Shirt
                'sku' => 'TSHIRT-RED-M',
                'price' => 1200,
                'sale_price' => 1000,
                'stock_quantity' => 30,
                'weight' => 0.25,
                'width' => 30,
                'height' => 2,
                'depth' => 25,
            ],
            [
                'product_id' => 2,
                'sku' => 'TSHIRT-BLUE-L',
                'price' => 1250,
                'sale_price' => 1100,
                'stock_quantity' => 20,
                'weight' => 0.28,
                'width' => 32,
                'height' => 2,
                'depth' => 27,
            ]
        ];

        foreach ($variants as $variant) {
            ProductVariant::create($variant);
        }
    }
}
