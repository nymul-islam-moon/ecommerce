<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'Leather Wallet',
                'sku' => 'WALLET-001',
                'slug' => Str::slug('Leather Wallet'),
                'short_description' => 'Genuine leather wallet with premium finish.',
                'description' => 'A stylish and durable leather wallet for men with multiple compartments.',
                'price' => 2000,
                'sale_price' => 1800,
                'stock_quantity' => 20,
                'category_id' => 1,
                'subcategory_id' => 1,
                'child_category_id' => 1,
                'brand_id' => 1,
                'product_type' => 'simple',
                'weight' => 0.15,
                'width' => 10,
                'height' => 2,
                'depth' => 8,
                'mpn' => 'MPN-W001',
                'gtin8' => '12345671',
                'gtin13' => '1234567890121',
                'gtin14' => '12345678901231',
                'return_policy' => 'Return within 7 days for unused items.',
                'return_days' => 7,
                'main_image' => 'products/wallet_main.jpg',
                'meta_title' => 'Leather Wallet',
                'meta_description' => 'Premium leather wallet for men.',
                'meta_keywords' => 'wallet, leather, men',
                'status' => 'active',
                'is_featured' => false,
            ],
            [
                'name' => 'Cotton T-Shirt',
                'sku' => 'TSHIRT-001',
                'slug' => Str::slug('Cotton T-Shirt'),
                'short_description' => '100% cotton breathable t-shirt.',
                'description' => 'Available in multiple colors and sizes, perfect for summer.',
                'price' => null,
                'sale_price' => null,
                'stock_quantity' => null,
                'category_id' => 1,
                'subcategory_id' => 1,
                'child_category_id' => 1,
                'brand_id' => 1,
                'product_type' => 'variable',
                'weight' => 0.25,
                'width' => 30,
                'height' => 2,
                'depth' => 25,
                'mpn' => 'MPN-T001',
                'gtin8' => '12345678',
                'gtin13' => '1234567890123',
                'gtin14' => '12345678901234',
                'return_policy' => 'Returns accepted within 7 days.',
                'return_days' => 7,
                'main_image' => 'products/tshirt_main.jpg',
                'meta_title' => 'Cotton T-Shirt',
                'meta_description' => 'High-quality cotton t-shirt.',
                'meta_keywords' => 'tshirt, cotton, fashion',
                'status' => 'active',
                'is_featured' => true,
            ]
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
