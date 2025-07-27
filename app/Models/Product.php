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
        'hight',
        'depth',
        'mpn',
        'gtin8',
        'gtin13',
        'gtin14',
        'return_policy',
        'return_days'
    ];

    // Relations
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

    // In ProductVariant.php
    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'variant_attributes')
            ->withPivot('value_id')
            ->withTimestamps();
    }


    public function attributeValues()
    {
        return $this->hasMany(AttributeValue::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }


    // Scope for eager loading
    public function scopeWithRelations($query)
    {
        return $query->with([
            'variants',                  // load variants
            'variants.attributes',       // load attributes for each variant
            'variants.images',           // load variant images
            'images'                     // load product images
        ]);
    }
}
