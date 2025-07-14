<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Models\Brand;
use App\Services\MediaService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::paginate(10);
        return view('admin.products.brands.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.products.brands.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBrandRequest $request, MediaService $mediaService)
    {
        $formData = $request->validated();

        DB::beginTransaction();

        try {
            if ($request->hasFile('image')) {
                $formData['image'] = $mediaService->storeFile($request->file('image'), 'brands');
            }

            $formData['slug'] = Str::slug($formData['name']);

            Brand::create($formData);
            DB::commit();
            return redirect()->route('admin.brands.index')->with('success', 'Brand created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Failed to create brand: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        return view('admin.products.brands.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBrandRequest $request, Brand $brand, MediaService $mediaService)
    {
        $formData = $request->validated();

        DB::beginTransaction();

        try {
            if ($request->hasFile('image')) {
                // Delete old image
                $mediaService->deleteFile($brand->image, 'public');

                // Store new image
                $formData['image'] = $mediaService->storeFile($request->file('image'), 'brands');
            }

            $formData['slug'] = Str::slug($formData['name']);

            $brand->update($formData);
            DB::commit();
            return redirect()->route('admin.brands.index')->with('success', 'Brand updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Failed to update brand: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand, MediaService $mediaService)
    {
        DB::beginTransaction();

        try {
            // Delete the brand's image if it exists
            $mediaService->deleteFile($brand->image, 'public');

            $brand->delete();
            DB::commit();
            return redirect()->route('admin.brands.index')->with('success', 'Brand deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Failed to delete brand: ' . $e->getMessage()]);
        }
    }
}
