<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;


    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    /**
     * Get the subcategories for the category.
     */
    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }

}
