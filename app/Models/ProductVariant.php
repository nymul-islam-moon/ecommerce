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
        'main_image',
        'weight',
        'height',
        'width',
        'depth'
    ];

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'product_variant_attributes', 'product_variant_id', 'attribute_id')
            ->withPivot('attribute_value_id');
    }

    public function syncAttributes(array $attributes)
    {
        $syncData = [];
        foreach ($attributes as $attr) {
            if (isset($attr['attribute_id'], $attr['attribute_value_id'])) {
                $syncData[$attr['attribute_id']] = ['attribute_value_id' => $attr['attribute_value_id']];
            }
        }
        if (!empty($syncData)) {
            $this->attributes()->sync($syncData);
        }
    }


    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_variant_id');
    }
}
