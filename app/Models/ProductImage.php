<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'product_variant_id',
        'image_path',
    ];

    /**
     * Relationship: The product this image belongs to.
     */
    // public function product()
    // {
    //     return $this->belongsTo(Product::class);
    // }

    /**
     * Relationship: The variant this image belongs to (optional).
     */
    public function variant()
    {
        return $this->belongsTo(ProductVariant::class);
    }
}
