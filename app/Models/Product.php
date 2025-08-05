<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sku',
        'slug',
        'short_description',
        'description',
        'price',
        'sale_price',
        'stock_quantity',
        'category_id',
        'subcategory_id',
        'child_category_id',
        'brand_id',
        'status',
        'is_featured',
        'main_image',
        'product_type',
        'low_stock_threshold',
        'restock_date',
        'weight',
        'width',
        'height',
        'depth',
        'mpn',
        'gtin8',
        'gtin13',
        'gtin14',
        'return_policy',
        'return_days'
    ];


    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }


    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function childCategory()
    {
        return $this->belongsTo(ChildCategory::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function discounts()
    {
        return $this->belongsToMany(Discount::class, 'discount_products');
    }

    // Auto calculate final price
    public function getFinalPriceAttribute()
    {
        $discount = $this->discounts()
            ->where('type', 'product')
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->first();

        if (!$discount) {
            return $this->price; // No discount
        }

        if ($discount->discount_type === 'percent') {
            return max(0, $this->price - ($this->price * $discount->amount / 100));
        }

        return max(0, $this->price - $discount->amount);
    }



    // Optional: preload variants + images if needed
    public function scopeWithRelations($query)
    {
        return $query->with([
            'variants',
            'images',
        ]);
    }
}
