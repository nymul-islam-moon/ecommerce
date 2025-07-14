@extends('admin.layouts.app')

@section('title', 'Create Product Attribute')

@section('admin_content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Create Product Attribute</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.attributes.index') }}">Product Attributes</a></li>
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
                    <!-- Attribute Create Card -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title mb-0">Add New Attribute</h3>
                        </div>
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        <div class="card-body">
                            <form action="{{ route('admin.attributes.store') }}" method="POST">
                                @csrf

                                <!-- Attribute Name -->
                                <div class="mb-3">
                                    <label for="name" class="form-label">Attribute Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Enter attribute name" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Attribute Type -->
                                <div class="mb-3">
                                    <label for="type" class="form-label">Attribute Type <span class="text-danger">*</span></label>
                                    <select name="type" id="type"
                                        class="form-select @error('type') is-invalid @enderror" required>
                                        <option value="">Select type</option>
                                        <option value="text" {{ old('type') == 'text' ? 'selected' : '' }}>Text</option>
                                        <option value="select" {{ old('type') == 'select' ? 'selected' : '' }}>Select</option>
                                        <option value="checkbox" {{ old('type') == 'checkbox' ? 'selected' : '' }}>Checkbox</option>
                                        <option value="radio" {{ old('type') == 'radio' ? 'selected' : '' }}>Radio</option>
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Submit Button -->
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('admin.attributes.index') }}" class="btn btn-secondary">
                                        <i class="bi bi-arrow-left"></i> Back
                                    </a>
                                    <button type="submit" class="btn btn-success">
                                        <i class="bi bi-check-circle"></i> Create Attribute
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
