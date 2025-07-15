@extends('admin.layouts.app')

@section('title', 'Edit Attribute Value')

@section('admin_content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row mb-3">
                <div class="col-sm-6">
                    <h3 class="mb-0">Edit Value of: {{ $attributeValue->attribute->name }}</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.attributes.index') }}">Attributes</a></li>
                        <li class="breadcrumb-item active">Edit Value</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Update Attribute Value</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.attribute-values.update', $attributeValue->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="value" class="form-label">Value</label>
                            <input type="text" name="value" id="value"
                                value="{{ old('value', $attributeValue->value) }}"
                                class="form-control @error('value') is-invalid @enderror" required>

                            @error('value')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.attributes.show', $attributeValue->attribute_id) }}"
                                class="btn btn-secondary">Back</a>
                            <button type="submit" class="btn btn-primary">Update Value</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
