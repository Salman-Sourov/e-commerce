<nav class="sidebar">
    <div class="sidebar-header">
        <a href="{{ route('admin.home') }}" class="sidebar-brand">
            Bazar<span>BD</span>
        </a>
    </div>

    <div class="sidebar-body">
        <ul class="nav">
            <li class="nav-item nav-category">Main</li>
            <li class="nav-item">
                <a href="{{ route('admin.home') }}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Dashboard</span>
                </a>
            </li>
            <li class="nav-item nav-category">Bazar BD</li>

            {{-- Brands --}}
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#brand" role="button" aria-expanded="false"
                    aria-controls="brand">
                    <i class="link-icon" data-feather="home"></i>
                    <span class="link-title">Brands</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="brand">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('brand.index') }}" class="nav-link">All Brands</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('brand.create') }}" class="nav-link">Inactive Brands</a>
                        </li>
                    </ul>
                </div>
            </li>

            {{-- Category --}}
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#category" role="button" aria-expanded="false"
                    aria-controls="category">
                    <i class="link-icon" data-feather="home"></i>
                    <span class="link-title">Category</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="category">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('category.index') }}" class="nav-link">All Category</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('category.create') }}" class="nav-link">Inactive Category</a>
                        </li>
                    </ul>
                </div>
            </li>

            {{-- Sub Category --}}
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#subcategory" role="button" aria-expanded="false"
                    aria-controls="subcategory">
                    <i class="link-icon" data-feather="home"></i>
                    <span class="link-title">Sub Category</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="subcategory">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('sub-category.index') }}" class="nav-link">All Sub Category</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('sub-category.create') }}" class="nav-link">Inactive Sub Category</a>
                        </li>
                    </ul>
                </div>
            </li>

            {{-- Attribute Set --}}
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#attributeset" role="button" aria-expanded="false"
                    aria-controls="attributeset">
                    <i class="link-icon" data-feather="home"></i>
                    <span class="link-title">Attribute Set</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="attributeset">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('attribute-set.index') }}" class="nav-link">All Attribute Set</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('attribute-set.create') }}" class="nav-link">Inactive Attribute Set</a>
                        </li>
                    </ul>
                </div>
            </li>

            {{-- Attribute --}}
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#attribute" role="button" aria-expanded="false"
                    aria-controls="attribute">
                    <i class="link-icon" data-feather="home"></i>
                    <span class="link-title">Attribute</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="attribute">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('attribute.index') }}" class="nav-link">All Attribute</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('attribute.create') }}" class="nav-link">Inactive Attribute</a>
                        </li>
                    </ul>
                </div>
            </li>

            {{-- Product --}}
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#product" role="button" aria-expanded="false"
                    aria-controls="product">
                    <i class="link-icon" data-feather="home"></i>
                    <span class="link-title">Product</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="product"> <!-- Single collapse div -->
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('product.create') }}" class="nav-link">Add Product</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('product.index') }}" class="nav-link">All Product</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('inactive.product') }}" class="nav-link">Inactive Product</a>
                        </li>
                    </ul>
                </div>
            </li>

        </ul>
    </div>
</nav>
