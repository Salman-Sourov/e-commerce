<title>Checkout - EMPO BD</title>
@extends('frontend.frontend_dashboard')
@section('main')
    <!-- Cart Section Start -->
    @if ($carts)
        {
        @php
            $carts = $carts ?? [];
            $total_price = 0;
        @endphp
        <div class="container-fluid-lg">
            <div class="row g-sm-5 g-3">

                <div class="col-xxl-6">
                    <div class="log-in-box">
                        <div class="log-in-title">

                            @guest
                                <div class="sign-up-box-cart">
                                    <h4 class="inline-text">Already have an account?</h4>
                                    <a href="{{ route('login') }}" class="inline-text login-link">Log In</a>
                                </div>
                            @endguest
                            <h3 class="mb-2 text-success fw-bold">Confirm Order - EMPO BD</h3>
                            <p>
                                Enter <strong>Name</strong>, <strong>Address</strong>, <strong>Phone</strong>, select
                                <strong>Area</strong>, <strong>Payment Amount</strong>, <strong>Method</strong>, and click
                                <span class="highlight">Confirm Order</span>.
                            </p>
                        </div>

                        <div class="input-box">
                            <form id="confirmOrder" class="row g-4" method="POST" onsubmit="event.preventDefault();">
                                @csrf

                                <div class="col-12">
                                    <div class="form-floating theme-form-floating mb-3">
                                        <input type="text" name="name" class="form-control" id="fullname"
                                            placeholder="Full Name" value="{{ Auth::check() ? Auth::user()->name : '' }}"
                                            {{ Auth::check() }}>
                                        <label for="fullname">Full Name (আপনার নাম)</label>
                                        <span id="name_error" class="text-danger"></span>
                                    </div>

                                    <div class="col-12 mb-3">
                                        <div class="form-floating theme-form-floating">
                                            <input type="text" name="phone" class="form-control" id="phone"
                                                placeholder="phone" value="{{ Auth::check() ? Auth::user()->phone : '' }}"
                                                {{ Auth::check() }}>
                                            <label for="phone">Phone Number (ফোন নাম্বার)</label>
                                            <span id="phone_error" class="text-danger"></span>
                                        </div>
                                    </div>

                                    <div class="col-12 mb-3">
                                        <div class="form-floating theme-form-floating">
                                            <input type="text" name="address" class="form-control" id="address"
                                                placeholder="Address"
                                                value="{{ Auth::check() ? Auth::user()->address : '' }}"
                                                {{ Auth::check() }}>
                                            <label for="email">Address (ঠিকানা)</label>
                                            <span id="address_error" class="text-danger"></span>
                                        </div>
                                    </div>

                                    <div class="col-12 mb-3">
                                        <div class="form-floating theme-form-floating">
                                            <select class="form-select" id="area" name="area">
                                                <option value="">Select Area</option>
                                                <option value="60">Dhaka City - ৳60</option>
                                                <option value="100">Sub Area of Dhaka - ৳100 (Savar, Tongi-Gazipur,
                                                    Narayanganj, Keraniganj)</option>
                                                <option value="130">Other Area - ৳130 (Outside Dhaka)</option>
                                            </select>
                                            <label for="area"> Please Select Your Area (এলাকা) </label>
                                            <span id="area_error" class="text-danger"></span>
                                        </div>
                                    </div>

                                    <div class="col-12 mb-3">
                                        <div class="form-floating theme-form-floating">
                                            <select class="form-select" id="payment-option"
                                                onchange="toggleTransactionField()" name="payment_option">
                                                <option value="cash-on-delivery" selected>Cash on Delivery</option>
                                                <option value="full-amount">Payable Amount</option>
                                            </select>
                                            <label for="payment-option">Payment Option (পেমেন্ট অপশন)</label>
                                            <span id="payment-option_error" class="text-danger"></span>
                                        </div>
                                    </div>

                                    <div class="col-12 mb-4" id="transaction-field" style="display: none;">
                                        <div class="form-floating theme-form-floating">
                                            <input type="text" name="bkash" class="form-control" id="transaction"
                                                placeholder="Bkash No or Transaction No">
                                            <label for="transaction">সেন্ডমানি: 01521406205(Bkash) <br> (আপনার বিকাশ নাম্বার
                                                বা ট্রানজেকশন আইডি লিখুন)</label>
                                        </div>
                                    </div>

                                    {{-- <button type="button" onclick="addTocart()"
                                        class="btn btn-md bg-dark cart-button text-white w-90">Add To Cart</button> --}}

                                    <div class="col-12">
                                        <button class="btn btn-animation w-100" type="button"
                                            onclick="confirmOrder()">Confirm
                                            Order</button>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-xxl-6">
                <div class="cart-table">
                    <div class="table-responsive-xl">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Img</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th>Att.</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($carts as $key => $cart)
                                    <tr class="product-box-contain">
                                        <td class="product-detail">
                                            <div class="product border-0">
                                                <a href="{{ route('product.details', $key) }}" class="product-image" target="_blank"> 
                                                    <img src="{{ asset($cart['image']) }}" alt="">
                                                </a>
                                            </div>
                                        </td>
                                        <td class="name" data-label="Name">
                                            <a href="{{ route('product.details', $key) }} " target="_blank">
                                                {{ $cart['name'] }}
                                            </a>
                                        </td>
                                        <td class="price text-center" data-label="Price">৳ {{ $cart['price'] }}</td>
                                        <td class="quantity text-centre" data-label="Qty">{{ $cart['quantity'] }}</td>
                                        @if (isset($cart['attributes']) && $cart['attributes'])
                                            @php
                                                $explode_attributes = explode(',', $cart['attributes']);
                                                $attributes = App\Models\Product_attribute::whereIn(
                                                    'id',
                                                    $explode_attributes,
                                                )->get();

                                                // dd($attributes);

                                            @endphp

                                            <td class="attribute" data-label="Attributes">
                                                @if ($attributes->isNotEmpty())
                                                    @php
                                                        $total_attributes = count($attributes);
                                                    @endphp
                                                    @foreach ($attributes as $index => $attribute)
                                                        <li>
                                                            {{ $attribute->title }}
                                                            @if ($index < $total_attributes - 1)
                                                                <!-- Check if it's not the last item -->
                                                                -
                                                            @endif
                                                        </li>
                                                    @endforeach
                                                @else
                                                    No Attribute
                                                @endif

                                            </td>
                                        @else
                                            <td class="attribute" data-label="Attributes">X</td>
                                        @endif

                                        <td class="subtotal" data-label="Total">৳ {{ $cart['price'] * $cart['quantity'] }}</td>
                                        <td class="remove close_button">
                                            <a class="" data-id="{{ $key }}" onclick="closeCart()">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @php
                                        $total_price = $total_price + $cart['price'] * $cart['quantity'];
                                    @endphp
                                @empty
                                    <tr>
                                        <td colspan="6">No items in the cart.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>



                <div class="summery-box p-sticky">
                    <div class="summery-header">
                        <h3>Cart Total</h3>
                    </div>

                    <div class="summery-contain">
                        {{-- <div class="coupon-cart">
                                    <h6 class="text-content mb-2">Coupon Apply</h6>
                                    <div class="mb-3 coupon-box input-group">
                                        <input type="email" class="form-control" id="exampleFormControlInput1"
                                            placeholder="Enter Coupon Code Here...">
                                        <button class="btn-apply">Apply</button>
                                    </div>
                                </div> --}}
                        <ul>
                            <li>
                                <h4>Subtotal</h4>
                                <h4 class="price" id="sub_total">{{ $total_price }}</h4>
                                <h4> ৳</h4>
                            </li>

                            {{-- <li>
                                        <h4>Coupon Discount</h4>
                                        <h4 class="price">(-) 0.00</h4>
                                    </li> --}}

                            <li class="align-items-start">
                                <h4>Shipping</h4>
                                <h4 class="price text-end" id="shipping_amount">0</h4>
                                <h4> ৳</h4>
                            </li>
                        </ul>
                    </div>

                    <ul class="summery-total">
                        <li class="list-total border-top-0">
                            <h4>Total </h4>
                            <h4 class="price theme-color" id="total_order_amount">{{ $total_price }}</h4>
                            <h4> (৳)</h4>
                        </li>
                    </ul>

                    {{-- <div class="button-group cart-button">
                            <ul>
                                <li>
                                    <button onclick="location.href = 'checkout.html';"
                                        class="btn btn-animation proceed-btn fw-bold">Process To Checkout</button>
                                </li>

                                <li>
                                    <button onclick="location.href = 'index.html';"
                                        class="btn btn-light shopping-button text-dark">
                                        <i class="fa-solid fa-arrow-left-long"></i>Return To Shopping</button>
                                </li>
                            </ul>
                        </div> --}}
                </div>
            </div>

        </div>
        </div>
        }
    @else
        <div style="text-align: center; mb-3">
            <img src="https://media3.giphy.com/media/v1.Y2lkPTc5MGI3NjExM3dsZW9nZ2oydG9lYTRpM2xpbDhiMDl3OTA2ZXR1azdvcHhzdzZkNyZlcD12MV9pbnRlcm5hbF9naWZfYnlfaWQmY3Q9Zw/RipfZWzjUDH25euMpM/giphy.gif" 
         alt="Thank You for Your Order Animation"
         style="width: 400px; margin-bottom: 20px;">
            <p style="font-size: 18px; font-weight: bold;">Thank You for Your Order!</p>
            <p style="font-size: 18px;">If you have any issues, please call or message us.</p>
            <p style="font-size: 18px;">
                Contact us at:
                <a href="https://wa.me/8801521406205?text=Hello%20I%20want%20to%20know%20more%20about%20your%20services"
                    target="_blank" aria-label="Contact us via WhatsApp at 01521406205">
                    01521406205
                </a>
            </p>
        </div>
    @endif
    <!-- Cart Section End -->
@endsection

@section('script')
    <script>
        function confirmOrder() {
            // Gather form data
            const formData = new FormData(document.getElementById('confirmOrder'));

            // Add the subtotal value to the formData
            var subTotal = $('#sub_total').text();
            formData.append('sub_total', subTotal);

            // Get the CSRF token value
            const csrfToken = $('input[name="_token"]').val();

            // Send AJAX request
            $.ajax({
                type: 'POST',
                url: '{{ route('confirm.order') }}', // Use the Laravel route
                data: formData,
                contentType: false, // Prevent jQuery from setting the content type
                processData: false, // Prevent jQuery from processing the data
                headers: {
                    'X-CSRF-TOKEN': csrfToken // Add CSRF token to headers
                },
                success: function(data) {
                    // Check the response in the console

                    if (data.success) {
                        toastr.success(data.message); // Show success message
                        setTimeout(function() {
                            window.location.reload(); // Reload the page after 1500 milliseconds
                        }, 1500);
                    } else {
                        toastr.error(data.message || 'Failed.'); // Show error message if needed
                    }
                },
                error: function(xhr, status, error) {
                    const errors = xhr.responseJSON.errors;
                    for (let field in errors) {
                        $('#' + field + '_error').text(errors[field][0]); // Show validation errors
                    }
                }
            });
        }
    </script>
@endsection
