<title>{{ request('search') }} - EMPO BD</title>
@extends('frontend.frontend_dashboard')
@section('main')
    <!-- Product Section Start -->
    <section class="section-b-space shop-section">
        <div class="container-fluid-lg">
            <div class="title">
                <h2> Results for your search '{{ request('search') }}' </h2>
                <span class="title-leaf">
                    <svg class="icon-width">
                        <use xlink:href="{{ asset('frontend/assets/svg/leaf.svg#leaf') }}"></use>
                    </svg>
                </span>
            </div>
            <div class="row">
                <div class="col-xxl-9 col-xl-8">
                    <div
                        class="row g-sm-4 g-3 row-cols-xxl-5 row-cols-xl-3 row-cols-lg-2 row-cols-md-3 row-cols-2 product-list-section">
                        
                        @if ($products->count())
                            @foreach ($products as $product)
                                <div>
                                    <div class="product-box-3 h-100 wow fadeInUp">
                                        <div class="product-header">
                                            <div class="product-image">
                                                <a href="{{ route('product.details', $product->id) }}">
                                                    <img src="{{ asset($product->thumbnail) }}"
                                                        class="img-fluid blur-up lazyload" alt="{{ $product->name }}">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="product-footer">
                                            <div class="product-detail">
                                                <span class="span-name">
                                                    {{ $product->categories->category_detail->name ?? 'No Category' }}
                                                </span>
                                                <a href="{{ route('product.details', $product->id) }}">
                                                    <h5 class="name">{{ Str::limit($product->name, 17) }}</h5>
                                                </a>
                                                <p class="text-content mt-1 mb-2 product-content">
                                                    {{ Str::limit($product->description, 50) ?? 'No Description Available' }}
                                                </p>
                                                @php
                                                    $brand = $product->brand ?? null;
                                                @endphp
                                                <h6 class="unit">{{ $brand->name ?? 'No Brand' }}</h6>
                                                <h5 class="price">
                                                    <span class="theme-color">৳ {{ $product->sale_price }}</span>
                                                    @if ($product->price > $product->sale_price)
                                                        <del>৳ {{ $product->price }}</del>
                                                    @endif
                                                </h5>
                                                <br>
                                                <div class="add-to-cart-box">
                                                    <a href="{{ route('product.details', $product->id) }}">
                                                        <button class="btn btn-sm btn-animation">Buy Now</button>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="text-center">No products found for your search.</p>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Section End -->
@endsection
