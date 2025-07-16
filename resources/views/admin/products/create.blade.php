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
            <form action="{{ route('admin.products.store') }}" method="POST">
                @csrf
                <div class="card mb-4">
                    <div class="card-header">
                        <h4>Basic Product Info</h4>
                    </div>
                    <div class="card-body row g-3">
                        <div class="col-md-6">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                        </div>
                        <div class="col-md-3">
                            <label>SKU</label>
                            <input type="text" name="sku" class="form-control" value="{{ old('sku') }}">
                        </div>
                        <div class="col-md-3">
                            <label>Slug</label>
                            <input type="text" name="slug" class="form-control" value="{{ old('slug') }}">
                        </div>
                        <div class="col-12">
                            <label>Short Description</label>
                            <textarea name="short_description" class="form-control">{{ old('short_description') }}</textarea>
                        </div>
                        <div class="col-12">
                            <label>Full Description</label>
                            <textarea name="description" class="form-control">{{ old('description') }}</textarea>
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
                            <input type="number" name="price" class="form-control" step="0.01"
                                value="{{ old('price') }}">
                        </div>
                        <div class="col-md-4">
                            <label>Sale Price</label>
                            <input type="number" name="sale_price" class="form-control" step="0.01"
                                value="{{ old('sale_price') }}">
                        </div>
                        <div class="col-md-4">
                            <label>Stock Quantity</label>
                            <input type="number" name="stock_quantity" class="form-control"
                                value="{{ old('stock_quantity') }}">
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
                            <select name="category_id" class="form-select">
                                <option value="">Select Category</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}"
                                        {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label>Subcategory</label>
                            <select name="subcategory_id" class="form-select">
                                <option value="">Select Subcategory</option>
                                @foreach ($subcategories as $sub)
                                    <option value="{{ $sub->id }}"
                                        {{ old('subcategory_id') == $sub->id ? 'selected' : '' }}>
                                        {{ $sub->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label>Child Category</label>
                            <select name="child_category_id" class="form-select">
                                <option value="">Select Child Category</option>
                                @foreach ($childCategories as $child)
                                    <option value="{{ $child->id }}"
                                        {{ old('child_category_id') == $child->id ? 'selected' : '' }}>
                                        {{ $child->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label>Brand</label>
                            <select name="brand_id" class="form-select">
                                <option value="">Select Brand</option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}"
                                        {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
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

                <div class="card mb-4">
                    <div class="card-header">
                        <h4>Attributes</h4>
                    </div>
                    <div class="card-body">
                        @foreach ($attributes as $attribute)
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="attribute_selector" class="form-label">Select Attribute</label>
                                    <select id="attribute_selector" class="form-select">
                                        <option value="">-- Choose Attribute --</option>
                                        @foreach ($attributes as $attribute)
                                            <option value="{{ $attribute->id }}" data-type="{{ $attribute->type }}"
                                                data-values='@json($attribute->values)'>
                                                {{ $attribute->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div id="attribute_input_container">
                                    <!-- Dynamic input field will be injected here -->
                                </div>
                            </div>
                        @endforeach
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const attributeSelector = document.getElementById('attribute_selector');
        const inputContainer = document.getElementById('attribute_input_container');

        attributeSelector.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];

            const type = selectedOption.getAttribute('data-type');
            const values = JSON.parse(selectedOption.getAttribute('data-values') || '[]');
            const attributeId = selectedOption.value;

            inputContainer.innerHTML = ''; // Clear previous input

            if (!attributeId || !type) return;

            let inputHtml = '';
            const namePrefix = `attribute_values[${attributeId}]`;

            if (type === 'select') {
                inputHtml += `<label class="form-label">Select Value</label>`;
                inputHtml += `<select name="${namePrefix}" class="form-select">`;
                inputHtml += `<option value="">-- Choose Value --</option>`;
                values.forEach(value => {
                    inputHtml += `<option value="${value.id}">${value.value}</option>`;
                });
                inputHtml += `</select>`;
            } else if (type === 'checkbox') {
                inputHtml +=
                    `<label class="form-label">Select One or More</label><div class="d-flex flex-wrap gap-2">`;
                values.forEach(value => {
                    inputHtml += `
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="${namePrefix}[]" value="${value.id}" id="attr_val_${value.id}">
                        <label class="form-check-label" for="attr_val_${value.id}">${value.value}</label>
                    </div>
                `;
                });
                inputHtml += `</div>`;
            } else if (type === 'text') {
                inputHtml += `<label class="form-label">Enter Value</label>`;
                inputHtml += `<input type="text" name="${namePrefix}" class="form-control">`;
            }

            inputContainer.innerHTML = inputHtml;
        });
    });
</script>
