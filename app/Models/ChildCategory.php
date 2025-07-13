<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildCategory extends Model
{
    /** @use HasFactory<\Database\Factories\ChildCategoryFactory> */
    use HasFactory;


    protected $fillable = [
        'name',
        'slug',
        'description',
        'subcategory_id',
    ];

    /**
     * Get the subcategory that owns the child category.
     */
    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'subcategory_id');
    }


    /**
     * Get the category that owns the child category.
     */
    public function category()
    {
        return $this->hasOneThrough(
            Category::class,        // Final model
            SubCategory::class,     // Intermediate model
            'id',                   // Foreign key on SubCategory table (i.e., SubCategory.id)
            'id',                   // Foreign key on Category table (i.e., Category.id)
            'subcategory_id',       // Local key on ChildCategory (i.e., ChildCategory.subcategory_id)
            'category_id'           // Local key on SubCategory (i.e., SubCategory.category_id)
        );
    }
}
