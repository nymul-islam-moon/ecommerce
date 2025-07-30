@extends('admin.layouts.app')

@section('content')
    <section class="content">

        <div class="card card-solid">
            <div class="card-body">
                <div class="row">
                    {{-- Product images --}}
                    <div class="col-12 col-sm-6">
                        <h3 class="d-inline-block d-sm-none">{{ $product->name }}</h3>

                        <div class="col-12">
                            <img src="{{ $product->images[0] ?? asset('dist/img/prod-1.jpg') }}" class="product-image"
                                alt="{{ $product->name }}">
                        </div>

                        @if (!empty($product->images) && count($product->images) > 1)
                            <div class="col-12 product-image-thumbs">
                                @foreach ($product->images as $index => $img)
                                    <div class="product-image-thumb {{ $index === 0 ? 'active' : '' }}">
                                        <img src="{{ $img }}" alt="Image {{ $index + 1 }}">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    {{-- Product details --}}
                    <div class="col-12 col-sm-6">
                        <h3 class="my-3">{{ $product->name }}</h3>
                        <p>{{ $product->short_description ?? Str::limit($product->description, 150) }}</p>

                        <hr>

                        @if (!empty($product->colors) && count($product->colors))
                            <h4>Available Colors</h4>
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                @foreach ($product->colors as $color)
                                    <label class="btn btn-default text-center {{ $loop->first ? 'active' : '' }}">
                                        <input type="radio" name="color_option" autocomplete="off"
                                            {{ $loop->first ? 'checked' : '' }}>
                                        {{ ucfirst($color['name']) }}
                                        <br>
                                        <i class="fas fa-circle fa-2x text-{{ $color['class'] ?? 'secondary' }}"></i>
                                    </label>
                                @endforeach
                            </div>
                        @endif

                        @if (!empty($product->sizes) && count($product->sizes))
                            <h4 class="mt-3">Size <small>Please select one</small></h4>
                            <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                @foreach ($product->sizes as $size)
                                    <label class="btn btn-default text-center">
                                        <input type="radio" name="size_option" autocomplete="off">
                                        <span class="text-xl">{{ strtoupper($size['abbr']) }}</span>
                                        <br>
                                        {{ ucfirst($size['name']) }}
                                    </label>
                                @endforeach
                            </div>
                        @endif

                        <div class="bg-gray py-2 px-3 mt-4">
                            <h2 class="mb-0">${{ number_format($product->price, 2) }}</h2>
                            <h4 class="mt-0"><small>Ex Tax: ${{ number_format($product->price, 2) }}</small></h4>
                        </div>

                        <div class="mt-4">
                            <button class="btn btn-primary btn-lg btn-flat">
                                <i class="fas fa-cart-plus fa-lg mr-2"></i>
                                Add to Cart
                            </button>
                            <button class="btn btn-default btn-lg btn-flat">
                                <i class="fas fa-heart fa-lg mr-2"></i>
                                Add to Wishlist
                            </button>
                        </div>

                        <div class="mt-4 product-share">
                            <a href="#" class="text-gray"><i class="fab fa-facebook-square fa-2x"></i></a>
                            <a href="#" class="text-gray"><i class="fab fa-twitter-square fa-2x"></i></a>
                            <a href="#" class="text-gray"><i class="fas fa-envelope-square fa-2x"></i></a>
                            <a href="#" class="text-gray"><i class="fas fa-rss-square fa-2x"></i></a>
                        </div>
                    </div>
                </div>

                {{-- Tabs --}}
                <div class="row mt-4">
                    <nav class="w-100">
                        <div class="nav nav-tabs" id="product-tab" role="tablist">
                            <a class="nav-item nav-link active" id="desc-tab" data-toggle="tab" href="#desc"
                                role="tab" aria-controls="desc" aria-selected="true">Description</a>
                            <a class="nav-item nav-link" id="comments-tab" data-toggle="tab" href="#comments"
                                role="tab">Comments</a>
                            <a class="nav-item nav-link" id="rating-tab" data-toggle="tab" href="#rating"
                                role="tab">Rating</a>
                        </div>
                    </nav>
                    <div class="tab-content p-3" id="productTabContent">
                        <div class="tab-pane fade show active" id="desc" role="tabpanel">
                            {!! nl2br(e($product->description)) !!}
                        </div>
                        <div class="tab-pane fade" id="comments" role="tabpanel">
                            <p>No comments yet.</p>
                        </div>
                        <div class="tab-pane fade" id="rating" role="tabpanel">
                            <p>Rating: ★★★★☆</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection
