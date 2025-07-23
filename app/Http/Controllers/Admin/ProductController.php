<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ChildCategory;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\Attribute;
use App\Services\MediaService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::withRelations();

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('short_description')) {
            $query->where('short_description', 'like', '%' . $request->short_description . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('stock_quantity')) {
            $query->where('stock_quantity', $request->stock_quantity);
        }

        $products = $query->paginate(10)->appends($request->all());

        return view('admin.products.index', compact('products'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.products.create', [
            // 'categories' => Category::all(),
            // 'subcategories' => SubCategory::all(),
            // 'childCategories' => ChildCategory::all(),
            // 'brands' => Brand::all(),
            // 'attributes' => Attribute::with('values')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request, MediaService $mediaService)
    {
        $formData = $request->validated();

        dd($formData);

        DB::beginTransaction();

        try {
            // Generate slug if not provided
            if (empty($formData['slug'])) {
                $formData['slug'] = Str::slug($formData['name']);
            }

            // Handle main image upload
            if ($request->hasFile('main_image')) {
                $formData['main_image'] = $mediaService->storeFile($request->file('main_image'), 'products');
            }

            // Handle gallery images upload
            $galleryImages = [];
            if ($request->hasFile('gallery_images')) {
                foreach ($request->file('gallery_images') as $image) {
                    $galleryImages[] = $mediaService->storeFile($image, 'products/gallery');
                }
            }

            // Create product
            $product = Product::create($formData);

            // Save gallery images (if you have a separate table for product images)
            if (!empty($galleryImages)) {
                foreach ($galleryImages as $img) {
                    $product->images()->create(['image_path' => $img]);
                }
            }

            // Attach attributes
            if ($request->has('attribute_values')) {
                foreach ($request->attribute_values as $attributeId => $valueId) {
                    if ($valueId) {
                        $product->attributes()->attach($attributeId, ['value_id' => $valueId]);
                    }
                }
            }

            DB::commit();
            return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to create product: ' . $e->getMessage()]);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
