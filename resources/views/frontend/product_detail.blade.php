@extends('frontend.frontend_dashboard')
@section('main')
    <!-- Breadcrumb Section Start -->
    <section class="breadscrumb-section pt-0">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="breadscrumb-contain">
                        <h2>{{ $selected_product->name }}</h2>
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="index.html">
                                        <i class="fa-solid fa-house"></i>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active">{{ $selected_product->name }}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Product Left Sidebar Start -->
    <section class="product-section">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-xxl-9 col-xl-8 col-lg-7 wow fadeInUp">
                    <div class="row g-4">
                        <div class="col-xl-6 wow fadeInUp">
                            <div class="product-left-box">
                                <div class="row g-sm-4 g-2">
                                    <div class="col-12">
                                        <div class="product-main no-arrow">

                                            <div class="slider-image">
                                                <img src="{{ asset($selected_product->thumbnail) }}" id="img-1"
                                                    data-zoom-image="{{ asset($selected_product->thumbnail) }}"
                                                    class="
                                                        img-fluid image_zoom_cls-0 blur-up lazyload"
                                                    alt="">
                                            </div>
                                            @forelse($selected_product->multi_images as $images)
                                                <div>
                                                    <div class="slider-image">
                                                        <img src="{{ asset($images->image_detail->image) }}" id="img"
                                                            data-zoom-image="{{ asset($images->image_detail->image) }}"
                                                            class="
                                                        img-fluid image_zoom_cls-0 blur-up lazyload"
                                                            alt="">
                                                    </div>
                                                </div>
                                            @empty
                                            @endforelse
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="left-slider-image left-slider no-arrow slick-top">
                                            <div class="sidebar-image">
                                                <img src="{{ asset($selected_product->thumbnail) }}"
                                                    class="img-fluid blur-up lazyload" alt="" style="width: 82px;">
                                            </div>
                                            @forelse($selected_product->multi_images as $images)
                                                <div>
                                                    <div class="sidebar-image">
                                                        <img src="{{ asset($images->image_detail->image) }}"
                                                            class="img-fluid blur-up lazyload" alt="" style="width: 82px;">
                                                    </div>

                                                </div>
                                            @empty
                                            @endforelse
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-xl-6 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="right-box-contain">
                                <h6 class="offer-top">30% Off</h6>
                                <h2 class="name">{{ $selected_product->name }}</h2>
                                <div class="price-rating">
                                    <h3 class="theme-color price">৳ {{ $selected_product->sale_price }} <del
                                            class="text-content">৳ {{ $selected_product->price }}</del></h3>
                                </div>

                                <div class="procuct-contain">
                                    <p>{{ $selected_product->content }}</p>
                                </div>

                                <div class="product-packege">
                                    <div class="product-title">
                                        <h4>Weight</h4>
                                    </div>
                                    <ul class="select-packege">
                                        <li>
                                            <a href="javascript:void(0)" class="active">1/2 KG</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)">1 KG</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)">1.5 KG</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)">Red Roses</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)">With Pink Roses</a>
                                        </li>
                                    </ul>
                                </div>


                                <div class="note-box product-packege">
                                    <div class="cart_qty qty-box product-qty">
                                        <div class="input-group">
                                            <button type="button" class="qty-right-plus" data-type="plus" data-field="">
                                                <i class="fa fa-plus" aria-hidden="true"></i>
                                            </button>
                                            <input class="form-control input-number qty-input" type="text"
                                                name="quantity" value="0">
                                            <button type="button" class="qty-left-minus" data-type="minus" data-field="">
                                                <i class="fa fa-minus" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <button onclick="location.href = 'cart.html';"
                                        class="btn btn-md bg-dark cart-button text-white w-100">Add To Cart</button>
                                </div>

                                <div class="buy-box">
                                    <a href="wishlist.html">
                                        <i data-feather="heart"></i>
                                        <span>Add To Wishlist</span>
                                    </a>
                                </div>

                                <div class="pickup-box">

                                    <div class="product-info">
                                        <ul class="product-info-list product-info-list-2">
                                            <li>Type : <a
                                                    href="javascript:void(0)">{{ $category_product->category_detail->name }}</a>
                                            </li>
                                            <li>SKU : <a href="javascript:void(0)">{{ $selected_product->sku }}</a></li>
                                            <li>Stock : <a href="javascript:void(0)">2 Items Left</a></li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="paymnet-option">
                                    <div class="product-title">
                                        <h4>Guaranteed Safe Checkout</h4>
                                    </div>
                                    <ul>
                                        <li>
                                            <a href="javascript:void(0)">
                                                <img src="{{ asset('frontend') }}/assets/images/product/payment/1.svg"
                                                    class="blur-up lazyload" alt="">
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)">
                                                <img src="{{ asset('frontend') }}/assets/images/product/payment/2.svg"
                                                    class="blur-up lazyload" alt="">
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)">
                                                <img src="{{ asset('frontend') }}/assets/images/product/payment/3.svg"
                                                    class="blur-up lazyload" alt="">
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)">
                                                <img src="{{ asset('frontend') }}/assets/images/product/payment/4.svg"
                                                    class="blur-up lazyload" alt="">
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)">
                                                <img src="{{ asset('frontend') }}/assets/images/product/payment/5.svg"
                                                    class="blur-up lazyload" alt="">
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="product-section-box">
                                <ul class="nav nav-tabs custom-nav" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="description-tab" data-bs-toggle="tab"
                                            data-bs-target="#description" type="button" role="tab"
                                            aria-controls="description" aria-selected="true">Description</button>
                                    </li>
                                </ul>

                                <div class="tab-content custom-tab" id="myTabContent">
                                    <div class="tab-pane fade show active" id="description" role="tabpanel"
                                        aria-labelledby="description-tab">
                                        <div class="product-description">
                                            <div class="nav-desh">
                                                <h5>{!! nl2br(e($selected_product->description)) !!}</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-3 col-xl-4 col-lg-5 d-none d-lg-block wow fadeInUp">
                    <div class="right-sidebar-box">
                        <!-- Trending Product -->
                        <div class="pt-25">
                            <div class="category-menu">
                                <h3>Trending Products</h3>

                                <ul class="product-list product-right-sidebar border-0 p-0">
                                    @forelse ($trending_products->take(5) as $product)
                                        <li>
                                            <div class="offer-product">
                                                <a href="{{ route('product.details', $product->id) }}"
                                                    class="offer-image">
                                                    <img src="{{ asset($product->thumbnail) }}"
                                                        class="img-fluid blur-up lazyload" alt="">
                                                </a>

                                                <div class="offer-detail">
                                                    <div>
                                                        <a href="{{ route('product.details', $product->id) }}">
                                                            @if (App::getLocale() == 'en')
                                                                <h6 class="name">{{ Str::limit($product->name, 25) }}
                                                                </h6>
                                                            @else
                                                                <h6 class="name">
                                                                    {{ Str::limit($product->translations->name, 20) }}</h6>
                                                            @endif
                                                        </a>
                                                        {{-- <span>450 G</span> --}}
                                                        <h6 class="price theme-color">৳ {{ $product->sale_price }}</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @empty
                                        <!-- Do nothing or display a message if needed -->
                                    @endforelse
                                </ul>
                            </div>
                        </div>

                        <!-- Banner Section -->
                        <div class="ratio_156 pt-25">
                            <div class="home-contain">
                                <img src="{{ asset('frontend') }}/assets/images/veg-2/banner/empotech_bd_banner_3.jpg"
                                    class="bg-img blur-up lazyload" alt="">
                                <div class="home-detail p-top-left home-p-medium">
                                    <div>
                                        <h6 class="text-yellow home-banner">Seafood</h6>
                                        <h3 class="text-uppercase fw-normal"><span
                                                class="theme-color fw-bold">Freshes</span> Products</h3>
                                        <h3 class="fw-light">every hour</h3>
                                        <button onclick="location.href = 'shop-left-sidebar.html';"
                                            class="btn btn-animation btn-md fw-bold mend-auto">Shop Now <i
                                                class="fa-solid fa-arrow-right icon"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Left Sidebar End -->

    <!-- Releted Product Section Start -->
    <section class="product-list-section section-b-space">
        <div class="container-fluid-lg">
            <div class="title">
                <h2>Related Products</h2>
                <span class="title-leaf">
                    <svg class="icon-width">
                        <use xlink:href="{{ asset('frontend') }}/assets/svg/leaf.svg#leaf"></use>
                    </svg>
                </span>
            </div>
            <div class="row">
                <div class="col-12">

                    <div class="slider-6_1 product-wrapper">
                        @forelse ($related_products->totalProducts as $product)
                            @if ($product->products->id != $category_product->product_id)
                                <div>
                                    <div class="product-box-3 wow fadeInUp">
                                        <div class="product-header">
                                            <div class="product-image">
                                                <a href="{{ route('product.details', $product->products->id) }}">
                                                    <img src="{{ asset($product->products->thumbnail) }}"
                                                        class="img-fluid blur-up lazyload" alt="">
                                                </a>
                                            </div>
                                        </div>

                                        <div class="product-footer">
                                            <div class="product-detail">
                                                {{-- <span class="span-name">Cake</span> --}}
                                                <a href="{{ route('product.details', $product->products->id) }}">
                                                    <h5 class="name">{{ $product->products->name }}</h5>
                                                </a>
                                                {{-- <h6 class="unit">500 G</h6> --}}
                                                <h5 class="price"><span class="theme-color">৳ {{ $product->products->sale_price }}</span>
                                                    <del>৳ {{ $product->products->price }}</del>
                                                </h5>
                                                <div class="add-to-cart-box bg-white">
                                                    <button class="btn btn-add-cart addcart-button">Add
                                                        <span class="add-icon bg-light-gray">
                                                            <i class="fa-solid fa-plus"></i>
                                                        </span>
                                                    </button>
                                                    <div class="cart_qty qty-box">
                                                        <div class="input-group bg-white">
                                                            <button type="button" class="qty-left-minus bg-gray"
                                                                data-type="minus" data-field="">
                                                                <i class="fa fa-minus" aria-hidden="true"></i>
                                                            </button>
                                                            <input class="form-control input-number qty-input"
                                                                type="text" name="quantity" value="0">
                                                            <button type="button" class="qty-right-plus bg-gray"
                                                                data-type="plus" data-field="">
                                                                <i class="fa fa-plus" aria-hidden="true"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @empty
                            <!-- Do nothing or display a message if needed -->
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Releted Product Section End -->
@endsection