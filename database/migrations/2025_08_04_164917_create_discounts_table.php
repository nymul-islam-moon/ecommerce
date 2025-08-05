<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // e.g., "Summer Sale"
            $table->enum('type', ['product', 'cart', 'bogo', 'bulk']);
            $table->enum('discount_type', ['fixed', 'percent'])->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->integer('buy_quantity')->nullable(); // For bulk or BOGO: Buy X
            $table->integer('get_quantity')->nullable(); // For BOGO: Get Y
            $table->foreignId('free_product_id')->nullable()->constrained('products'); // Free product for BOGO
            $table->string('coupon_code')->nullable(); // For cart discounts
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
};
