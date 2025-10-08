<title>{{ $category_name->name }} - ECOM EmpoTech</title>
@extends('frontend.frontend_dashboard')
@section('main')
    <section class="breadscrumb-section pt-0">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="breadscrumb-contain">
                        <h2>{{ $category_name->name }}</h2>
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="">
                                        <i class="fa-solid fa-house"></i>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">{{ $category_name->name }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- <section>
                            <div class="container-fluid-lg">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="slider-1 slider-animate product-wrapper no-arrow">
                                            <div>
                                                <div class="banner-contain-2 hover-effect">
                                                    <img src="../assets/images/shop/1.jpg" class="bg-img rounded-3 blur-up lazyload" alt="">
                                                    <div
                                                        class="banner-detail p-center-right position-relative shop-banner ms-auto banner-small">
                                                        <div>
                                                            <h2>Healthy, nutritious & Tasty Fruits & Veggies</h2>
                                                            <h3>Save upto 50%</h3>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div>
                                                <div class="banner-contain-2 hover-effect">
                                                    <img src="../assets/images/shop/1.jpg" class="bg-img rounded-3 blur-up lazyload" alt="">
                                                    <div
                                                        class="banner-detail p-center-right position-relative shop-banner ms-auto banner-small">
                                                        <div>
                                                            <h2>Healthy, nutritious & Tasty Fruits & Veggies</h2>
                                                            <h3>Save upto 50%</h3>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div>
                                                <div class="banner-contain-2 hover-effect">
                                                    <img src="../assets/images/shop/1.jpg" class="bg-img rounded-3 blur-up lazyload" alt="">
                                                    <div
                                                        class="banner-detail p-center-right position-relative shop-banner ms-auto banner-small">
                                                        <div>
                                                            <h2>Healthy, nutritious & Tasty Fruits & Veggies</h2>
                                                            <h3>Save upto 50%</h3>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section> -->


    <section class="section-b-space shop-section">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-custome-0">
                    <div class="left-box wow fadeInUp">
                        <div class="shop-left-sidebar">
                            <div class="back-button">
                                <h3><i class="fa-solid fa-arrow-left"></i> Back</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-custome-12">
                    <div class="show-button">
                        <div class="filter-button-group mt-0">
                            <div class="filter-button d-inline-block d-lg-none">
                                <a><i class="fa-solid fa-filter"></i> Filter Menu</a>
                            </div>
                        </div>

                        <div class="top-filter-menu">
                            <div class="grid-option d-none d-md-block">
                                <ul>
                                    <li class="three-grid">
                                        <a href="javascript:void(0)">
                                            <img src="{{ asset('frontend') }}/assets/svg/grid-3.svg"
                                                class="blur-up lazyload" alt="">
                                        </a>
                                    </li>
                                    <li class="grid-btn d-xxl-inline-block d-none active">
                                        <a href="javascript:void(0)">
                                            <img src="{{ asset('frontend') }}/assets/svg/grid-4.svg"
                                                class="blur-up lazyload d-lg-inline-block d-none" alt="">
                                            <img src="{{ asset('frontend') }}/assets/svg/grid.svg"
                                                class="blur-up lazyload img-fluid d-lg-none d-inline-block" alt="">
                                        </a>
                                    </li>
                                    <li class="list-btn">
                                        <a href="javascript:void(0)">
                                            <img src="{{ asset('frontend') }}/assets/svg/list.svg" class="blur-up lazyload"
                                                alt="">
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div
                        class="row g-sm-4 g-3 row-cols-xxl-5 row-cols-xl-4 row-cols-lg-2 row-cols-md-3 row-cols-2 product-list-section">
                        @forelse ($category_product->totalProducts as $product)
                            @if ($category_product->parent_id != null && $product->products)
                                <div>
                                    <div class="product-box-3 h-100 wow fadeInUp">
                                        <div class="product-header">
                                            <div class="product-image">
                                                <a href="{{ route('product.details', $product->products->id) }}">
                                                    <img src="{{ asset($product->products->thumbnail ?? 'frontend/assets/images/placeholder.png') }}"
                                                        class="img-fluid blur-up lazyload" alt="">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="product-footer">
                                            <div class="product-detail">
                                                <span class="span-name">
                                                    {{ $product->products->categories->category_detail->name ?? '' }}
                                                </span>
                                                <a href="{{ route('product.details', $product->products->id) }}">
                                                    @if (App::getLocale() == 'en')
                                                        <h5 class="name">{{ Str::limit($product->products->name, 20) }}
                                                        </h5>
                                                    @else
                                                        @php
                                                            $get_product_bangla = App\Models\product_translation::where(
                                                                'products_id',
                                                                $product->products->id,
                                                            )->first();
                                                        @endphp
                                                        <h5 class="name">
                                                            {{ Str::limit($get_product_bangla->name ?? '', 20) }}</h5>
                                                    @endif
                                                </a>
                                                <p class="text-content mt-1 mb-2 product-content">
                                                    {{ $product->products->description ?? '' }}
                                                </p>
                                                <h6 class="unit">{{ $product->products->brands->name ?? '' }}</h6>
                                                <h5 class="price">
                                                    <span
                                                        class="theme-color">{{ $product->products->sale_price ?? '' }}</span>
                                                    <del>{{ $product->products->price ?? '' }}</del>
                                                    <br><br>
                                                </h5>
                                                <a href="{{ route('product.details', $product->products->id) }}">
                                                    <button class="btn btn-sm btn-animation">Buy Now</button>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @empty
                            <p>No products available</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
