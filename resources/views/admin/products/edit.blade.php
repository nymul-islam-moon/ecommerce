@extends('admin.layouts.app')

@section('title', 'Edit Product')

@push('admin_style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        .cke_notifications_area {
            display: none !important;
        }

        .image-preview {
            max-width: 60px;
            max-height: 60px;
            object-fit: cover;
            border: 1px solid #ddd;
            padding: 2px;
            border-radius: 4px;
        }
    </style>
@endpush

@section('admin_content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row mb-3">
                <div class="col-sm-6">
                    <h3 class="mb-0">Edit Product</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Products</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">

            <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Basic Info --}}
                <div class="card card-primary card-outline mb-4">
                    <div class="card-header">
                        <div class="card-title">
                            Basic Product Info
                            <i class="bi bi-info-circle ms-2 text-primary" data-bs-toggle="tooltip"
                                title="Fill in the product name, SKU, slug, and descriptions. The slug will auto-generate from the name.">
                            </i>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Product Name</label>
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $product->name) }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Product Type</label>
                                <select name="product_type" id="product_type" class="form-select">
                                    <option value="simple"
                                        {{ old('product_type', $product->product_type) == 'simple' ? 'selected' : '' }}>
                                        Simple Product</option>
                                    <option value="variable"
                                        {{ old('product_type', $product->product_type) == 'variable' ? 'selected' : '' }}>
                                        Variable Product</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="sku" class="form-label">SKU</label>
                                <input type="text" name="sku" id="sku"
                                    class="form-control @error('sku') is-invalid @enderror"
                                    value="{{ old('sku', $product->sku) }}">
                                @error('sku')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="slug" class="form-label">Slug</label>
                                <input type="text" name="slug" id="slug"
                                    class="form-control @error('slug') is-invalid @enderror"
                                    value="{{ old('slug', $product->slug) }}">
                                @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="short_description" class="form-label">Short Description</label>
                            <textarea name="short_description" id="short_description"
                                class="form-control @error('short_description') is-invalid @enderror">{{ old('short_description', $product->short_description) }}</textarea>
                            @error('short_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Full Description</label>
                            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror">{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Category & Brand --}}
                <div class="card card-success card-outline mb-4">
                    <div class="card-header">
                        <div class="card-title">
                            Category & Brand
                            <i class="bi bi-info-circle ms-2 text-primary" data-bs-toggle="tooltip"
                                title="Select category, subcategory, and brand for the product."></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="category_id" class="form-label">Category</label>
                                <select name="category_id" id="category_id" class="form-select select2">
                                    <option value="">Select Category</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="subcategory_id" class="form-label">Subcategory</label>
                                <select name="subcategory_id" id="subcategory_id" class="form-select select2">
                                    <option value="">Select Subcategory</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="child_category_id" class="form-label">Child Category</label>
                                <select name="child_category_id" id="child_category_id" class="form-select select2">
                                    <option value="">Select Child Category</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="brand_id" class="form-label">Brand</label>
                                <select name="brand_id" id="brand_id" class="form-select select2">
                                    <option value="">Select Brand</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="active"
                                        {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive"
                                        {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>Inactive
                                    </option>
                                    <option value="out_of_stock"
                                        {{ old('status', $product->status) == 'out_of_stock' ? 'selected' : '' }}>Out of
                                        Stock</option>
                                    <option value="discontinued"
                                        {{ old('status', $product->status) == 'discontinued' ? 'selected' : '' }}>
                                        Discontinued</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="is_featured" class="form-label">Featured?</label>
                                <select name="is_featured" class="form-select">
                                    <option value="0"
                                        {{ old('is_featured', $product->is_featured) == 0 ? 'selected' : '' }}>No</option>
                                    <option value="1"
                                        {{ old('is_featured', $product->is_featured) == 1 ? 'selected' : '' }}>Yes</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Simple Product Pricing & Stock --}}
                <div class="card card-secondary card-outline mb-4 simple-section">
                    <div class="card-header">
                        <div class="card-title">
                            Pricing & Stock (Simple Product)
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="price" class="form-label">Regular Price</label>
                                <input type="number" step="0.01" name="price" id="price" class="form-control"
                                    value="{{ old('price', $product->price) }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="sale_price" class="form-label">Sale Price</label>
                                <input type="number" step="0.01" name="sale_price" id="sale_price"
                                    class="form-control" value="{{ old('sale_price', $product->sale_price) }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="stock_quantity" class="form-label">Stock Quantity</label>
                                <input type="number" name="stock_quantity" id="stock_quantity" class="form-control"
                                    value="{{ old('stock_quantity', $product->stock_quantity) }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="weight" class="form-label">Weight (kg)</label>
                                <input type="number" step="0.01" name="weight" id="weight" class="form-control"
                                    value="{{ old('weight', $product->weight) }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="width" class="form-label">Width (cm)</label>
                                <input type="number" step="0.01" name="width" id="width" class="form-control"
                                    value="{{ old('width', $product->width) }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="height" class="form-label">Height (cm)</label>
                                <input type="number" step="0.01" name="height" id="height" class="form-control"
                                    value="{{ old('height', $product->height) }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="depth" class="form-label">Depth (cm)</label>
                                <input type="number" step="0.01" name="depth" id="depth" class="form-control"
                                    value="{{ old('depth', $product->depth) }}">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="low_stock_threshold" class="form-label">Low Stock Threshold</label>
                                <input type="number" step="1" name="low_stock_threshold" id="low_stock_threshold"
                                    class="form-control"
                                    value="{{ old('low_stock_threshold', $product->low_stock_threshold) }}">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Main & Gallery Images (Simple Products Only) --}}
                <div class="card card-info card-outline mb-4 simple-section">
                    <div class="card-header">
                        <div class="card-title">
                            Main & Gallery Images
                            <i class="bi bi-info-circle ms-2 text-info" data-bs-toggle="tooltip"
                                title="Upload the main thumbnail image for the product and additional gallery images.">
                            </i>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="main_image" class="form-label">Main Image (Thumbnail)</label>
                            <input type="file" name="main_image" id="main_image"
                                class="form-control @error('main_image') is-invalid @enderror" accept="image/*">
                            @error('main_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @if ($product->main_image)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/products/' . basename($product->main_image)) }}"
                                        alt="Main Image" class="image-preview rounded">
                                </div>
                            @endif
                            <div class="form-text">Recommended size: 600x600px.</div>
                        </div>
                        <div class="mb-3">
                            <label for="gallery_images" class="form-label">Gallery Images</label>
                            <input type="file" name="gallery_images[]" id="gallery_images"
                                class="form-control @error('gallery_images') is-invalid @enderror" accept="image/*"
                                multiple>
                            @error('gallery_images')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @if ($product->images && $product->images->count())
                                <div class="d-flex flex-wrap gap-2 mt-2">
                                    @foreach ($product->images as $image)
                                        <img src="{{ asset('storage/products/gallery/' . basename($image->image)) }}"
                                            alt="Gallery Image" class="image-preview rounded">
                                    @endforeach
                                </div>
                            @endif
                            <div class="form-text">You can select multiple images for product gallery.</div>
                        </div>
                    </div>
                </div>

                {{-- Attributes (Variable Products Only) --}}
                <div class="card card-warning card-outline mb-4 variable-section">
                    <div class="card-header">
                        <div class="card-title">
                            Product Attributes
                            <i class="bi bi-info-circle ms-2 text-warning" data-bs-toggle="tooltip"
                                title="Select attribute values like size, color, or material."></i>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($attributes->count() > 0)
                            <div class="row g-3">
                                @foreach ($attributes as $attribute)
                                    @php
                                        // Get selected attribute values (old input or from product variants)
                                        $selectedValues = old('attribute_values.' . $attribute->id);
                                        if (!$selectedValues) {
                                            // Collect from existing variants attribute values
                                            $selectedValues = $product->variants
                                                ->flatMap(function ($variant) use ($attribute) {
                                                    return $variant->attributes
                                                        ->where('attribute_id', $attribute->id)
                                                        ->pluck('attribute_value_id');
                                                })
                                                ->unique()
                                                ->toArray();
                                        }
                                    @endphp
                                    <div class="col-md-4">
                                        <label class="form-label">{{ $attribute->name }}</label>
                                        <select name="attribute_values[{{ $attribute->id }}][]"
                                            class="form-select select2 attribute-select @error('attribute_values.' . $attribute->id) is-invalid @enderror"
                                            multiple>
                                            @foreach ($attribute->values as $value)
                                                <option value="{{ $value->id }}"
                                                    {{ in_array($value->id, $selectedValues ?? []) ? 'selected' : '' }}>
                                                    {{ $value->value }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('attribute_values.' . $attribute->id)
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="alert alert-info mb-0">
                                No attributes available. Please create attributes first.
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Dynamic Pricing & Inventory (Variable Products Only) --}}
                <div class="card card-success card-outline mb-4 variable-section">
                    <div class="card-header">
                        <div class="card-title">
                            Pricing, Stock & Images (Per Combination)
                            <i class="bi bi-info-circle ms-2 text-success" data-bs-toggle="tooltip"
                                title="Once you select attributes above, combinations will be generated here.">
                            </i>
                        </div>
                    </div>
                    <div class="card-body" id="combination-pricing">
                        @php
                            // Prepare existing combinations data to show
                            $variants = $product->variants;
                        @endphp

                        @if ($variants->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            @foreach ($attributes as $attribute)
                                                <th>{{ $attribute->name }}</th>
                                            @endforeach
                                            <th>Price</th>
                                            <th>Stock</th>
                                            <th>SKU</th>
                                            <th>Images</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($variants as $index => $variant)
                                            @php
                                                $variantAttrIds = $variant->attributes
                                                    ->pluck('attribute_value_id')
                                                    ->toArray();
                                            @endphp
                                            <tr>
                                                @foreach ($variantAttrIds as $valId)
                                                    @php
                                                        $valName =
                                                            $attributes->flatMap->values->firstWhere('id', $valId)
                                                                ?->value ?? 'N/A';
                                                    @endphp
                                                    <td>{{ $valName }}</td>
                                                @endforeach

                                                <td>
                                                    <input type="number" name="combinations[{{ $index }}][price]"
                                                        value="{{ old("combinations.{$index}.price", $variant->price) }}"
                                                        class="form-control" step="0.01" placeholder="0.00">
                                                </td>
                                                <td>
                                                    <input type="number"
                                                        name="combinations[{{ $index }}][stock_quantity]"
                                                        value="{{ old("combinations.{$index}.stock_quantity", $variant->stock_quantity) }}"
                                                        class="form-control" placeholder="0">
                                                </td>
                                                <td>
                                                    <input type="text" name="combinations[{{ $index }}][sku]"
                                                        value="{{ old("combinations.{$index}.sku", $variant->sku) }}"
                                                        class="form-control" placeholder="">
                                                </td>
                                                <td>
                                                    <div class="mb-2">
                                                        <label class="form-label small">Main Image:</label>
                                                        <input type="file"
                                                            name="combinations[{{ $index }}][main_image]"
                                                            class="form-control" accept="image/*">
                                                        @if ($variant->main_image)
                                                            <img src="{{ asset('storage/products/variants/' . basename($variant->main_image)) }}"
                                                                alt="Variant Image" class="image-preview mt-1 rounded">
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <label class="form-label small">Gallery Images:</label>
                                                        <input type="file"
                                                            name="combinations[{{ $index }}][gallery_images][]"
                                                            class="form-control" multiple accept="image/*">
                                                        @if ($variant->gallery_images && $variant->gallery_images->count() > 0)
                                                            <div class="d-flex flex-wrap gap-2 mt-1">
                                                                @foreach ($variant->gallery_images as $img)
                                                                    <img src="{{ asset('storage/products/variants/gallery/' . basename($img->image)) }}"
                                                                        alt="Gallery Image" class="image-preview rounded">
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                    </div>
                                                </td>

                                                @foreach ($variantAttrIds as $valId)
                                                    <input type="hidden"
                                                        name="combinations[{{ $index }}][attributes][]"
                                                        value="{{ $valId }}">
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-info">
                                Select attribute values above to generate variant combinations.
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Submit --}}
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Update Product</button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>

        </div>
    </div>
@endsection

@push('admin_scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize select2 on selects
            $('.select2').select2({
                width: '100%'
            });

            // Tooltip
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function(el) {
                return new bootstrap.Tooltip(el)
            });

            // CKEditor
            CKEDITOR.replace('short_description');
            CKEDITOR.replace('description');

            // Slug auto-generate from name
            $('#name').on('blur', function() {
                let slug = $(this).val().toLowerCase().trim()
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-');
                $('#slug').val(slug);
            });

            // Load brands via AJAX and select old/DB value
            $.get('{{ route('admin.select.brands') }}', function(data) {
                let $brand = $('#brand_id');
                $brand.empty().append('<option value="">Select Brand</option>');
                $.each(data, function(i, brand) {
                    $brand.append('<option value="' + brand.id + '">' + brand.name + '</option>');
                });
                $brand.val('{{ old('brand_id', $product->brand_id) }}').trigger('change');
            });

            // Load categories
            $.get('{{ route('admin.select.categories') }}', function(data) {
                let $cat = $('#category_id');
                $cat.empty().append('<option value="">Select Category</option>');
                $.each(data, function(i, category) {
                    $cat.append('<option value="' + category.id + '">' + category.name +
                        '</option>');
                });
                $cat.val('{{ old('category_id', $product->category_id) }}').trigger('change');
            });

            // On category change, load subcategories
            $('#category_id').on('change', function() {
                let catId = $(this).val();
                let $sub = $('#subcategory_id');
                let $child = $('#child_category_id');
                $sub.empty().append('<option value="">Select Subcategory</option>');
                $child.empty().append('<option value="">Select Child Category</option>');
                if (catId) {
                    $.get('{{ route('admin.select.subcategories') }}', {
                        category_id: catId
                    }, function(data) {
                        $.each(data, function(i, sub) {
                            $sub.append('<option value="' + sub.id + '">' + sub.name +
                                '</option>');
                        });
                        $sub.val('{{ old('subcategory_id', $product->subcategory_id) }}').trigger(
                            'change');
                    });
                }
            });

            // On subcategory change, load child categories
            $('#subcategory_id').on('change', function() {
                let subId = $(this).val();
                let $child = $('#child_category_id');
                $child.empty().append('<option value="">Select Child Category</option>');
                if (subId) {
                    $.get('{{ route('admin.select.childcategories') }}', {
                        subcategory_id: subId
                    }, function(data) {
                        $.each(data, function(i, child) {
                            $child.append('<option value="' + child.id + '">' + child.name +
                                '</option>');
                        });
                        $child.val('{{ old('child_category_id', $product->child_category_id) }}')
                            .trigger('change');
                    });
                }
            });

            // Product type toggle sections
            function toggleSections() {
                let type = $('#product_type').val();
                if (type === 'simple') {
                    $('.simple-section').show();
                    $('.variable-section').hide();
                } else if (type === 'variable') {
                    $('.simple-section').hide();
                    $('.variable-section').show();
                }
            }
            $('#product_type').on('change', toggleSections);
            toggleSections();

            // Combinations generation
            function generateCombinations(arrays) {
                if (arrays.length === 0) return [
                    []
                ];
                const result = [];
                const rest = generateCombinations(arrays.slice(1));
                for (const v of arrays[0]) {
                    for (const combo of rest) {
                        result.push([v, ...combo]);
                    }
                }
                return result;
            }

            function loadCombinations() {
                let attributeArrays = [];
                let attributeNames = [];

                $('.attribute-select').each(function() {
                    let vals = $(this).val();
                    let name = $(this).closest('.col-md-4').find('label').text();
                    if (vals && vals.length > 0) {
                        attributeArrays.push(vals);
                        attributeNames.push(name);
                    }
                });

                if (attributeArrays.length === 0) {
                    $('#combination-pricing').html(
                        '<div class="alert alert-info mb-0">Select attribute values to generate combinations...</div>'
                        );
                    return;
                }

                const combos = generateCombinations(attributeArrays);

                let html = `<div class="table-responsive"><table class="table table-bordered align-middle">
                    <thead class="table-light"><tr>`;
                attributeNames.forEach(n => html += `<th>${n}</th>`);
                html += `<th>Price</th><th>Stock</th><th>SKU</th><th>Images</th></tr></thead><tbody>`;

                combos.forEach((combo, index) => {
                    html += '<tr>';
                    combo.forEach(val => {
                        let text = $(`.attribute-select option[value="${val}"]`).text();
                        html += `<td>${text}</td>`;
                    });

                    html += `
                        <td><input type="number" name="combinations[${index}][price]" class="form-control" step="0.01" placeholder="0.00"></td>
                        <td><input type="number" name="combinations[${index}][stock_quantity]" class="form-control" placeholder="0"></td>
                        <td><input type="text" name="combinations[${index}][sku]" class="form-control" placeholder=""></td>
                        <td>
                            <div class="mb-2">
                                <label class="form-label small">Main Image:</label>
                                <input type="file" name="combinations[${index}][main_image]" class="form-control" accept="image/*">
                            </div>
                            <div>
                                <label class="form-label small">Gallery Images:</label>
                                <input type="file" name="combinations[${index}][gallery_images][]" class="form-control" multiple accept="image/*">
                            </div>
                        </td>`;

                    combo.forEach(val => {
                        html +=
                            `<input type="hidden" name="combinations[${index}][attributes][]" value="${val}">`;
                    });
                    html += '</tr>';
                });

                html += '</tbody></table></div>';
                $('#combination-pricing').html(html);
            }

            $(document).on('change', '.attribute-select', loadCombinations);

            // Load old attribute_values on page load to generate combos for variable products
            @if (old('attribute_values'))
                loadCombinations();
            @endif
        });
    </script>
@endpush
