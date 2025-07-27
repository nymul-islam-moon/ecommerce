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

            // Create main product
            $product = Product::create([
                'name' => $formData['name'],
                'sku' => $formData['sku'] ?? null,
                'slug' => $formData['slug'],
                'short_description' => $formData['short_description'] ?? null,
                'description' => $formData['description'] ?? null,
                'product_type' => $formData['product_type'],
                'price' => $formData['product_type'] === 'simple' ? $formData['price'] : null,
                'sale_price' => $formData['product_type'] === 'simple' ? ($formData['sale_price'] ?? null) : null,
                'stock_quantity' => $formData['product_type'] === 'simple' ? ($formData['stock_quantity'] ?? 0) : null,
                'category_id' => $formData['category_id'],
                'subcategory_id' => $formData['subcategory_id'] ?? null,
                'child_category_id' => $formData['child_category_id'] ?? null,
                'brand_id' => $formData['brand_id'] ?? null,
                'status' => $formData['status'],
                'is_featured' => $formData['is_featured'],
                'main_image' => $formData['main_image'] ?? null,
            ]);

            // Save gallery images
            if (!empty($galleryImages)) {
                foreach ($galleryImages as $img) {
                    $product->images()->create(['image_path' => $img]);
                }
            }

            // Attach selected attributes (for variable products)
            if ($request->has('attribute_values')) {
                foreach ($request->attribute_values as $attributeId => $valueIds) {
                    if (!empty($valueIds)) {
                        foreach ($valueIds as $valueId) {
                            $product->attributes()->attach($attributeId, ['value_id' => $valueId]);
                        }
                    }
                }
            }

            // Handle combinations (for variable products)
            if ($formData['product_type'] === 'variable' && isset($formData['combinations'])) {
                foreach ($formData['combinations'] as $combination) {
                    $variantData = [
                        'product_id' => $product->id,
                        'price' => $combination['price'],
                        'sale_price' => $combination['sale_price'] ?? null,
                        'stock_quantity' => $combination['stock_quantity'],
                        'sku' => $combination['sku'] ?? null,
                        'weight' => $combination['weight'] ?? null,
                        'height' => $combination['height'] ?? null,
                        'width' => $combination['width'] ?? null,
                        'depth' => $combination['depth'] ?? null,
                    ];

                    // Upload variant main image
                    if (isset($combination['main_image']) && $request->hasFile("combinations.{$loop->index}.main_image")) {
                        $variantData['main_image'] = $mediaService->storeFile(
                            $request->file("combinations.{$loop->index}.main_image"),
                            'products/variants'
                        );
                    }

                    // Create variant
                    $variant = $product->variants()->create($variantData);

                    // Upload variant gallery images
                    if (isset($combination['gallery_images']) && $request->hasFile("combinations.{$loop->index}.gallery_images")) {
                        foreach ($request->file("combinations.{$loop->index}.gallery_images") as $img) {
                            $variant->images()->create([
                                'image_path' => $mediaService->storeFile($img, 'products/variants/gallery'),
                            ]);
                        }
                    }

                    // Attach selected attribute values for this variant
                    if (!empty($combination['attributes'])) {
                        $variant->attributes()->attach($combination['attributes']);
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
