    <title>User Dashboard - EMPO BD</title>
    @extends('frontend.frontend_dashboard')
    @section('main')
        <!-- Breadcrumb Section Start -->
        <section class="breadscrumb-section pt-0">
            <div class="container-fluid-lg">
                <div class="row">
                    <div class="col-12">
                        <div class="breadscrumb-contain">
                            <h2>User Dashboard</h2>
                            <nav>
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item">
                                        <a href="#">
                                            <i class="fa-solid fa-house"></i>
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">User Dashboard</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Breadcrumb Section End -->

        <!-- User Dashboard Section Start -->
        <section class="user-dashboard-section section-b-space">
            <div class="container-fluid-lg">
                <div class="row">
                    <div class="col-xxl-3 col-lg-4">
                        <div class="dashboard-left-sidebar">
                            <div class="close-button d-flex d-lg-none">
                                <button class="close-sidebar">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </div>
                            <div class="profile-box">
                                <div class="cover-image">
                                    <img src="{{ asset('frontend/assets/images/banner/empobd_banner_4.png') }}"
                                        class="img-fluid blur-up lazyload" alt="">
                                </div>

                                <div class="profile-contain">
                                    <div class="profile-name">
                                        <h3>{{ $auth->name ?? '' }}</h3>
                                        <h6 class="text-content">{{ $auth->email ?? '' }}</h6>
                                    </div>
                                </div>
                            </div>

                            <ul class="nav nav-pills user-nav-pills" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="pills-dashboard-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-dashboard" type="button" role="tab"
                                        aria-controls="pills-dashboard" aria-selected="true"><i data-feather="home"></i>
                                        Profile</button>
                                </li>

                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pills-order-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-order" type="button" role="tab"
                                        aria-controls="pills-order" aria-selected="false"><i
                                            data-feather="shopping-bag"></i>Order</button>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-xxl-9 col-lg-8">
                        <div class="dashboard-right-sidebar">
                            <div class="tab-content" id="pills-tabContent">
                                <button
                                    class="btn left-dashboard-show btn-animation btn-md fw-bold d-block mb-4 d-lg-none">Show
                                    Menu</button>
                                <div class="tab-pane fade show active" id="pills-dashboard" role="tabpanel"
                                    aria-labelledby="pills-dashboard-tab">
                                    <div class="dashboard-home">
                                        <div class="title">
                                            <h2>My Profile</h2>
                                            <span class="title-leaf">
                                                <svg class="icon-width bg-gray">
                                                    <use xlink:href="{{ asset('frontend/assets/svg/leaf.svg#leaf') }}">
                                                    </use>
                                                </svg>
                                            </span>
                                        </div>


                                        <div class="row g-4">
                                            <div class="col-xxl-12">
                                                <form method="POST" action="{{ route('user.profile.update') }}">
                                                    @csrf

                                                    <!-- Phone Number -->
                                                    <div class="form-floating theme-form-floating mb-4">
                                                        <input type="text" name="phone" class="form-control"
                                                            id="phone" placeholder="Phone Number"
                                                            value="{{ Auth::check() ? Auth::user()->phone : '' }}">
                                                        <label for="phone">Phone Number (ফোন নাম্বার)</label>
                                                        <span class="text-danger">
                                                            @error('phone')
                                                                {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>

                                                    <!-- Email -->
                                                    <div class="form-floating theme-form-floating mb-4">
                                                        <input type="email" name="email" class="form-control"
                                                            id="email" placeholder="Email Address"
                                                            value="{{ Auth::check() ? Auth::user()->email : '' }}">
                                                        <label for="email">Email Address (ইমেইল)</label>
                                                        <span class="text-danger">
                                                            @error('email')
                                                                {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>

                                                    <!-- Address -->
                                                    <div class="form-floating theme-form-floating mb-4">
                                                        <input type="text" name="address" class="form-control"
                                                            id="address" placeholder="Address"
                                                            value="{{ Auth::check() ? Auth::user()->address : '' }}">
                                                        <label for="address">Address (ঠিকানা)</label>
                                                        <span class="text-danger">
                                                            @error('address')
                                                                {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>

                                                    <!-- New Password -->
                                                    <div class="form-floating theme-form-floating mb-4">
                                                        <input type="password" name="password" class="form-control"
                                                            id="password" placeholder="New Password">
                                                        <label for="password">New Password (নতুন পাসওয়ার্ড)</label>
                                                        <span class="text-danger">
                                                            @error('password')
                                                                {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>

                                                    <!-- Confirm Password -->
                                                    <div class="form-floating theme-form-floating mb-4">
                                                        <input type="password" name="password_confirmation"
                                                            class="form-control" id="password_confirmation"
                                                            placeholder="Confirm Password">
                                                        <label for="password_confirmation">Confirm Password (পাসওয়ার্ড
                                                            নিশ্চিত করুন)</label>
                                                        <span class="text-danger">
                                                            @error('password_confirmation')
                                                                {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>

                                                    <!-- Submit Button -->
                                                    <div class="text-end">
                                                        <button type="submit" class="btn btn-animation">Update
                                                            Profile</button>
                                                    </div>

                                                    <!-- Success Message -->
                                                    @if (session('success'))
                                                        <div class="alert alert-success mt-3">
                                                            {{ session('success') }}
                                                        </div>
                                                    @endif
                                                </form>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="tab-pane fade show" id="pills-order" role="tabpanel"
                                    aria-labelledby="pills-order-tab">
                                    <div class="dashboard-order">
                                        <div class="title">
                                            <h2>My Orders History</h2>
                                            <span class="title-leaf title-leaf-gray">
                                                <svg class="icon-width bg-gray">
                                                    <use xlink:href="{{ asset('frontend/assets/svg/leaf.svg#leaf') }}">
                                                    </use>
                                                </svg>
                                            </span>
                                        </div>

                                        @if ($orders && count($orders) > 0)
                                            @foreach ($orders as $key => $item)
                                                <div class="order-contain">
                                                    <div class="order-box dashboard-bg-box">
                                                        <div class="order-container">
                                                            <div class="order-icon">
                                                                <i data-feather="box"></i>
                                                            </div>

                                                            <div class="order-detail">
                                                                <h4>#elhaambd{{ $item->id }}
                                                                    <span>{{ $item->status }}</span>
                                                                </h4>
                                                                <h6 class="text-content">
                                                                    <b>Total Cost:</b> {{ $item->total_cost }} <br>
                                                                    <b>Order Date:</b>
                                                                    {{ $item->created_at->timezone('Asia/Dhaka')->format('F d, Y h:i A') }}
                                                                </h6>
                                                            </div>
                                                        </div>

                                                        @if ($item->product && count($item->product) > 0)
                                                            <div class="product-order-detail">
                                                                <div class="table-responsive">
                                                                    <table class="user-table vendor-table table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Sl</th>
                                                                                <th>Image</th>
                                                                                <th>Name</th>
                                                                                <th>Variation</th>
                                                                                <th>Quantity</th>
                                                                                <th>Unit Price</th>
                                                                            </tr>
                                                                        </thead>
                                                                        @foreach ($item->product as $key => $product)
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td>{{ $key + 1 }}</td>
                                                                                    <td>
                                                                                        <span>
                                                                                            <img src="{{ !empty($product->product_details->thumbnail) ? url($product->product_details->thumbnail) : url('upload/no_image.jpg') }}"
                                                                                                alt="users"
                                                                                                style="width:60px; height:40px;">
                                                                                        </span>
                                                                                    </td>

                                                                                    <td>{{ $product->product_details->name }}
                                                                                    </td>

                                                                                    @php
                                                                                        $order_quantity = App\Models\Order_product_quantity::where(
                                                                                            'order_id',
                                                                                            $item->id,
                                                                                        )
                                                                                            ->where(
                                                                                                'product_id',
                                                                                                $product
                                                                                                    ->product_details
                                                                                                    ->id,
                                                                                            )
                                                                                            ->first();

                                                                                        $order_attributes = App\Models\Order_product_attribute::where(
                                                                                            'order_id',
                                                                                            $item->id,
                                                                                        )
                                                                                            ->where(
                                                                                                'product_id',
                                                                                                $product
                                                                                                    ->product_details
                                                                                                    ->id,
                                                                                            )
                                                                                            ->first();

                                                                                        $attributes = $order_attributes
                                                                                            ? App\Models\Product_attribute::whereIn(
                                                                                                'id',
                                                                                                explode(
                                                                                                    ',',
                                                                                                    $order_attributes->attributes,
                                                                                                ),
                                                                                            )->get()
                                                                                            : collect([]);
                                                                                    @endphp

                                                                                    @if ($attributes->count() > 0)
                                                                                        <td class="font-primary">
                                                                                            @foreach ($attributes as $attribute)
                                                                                                {{ $attribute->title }}
                                                                                                @if (!$loop->last)
                                                                                                    -
                                                                                                @endif
                                                                                            @endforeach
                                                                                        </td>
                                                                                    @else
                                                                                        <td>No Variation</td>
                                                                                    @endif

                                                                                    <td>{{ $order_quantity->quantity ?? 0 }}
                                                                                    <td>{{ $product->product_details->sale_price }}
                                                                                    </td>
                                                                                </tr>
                                                                            </tbody>
                                                                        @endforeach
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <p>No order available</p>
                                                        @endif
                                                    </div>
                                                </div>
                                                <hr>
                                            @endforeach
                                        @else
                                            <p>No order available</p>
                                        @endif


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- User Dashboard Section End -->
    @endsection

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let sidebar = document.querySelector(".dashboard-left-sidebar");
            let showMenuBtn = document.querySelector(".left-dashboard-show");
            let closeMenuBtn = document.querySelector(".close-sidebar");
            let sidebarLinks = document.querySelectorAll(".user-nav-pills .nav-link");

            // Show Sidebar
            if (showMenuBtn) {
                showMenuBtn.addEventListener("click", function() {
                    sidebar.classList.add("active");
                });
            }

            // Close Sidebar
            if (closeMenuBtn) {
                closeMenuBtn.addEventListener("click", function() {
                    sidebar.classList.remove("active");
                });
            }

            // Close Sidebar when clicking any sidebar link
            sidebarLinks.forEach(link => {
                link.addEventListener("click", function() {
                    sidebar.classList.remove("active");
                });
            });
        });
    </script>
