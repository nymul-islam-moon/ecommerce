@extends('admin.layouts.app')

@section('title', 'Edit Child Category')

@section('admin_content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Edit Child Category</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.childcategories.index') }}">Child Categories</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <!-- Edit Card -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title mb-0">Update Child Category</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.childcategories.update', $childcategory->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <!-- Subcategory Select -->
                                <div class="mb-3">
                                    <label for="subcategory_id" class="form-label">Parent Subcategory <span class="text-danger">*</span></label>
                                    <select name="subcategory_id" id="subcategory_id"
                                        class="form-select @error('subcategory_id') is-invalid @enderror" required>
                                        <option value="" disabled>Select a subcategory</option>
                                        @foreach($subcategories as $subcategory)
                                            <option value="{{ $subcategory->id }}"
                                                {{ old('subcategory_id', $childcategory->subcategory_id) == $subcategory->id ? 'selected' : '' }}>
                                                {{ $subcategory->name }} ({{ $subcategory->category->name ?? 'N/A' }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('subcategory_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Name Input -->
                                <div class="mb-3">
                                    <label for="name" class="form-label">Child Category Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name', $childcategory->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Description Input -->
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea name="description" id="description"
                                        class="form-control @error('description') is-invalid @enderror"
                                        placeholder="Optional description">{{ old('description', $childcategory->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Submit -->
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('admin.childcategories.index') }}" class="btn btn-secondary">
                                        <i class="bi bi-arrow-left"></i> Back
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                         <i class="bi bi-check-circle"></i> Update Child Category
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
