{{-- resources/views/admin/dashboard.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Admin Dashboard')

@push('admin_style')
    <style>
        .small.text-muted {
            padding-right: 10px;
        }
    </style>
@endpush

@section('admin_content')
    <div class="app-content-header">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">SubCategories List</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">SubCategories</li>
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
                <!-- SubCategory Table Section -->
                <div class="col-lg-12">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title flex-grow-1 mb-0">All SubCategories</h3>
                            <a href="{{ route('admin.subcategories.create') }}" class="btn btn-sm btn-success ms-3">
                                <i class="bi bi-plus-lg"></i> Create SubCategory
                            </a>
                        </div>

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="card-body">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Name</th>
                                        <th>Slug</th>
                                        <th>Description</th>
                                        <th>Category</th>
                                        <th>Child Categories</th>
                                        <th style="width: 150px">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($subCategories as $key => $subCategory)
                                        <tr>
                                            <td>{{ $key + $subCategories->firstItem() }}</td>
                                            <td>{{ $subCategory->name }}</td>
                                            <td>{{ $subCategory->slug }}</td>
                                            <td>{{ $subCategory->description ?? '-' }}</td>
                                            <td>{{ $subCategory->category?->name ?? 'N/A' }}</td>
                                            <td>
                                                <span class="badge bg-info">{{ $subCategory->child_categories_count ?? 0 }}</span>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.subcategories.edit', $subCategory->id) }}"
                                                    class="btn btn-sm btn-primary" title="Edit SubCategory">
                                                    <i class="bi bi-pencil"></i>
                                                </a>

                                                <form action="{{ route('admin.subcategories.destroy', $subCategory->id) }}"
                                                    method="POST" class="d-inline"
                                                    onsubmit="return confirm('Are you sure you want to delete this subcategory?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        title="Delete SubCategory">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="card-footer clearfix">
                            <div class="float-end">
                                {!! $subCategories->links('pagination::bootstrap-5') !!}
                            </div>
                        </div>

                    </div>
                </div>
                <!-- /.col -->
            </div>
        </div>
    </div>
@endsection
