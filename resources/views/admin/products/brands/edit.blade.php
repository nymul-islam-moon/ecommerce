@extends('admin.layouts.app')

@section('title', 'Edit Brand')

@section('admin_content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Edit Brand</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.brands.index') }}">Brands</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <!-- Brand Edit Card -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title mb-0">Update Brand</h3>
                        </div>
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        <div class="card-body">
                            <form action="{{ route('admin.brands.update', $brand->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <!-- Brand Name -->
                                <div class="mb-3">
                                    <label for="name" class="form-label">Brand Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name', $brand->name) }}"
                                        placeholder="Enter brand name" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Brand Image -->
                                <div class="mb-3">
                                    <label for="image" class="form-label">Brand Image</label>
                                    <input type="file" name="image" id="image"
                                        class="form-control @error('image') is-invalid @enderror" accept="image/*">
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @if ($brand->image)
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $brand->image) }}"
                                                 alt="{{ $brand->name }}"
                                                 class="img-thumbnail"
                                                 style="width: 80px; height: 80px;">
                                        </div>
                                    @endif
                                </div>

                                <!-- Brand Status -->
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                    <select name="status" id="status"
                                        class="form-select @error('status') is-invalid @enderror" required>
                                        <option value="1" {{ old('status', $brand->status) == '1' ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('status', $brand->status) == '0' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Brand Description -->
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea name="description" id="description"
                                        class="form-control @error('description') is-invalid @enderror"
                                        placeholder="Optional brand description">{{ old('description', $brand->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Submit Button -->
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('admin.brands.index') }}" class="btn btn-secondary">
                                        <i class="bi bi-arrow-left"></i> Back
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-save"></i> Update Brand
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- End Card -->
                </div>
            </div>
        </div>
    </div>
@endsection
