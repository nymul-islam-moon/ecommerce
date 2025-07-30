<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'sku',
        'price',
        'sale_price',
        'stock_quantity',
        'image',
        'weight',
        'height',
        'width',
        'depth'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'product_variant_attributes')
            ->withPivot('attribute_value_id')
            ->withTimestamps();
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'variant_id');
    }
}
