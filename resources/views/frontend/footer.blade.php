    <!-- Footer Section Start -->
    <footer class="section-t-space">
        <div class="container-fluid-lg">
            <div class="service-section">
                <div class="row g-3">
                    <div class="col-12">
                        <div class="service-contain">
                            <div class="service-box">
                                <div class="service-image">
                                    <img src="{{ asset('frontend') }}/assets/svg/product.svg" class="blur-up lazyload"
                                        alt="">
                                </div>

                                <div class="service-detail">
                                    <h5>Every Fresh Products</h5>
                                </div>
                            </div>

                            <div class="service-box">
                                <div class="service-image">
                                    <img src="{{ asset('frontend') }}/assets/svg/delivery.svg" class="blur-up lazyload"
                                        alt="">
                                </div>

                                <div class="service-detail">
                                    <h5>Free Delivery For Limited Products</h5>
                                </div>
                            </div>

                            <div class="service-box">
                                <div class="service-image">
                                    <img src="{{ asset('frontend') }}/assets/svg/discount.svg" class="blur-up lazyload"
                                        alt="">
                                </div>

                                <div class="service-detail">
                                    <h5>Daily Mega Discounts</h5>
                                </div>
                            </div>

                            <div class="service-box">
                                <div class="service-image">
                                    <img src="{{ asset('frontend') }}/assets/svg/market.svg" class="blur-up lazyload"
                                        alt="">
                                </div>

                                <div class="service-detail">
                                    <h5>Best Price On The Market</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="main-footer section-b-space section-t-space">
                <div class="row g-md-4 g-3">
                    <div class="col-xl-3 col-lg-4 col-sm-6">
                        <div class="footer-logo">
                            <div class="theme-logo">
                                <a href="{{ route('index') }}">
                                    <img src="{{ asset('frontend') }}/assets/images/logo/ElhaamBD_logo.png"
                                        class="blur-up lazyload" alt="">
                                </a>
                                {{-- <a href="{{ url('/') }}" class="web-logo nav-logo">
                                    <img src="{{ asset('frontend') }}/assets/images/logo/ElhaamBD_logo.png"
                                        class="img-fluid blur-up lazyload" alt="">
                                </a> --}}
                            </div>

                            <div class="footer-logo-contain">
                                <p>Welcome to ECOM EmpoTechBD!
                                    Your go-to for quality products, great prices, and exceptional service.
                                    We prioritize convenience, sustainability, and a seamless shopping experience. Shop
                                    confidently—your satisfaction is our mission!</p>
                                <ul class="address">
                                    <li>
                                        <i data-feather="home"></i>
                                        <a href="javascript:void(0)">House 36, Road-5, Block B, Banasree, <br> Rampura,
                                            Dhaka, Bangladesh,1219
                                        </a>
                                    </li>
                                    <li>
                                        <i data-feather="mail"></i>
                                        <a href="javascript:void(0)">support@empotechbd.com </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                        <div class="footer-title">
                            <h4>{{ __('content.all_category') }}</h4>
                        </div>

                        <div class="footer-contain">
                            <ul>
                                @forelse ($categories as $category)
                                    <li>
                                        <a href="{{ route('category.details', $category->id) }}"
                                            class="text-content">{{ $category->name }}</a>
                                    </li>
                                @empty
                                    <!-- You can display a message if no categories are available -->
                                    <li>No categories available.</li>
                                @endforelse
                            </ul>
                        </div>

                    </div>

                    <div class="col-xl col-lg-2 col-sm-3">
                        <div class="footer-title">
                            <h4>Useful Links</h4>
                        </div>

                        <div class="footer-contain">
                            <ul>
                                <li>
                                    <a href="{{ route('index') }}" class="text-content">Home</a>
                                </li>
                                <li>
                                    <a href="#" class="text-content">About Us</a>
                                </li>
                                <li>
                                    <a href="#" class="text-content">Blog</a>
                                </li>
                                <li>
                                    <a href="#" class="text-content">Contact Us</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-xl-2 col-sm-3">
                        <div class="footer-title">
                            <h4>Help Center</h4>
                        </div>

                        <div class="footer-contain">
                            <ul>
                                <li>
                                    <a href="{{ route('user.dashboard') }}" class="text-content">Your Order</a>
                                </li>
                                <li>
                                    <a href="{{ route('user.dashboard') }}" class="text-content">Your Account</a>
                                </li>
                                {{-- <li>
                                    <a href="order-tracking.html" class="text-content">Track Order</a>
                                </li> --}}
                                {{-- <li>
                                    <a href="#" class="text-content">Your Wishlist</a>
                                </li> --}}
                                {{-- <li>
                                    <a href="search.html" class="text-content">Search</a>
                                </li> --}}
                                <li>
                                    <a href="#" class="text-content">FAQ</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-xl-3 col-lg-4 col-sm-6">
                        <div class="footer-title">
                            <h4>Contact Us</h4>
                        </div>

                        <div class="footer-contact">
                            <ul>
                                <li>
                                    <div class="footer-number">
                                        <i data-feather="phone"></i>
                                        <div class="contact-number">
                                            <h6 class="text-content">Hotline 24/7 :</h6>
                                            <h5>
                                                <a href="https://wa.me/8801521406205?text=Hello%20I%20want%20to%20know%20more%20about%20your%20services"
                                                    target="_blank">
                                                    01521406205
                                                </a>
                                            </h5>

                                        </div>
                                    </div>
                                </li>

                                <li>
                                    <div class="footer-number">
                                        <i data-feather="mail"></i>
                                        <div class="contact-number">
                                            <h6 class="text-content">Email Address :</h6>
                                            <h5>support@empotechbd.com</h5>
                                        </div>
                                    </div>
                                </li>

                                {{-- <li class="social-app">
                                    <h5 class="mb-2 text-content">Download App :</h5>
                                    <ul>
                                        <li class="mb-0">
                                            <a href="https://play.google.com/store/apps" target="_blank">
                                                <img src="{{ asset('frontend') }}/assets/images/playstore.svg"
                                                    class="blur-up lazyload" alt="">
                                            </a>
                                        </li>
                                        <li class="mb-0">
                                            <a href="https://www.apple.com/in/app-store/" target="_blank">
                                                <img src="{{ asset('frontend') }}/assets/images/appstore.svg"
                                                    class="blur-up lazyload" alt="">
                                            </a>
                                        </li>
                                    </ul>
                                </li> --}}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="sub-footer section-small-space">
                <div class="reserve">
                    <h6 class="text-content">Developed by <strong><a href="https://www.empotechbd.com" target="_blank"
                                style="color: #007bff; text-decoration: none;">Empotech BD</a></strong></h6>
                </div>

                {{-- <div class="payment">
                    <img src="{{ asset('frontend') }}/assets/images/payment/1.png" class="blur-up lazyload"
                        alt="">
                </div> --}}

                <div class="social-link">
                    <h6 class="text-content">Stay connected :</h6>
                    <ul>
                        <li>
                            <a href="https://www.facebook.com/empotechbdofficial" target="_blank">
                                <i class="fa-brands fa-facebook-f"></i>
                            </a>
                        </li>
                        <li>
                            <a href="https://empotechbd.com/" target="_blank">
                                <i class="fa-brands fa-linkedin"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#" target="_blank">
                                <i class="fa-brands fa-instagram"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer Section End -->
