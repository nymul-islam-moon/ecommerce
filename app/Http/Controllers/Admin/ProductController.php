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
        // dd($formData);
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

            /** ------------------------
             * 2. Create Product
             * ------------------------ */
            $product = Product::create($formData);

            // Save gallery images
            $galleryImages = [];
            if ($request->hasFile('gallery_images')) {
                foreach ($request->file('gallery_images') as $image) {
                    $galleryImages[] = $mediaService->storeFile($image, 'products/gallery');
                }
            }

            foreach ($galleryImages as $img) {
                $product->images()->create(['image_path' => $img]);
            }

            /** ------------------------
             * 3. Handle Variants (if variable)
             * ------------------------ */
            if ($formData['product_type'] === 'variable' && isset($formData['combinations'], $formData['attribute_values'])) {
                \Log::info('inside the variant section');
                \Log::info($formData['combinations']);

                $attributeValues = $formData['attribute_values']; // array(attribute_id => [value_ids])
                $attributeIds = array_keys($attributeValues);

                // Generate all attribute combinations in the order frontend expects
                $combinationsAttributes = $this->generateCombinations(array_values($attributeValues));

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
                        'main_image' => $variantMainImage,
                    ]);

                    // Variant gallery images
                    if ($request->hasFile("combinations.$index.gallery_images")) {
                        foreach ($request->file("combinations.$index.gallery_images") as $img) {
                            $variant->images()->create([
                                'image_path' => $mediaService->storeFile($img, 'products/variants/gallery'),
                            ]);
                        }
                    }

                    // Build attribute sync array for this variant
                    $attributesForVariant = [];
                    if (isset($combinationsAttributes[$index])) {
                        foreach ($combinationsAttributes[$index] as $attrIndex => $valueId) {
                            $attributesForVariant[] = [
                                'attribute_id' => $attributeIds[$attrIndex],
                                'attribute_value_id' => $valueId,
                            ];
                        }
                    } else {
                        \Log::warning('No attribute combination found for variant', ['variant_index' => $index]);
                    }

                    $this->syncVariantAttributes($variant, $attributesForVariant);
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

    private function generateCombinations(array $arrays)
    {
        $result = [[]];
        foreach ($arrays as $propertyValues) {
            $tmp = [];
            foreach ($result as $resultItem) {
                foreach ($propertyValues as $propertyValue) {
                    $tmp[] = array_merge($resultItem, [$propertyValue]);
                }
            }
            $result = $tmp;
        }
        return $result;
    }

    private function syncVariantAttributes($variant, $attributes)
    {
        if (!is_array($attributes) || empty($attributes)) {
            \Log::warning('Variant attributes missing or empty', ['variant_id' => $variant->id ?? null]);
            return;
        }

        $syncData = [];
        foreach ($attributes as $attr) {
            if (isset($attr['attribute_id'], $attr['attribute_value_id'])) {
                $syncData[$attr['attribute_id']] = ['attribute_value_id' => $attr['attribute_value_id']];
            } else {
                \Log::warning('Malformed attribute data', ['data' => $attr]);
            }
        }

        if (!empty($syncData)) {
            $variant->attributes()->sync($syncData);
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
        return view('admin.products.edit', [
            'product' => $product->load(['variants', 'images', 'category', 'subcategory', 'childCategory', 'brand']),
            'attributes' => Attribute::with('values')->get(),
        ]);
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
        DB::beginTransaction();
        try {
            // Delete main image if exists
            if ($product->main_image) {
                app(MediaService::class)->deleteFile($product->main_image);
            }

            // Delete gallery images
            foreach ($product->images as $image) {
                app(MediaService::class)->deleteFile($image->image_path);
                $image->delete();
            }

            // Delete variants and their images if any (for variable products)
            foreach ($product->variants as $variant) {
                foreach ($variant->images as $variantImage) {
                    app(MediaService::class)->deleteFile($variantImage->image_path);
                    $variantImage->delete();
                }
                $variant->attributes()->detach();
                $variant->delete();
            }

            $product->delete();

            DB::commit();
            return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Product delete failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->withErrors(['error' => 'Failed to delete product: ' . $e->getMessage()]);
        }
    }
}
