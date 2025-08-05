@extends('admin.layouts.app')

@section('title', 'Discounts')

@section('admin_content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Discounts</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Discounts</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title flex-grow-1 mb-0">All Discounts</h3>
                    <a href="{{ route('admin.discounts.create') }}" class="btn btn-sm btn-success ms-3">
                        <i class="bi bi-plus-lg"></i> Create Discount
                    </a>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Title</th>
                                    <th>Type</th>
                                    <th>Amount</th>
                                    <th>Coupon</th>
                                    <th>Start</th>
                                    <th>End</th>
                                    <th>Status</th>
                                    <th width="15%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($discounts as $discount)
                                    <tr>
                                        <td>{{ $discount->title }}</td>
                                        <td><span class="badge bg-primary">{{ ucfirst($discount->type) }}</span></td>
                                        <td>
                                            @if ($discount->discount_type)
                                                {{ $discount->discount_type === 'percent' ? $discount->amount . '%' : '৳' . $discount->amount }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ $discount->coupon_code ?? '-' }}</td>
                                        <td>{{ $discount->start_date }}</td>
                                        <td>{{ $discount->end_date }}</td>
                                        <td>
                                            <span class="badge {{ $discount->isValid() ? 'bg-success' : 'bg-danger' }}">
                                                {{ $discount->isValid() ? 'Active' : 'Expired' }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.discounts.edit', $discount) }}"
                                                class="btn btn-sm btn-warning">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <form action="{{ route('admin.discounts.destroy', $discount) }}" method="POST"
                                                class="d-inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" onclick="return confirm('Are you sure?')"
                                                    class="btn btn-sm btn-danger">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No discounts found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $discounts->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
