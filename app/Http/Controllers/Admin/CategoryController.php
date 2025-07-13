<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Support\Str;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::withCount(['subcategories', 'childCategories'])->paginate(5);
        return view('admin.products.categories.index', compact('categories'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.products.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $formData = $request->validated();

        $formData['slug'] = Str::slug($formData['name']);

        Category::create($formData);

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('admin.products.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $formData = $request->validated();

        // Update the slug if the name has changed
        if ($formData['name'] !== $category->name) {
            $formData['slug'] = Str::slug($formData['name']);
        }

        $category->update($formData);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('error', 'Category deleted successfully.');
    }
}
