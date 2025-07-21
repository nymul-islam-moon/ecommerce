@extends('admin.layouts.app')

@section('title', 'Create Product')

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

                <div class="card mb-4">
                    <div class="card-header">
                        <h4>Pricing & Inventory</h4>
                    </div>
                    <div class="card-body row g-3">
                        <div class="col-md-4">
                            <label>Price</label>
                            <input type="number" name="price" step="0.01"
                                class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}">
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label>Sale Price</label>
                            <input type="number" name="sale_price" step="0.01"
                                class="form-control @error('sale_price') is-invalid @enderror"
                                value="{{ old('sale_price') }}">
                            @error('sale_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label>Stock Quantity</label>
                            <input type="number" name="stock_quantity"
                                class="form-control @error('stock_quantity') is-invalid @enderror"
                                value="{{ old('stock_quantity') }}">
                            @error('stock_quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h4>Category & Brand</h4>
                    </div>
                    <div class="card-body row g-3">
                        <div class="col-md-4">
                            <label>Category</label>
                            <select name="category_id" id="category_id"
                                class="form-select @error('category_id') is-invalid @enderror">
                                <option value="">Select Category</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}"
                                        {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label>Subcategory</label>
                            <select name="subcategory_id" id="subcategory_id"
                                class="form-select @error('subcategory_id') is-invalid @enderror">
                            </select>
                            @error('subcategory_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label>Child Category</label>
                            <select name="child_category_id" id="child_category_id"
                                class="form-select @error('child_category_id') is-invalid @enderror">
                                <option value="">Select Child Category</option>
                                @foreach ($childCategories as $child)
                                    <option value="{{ $child->id }}"
                                        {{ old('child_category_id') == $child->id ? 'selected' : '' }}>
                                        {{ $child->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('child_category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label>Brand</label>
                            <select name="brand_id" class="form-select @error('brand_id') is-invalid @enderror">
                                <option value="">Select Brand</option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}"
                                        {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('brand_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label>Status</label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror">
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive
                                </option>
                                <option value="out_of_stock" {{ old('status') == 'out_of_stock' ? 'selected' : '' }}>Out
                                    of Stock</option>
                                <option value="discontinued" {{ old('status') == 'discontinued' ? 'selected' : '' }}>
                                    Discontinued</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label>Featured?</label>
                            <select name="is_featured" class="form-select @error('is_featured') is-invalid @enderror">
                                <option value="0" {{ old('is_featured') == '0' ? 'selected' : '' }}>No</option>
                                <option value="1" {{ old('is_featured') == '1' ? 'selected' : '' }}>Yes</option>
                            </select>
                            @error('is_featured')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h4>Attributes</h4>
                    </div>
                    <div class="card-body row g-3">
                        @foreach ($attributes as $attribute)
                            <div class="col-md-4">
                                <label for="attribute_{{ $attribute->id }}">{{ $attribute->name }}</label>
                                <select name="attribute_values[{{ $attribute->id }}]"
                                    id="attribute_{{ $attribute->id }}"
                                    class="form-select @error('attribute_values.' . $attribute->id) is-invalid @enderror">
                                    <option value="">Select {{ $attribute->name }}</option>
                                    @foreach ($attribute->values as $value)
                                        <option value="{{ $value->id }}"
                                            {{ old('attribute_values.' . $attribute->id) == $value->id ? 'selected' : '' }}>
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
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h4>Product Images</h4>
                    </div>
                    <div class="card-body row g-3">
                        <div class="col-md-6">
                            <label for="main_image">Main Image (Thumbnail)</label>
                            <input type="file" name="main_image" id="main_image"
                                class="form-control @error('main_image') is-invalid @enderror" accept="image/*">
                            @error('main_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="gallery_images">Gallery Images</label>
                            <input type="file" name="gallery_images[]" id="gallery_images" multiple
                                class="form-control @error('gallery_images') is-invalid @enderror" accept="image/*">
                            @error('gallery_images')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @if ($errors->has('gallery_images.*'))
                                <div class="invalid-feedback">
                                    @foreach ($errors->get('gallery_images.*') as $messages)
                                        @foreach ($messages as $message)
                                            {{ $message }}<br>
                                        @endforeach
                                    @endforeach
                                </div>
                            @endif
                        </div>
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
    <script>
        $(document).ready(function() {
            // Initialize tooltips
            // $('[data-bs-toggle="tooltip"]').tooltip();

            // on change category_id console log subcategory_id
            $('#category_id').on('change', function() {
                var categoryId = $(this).val();
                var subcategorySelect = $('select[name="subcategory_id"]');
                var childCategorySelect = $('#child_category_id');

                if (categoryId) {
                    $.ajax({
                        url: '{{ route('admin.select.subcategories') }}',
                        method: 'GET',
                        data: {
                            category_id: categoryId
                        },
                        success: function(data) {
                            subcategorySelect.empty();
                            subcategorySelect.append(
                                '<option value="">Select Subcategory</option>');
                            $.each(data, function(index, subcategory) {
                                subcategorySelect.append('<option value="' + subcategory
                                    .id + '">' + subcategory.name + '</option>');
                            });
                        }
                    });
                } else {
                    // Clear subcategory dropdown if no category is selected
                    subcategorySelect.empty();
                    subcategorySelect.append('<option value="">Select Subcategory</option>');

                    // Clear child category dropdown if no subcategory is selected
                    childCategorySelect.empty();
                    childCategorySelect.append('<option value="">Select Child Category</option>');
                }
            });

            // here on change the subcategory_id console log child_category_id
            $('#subcategory_id').on('change', function() {
                var subcategoryId = $(this).val();
                var childCategorySelect = $('#child_category_id');

                if (subcategoryId) {
                    $.ajax({
                        url: '{{ route('admin.select.childcategories') }}',
                        method: 'GET',
                        data: {
                            subcategory_id: subcategoryId
                        },
                        success: function(data) {
                            childCategorySelect.empty();
                            childCategorySelect.append(
                                '<option value="">Select Child Category</option>');
                            $.each(data, function(index, childCategory) {
                                childCategorySelect.append('<option value="' +
                                    childCategory
                                    .id + '">' + childCategory.name + '</option>');
                            });
                        }
                    });
                } else {
                    // Clear child category dropdown if no subcategory is selected
                    childCategorySelect.empty();
                    childCategorySelect.append('<option value="">Select Child Category</option>');
                }

            });

            $('#name').on('blur', function() {
                const nameValue = $(this).val();
                const slug = nameValue
                    .toLowerCase()
                    .trim()
                    .replace(/[^a-z0-9\s-]/g, '') // Remove special chars
                    .replace(/\s+/g, '-') // Replace spaces with -
                    .replace(/-+/g, '-'); // Remove duplicate -

                $('#slug').val(slug); // Set slug field value
            });




        });
    </script>
@endpush
