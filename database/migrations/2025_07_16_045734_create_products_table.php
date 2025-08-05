<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            // Basic Info
            $table->string('sku', 100)->nullable()->unique(); // SKU for simple products only
            $table->string('slug', 100)->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->text('short_description')->nullable();

            // Product Type
            $table->enum('product_type', ['simple', 'variable'])->default('simple');

            // Pricing (for simple products only)
            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->enum('discount_type', ['percent', 'fixed'])->nullable()->after('sale_price');


            // Inventory (for simple products only)
            $table->integer('stock_quantity')->nullable();
            $table->integer('low_stock_threshold')->nullable();
            $table->timestamp('restock_date')->nullable();

            // Physical Details
            $table->decimal('weight', 10, 2)->nullable();
            $table->decimal('width', 8, 2)->nullable();
            $table->decimal('height', 8, 2)->nullable();
            $table->decimal('depth', 8, 2)->nullable();

            // Product Identifiers
            $table->string('mpn')->nullable();
            $table->string('gtin8')->nullable();
            $table->string('gtin13')->nullable();
            $table->string('gtin14')->nullable();

            // Return Policy
            $table->text('return_policy')->nullable();
            $table->integer('return_days')->nullable();

            $table->string('main_image')->nullable();

            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();

            // Status
            $table->enum('status', ['active', 'inactive', 'discontinued', 'out_of_stock'])->default('active');
            $table->boolean('is_featured')->default(false);

            // Relationships
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('cascade');
            $table->foreignId('subcategory_id')->nullable()->constrained('sub_categories')->onDelete('cascade');
            $table->foreignId('child_category_id')->nullable()->constrained('child_categories')->onDelete('cascade');
            $table->foreignId('brand_id')->nullable()->constrained('brands')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
}
