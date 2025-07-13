<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSubCategoryRequest;
use App\Http\Requests\UpdateSubCategoryRequest;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Str;


class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Eager load the parent category to avoid N+1
        $subCategories = SubCategory::with('category')->paginate(5);

        return view('admin.products.subcategories.index', compact('subCategories'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.subcategories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubCategoryRequest $request)
    {
        $formData = $request->validated();

        $formData['slug'] = Str::slug($formData['name']) . '-' . Category::find($formData['category_id'])->slug;

        SubCategory::create($formData);

        return redirect()->route('admin.subcategories.index')->with('success', 'SubCategory created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SubCategory $subCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubCategory $subcategory)
    {
        $categories = Category::all();
        return view('admin.products.subcategories.edit', compact('subcategory', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubCategoryRequest $request, SubCategory $subcategory)
    {
        $formData = $request->validated();

        // Update the slug if the name has changed
        if ($formData['name'] !== $subcategory->name) {
            $formData['slug'] = Str::slug($formData['name']) . '-' . $subcategory->category->slug;
        }

        $subcategory->update($formData);

        return redirect()->route('admin.subcategories.index')->with('success', 'SubCategory updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubCategory $subcategory)
    {
        // dd($subCategory);
        $subcategory->delete();

        return redirect()->route('admin.subcategories.index')->with('error', 'SubCategory deleted successfully.');
    }
}
