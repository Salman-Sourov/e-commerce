<title>Seaarch - EMPO BD</title>
@extends('frontend.frontend_dashboard')
@section('main')
    <!-- Breadcrumb Section Start -->
    <section class="breadscrumb-section pt-0">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="breadscrumb-contain">
                        <h2>Search</h2>
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('index') }}">
                                        <i class="fa-solid fa-house"></i>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Search</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Search Bar Section Start -->
    <section class="search-section">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-xxl-6 col-xl-8 mx-auto">
                    <div class="title d-block text-center">
                        <h2>Search for products</h2>
                        <span class="title-leaf">
                            <svg class="icon-width">
                                <use xlink:href="{{ asset('frontend') }}/assets/svg/leaf.svg#leaf"></use>
                            </svg>
                        </span>
                    </div>

                    <div class="search-box">
                        <form action="{{ route('product.search') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="input-group">
                                <input type="search" name="search" class="form-control"
                                    placeholder="{{ __('content.search') }}" aria-label="Search"
                                    aria-describedby="button-addon2" requireds>
                                <button class="btn theme-bg-color text-white m-0" type="submit"
                                >Search</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Search Bar Section End -->

    <!-- Product Section Start -->
    <section class="section-b-space">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="search-product product-wrapper">
                        @forelse ($products as $product)
                            <div>
                                <div class="product-box-3 h-100">
                                    <div class="product-header">
                                        <div class="product-image">
                                            <a href="{{ route('product.details', $product->id) }}">
                                                <img src="{{ asset($product->thumbnail) }}"
                                                    class="img-fluid blur-up lazyload" alt="">
                                            </a>
                                        </div>
                                    </div>
                                    @if ($product->stock_status == 'stock_out')
                                        <h5 style="color: red;">Stock Out</h5>
                                    @endif
                                    <div class="product-footer">
                                        <div class="product-detail">
                                            <span class="span-name">{{ $product->categories->category_detail->name }}</span>
                                            <a href="{{ route('product.details', $product->id) }}">
                                                <h5 class="product_name">
                                                    @if (App::getLocale() == 'en')
                                                        {{ $product->name }}
                                                    @else
                                                        {{ $product->translations->name }}
                                                    @endif
                                                </h5>
                                            </a>

                                            <p class="text-content mt-1 mb-2 product-content">{{ $product->description }}
                                            </p>
                                            @php
                                                $get_brand = App\Models\Brand::where('id', $product->brand_id)->first();
                                            @endphp
                                            <h6 class="unit">{{ $get_brand->name ?? 'No Brand' }}</h6>
                                            <h5 class="price"><span class="theme-color">৳
                                                    {{ $product->sale_price }}</span>
                                                <del>৳ {{ $product->price }}</del>
                                                <br> <br>
                                            </h5>
                                            <div class="add-to-cart-box">
                                                <a href="{{ route('product.details', $product->id) }}">
                                                    <button class="btn btn-sm btn-animation">Buy Now</button>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <!-- Do nothing or display a message if needed -->
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Product Section End -->
@endsection

@section('script')
    <script>
        var num = $('#cart_value').val();
        $('#max_value').on('click', function() {
            num++;
            $('#cart_value').val(num);
        });
        $('#min_value').on('click', function() {
            // console.log(num);
            if (num > 1) {
                num--;
            }
            $('#cart_value').val(num);
        });

        function addTocart() {
            // Gather form data
            const formData = new FormData(document.getElementById('addToCart'));

            $.ajax({
                type: 'POST',
                url: '{{ route('cart.add') }}', // Use the Laravel route
                data: formData,
                contentType: false, // Prevent jQuery from setting the content type
                processData: false, // Prevent jQuery from processing the data
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value // Include CSRF token
                },
                success: function(data) {
                    console.log('hello'); // Check the success response in the console

                    if (data.success) {
                        toastr.success(data.message); // Show success message
                        setTimeout(function() {
                            window.location.reload(); // Reload the page after 1500 milliseconds
                        }, 1500);
                    } else {
                        toastr.error(data.message || 'Failed.'); // Show error message if needed
                    }
                },

            });

        }

        function checkOut() {
            const formData = new FormData(document.getElementById('addToCart'));

            $.ajax({
                type: 'POST',
                url: '{{ route('buy.now') }}', // Use the Laravel route
                data: formData,
                contentType: false, // Prevent jQuery from setting the content type
                processData: false, // Prevent jQuery from processing the data
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value // Include CSRF token
                },
                success: function(data) {
                    console.log('hello'); // Check the success response in the console

                    if (data.success) {
                        window.location.href = '{{ route('checkout') }}';
                    } else {
                        toastr.error(data.message || 'Failed to purchase.'); // Show error message if needed
                    }
                },


            });

        }
    </script>
@endsection
