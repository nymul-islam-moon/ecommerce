@extends('admin.layouts.app')

@section('title', 'Edit subcategory')

@section('admin_content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Edit subcategory</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.subcategories.index') }}">Subcategories</a></li>
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
                    <!-- Subcategory Edit Card -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title mb-0">Edit subcategory - {{ $subcategory->name }}</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.subcategories.update', $subcategory) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <!-- Display All Validation Errors (Optional Global Display) -->
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <strong>There were some problems with your input:</strong>
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <!-- Parent Category -->
                                <div class="mb-3">
                                    <label for="category_id" class="form-label">Parent Category <span class="text-danger">*</span></label>
                                    <select name="category_id" id="category_id"
                                            class="form-select @error('category_id') is-invalid @enderror" required>
                                        <option value="" disabled {{ old('category_id', $subcategory->category_id) ? '' : 'selected' }}>Select a category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category_id', $subcategory->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Subcategory Name -->
                                <div class="mb-3">
                                    <label for="name" class="form-label">Subcategory Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name"
                                           class="form-control @error('name') is-invalid @enderror"
                                           value="{{ old('name', $subcategory->name) }}"
                                           placeholder="Enter subcategory name" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Description -->
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea name="description" id="description"
                                              class="form-control @error('description') is-invalid @enderror"
                                              placeholder="Optional description">{{ old('description', $subcategory->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Submit Button -->
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('admin.subcategories.index') }}" class="btn btn-secondary">
                                        <i class="bi bi-arrow-left"></i> Back
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-check-circle"></i> Update Subcategory
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
