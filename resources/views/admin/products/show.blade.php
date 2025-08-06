@extends('admin.layouts.app')

@push('admin_style')
<style>
    .product-image {
        max-width: 100%;
        height: auto;
        display: block;
        object-fit: contain;
        border: 1px solid #ddd;
        border-radius: 5px;
        background: #fff;
        padding: 5px;
    }

    .product-image-thumbs {
        display: flex;
        margin-top: 10px;
        gap: 10px;
        flex-wrap: wrap;
    }

    .product-image-thumb {
        border: 1px solid #ddd;
        border-radius: 5px;
        cursor: pointer;
        padding: 3px;
        background: #fff;
        transition: border 0.2s;
    }

    .product-image-thumb img {
        max-width: 70px;
        height: auto;
        display: block;
    }

    .product-image-thumb.active {
        border: 2px solid #0d6efd;
    }
</style>
@endpush

@section('admin_content')
<section class="content">
    <div class="card card-solid">
        <div class="card-body">
            <div class="row">
                {{-- Left: Product images --}}
                <div class="col-12 col-sm-6">
                    <h3 class="d-inline-block d-sm-none">{{ $product->name }}</h3>
                    <div class="col-12">
                        <img id="main-product-image"
                             src="{{ $product->getDisplayData()['image'] ?? asset('dist/img/prod-1.jpg') }}"
                             class="product-image" alt="{{ $product->name }}">
                    </div>

                    @if ($product->images->count() > 1)
                        <div class="col-12 product-image-thumbs">
                            @foreach ($product->images as $index => $img)
                                <div class="product-image-thumb {{ $index === 0 ? 'active' : '' }}">
                                    <img src="{{ asset('storage/products/' . basename($img->image_path ?? '')) }}"
                                         alt="Image {{ $index + 1 }}">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Right: Product details --}}
                <div class="col-12 col-sm-6">
                    <h3 class="my-3">{{ $product->name }}</h3>
                    <p>{{ $product->short_description ?? Str::limit($product->description, 150) }}</p>
                    <hr>

                    {{-- Colors --}}
                    @if (!empty($product->colors) && count($product->colors))
                        <h4>Available Colors</h4>
                        <div class="btn-group btn-group-toggle" data-bs-toggle="buttons">
                            @foreach ($product->colors as $color)
                                <label class="btn btn-outline-secondary {{ $loop->first ? 'active' : '' }}">
                                    <input type="radio" name="color_option" autocomplete="off" {{ $loop->first ? 'checked' : '' }}>
                                    {{ ucfirst($color['name']) }}
                                    <br>
                                    <i class="fas fa-circle fa-2x text-{{ $color['class'] ?? 'secondary' }}"></i>
                                </label>
                            @endforeach
                        </div>
                    @endif

                    {{-- Sizes --}}
                    @if (!empty($product->sizes) && count($product->sizes))
                        <h4 class="mt-3">Size <small>Please select one</small></h4>
                        <div class="btn-group btn-group-toggle" data-bs-toggle="buttons">
                            @foreach ($product->sizes as $size)
                                <label class="btn btn-outline-secondary">
                                    <input type="radio" name="size_option" autocomplete="off">
                                    <span class="text-xl">{{ strtoupper($size['abbr']) }}</span>
                                    <br>{{ ucfirst($size['name']) }}
                                </label>
                            @endforeach
                        </div>
                    @endif

                    {{-- Price --}}
                    @php
                        $displayData = $product->getDisplayData();
                        $price = $displayData['price'] ?? $product->price;
                        $salePrice = $displayData['sale_price'] ?? $product->sale_price;
                    @endphp

                    <div class="bg-light py-2 px-3 mt-4 rounded">
                        @if ($salePrice && $salePrice < $price)
                            <h2 class="mb-0 text-danger">${{ number_format($salePrice, 2) }}</h2>
                            <h4 class="mt-0"><small><del>${{ number_format($price, 2) }}</del></small></h4>
                        @else
                            <h2 class="mb-0">${{ number_format($price, 2) }}</h2>
                            <h4 class="mt-0"><small>Ex Tax: ${{ number_format($price, 2) }}</small></h4>
                        @endif
                    </div>

                    {{-- Buttons --}}
                    <div class="mt-4">
                        <button class="btn btn-primary btn-lg">
                            <i class="fas fa-cart-plus fa-lg me-2"></i> Add to Cart
                        </button>
                        <button class="btn btn-outline-secondary btn-lg">
                            <i class="fas fa-heart fa-lg me-2"></i> Add to Wishlist
                        </button>
                    </div>

                    {{-- Share --}}
                    <div class="mt-4 product-share">
                        <a href="#" class="text-gray me-2"><i class="fab fa-facebook-square fa-2x"></i></a>
                        <a href="#" class="text-gray me-2"><i class="fab fa-twitter-square fa-2x"></i></a>
                        <a href="#" class="text-gray me-2"><i class="fas fa-envelope-square fa-2x"></i></a>
                        <a href="#" class="text-gray"><i class="fas fa-rss-square fa-2x"></i></a>
                    </div>
                </div>
            </div>

            {{-- Tabs --}}
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#product-desc" data-bs-toggle="tab">Description</a></li>
                                <li class="nav-item"><a class="nav-link" href="#product-comments" data-bs-toggle="tab">Comments</a></li>
                                <li class="nav-item"><a class="nav-link" href="#product-rating" data-bs-toggle="tab">Rating</a></li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="product-desc">
                                    {!! nl2br(e($product->description)) !!}
                                </div>
                                <div class="tab-pane fade" id="product-comments">
                                    <p>No comments yet.</p>
                                </div>
                                <div class="tab-pane fade" id="product-rating">
                                    <p>★★★★☆</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection

@push('admin_script')
<script>
    // Thumbnail click to change main image
    document.querySelectorAll('.product-image-thumb').forEach(function(el) {
        el.addEventListener('click', function() {
            document.querySelectorAll('.product-image-thumb').forEach(i => i.classList.remove('active'));
            this.classList.add('active');
            document.getElementById('main-product-image').src = this.querySelector('img').src;
        });
    });
</script>
@endpush
