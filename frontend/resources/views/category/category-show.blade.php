@extends('layouts.app')

@section('seo_title', (isset($subcategory) ? $subcategory->name : $category->name) . ' - ' . config('app.name'))
@section('seo_description', (isset($subcategory) ? $subcategory->description : $category->description) ?? '')
@section('og_title', (isset($subcategory) ? $subcategory->name : $category->name) . ' - ' . config('app.name'))
@section('og_description', (isset($subcategory) ? $subcategory->description : $category->description) ?? '')
@section('content')

    <main class="main">
        <div class="page-header my-3">
            <div class="container">
                <div class="archive-header">
                    <div class="row align-items-center">
                        <div class="col-xl-12">
                            <h4 class="mb-2">{{ $category->name }}</h4>
                            <div class="breadcrumb">
                                <a href="{{ route('index') }}"><i class="fi-rs-home mr-5"></i>Home</a>
                                <span></span>
                                <a href="{{ route('shop') }}">Shop</a> <span></span> {{ $category->name }}
                            </div>
                        </div>

                        <!-- <div class="col-xl-9 text-end d-none d-xl-block">
                            <ul class="tags-list">

                                @foreach ($category->subcategories as $sub)
                                    <li class="hover-up">
                                        <a href="{{ route('subcategory.products', $sub->slug) }}">
                                            <i class="fi-rs-cross mr-10"></i>{{ $sub->name }}
                                        </a>
                                    </li>
                                @endforeach

                            </ul>
                        </div> -->

                    </div>
                </div>
            </div>
        </div>

       
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="shop-product-fillter">
                        <div class="totall-product">
                            <!-- <p>We found <strong class="text-brand">29</strong> items for you!</p> -->
                        </div>
                        <div class="sort-by-product-area">
                            <div class="sort-by-product-area">
                                <div class="sort-by-cover">
                                    <div class="sort-by-product-wrap">
                                        <div class="sort-by">
                                            <span><i class="fi-rs-apps-sort"></i>Sort by:</span>
                                        </div>
                                        <div class="sort-by-dropdown-wrap">
                                            <span>
                                                @if(request('sort') == 'low')
                                                    Price: Low to High
                                                @elseif(request('sort') == 'high')
                                                    Price: High to Low
                                                @else
                                                    Featured
                                                @endif
                                                <i class="fi-rs-angle-small-down"></i>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="sort-by-dropdown">
                                        <ul>
                                            <li><a href="?sort=featured">Featured</a></li>
                                            <li><a href="?sort=low">Price: Low to High</a></li>
                                            <li><a href="?sort=high">Price: High to Low</a></li>

                                        </ul>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    @if(isset($subcategory))
                        <!-- <h4 class="mb-15">{{ $subcategory->name }}</h4> -->
                    @else
                        <!-- <h4 class="mb-15">{{ $category->name }}</h4> -->
                    @endif
                    <div class="row product-grid" id="infinite-scroll-grid">
                        @include('section.product-cards', ['products' => $products])
                    </div>
                    
                    <!-- Loading Spinner & End Message -->
                    <div id="infinite-scroll-loader" class="text-center" style="display: none; padding: 20px;">
                        <div class="spinner-border text-success" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                    <div id="infinite-scroll-end" class="text-center" style="display: none; padding: 20px; color: #777;">
                        <p>No More Products Available</p>
                    </div>

                    <!--product grid-->
                    


                    <!--End Deals-->
                </div>
                <!-- <div class="col-lg-1-5 primary-sidebar sticky-sidebar">
                    <div class="sidebar-widget widget-category-2 mb-30">
                        <h5 class="section-title style-1 mb-30">Category</h5>
                        <div class="category-scroll">
                            <ul>
                                @foreach($categories as $cat)
                                    <li>
                                        <a href="{{ route('category.products', $cat->slug) }}">
                                            <img src="{{ env('ADMIN_ASSET_URL') }}/maincategory/{{ basename($cat->image) }}"
                                                alt="{{ $cat->name }}" style="width: 30px; height: 30px; object-fit: cover;" />
                                            {{ $cat->name }}
                                        </a>
                                        
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                    </div>


                </div> -->
            </div>
        </div>
    </main>



    <!-- add to cart -->
    <script>
        /**
         * ADD TO CART & VARIANT CHANGE HANDLER
         * Wait for DOM and jQuery to be ready
         */
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof $ === 'undefined' && typeof jQuery !== 'undefined') {
                var $ = jQuery;
            }

            if (typeof $ !== 'undefined') {
                // Handle variant dropdown changes - dynamic price update
                $(document).on('change', '[class*="variant-dropdown-"]', function () {
                    const productId = $(this).data('product-id');
                    const selectedOption = $(this).find('option:selected');

                    const displayPrice = selectedOption.data('price');
                    const mrpPrice = selectedOption.data('mrp-price');
                    const sellPrice = selectedOption.data('sell-price');
                    const hasOffer = selectedOption.data('has-offer') === 1;
                    const stockValue = parseInt(selectedOption.data('stock')) || 0;

                    // Update sell price display
                    $(`.product-sell-price-${productId}`).text('₹' + Math.round(displayPrice).toLocaleString());

                    // Update MRP strike-through price
                    const mrpElement = $(`.product-mrp-display-${productId}`);
                    const mrpVal = parseFloat(mrpPrice);
                    const displayVal = parseFloat(displayPrice);

                    if (mrpVal && mrpVal > displayVal) {
                        mrpElement.text('₹' + Math.round(mrpVal).toLocaleString());
                        mrpElement.css('display', 'inline');
                    } else {
                        mrpElement.css('display', 'none');
                    }

                    // Update add to cart button data and state
                    const addToCartBtn = $(`.add-to-cart-btn-${productId}`);
                    addToCartBtn.data('price', displayPrice);
                    addToCartBtn.data('variant-id', selectedOption.data('variant-id'));
                    addToCartBtn.data('stock', stockValue);

                    // Enable/disable button based on stock
                    const productCard = $(`.product-card-${productId}`);
                    const productAction = productCard.find('.product-action-1');
                    const productQty = productCard.find(`.product-qty-${productId}`);
                    const btnContainer = productCard.find('.add-cart');

                    if (stockValue <= 0) {
                        productCard.addClass('product-out-of-stock');
                        productAction.attr('style', 'display: none !important;');
                        productQty.prop('disabled', true);
                        btnContainer.attr('style', 'display: none !important;');
                        $(`.variant-dropdown-${productId}`).prop('disabled', true);
                        
                        // Add out of stock badge if not present
                        let badgeContainer = productCard.find('.product-badges');
                        if (badgeContainer.length === 0) {
                            productCard.find('.product-img-action-wrap').append('<div class="product-badges product-badges-position product-badges-mrg"><span class="hot" style="background-color: #dc3545;">OUT OF STOCK</span></div>');
                        } else {
                            badgeContainer.show();
                            badgeContainer.find('.hot').text('OUT OF STOCK').css('background-color', '#dc3545');
                        }
                        
                        addToCartBtn.css({
                            'opacity': '0.5',
                            'cursor': 'not-allowed',
                            'pointer-events': 'none',
                            'color': '#fff',
                            'background-color': '#dc3545',
                            'border-color': '#dc3545'
                        });
                        addToCartBtn.html('<i class="fi-rs-shopping-cart mr-5"></i>OUT OF STOCK');
                    } else {
                        productCard.removeClass('product-out-of-stock');
                        productAction.attr('style', 'display: flex !important;');
                        productQty.prop('disabled', false);
                        btnContainer.attr('style', 'display: block !important;');
                        
                        // Hide out of stock badge
                        const badgeContainer = productCard.find('.product-badges');
                        if (badgeContainer.length > 0) {
                            badgeContainer.hide();
                        }
                        
                        addToCartBtn.css({
                            'opacity': '1',
                            'cursor': 'pointer',
                            'pointer-events': 'auto',
                            'color': '',
                            'background-color': '',
                            'border-color': ''
                        });
                        addToCartBtn.html('<i class="fi-rs-shopping-cart mr-5"></i>ADD');
                        $(`.variant-dropdown-${productId}`).prop('disabled', false);
                    }
                });

                // Handle add to cart button clicks
                $(document).on('click', '[class*="add-to-cart-btn-"]', function (e) {
                    e.preventDefault();

                    // Check stock before proceeding
                    const stockValue = parseInt($(this).data('stock')) || 0;
                    if (stockValue <= 0) {
                        if (typeof toastr !== 'undefined') {
                            toastr.error('This product is out of stock', 'Error');
                        }
                        return false;
                    }

                    const productId = $(this).data('product-id');
                    const variantDropdown = $(`.variant-dropdown-${productId}`);
                    const qtyInput = $(`.product-qty-${productId}`);

                    let variantId = null;
                    let unitPrice = $(this).data('price');
                    let quantity = qtyInput.length > 0 ? parseInt(qtyInput.val()) || 1 : 1;

                    // If product has variants, get selected variant
                    if (variantDropdown.length > 0) {
                        const selectedOption = variantDropdown.find('option:selected');
                        variantId = selectedOption.data('variant-id');
                        unitPrice = selectedOption.data('price');
                    }

                    const csrfToken = "{{ csrf_token() }}";

                    // Get selected_weight (gram value) from variant dropdown
                    let selectedWeight = null;
                    const catVarDropdown = $(`.variant-dropdown-${productId}`);
                    if (catVarDropdown.length > 0) {
                        selectedWeight = catVarDropdown.find('option:selected').data('label') || null;
                    }

                    const requestData = {
                        _token: csrfToken,
                        product_id: productId,
                        selected_quantity: quantity,
                        unit_price: unitPrice
                    };

                    if (variantId) {
                        requestData.variant_id = variantId;
                    }
                    if (selectedWeight) {
                        requestData.selected_weight = selectedWeight;
                    }

                    $.ajax({
                        url: '{{ route("add-to-cart") }}',
                        type: 'POST',
                        data: requestData,
                        success: function (response) {
                            if (response.success) {
                                toastr.success(response.message);
                                $('#header-cart-count').text(response.cartCount);
                                $('#bottom-header-cart-count').text(response.cartCount);
                                $('#mobile-cart-count').text(response.cartCount);
                            } else {
                                toastr.error(response.message);
                            }
                        },
                        error: function (xhr) {
                            let errorMsg = 'Something went wrong!';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMsg = xhr.responseJSON.message;
                            }
                            toastr.error(errorMsg);
                        }
                    });
                });
            }
        });
    </script>



    <style>
        /* Center product price on all screen sizes */
        .product-cart-wrap .product-price,
        .product-cart-wrap .product-card-bottom .product-price {
            text-align: center !important;
        }

        /* Product Action Icons - Centered on Image */
        .product-img-action-wrap {
            position: relative;
        }

        .product-img-action-wrap .product-action-1 {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            display: flex;
            flex-direction: row;
            gap: 5px;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 10;
        }

        .product-img-action-wrap:hover .product-action-1 {
            opacity: 1;
            visibility: visible;
        }

        .product-img-action-wrap .product-action-1 .action-btn {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 40px !important;
            height: 40px !important;
            line-height: 40px !important;
            text-align: center !important;
            background: #fff;
            border: 1px solid #e5e5e5;
            border-radius: 4px;
            color: #333;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .product-img-action-wrap .product-action-1 .action-btn:hover {
            background: #3BB77E;
            border-color: #3BB77E;
            color: #fff;
        }

        .product-img-action-wrap .product-action-1 .action-btn.active,
        .product-img-action-wrap .product-action-1 .action-btn.active i {
            color: #ff0000 !important;
        }

        .product-img-action-wrap .product-action-1 .action-btn i {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 100% !important;
            height: 100% !important;
            font-size: 16px !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .category-scroll {
            height: 300px;
            /* fixed height for scroll to appear */
            overflow-y: auto;
            /* vertical scroll */
            overflow-x: hidden;
            /* hide horizontal scroll if any */
            border: 1px solid #ddd;
            /* optional: just to see the container */
            padding-right: 5px;
            /* space for scrollbar */
        }


        .category-scroll::-webkit-scrollbar {
            width: 6px;
        }

        .category-scroll::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .category-scroll::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 3px;
        }

        .category-scroll::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        /* Sort dropdown styles */
        .sort-by-cover {
            position: relative;
            cursor: pointer;
        }

        .sort-by-dropdown {
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            z-index: 999;
            min-width: 180px;
        }

        .sort-by-dropdown.show {
            display: block;
        }

        .sort-by-dropdown ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sort-by-dropdown ul li a {
            display: block;
            padding: 10px 15px;
            color: #333;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .sort-by-dropdown ul li a:hover {
            background: #f5f5f5;
            color: #3BB77E;
        }

        .sort-by-product-wrap {
            cursor: pointer;
        }

        /* Mobile Overlay box perfect square override */
        @media (max-width: 768px) {
            .product-img-action-wrap .product-action-1,
            .product-cart-wrap .product-img-action-wrap .product-action-1,
            .product-action-1 {
                display: flex !important;
                visibility: visible !important;
                opacity: 1 !important;
                position: absolute !important;
                top: 50% !important;
                left: 50% !important;
                transform: translate(-50%, -50%) !important;
                background: transparent !important;
                border: none !important;
                box-shadow: none !important;
                gap: 0 !important;
                width: auto !important;
                max-width: none !important;
                min-width: 0 !important;
                height: auto !important;
                overflow: visible !important;
                z-index: 99 !important;
            }

            .product-action-1 .action-btn,
            .product-img-action-wrap .product-action-1 .action-btn {
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                width: 32px !important;
                height: 32px !important;
                background: #fff !important;
                border: 1px solid #BCE3C9 !important;
                border-radius: 5px !important;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08) !important;
                padding: 0 !important;
                margin: 0 !important;
                pointer-events: auto !important;
                cursor: pointer !important;
            }

            .product-action-1 .action-btn i,
            .product-img-action-wrap .product-action-1 .action-btn i {
                font-size: 15px !important;
                color: #3BB77E !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            .product-action-1 .action-btn.active i,
            .product-action-1 .action-btn.active {
                color: #ff0000 !important;
            }

            .product-action-1 .quick-view-btn,
            .product-img-action-wrap .product-action-1 .quick-view-btn {
                display: none !important;
            }
        }

        /* Mobile View (≤575px) compact wish button */
        @media (max-width: 575px) {
            .product-action-1 .action-btn,
            .product-img-action-wrap .product-action-1 .action-btn {
                width: 28px !important;
                height: 28px !important;
                border-radius: 4px !important;
            }

            .product-action-1 .action-btn i,
            .product-img-action-wrap .product-action-1 .action-btn i {
                font-size: 12px !important;
                line-height: 28px !important;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Sort dropdown toggle functionality
            const sortByWrap = document.querySelector('.sort-by-product-wrap');
            const sortDropdown = document.querySelector('.sort-by-dropdown');

            if (sortByWrap && sortDropdown) {
                // Toggle dropdown on click
                sortByWrap.addEventListener('click', function (e) {
                    e.stopPropagation();
                    sortDropdown.classList.toggle('show');
                });

                // Close dropdown when clicking outside
                document.addEventListener('click', function (e) {
                    if (!sortByWrap.contains(e.target) && !sortDropdown.contains(e.target)) {
                        sortDropdown.classList.remove('show');
                    }
                });

                // Handle sort option clicks
                sortDropdown.querySelectorAll('a').forEach(function (link) {
                    link.addEventListener('click', function (e) {
                        // Allow the default anchor behavior to navigate to the sort URL
                        sortDropdown.classList.remove('show');
                    });
                });
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let currentPage = 1;
            let isLoading = false;
            let hasMoreProducts = true;
            
            function handleScroll() {
                // If currently fetching, or no more products, or near bottom - don't fire or fetch
                if (isLoading || !hasMoreProducts) return;
                
                // When scroll is near the bottom of the page (offset 200px)
                if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight - 200) {
                    isLoading = true;
                    currentPage++;
                    
                    // Show spinner
                    document.getElementById('infinite-scroll-loader').style.display = 'block';
                    
                    // Keep current url parameters (e.g. ?sort=low) and add page
                    let fetchUrl = new URL(window.location.href);
                    fetchUrl.searchParams.set('page', currentPage);
                    
                    fetch(fetchUrl, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('infinite-scroll-loader').style.display = 'none';
                        
                        if (data.html) {
                            // Append the partial containing the newly fetched products
                            document.getElementById('infinite-scroll-grid').insertAdjacentHTML('beforeend', data.html);
                        }
                        
                        hasMoreProducts = data.hasMore;
                        
                        // If no more products, show end message
                        if (!hasMoreProducts) {
                            document.getElementById('infinite-scroll-end').style.display = 'block';
                        }
                        
                        isLoading = false;
                    })
                    .catch(error => {
                        console.error('Error fetching products:', error);
                        document.getElementById('infinite-scroll-loader').style.display = 'none';
                        isLoading = false;
                    });
                }
            }

            // Attach scroll event
            window.addEventListener('scroll', handleScroll);
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.3.2/lazysizes.min.js" async></script>
@endsection