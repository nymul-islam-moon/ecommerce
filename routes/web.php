<?php

use App\Http\Controllers\Admin\AttributesController;
use App\Http\Controllers\Admin\AttributeValueController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ChildCategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SubCategoryController;
use Illuminate\Support\Facades\Route;


// Attribute value routes (nested under attribute)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('categories', CategoryController::class);
    Route::resource('subcategories', SubCategoryController::class);
    Route::resource('childcategories', ChildCategoryController::class);
    Route::resource('brands', BrandController::class);
    Route::resource('attributes', AttributesController::class);

    // ✅ NESTED attribute values
    Route::prefix('attributes/{attribute}')->group(function () {
        Route::get('values/create', [AttributeValueController::class, 'create'])->name('attribute-values.create');
    });

    Route::post('attribute-values/store', [AttributeValueController::class, 'store'])->name('attribute-values.store');
    Route::get('attribute-values/{attributeValue}/edit', [AttributeValueController::class, 'edit'])->name('attribute-values.edit');
    Route::put('attribute-values/{attributeValue}', [AttributeValueController::class, 'update'])->name('attribute-values.update');
    Route::delete('attribute-values/{attributeValue}', [AttributeValueController::class, 'destroy'])->name('attribute-values.destroy');
});

