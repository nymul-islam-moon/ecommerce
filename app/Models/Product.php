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
        'child_category_id', // FIXED naming
        'brand_id',
        'status',
        'is_featured',
        'main_image',
        'gallery_images',
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

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'product_attribute')
            ->withPivot('value')
            ->withTimestamps();
    }

    public function attributeValues()
    {
        return $this->hasMany(AttributeValue::class);
    }

    // Scope for eager loading
    public function scopeWithRelations($query)
    {
        return $query->with(['category', 'subcategory', 'childCategory', 'brand', 'attributes']);
    }
}
