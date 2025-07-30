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
            'attributes' => Attribute::with('values')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request, MediaService $mediaService)
    {
        $formData = $request->validated();
        // dd($formData);
        DB::beginTransaction();
        try {
            // Generate slug if not provided
            if (empty($formData['slug'])) {
                $formData['slug'] = Str::slug($formData['name']);
            }

            /** ------------------------
             * 1. Handle Product Images
             * ------------------------ */
            if ($request->hasFile('main_image')) {
                $formData['main_image'] = $mediaService->storeFile($request->file('main_image'), 'products');
            }

            $galleryImages = [];
            if ($request->hasFile('gallery_images')) {
                foreach ($request->file('gallery_images') as $image) {
                    $galleryImages[] = $mediaService->storeFile($image, 'products/gallery');
                }
            }

            /** ------------------------
             * 2. Create Product
             * ------------------------ */
            // $product = Product::create([
            //     'name' => $formData['name'],
            //     'sku' => $formData['sku'] ?? null,
            //     'slug' => $formData['slug'],
            //     'short_description' => $formData['short_description'] ?? null,
            //     'description' => $formData['description'] ?? null,
            //     'product_type' => $formData['product_type'],
            //     'price' => $formData['product_type'] === 'simple' ? $formData['price'] : null,
            //     'sale_price' => $formData['product_type'] === 'simple' ? ($formData['sale_price'] ?? null) : null,
            //     'stock_quantity' => $formData['product_type'] === 'simple' ? ($formData['stock_quantity'] ?? 0) : null,
            //     'category_id' => $formData['category_id'],
            //     'subcategory_id' => $formData['subcategory_id'] ?? null,
            //     'child_category_id' => $formData['child_category_id'] ?? null,
            //     'brand_id' => $formData['brand_id'] ?? null,
            //     'status' => $formData['status'],
            //     'is_featured' => $formData['is_featured'],
            //     'main_image' => $formData['main_image'] ?? null,
            // ]);

            $product = Product::create($formData);

            // Save gallery images
            foreach ($galleryImages as $img) {
                $product->images()->create(['image_path' => $img]);
            }

            /** ------------------------
             * 3. Handle Variants (if variable)
             * ------------------------ */
            if ($formData['product_type'] === 'variable' && isset($formData['combinations'])) {
                foreach ($formData['combinations'] as $index => $combination) {
                    // Variant main image
                    $variantMainImage = null;
                    if ($request->hasFile("combinations.$index.main_image")) {
                        $variantMainImage = $mediaService->storeFile(
                            $request->file("combinations.$index.main_image"),
                            'products/variants'
                        );
                    }

                    // Create variant
                    $variant = $product->variants()->create([
                        'sku' => $combination['sku'] ?? null,
                        'price' => $combination['price'],
                        'sale_price' => $combination['sale_price'] ?? null,
                        'stock_quantity' => $combination['stock_quantity'],
                        'weight' => $combination['weight'] ?? null,
                        'height' => $combination['height'] ?? null,
                        'width' => $combination['width'] ?? null,
                        'depth' => $combination['depth'] ?? null,
                    ]);

                    // Variant gallery images
                    if ($request->hasFile("combinations.$index.gallery_images")) {
                        foreach ($request->file("combinations.$index.gallery_images") as $img) {
                            $variant->images()->create([
                                'image_path' => $mediaService->storeFile($img, 'products/variants/gallery'),
                            ]);
                        }
                    }

                    // Attach variant attributes (pivot table: product_variant_attributes)
                    if (!empty($combination['attributes'])) {
                        $syncData = [];
                        foreach ($combination['attributes'] as $attr) {
                            $syncData[$attr['attribute_id']] = [
                                'attribute_value_id' => $attr['attribute_value_id']
                            ];
                        }
                        $variant->attributes()->sync($syncData);
                    }
                }
            }

            DB::commit();
            return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Product store failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->withErrors(['error' => 'Failed to create product: ' . $e->getMessage()]);
        }
    }



    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        // dd($product);
        return view('admin.products.show', compact('product'));
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
