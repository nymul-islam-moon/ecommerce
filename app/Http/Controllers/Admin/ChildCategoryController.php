<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreChildCategoryRequest;
use App\Http\Requests\UpdateChildCategoryRequest;
use App\Models\ChildCategory;
use App\Models\SubCategory;
use Illuminate\Support\Str;

class ChildCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $childcategories = ChildCategory::with(['category', 'subcategory'])
            // ->withCount('products')
            ->paginate(10);

        return view('admin.products.childcategories.index', compact('childcategories'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subcategories = SubCategory::all();
        return view('admin.products.childcategories.create', compact('subcategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreChildCategoryRequest $request)
    {
        $formData = $request->validated();

        // Generate slug based on name and subcategory
        $formData['slug'] = Str::slug($formData['name']) . '-' . SubCategory::find($formData['subcategory_id'])->slug;

        ChildCategory::create($formData);

        return redirect()->route('admin.childcategories.index')->with('success', 'Child Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ChildCategory $childCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ChildCategory $childcategory)
    {
        $subcategories = SubCategory::all();
        return view('admin.products.childcategories.edit', compact('childcategory', 'subcategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateChildCategoryRequest $request, ChildCategory $childcategory)
    {
        $formData = $request->validated();
        // dd($formData);
        // Update the slug if the name has changed
        if ($formData['name'] !== $childcategory->name) {
            $formData['slug'] = Str::slug($formData['name']) . '-' . $childcategory->subcategory->slug;
        }

        $childcategory->update($formData);

        return redirect()->route('admin.childcategories.index')->with('success', 'Child Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ChildCategory $childcategory)
    {
        // dd($childCategory);
        $childcategory->delete();

        return redirect()->route('admin.childcategories.index')->with('error', 'Child Category deleted successfully.');
    }
}
