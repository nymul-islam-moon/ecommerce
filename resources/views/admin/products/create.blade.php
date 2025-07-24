@extends('admin.layouts.app')

@section('title', 'Create Product')

@push('admin_style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('admin_content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row mb-3">
                <div class="col-sm-6">
                    <h3 class="mb-0">Create New Product</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Products</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Basic Info --}}
                <div class="card mb-4">
                    <div class="card-header">
                        <h4>Basic Product Info</h4>
                    </div>
                    <div class="card-body row g-3">
                        <div class="col-md-6">
                            <label>Name</label>
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label>SKU</label>
                            <input type="text" name="sku" id="sku"
                                class="form-control @error('sku') is-invalid @enderror" value="{{ old('sku') }}">
                            @error('sku')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label>Slug</label>
                            <input type="text" name="slug" id="slug"
                                class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug') }}">
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label>Short Description</label>
                            <textarea name="short_description" class="form-control @error('short_description') is-invalid @enderror">{{ old('short_description') }}</textarea>
                            @error('short_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label>Full Description</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Category & Brand --}}
                <div class="card mb-4">
                    <div class="card-header">
                        <h4>Category & Brand</h4>
                    </div>
                    <div class="card-body row g-3">
                        <div class="col-md-4">
                            <label>Category</label>
                            <select name="category_id" id="category_id" class="form-select select2">
                                <option value="">Select Category</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label>Subcategory</label>
                            <select name="subcategory_id" id="subcategory_id" class="form-select select2">
                                <option value="">Select Subcategory</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label>Child Category</label>
                            <select name="child_category_id" id="child_category_id" class="form-select select2">
                                <option value="">Select Child Category</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label>Brand</label>
                            <select name="brand_id" id="brand_id" class="form-select select2">
                                <option value="">Select Brand</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label>Status</label>
                            <select name="status" class="form-select">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="out_of_stock">Out of Stock</option>
                                <option value="discontinued">Discontinued</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label>Featured?</label>
                            <select name="is_featured" class="form-select">
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Main & Gallery Images --}}
                <div class="card mb-4">
                    <div class="card-header">
                        <h4>Main & Gallery Images</h4>
                    </div>
                    <div class="card-body row g-3">
                        <div class="col-md-6">
                            <label>Main Image (Thumbnail)</label>
                            <input type="file" name="main_image" class="form-control" accept="image/*">
                        </div>
                        <div class="col-md-6">
                            <label>Gallery Images</label>
                            <input type="file" name="gallery_images[]" multiple class="form-control" accept="image/*">
                        </div>
                    </div>
                </div>


                {{-- Attributes --}}
                <div class="card mb-4">
                    <div class="card-header">
                        <h4>Attributes</h4>
                    </div>
                    <div class="card-body row g-3">
                        @foreach ($attributes as $attribute)
                            <div class="col-md-4">
                                <label>{{ $attribute->name }}</label>
                                <select name="attribute_values[{{ $attribute->id }}][]"
                                    class="form-select attribute-select select2" multiple>
                                    @foreach ($attribute->values as $value)
                                        <option value="{{ $value->id }}">{{ $value->value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Dynamic Pricing & Inventory --}}
                <div class="card mb-4">
                    <div class="card-header">
                        <h4>Pricing, Stock & Images (Per Combination)</h4>
                    </div>
                    <div class="card-body" id="combination-pricing">
                        <p class="text-muted">Select attribute values to generate combinations...</p>
                    </div>
                </div>



                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Back
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle"></i> Create Product
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('admin_scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                width: '100%'
            });
            // load brands on page load
            function loadBrands() {
                $.ajax({
                    url: '{{ route('admin.select.brands') }}',
                    method: 'GET',
                    success: function(data) {
                        $('#brand_id').empty().append('<option value="">Select Brand</option>');
                        $.each(data, function(index, brand) {
                            $('#brand_id').append('<option value="' + brand.id + '">' + brand
                                .name + '</option>');
                        });
                        $('#brand_id').val('{{ old('brand_id') }}').trigger(
                        'change'); // Restore old value
                    }
                });
            }
            loadBrands();

            // Load Categories on page load
            function loadCategories() {
                $.ajax({
                    url: '{{ route('admin.select.categories') }}',
                    method: 'GET',
                    success: function(data) {
                        $('#category_id').empty().append('<option value="">Select Category</option>');
                        $.each(data, function(index, category) {
                            $('#category_id').append('<option value="' + category.id + '">' +
                                category.name + '</option>');
                        });
                        $('#category_id').val('{{ old('category_id') }}').trigger(
                            'change'); // Restore old value
                    }
                });
            }
            loadCategories();

            // On Category change → Load Subcategories
            $('#category_id').on('change', function() {
                var categoryId = $(this).val();
                var subcategorySelect = $('#subcategory_id');
                var childCategorySelect = $('#child_category_id');
                subcategorySelect.empty().append('<option value="">Select Subcategory</option>');
                childCategorySelect.empty().append('<option value="">Select Child Category</option>');

                if (categoryId) {
                    $.ajax({
                        url: '{{ route('admin.select.subcategories') }}',
                        method: 'GET',
                        data: {
                            category_id: categoryId
                        },
                        success: function(data) {
                            $.each(data, function(index, subcategory) {
                                subcategorySelect.append('<option value="' + subcategory
                                    .id + '">' + subcategory.name + '</option>');
                            });
                            subcategorySelect.val('{{ old('subcategory_id') }}').trigger(
                                'change'); // Restore old value
                        }
                    });
                }
            });

            // On Subcategory change → Load Child Categories
            $('#subcategory_id').on('change', function() {
                var subcategoryId = $(this).val();
                var childCategorySelect = $('#child_category_id');
                childCategorySelect.empty().append('<option value="">Select Child Category</option>');

                if (subcategoryId) {
                    $.ajax({
                        url: '{{ route('admin.select.childcategories') }}',
                        method: 'GET',
                        data: {
                            subcategory_id: subcategoryId
                        },
                        success: function(data) {
                            $.each(data, function(index, childCategory) {
                                childCategorySelect.append('<option value="' +
                                    childCategory.id + '">' + childCategory.name +
                                    '</option>');
                            });
                            childCategorySelect.val('{{ old('child_category_id') }}').trigger(
                                'change'); // Restore old value
                        }
                    });
                }
            });

            // Slug auto-generate from name
            $('#name').on('blur', function() {
                const nameValue = $(this).val();
                const slug = nameValue.toLowerCase().trim()
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-');
                $('#slug').val(slug);
            });

            // Load brands/categories/subcategories (existing code omitted for brevity)

            function generateCombinations(arrays) {
                if (arrays.length === 0) return [
                    []
                ];
                const result = [];
                const rest = generateCombinations(arrays.slice(1));
                for (const value of arrays[0]) {
                    for (const combo of rest) {
                        result.push([value, ...combo]);
                    }
                }
                return result;
            }

            function loadCombinations() {
                let attributeArrays = [];
                let attributeNames = [];

                $('.attribute-select').each(function() {
                    const values = $(this).val();
                    const name = $(this).prev('label').text();
                    if (values && values.length > 0) {
                        attributeArrays.push(values);
                        attributeNames.push(name);
                    }
                });

                if (attributeArrays.length === 0) {
                    $('#combination-pricing').html(
                        '<p class="text-muted">Select attribute values to generate combinations...</p>');
                    return;
                }

                const combinations = generateCombinations(attributeArrays);

                let html = `<table class="table table-bordered">
            <thead>
                <tr>`;
                attributeNames.forEach(name => html += `<th>${name}</th>`);
                html += `<th>Price</th><th>Stock Quantity</th><th>Image</th></tr></thead><tbody>`;

                combinations.forEach((combo, index) => {
                    html += `<tr>`;
                    combo.forEach(val => {
                        let text = $(`option[value="${val}"]`).text();
                        html += `<td>${text}</td>`;
                    });
                    html += `
                <td><input type="number" name="combinations[${index}][price]" class="form-control" step="0.01"></td>
                <td><input type="number" name="combinations[${index}][stock_quantity]" class="form-control"></td>
                <td>
                    <label>Main:</label>
                    <input type="file" name="combinations[${index}][main_image]" class="form-control mb-2" accept="image/*">
                    <label>Gallery:</label>
                    <input type="file" name="combinations[${index}][gallery_images][]" class="form-control" multiple accept="image/*">
                </td>`;
                    combo.forEach((val) => {
                        html +=
                            `<input type="hidden" name="combinations[${index}][attributes][]" value="${val}">`;
                    });
                    html += `</tr>`;
                });

                html += `</tbody></table>`;
                $('#combination-pricing').html(html);
            }

            $(document).on('change', '.attribute-select', function() {
                loadCombinations();
            });
        });
    </script>
@endpush
