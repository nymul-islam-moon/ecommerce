<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    /** @use HasFactory<\Database\Factories\AttributesFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'slug'
    ];

    /**
     * Get the attribute values for the attribute.
     */
    public function values()
    {
        return $this->hasMany(AttributeValue::class);
    }

    public function variants()
    {
        return $this->belongsToMany(ProductVariant::class, 'variant_attributes')
            ->withPivot('attribute_value_id')
            ->withTimestamps();
    }
}
