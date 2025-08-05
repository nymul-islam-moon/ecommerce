@extends('admin.layouts.app')

@section('title', 'Create Discount')

@section('admin_content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Create Discount</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.discounts.index') }}">Discounts</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title mb-0">Add New Discount</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.discounts.update', $discount) }}" method="POST">
                                @csrf
                                @method('PUT')


                                <!-- Title -->
                                <div class="mb-3">
                                    <label for="title" class="form-label">Title <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="title" id="title"
                                        class="form-control @error('title') is-invalid @enderror"
                                        value="{{ old('title') }}" placeholder="Enter discount title" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Type -->
                                <div class="mb-3">
                                    <label for="type" class="form-label">Type <span class="text-danger">*</span></label>
                                    <select name="type" id="type"
                                        class="form-select @error('type') is-invalid @enderror" required>
                                        <option value="product" {{ old('type') == 'product' ? 'selected' : '' }}>Product
                                        </option>
                                        <option value="cart" {{ old('type') == 'cart' ? 'selected' : '' }}>Cart</option>
                                        <option value="bogo" {{ old('type') == 'bogo' ? 'selected' : '' }}>BOGO</option>
                                        <option value="bulk" {{ old('type') == 'bulk' ? 'selected' : '' }}>Bulk</option>
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Discount Type -->
                                <div class="mb-3">
                                    <label for="discount_type" class="form-label">Discount Type</label>
                                    <select name="discount_type" id="discount_type" class="form-select">
                                        <option value="">None</option>
                                        <option value="fixed" {{ old('discount_type') == 'fixed' ? 'selected' : '' }}>
                                            Fixed</option>
                                        <option value="percent" {{ old('discount_type') == 'percent' ? 'selected' : '' }}>
                                            Percent</option>
                                    </select>
                                </div>

                                <!-- Amount -->
                                <div class="mb-3">
                                    <label for="amount" class="form-label">Amount</label>
                                    <input type="number" step="0.01" name="amount" id="amount"
                                        class="form-control @error('amount') is-invalid @enderror"
                                        value="{{ old('amount') }}" placeholder="Enter discount amount">
                                    @error('amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Buy & Get (For BOGO & Bulk) -->
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="buy_quantity" class="form-label">Buy Quantity</label>
                                        <input type="number" name="buy_quantity" id="buy_quantity" class="form-control"
                                            value="{{ old('buy_quantity') }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="get_quantity" class="form-label">Get Quantity</label>
                                        <input type="number" name="get_quantity" id="get_quantity" class="form-control"
                                            value="{{ old('get_quantity') }}">
                                    </div>
                                </div>

                                <!-- Free Product (for BOGO) -->
                                <div class="mb-3">
                                    <label for="free_product_id" class="form-label">Free Product</label>
                                    <select name="free_product_id" id="free_product_id" class="form-select">
                                        <option value="">--None--</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Coupon Code (for cart) -->
                                <div class="mb-3">
                                    <label for="coupon_code" class="form-label">Coupon Code</label>
                                    <input type="text" name="coupon_code" id="coupon_code" class="form-control"
                                        value="{{ old('coupon_code') }}" placeholder="Enter coupon code">
                                </div>

                                <!-- Start & End Date -->
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="start_date" class="form-label">Start Date <span
                                                class="text-danger">*</span></label>
                                        <input type="datetime-local" name="start_date" id="start_date"
                                            class="form-control @error('start_date') is-invalid @enderror"
                                            value="{{ old('start_date') }}" required>
                                        @error('start_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="end_date" class="form-label">End Date <span
                                                class="text-danger">*</span></label>
                                        <input type="datetime-local" name="end_date" id="end_date"
                                            class="form-control @error('end_date') is-invalid @enderror"
                                            value="{{ old('end_date') }}" required>
                                        @error('end_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Products -->
                                <div class="mb-3">
                                    <label for="products" class="form-label">Select Products</label>
                                    <select name="products[]" id="products" class="form-select" multiple>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Users -->
                                <div class="mb-3">
                                    <label for="users" class="form-label">Select Users (for cart discount)</label>
                                    <select name="users[]" id="users" class="form-select" multiple>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Submit -->
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('admin.discounts.index') }}" class="btn btn-secondary">
                                        <i class="bi bi-arrow-left"></i> Back
                                    </a>
                                    <button type="submit" class="btn btn-success">
                                        <i class="bi bi-check-circle"></i> Create Discount
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
