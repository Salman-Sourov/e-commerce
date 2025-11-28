<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    {{-- ✅ SEO Meta --}}
    <title>@yield('title', 'EMPO BD | Smart E-Commerce Platform')</title>
    <meta name="description" content="@yield('meta_description', 'Buy products online at the best prices from EmpoTech BD. Fast delivery, secure payment & trusted sellers.')">
    <meta name="keywords" content="@yield('meta_keywords', 'ecommerce, bangladesh, empotech, online shop, tech store, empotechbd')">
    <meta name="author" content="EmpoTech BD">

    {{-- ✅ Open Graph (for Facebook / WhatsApp) --}}
    <meta property="og:title" content="@yield('og_title', 'ECOM EmpoTech BD')" />
    <meta property="og:description" content="@yield('og_description', 'EmpoTech BD – Trusted Online Shopping Platform in Bangladesh')" />
    <meta property="og:image" content="@yield('og_image', asset('frontend/assets/images/favicon/empotech.png'))" />
    <meta property="og:url" content="https://ecom.empotechbd.com/" />
    <meta property="og:type" content="website" />

    {{-- ✅ Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('twitter_title', 'ECOM EmpoTech BD')">
    <meta name="twitter:description" content="@yield('twitter_description', 'EmpoTech BD – Trusted Online Shopping Platform in Bangladesh')">
    <meta name="twitter:image" content="@yield('twitter_image', asset('frontend/assets/images/favicon/empotech.png'))">

    {{-- ✅ Canonical URL --}}
    <link rel="canonical" href="https://ecom.empotechbd.com/" />

    {{-- ✅ Favicon --}}
    <link rel="icon" href="{{ asset('frontend/assets/images/favicon/empobd.png') }}" type="image/x-icon">

    {{-- ✅ Google Fonts --}}
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Russo+One&family=Exo+2:wght@400;600;700&family=Public+Sans:wght@400;600;700&display=swap"
        rel="stylesheet">

    {{-- ✅ CSS Files --}}
    <link id="rtl-link" rel="stylesheet" href="{{ asset('frontend/assets/css/vendors/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/vendors/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/vendors/feather-icon.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/vendors/slick/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/vendors/slick/slick-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/bulk-style.css') }}">
    <link id="color-link" rel="stylesheet" href="{{ asset('frontend/assets/css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">

    {{-- ✅ Custom Loader Color --}}
    <style>
        :root {
            --loader-color: #f3b201;
        }

        .fullpage-loader span {
            background: var(--loader-color) !important;
        }
    </style>

    {{-- ✅ CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- ✅ Google Tag Manager --}}
    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src = 'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-55XC7LQK');
    </script>
    <!-- End Google Tag Manager -->

    {{-- ✅ Google Analytics 4 (optional) --}}
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-XXXXXXX"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'G-XXXXXXX'); // Replace with your GA4 ID
    </script>

    {{-- ✅ Meta Pixel (Facebook / Instagram Ads) --}}
    <script>
        ! function(f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function() {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', ' 1184810063498513'); // Replace with your Pixel ID
        fbq('track', 'PageView');
    </script>
    <noscript>
        <img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id= 1184810063498513&ev=PageView&noscript=1" />
    </noscript>
</head>

<body class="bg-effect">
    {{-- ✅ Google Tag Manager (noscript) --}}
    <!-- Google Tag Manager (noscript) -->
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-55XC7LQK" height="0" width="0"
            style="display:none;visibility:hidden"></iframe>
    </noscript>
    <!-- End Google Tag Manager (noscript) -->

    <!-- Loader Start -->
    <div class="fullpage-loader">
        <span></span><span></span><span></span><span></span><span></span><span></span>
    </div>
    <!-- Loader End -->

    @include('frontend.header')

    @yield('main')

    @include('frontend.footer')

    <!-- Back to top -->
    <div class="theme-option">
        <div class="back-to-top">
            <a id="back-to-top" href="#"><i class="fas fa-chevron-up"></i></a>
        </div>
    </div>

    <div class="bg-overlay"></div>

    {{-- ✅ JS Files --}}
    <script src="{{ asset('frontend/assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/bootstrap/bootstrap-notify.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/feather/feather.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/feather/feather-icon.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/lazysizes.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/slick/slick.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/slick/custom_slick.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/auto-height.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/fly-cart.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/quantity-2.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/wow.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/custom-wow.js') }}"></script>
    <script src="{{ asset('frontend/assets/js/script.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        function closeCart() {
            var id = event.currentTarget.getAttribute('data-id');
            var url = "{{ route('cart.remove', ':id') }}".replace(':id', id);
            // alert(id);

            $.ajax({
                type: 'GET',
                url: url,
                contentType: false,
                processData: false,

                success: function(data) {
                    console.log(data);
                    $('#cart-quantity').text(data.update_cart_quantity);
                    $('#mobile-cart-count').text(data.update_cart_quantity);
                    $('#total_price').text(data.total_price);
                    $('#sub_total').text(data.total_price);
                    $('#total_order_amount').text(data.total_price);
                }
            });
        }
    </script>

    <script>
        function toggleTransactionField() {
            var paymentOption = document.getElementById('payment-option').value;
            var transactionField = document.getElementById('transaction-field');
            if (paymentOption === 'full-amount') {
                transactionField.style.display = 'block';
            } else {
                transactionField.style.display = 'none';
            }
        }
    </script>

    <script>
        $(document).ready(function() {
            // Trigger update when the area selection changes
            $('#area').change(function() {
                // Get the selected value from the dropdown
                var areaValue = $(this).val();
                // Default total price (replace with actual value)
                var totalPrice = parseInt($('#sub_total').text()); // Replace with your dynamic total price


                var shippingAmount = 0;
                if (areaValue) {
                    shippingAmount = parseInt(areaValue);
                }


                // Update the shipping amount displayed
                $('#shipping_amount').text(shippingAmount);

                // Calculate and update the total order amount (including shipping)
                var totalOrderAmount = totalPrice + shippingAmount;

                $('#total_order_amount').text(totalOrderAmount);
            });
        });
    </script>

    @yield('script')
</body>

</html>
