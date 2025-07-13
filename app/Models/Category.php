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


    // app/Models/Category.php

    public function childCategories()
    {
        return $this->hasManyThrough(
            ChildCategory::class,
            SubCategory::class,
            'category_id',     // Foreign key on SubCategory table
            'subcategory_id',  // Foreign key on ChildCategory table
            'id',              // Local key on Category table
            'id'               // Local key on SubCategory table
        );
    }
}
