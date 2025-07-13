@extends('admin.layouts.app')

@section('title', 'Product Brands')

@section('admin_content')
    <div class="app-content-header">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Brands List</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Brands</li>
                    </ol>
                </div>
            </div>
            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>
    <div class="app-content">
        <div class="container-fluid">  
            <div class="row">
                <!-- Brand Table Section -->
                <div class="col-lg-12">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title flex-grow-1 mb-0">All Brands</h3>
                            <a href="{{ route('admin.brands.create') }}" class="btn btn-sm btn-success ms-3">
                                <i class="bi bi-plus-lg"></i> Create Brand
                            </a>
                        </div>
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="card-body">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Name</th>
                                        <th>Slug</th>
                                        <th>Image</th>
                                        <th>Description</th>
                                        <th style="width: 150px">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($brands as $brand)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $brand->name }}</td>
                                            <td>{{ $brand->slug }}</td>
                                            <td>
                                                @if ($brand->image)
                                                    <img src="{{ asset('storage/' . $brand->image) }}" alt="{{ $brand->name }}" class="img-thumbnail" style="width: 50px; height: 50px;">
                                                @else
                                                    <span class="text-muted">No Image</span>
                                                @endif
                                            </td>
                                            <td>{{ $brand->description ?? '-' }}</td>
                                            <td class="d-flex justify-content-center">
                                                <a href="{{ route('admin.brands.edit', $brand->id) }}"
                                                   class="btn btn-sm btn-primary me-2" title="Edit Brand">
                                                    <i class="bi bi-pencil-square"></i> Edit
                                                </a>
                                                <form action="{{ route('admin.brands.destroy', $brand->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this brand?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete Brand">
                                                        <i class="bi bi-trash"></i> Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <!-- Pagination -->
                            {{ $brands->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection