{{-- resources/views/admin/dashboard.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Product Category')

@section('admin_content')
    <div class="app-content-header">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Product Category</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Products</li>
                        <li class="breadcrumb-item active" aria-current="page">Categories</li>
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
                <!-- Category Table Section -->
                <div class="col-lg-12">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title flex-grow-1 mb-0">All Categories</h3>
                            <a href="{{ route('admin.categories.create') }}" class="btn btn-sm btn-success ms-3">
                                <i class="bi bi-plus-lg"></i> Create Category
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

                        <!-- /.card-header -->
                        <div class="card-body">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Name</th>
                                        <th>Slug</th>
                                        <th>Description</th>
                                        <th style="width: 40px">SubCategories</th>
                                        <th style="width: 40px">Child Categories</th>
                                        <th style="width: 40px">Products</th>
                                        <th style="width: 150px">Actions</th> <!-- New Actions column -->
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($categories as $key => $category)
                                        <tr>
                                            <td>{{ $key + $categories->firstItem() }}</td>
                                            <td>{{ $category->name }}</td>
                                            <td>{{ $category->slug }}</td>
                                            <td>{{ $category->description ?? '-' }}</td>
                                            <td>
                                                <span class="badge bg-info">{{ $category->subcategories_count ?? 0 }}</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">{{ $category->child_categories_count ?? 0 }}</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">{{ $category->products_count ?? 0 }}</span>
                                            </td>
                                            <td>
                                                <!-- Edit Button -->
                                                <a href="{{ route('admin.categories.edit', $category->id) }}"
                                                    class="btn btn-sm btn-primary" title="Edit Category">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <!-- Delete Button -->
                                                <form action="{{ route('admin.categories.destroy', $category->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        title="Delete Category"
                                                        onclick="return confirm('Are you sure you want to delete this category?')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            <div class="float-end">
                                {!! $categories->links('pagination::bootstrap-5') !!}
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.col -->

            </div>

        </div>
    </div>
@endsection
