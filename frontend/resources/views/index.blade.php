@extends('layouts.app')

@section('seo_title', config('app.name') . ' - Authentic Chennai Groceries & Sweets')
@section('seo_description', 'Shop for authentic Chennai groceries, traditional sweets, and snacks online at ' . config('app.name') . '. Quality products delivered to your doorstep.')
@section('og_title', config('app.name') . ' - Authentic Chennai Groceries')
@section('og_description', 'Fresh groceries and traditional Chennai treats delivered home.')
@section('content')
    @include('includes.alert')
    <main class="main">
        <style>
            /* Desktop Hero Banner ( > 768px ) */
            @media (min-width: 769px) {
                .home-slide-cover .container { 
                    max-width: 1600px !important; 
                    padding: 0 !important;
                }

                .home-slide-cover,
                .hero-slider-1 {
                    max-width: 1600px !important;
                    margin: 0 auto !important; /* Centered horizontally */
                    padding-bottom: 0 !important;
                    box-sizing: border-box !important;
                    display: block;
                }
                
                .hero-slider-1,
                .hero-slider-1 .slick-slide,
                .hero-slider-1 .slick-slide > div,
                .hero-slider-1 .single-hero-slider {
                    height: 290px !important;
                    box-sizing: border-box !important;
                }
                
                .hero-slider-1 .slick-list,
                .hero-slider-1 .slick-track {
                    box-sizing: border-box !important;
                    /* Allow slick JS to natively assign inline pixel-heights to track without !important crushing it */
                }
                
                .hero-slider-1 {
                    position: relative !important;
                }

                .hero-slider-1 .single-hero-slider {
                    margin: 0 !important;
                    overflow: hidden !important;
                    background: none !important;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }
                
                .hero-slider-1 .single-hero-slider img.hero-responsive-img {
                    width: 100%;
                    height: 290px !important;
                    object-fit: cover !important;
                    max-width: 100%;
                    display: block;
                }

                /* Dots placement inside banner in desktop */
                .dot-style-1 .slick-dots,
                .dot-style-1-position-1 .slick-dots {
                    bottom: 15px !important;
                    z-index: 20 !important;
                }

                .slider-center-arrow {
                    position: absolute !important;
                    top: 50% !important;
                    transform: translateY(-50%) !important;
                    z-index: 20 !important;
                    width: 40px !important;
                    height: 40px !important;
                    background: rgba(255, 255, 255, 0.8) !important;
                    border: 1.5px solid #3BB77E !important;
                    border-radius: 50% !important;
                    display: flex !important;
                    align-items: center !important;
                    justify-content: center !important;
                    color: #3BB77E !important;
                    cursor: pointer !important;
                    transition: all 0.3s ease !important;
                }
                
                .slider-center-arrow i {
                    font-size: 18px !important;
                    color: inherit !important;
                    line-height: 1 !important;
                    margin: 0 !important;
                    display: flex !important;
                    align-items: center !important;
                    justify-content: center !important;
                }

                .slider-center-arrow.slider-prev {
                    left: 20px !important; 
                }
                
                .slider-center-arrow.slider-next {
                    right: 20px !important;
                }

                .slider-center-arrow:hover {
                    background: #3BB77E !important;
                    color: #fff !important;
                }
            }

            /* Global styling for numeric dots */
            .hero-slider-1 .slick-dots {
                display: flex !important;
                justify-content: center !important;
                align-items: center !important;
                gap: 8px !important;
                list-style: none !important;
                padding: 0 !important;
                margin: 0 !important;
            }

            .hero-slider-1 .slick-dots li {
                width: auto !important;
                height: auto !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            .hero-slider-1 .slick-dots li .number-dot {
                width: 10px !important;
                height: 10px !important;
                border-radius: 50% !important;
                background-color: rgba(255, 255, 255, 0.7) !important;
                border: none !important;
                color: transparent !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                font-size: 0 !important;
                cursor: pointer !important;
                transition: all 0.3s ease !important;
            }

            .hero-slider-1 .slick-dots li.slick-active .number-dot {
                background-color: #3BB77E !important;
            }

            /* Hide default dot button texts */
            .hero-slider-1 .slick-dots li button {
                display: none !important;
            }

            /* Category Tabs Scrollable Styles */
            .category-tabs-wrapper {
                display: flex;
                align-items: center;
                gap: 10px;
                position: relative;
                max-width: 600px;
            }

            .category-tabs-container {
                overflow: hidden;
                flex: 1;
                max-width: 500px;
                position: relative;
            }

            .category-tabs-container #categoryTabs {
                display: flex;
                flex-wrap: nowrap;
                transition: transform 0.3s ease;
                white-space: nowrap;
                margin: 0;
                padding: 0;
                list-style: none;
            }

            .category-tabs-container #categoryTabs .nav-item {
                flex-shrink: 0;
            }

            .category-nav-arrow {
                width: 22px;
                height: 22px;
                border: 1.5px solid #3BB77E;
                background: #fff;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                transition: all 0.3s ease;
                color: #3BB77E;
                flex-shrink: 0;
                align-self: center;
                margin-top: 0 !important;
            }

            .category-nav-arrow:hover {
                background: #3BB77E;
                color: #fff;
            }

            .category-nav-arrow:disabled {
                opacity: 0.5;
                cursor: not-allowed;
            }

            .category-nav-arrow i {
                font-size: 10px;
                font-weight: bold;
                line-height: 1;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            @media (max-width: 768px) {
                .category-tabs-container {
                    max-width: calc(100% - 50px);
                }

                .category-nav-arrow {
                    width: 20px;
                    height: 20px;
                }

                .category-nav-arrow i {
                    font-size: 9px;
                }
            }

            /* 4-Column Product List Scroll Constraints (All columns, Left-Aligned Scroll) */
            .product-list-small {
                max-height: 345px !important; /* Fits exactly 3 items without scroll. Triggers scroll ONLY on 4+ items. */
                overflow-y: auto;
                overflow-x: hidden;
                padding-left: 10px; /* Space for left scrollbar */
                direction: rtl; /* Forces scrollbar to the left side */
            }
            .product-list-small > * {
                direction: ltr; /* Restores normal left-to-right reading direction */
                text-align: left;
            }

            /* Mobile Banner - Show full image without cropping */
            @media (max-width: 768px) {
                .home-slider { 
                    margin-bottom: 0 !important; 
                    padding-bottom: 0 !important;
                    height: auto !important;
                }
                .home-slide-cover { 
                    margin-top: 0 !important; 
                    margin-bottom: 0 !important; 
                    padding-bottom: 0 !important;
                    height: auto !important;
                }

                /* Strict 250px dimensions for Mobile Hero Slider */
                .home-slider .container {
                    padding-left: 0 !important;
                    padding-right: 0 !important;
                }
                .hero-slider-1 {
                    display: block;
                    position: relative !important;
                    height: auto !important;
                    margin-top: 11px !important;
                    margin-bottom: 0 !important;
                    padding-left: 11px !important;
                    padding-right: 11px !important;
                    padding-bottom: 0px !important; /* remove padding */
                    box-sizing: border-box !important;
                }

                /* Lock slick internals and apply border-box to override slick JS content-box */
                .hero-slider-1 .slick-slide,
                .hero-slider-1 .single-hero-slider {
                    box-sizing: border-box !important;
                }
                
                .hero-slider-1 .slick-list,
                .hero-slider-1 .slick-track {
                    box-sizing: border-box !important;
                    /* Do not force height auto important on the track so slick JS can calculate bounds properly */
                }
                
                .hero-slider-1 .slick-slide > div {
                    height: 250px !important;
                }

                /* Mobile hero slide element styles */
                .hero-slider-1 .single-hero-slider {
                    height: 250px !important;
                    overflow: hidden !important; /* Hide image overflow if any */
                    margin-bottom: 0 !important;
                    background: none !important;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    border-radius: 10px !important;
                }
                
                .hero-slider-1 .single-hero-slider img.hero-responsive-img {
                    width: 100%;
                    height: 250px !important;
                    object-fit: cover !important;
                    display: block;
                }

                /* Push dots inside the banner padding, remove bottom gap, size down to fit */
                .dot-style-1 .slick-dots,
                .dot-style-1-position-1 .slick-dots {
                    bottom: 15px !important;
                    height: 10px !important;
                    display: flex !important;
                    align-items: center !important;
                    justify-content: center !important;
                    z-index: 20 !important;
                }

                /* Hide arrows on mobile */
                .slider-center-arrow {
                    display: none !important;
                }

                /* Standard dots on mobile */
                .hero-slider-1 .slick-dots li {
                    margin: 0 !important;
                    width: auto !important;
                    height: auto !important;
                }
                .hero-slider-1 .slick-dots li .number-dot {
                    width: 8px !important;
                    height: 8px !important;
                    font-size: 0 !important; /* Hide number */
                    color: transparent !important;
                    background-color: rgba(255, 255, 255, 0.7) !important;
                    border: none !important;
                    border-radius: 50% !important;
                }
                .hero-slider-1 .slick-dots li.slick-active .number-dot {
                    background-color: #3BB77E !important;
                }

                /* Hide dots if only 1 slide exists */
                .hero-slider-1.single-slide .slick-dots {
                    display: none !important;
                }

                /* Our Products - vertically center arrows with tab text */
                .category-tabs-wrapper {
                    align-items: center !important;
                }

                .category-nav-arrow {
                    align-self: center !important;
                    margin-top: 0 !important;
                    flex-shrink: 0;
                }

                .category-tabs-container #categoryTabs .nav-item .nav-link {
                    display: flex;
                    align-items: center;
                    height: 100%;
                }
            }

        </style>
        <section class="home-slider position-relative mb-10">
            <div class="container">
                <div class="home-slide-cover mt-10">
                    <div class="hero-slider-1 style-4 dot-style-1 dot-style-1-position-1 {{ ($topSliders ?? collect([]))->count() <= 1 ? 'single-slide' : '' }}">
                        @if($topSliders->count() > 0)
                            @foreach($topSliders as $slider)
                                @php
                                    $topImg = $slider->image;
                                    $topImg = str_replace('\\', '/', $topImg);
                                    $topImg = str_replace('uploads/', '', $topImg);
                                    $topImg = ltrim($topImg, '/');
                                    $adminUrl = rtrim(config('app.admin_asset_url'), '/');
                                @endphp
                                <div class="single-hero-slider single-animation-wrap">
                                    <img src="{{ $adminUrl }}/{{ $topImg }}" class="hero-responsive-img" alt="Promotional Banner" loading="eager">
                                    <!-- <div class="slider-content">
                                        @if($slider->title_text)
                                            {!! $slider->title_text !!}
                                        @else
                                            <h1 class="display-2 mb-40">
                                                Authentic Chennai<br />
                                                Groceries & Sweets
                                            </h1>
                                            <p class="mb-65">Quality products delivered to your doorstep</p>
                                        @endif
                                        <form class="form-subcriber d-flex">
                                            <input type="email" placeholder="Your emaill address" />
                                            <button class="btn" type="submit">Subscribe</button>
                                        </form>
                                    </div> -->
                                </div>
                            @endforeach
                        @else
                            <!-- <div class="single-hero-slider single-animation-wrap"
                                style="background-image: url('{{ asset('assets/imgs/slider/slider-1.png') }}')">
                                <div class="slider-content">
                                    <h1 class="display-2 mb-40">
                                        Don’t miss amazing<br />
                                        grocery deals
                                    </h1>
                                    <p class="mb-65">Sign up for the daily newsletter</p>
                                    <form class="form-subcriber d-flex">
                                        <input type="email" placeholder="Your emaill address" />
                                        <button class="btn" type="submit">Subscribe</button>
                                    </form>
                                </div>
                            </div> -->
                        @endif
                    </div>
                    <div class="slider-arrow hero-slider-1-arrow"></div>
                </div>
            </div>
        </section>
        <!--End hero slider-->
        <!-- Featured Categories -->
        <section class="popular-categories pt-5 mt-2">
            <div class="container wow animate__animated animate__fadeIn">
                <div class="section-title">
                    <div class="title">
                        <h3>Featured Categories</h3>

                    </div>
                </div>

                @include('section.Category', ['categories' => $categories])
            </div>
        </section>
        <!-- End Featured Categories -->
        <!--End category slider-->
        <!-- <section class="banners mb-25">
            <div class="container">
                <div class="row">
                    @php
                        $middle1 = $middleSliders->where('sort_order', 1)->first() ?? $middleSliders->skip(0)->first();
                        $middle2 = $middleSliders->where('sort_order', 2)->first() ?? $middleSliders->skip(1)->first();
                        $middle3 = $middleSliders->where('sort_order', 3)->first() ?? $middleSliders->skip(2)->first();
                    @endphp

                    <div class="col-lg-4 col-md-6">
                        <div class="banner-img wow animate__animated animate__fadeInUp" data-wow-delay="0">
                            @if($middle1)
                                @php 
                                    $midImg1 = str_replace(['\\', 'uploads/'], ['/', ''], $middle1->image); 
                                    $midImg1 = ltrim($midImg1, '/');
                                    $adminUrl = rtrim(config('app.admin_asset_url'), '/');
                                @endphp
                                <img src="{{ $adminUrl }}/{{ $midImg1 }}" alt="" style="width: 100%; aspect-ratio: 768 / 450; object-fit: cover; display: block; border-radius: 10px;" />
                                <div class="banner-text">
                                    @if($middle1->title_text)
                                        {!! $middle1->title_text !!}
                                    @else
                                        <h4>Everyday Fresh & <br />Clean with Our<br />Products</h4>
                                    @endif
                                    <a href="{{ route('shop') }}" class="btn btn-xs">Shop Now <i class="fi-rs-arrow-small-right"></i></a>
                                </div>
                            @else
                                <img src="{{ asset('assets/imgs/banner/banner-1.png') }}" alt="" />
                                <div class="banner-text">
                                    <h4>Everyday Fresh & <br />Clean with Our<br />Products</h4>
                                    <a href="{{ route('shop') }}" class="btn btn-xs">Shop Now <i class="fi-rs-arrow-small-right"></i></a>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="banner-img wow animate__animated animate__fadeInUp" data-wow-delay=".2s">
                            @if($middle2)
                                @php 
                                    $midImg2 = str_replace(['\\', 'uploads/'], ['/', ''], $middle2->image); 
                                    $midImg2 = ltrim($midImg2, '/');
                                    $adminUrl = rtrim(config('app.admin_asset_url'), '/');
                                @endphp
                                <img src="{{ $adminUrl }}/{{ $midImg2 }}" alt="" style="width: 100%; aspect-ratio: 768 / 450; object-fit: cover; display: block; border-radius: 10px;" />
                                <div class="banner-text">
                                    @if($middle2->title_text)
                                        {!! $middle2->title_text !!}
                                    @else
                                        <h4>Make your Breakfast<br />Healthy and Easy</h4>
                                    @endif
                                    <a href="{{ route('shop') }}" class="btn btn-xs">Shop Now <i class="fi-rs-arrow-small-right"></i></a>
                                </div>
                            @else
                                <img src="{{ asset('assets/imgs/banner/banner-2.png') }}" alt="" />
                                <div class="banner-text">
                                    <h4>Make your Breakfast<br />Healthy and Easy</h4>
                                    <a href="{{ route('shop') }}" class="btn btn-xs">Shop Now <i class="fi-rs-arrow-small-right"></i></a>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-4 d-md-none d-lg-flex">
                        <div class="banner-img mb-sm-0 wow animate__animated animate__fadeInUp" data-wow-delay=".4s">
                            @if($middle3)
                                @php 
                                    $midImg3 = str_replace(['\\', 'uploads/'], ['/', ''], $middle3->image); 
                                    $midImg3 = ltrim($midImg3, '/');
                                    $adminUrl = rtrim(config('app.admin_asset_url'), '/');
                                @endphp
                                <img src="{{ $adminUrl }}/{{ $midImg3 }}" alt="" style="width: 100%; aspect-ratio: 768 / 450; object-fit: cover; display: block; border-radius: 10px;" />
                                <div class="banner-text">
                                    @if($middle3->title_text)
                                        {!! $middle3->title_text !!}
                                    @else
                                        <h4>The best Organic <br />Products Online</h4>
                                    @endif
                                    <a href="{{ route('shop') }}" class="btn btn-xs">Shop Now <i class="fi-rs-arrow-small-right"></i></a>
                                </div>
                            @else
                                <img src="{{ asset('assets/imgs/banner/banner-3.png') }}" alt="" />
                                <div class="banner-text">
                                    <h4>The best Organic <br />Products Online</h4>
                                    <a href="{{ route('shop') }}" class="btn btn-xs">Shop Now <i class="fi-rs-arrow-small-right"></i></a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section> -->
        <!--End banners-->
        <section class="product-tabs position-relative">
            <div class="container">
                <div class="section-title style-2 wow animate__animated animate__fadeIn">
                    <h3>Our Products</h3>
                    <div class="category-tabs-wrapper">
                        <button type="button" class="category-nav-arrow category-nav-left" id="categoryNavLeft"
                            aria-label="Previous categories" onclick="scrollCategoryTabs('left')" style="z-index: 10;">
                            <i class="fi-rs-angle-left"></i>
                        </button>
                        <div class="category-tabs-container" id="categoryTabsContainer">
                            <ul class="nav nav-tabs links" id="categoryTabs">
                                <li class="nav-item">
                                    <button class="nav-link active" data-slug="all">All</button>
                                </li>
                                @foreach($categories as $category)
                                    <li class="nav-item">
                                        <button class="nav-link"
                                            data-slug="{{ $category->slug }}">{{ $category->name }}</button>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <button type="button" class="category-nav-arrow category-nav-right" id="categoryNavRight"
                            aria-label="Next categories" onclick="scrollCategoryTabs('right')" style="z-index: 10;">
                            <i class="fi-rs-angle-right"></i>
                        </button>
                    </div>
                </div>
                <!--End nav-tabs-->
                <div class="tab-content" id="myTabContent">
                    <div id="productArea" class="row">
                        @include('section.products', ['products' => $products])
                    </div>
                </div>




                <!--End tab-content-->
            </div>
        </section>
        <!--Offer Products Tabs-->
        @php
            echo app(\App\Http\Controllers\Web\OfferProductController::class)->section()->render();
        @endphp


        <section class="pt-2">
            <div class="container">
                <div class="row">
                    {{-- ========== TOP SELLING (top_selling = 1) ========== --}}
                    <div class="col-xl-3 col-lg-4 col-md-6 mb-sm-5 mb-md-0 wow animate__animated animate__fadeInUp"
                        data-wow-delay="0">
                        <h4 class="section-title style-1 mb-10 animated animated">Top Selling</h4>
                        <div class="product-list-small">
                            @foreach($topSellingProducts as $product)
                                @include('section.product-list-item', ['product' => $product])
                            @endforeach
                        </div>
                    </div>

                    {{-- ========== TRENDING PRODUCTS (trending_product = 1) ========== --}}
                    <div class="col-xl-3 col-lg-4 col-md-6 mb-md-0 wow animate__animated animate__fadeInUp"
                        data-wow-delay=".1s">
                        <h4 class="section-title style-1 mb-10 animated animated">Trending Products</h4>
                        <div class="product-list-small">
                            @foreach($trendingProducts as $product)
                                @include('section.product-list-item', ['product' => $product])
                            @endforeach
                        </div>
                    </div>

                    {{-- ========== RECENTLY ADDED (latest created) ========== --}}
                    <div class="col-xl-3 col-lg-4 col-md-6 mb-sm-5 mb-md-0 d-none d-lg-block wow animate__animated animate__fadeInUp"
                        data-wow-delay=".2s">
                        <h4 class="section-title style-1 mb-10 animated animated">Recently added</h4>
                        <div class="product-list-small">
                            @foreach($recentlyAddedProducts as $product)
                                @include('section.product-list-item', ['product' => $product])
                            @endforeach
                        </div>
                    </div>

                    {{-- ========== HOT DEALS (hot_deal = 1) ========== --}}
                    <div class="col-xl-3 col-lg-4 col-md-6 mb-sm-5 mb-md-0 d-none d-xl-block wow animate__animated animate__fadeInUp"
                        data-wow-delay=".3s">
                        <h4 class="section-title style-1 mb-10">Hot Deals</h4>
                        <div class="product-list-small">
                            @foreach($hotDealProducts as $product)
                                @include('section.product-list-item', ['product' => $product])
                            @endforeach
                        </div>
                    </div>
                </div>
        </section>
        <!--End 4 columns-->
    </main>

    <script>
        // Global variables for category scroll
        var categoryScrollPosition = 0;
        var categoryScrollAmount = 150;

        // Global function for category tabs scrolling
        function scrollCategoryTabs(direction) {
            var categoryTabs = document.getElementById('categoryTabs');
            var tabsContainer = document.getElementById('categoryTabsContainer');
            var leftArrow = document.getElementById('categoryNavLeft');
            var rightArrow = document.getElementById('categoryNavRight');

            if (!categoryTabs || !tabsContainer) return;

            var maxScroll = categoryTabs.scrollWidth - tabsContainer.clientWidth;
            if (maxScroll < 0) maxScroll = 500;

            if (direction === 'left') {
                categoryScrollPosition = categoryScrollPosition - categoryScrollAmount;
                if (categoryScrollPosition < 0) categoryScrollPosition = 0;
            } else if (direction === 'right') {
                categoryScrollPosition = categoryScrollPosition + categoryScrollAmount;
                if (categoryScrollPosition > maxScroll) categoryScrollPosition = maxScroll;
            }

            categoryTabs.style.transform = 'translateX(-' + categoryScrollPosition + 'px)';

            // Update arrow opacity
            if (leftArrow) {
                leftArrow.style.opacity = categoryScrollPosition <= 0 ? '0.4' : '1';
            }
            if (rightArrow) {
                rightArrow.style.opacity = categoryScrollPosition >= maxScroll ? '0.4' : '1';
            }
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function () {
            var leftArrow = document.getElementById('categoryNavLeft');
            var rightArrow = document.getElementById('categoryNavRight');
            if (leftArrow) leftArrow.style.opacity = '0.4';
            if (rightArrow) rightArrow.style.opacity = '1';
        });
    </script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const categoryTabs  = document.querySelector('#categoryTabs');
            const productArea   = document.querySelector('#productArea');
            const baseFilterUrl = "{{ route('filter.products') }}";

            let currentSlug  = 'all';
            let isLoading    = false;
            let observer     = null;

            /* ── helpers ─────────────────────────────────────── */

            function showSpinner() {
                const el = document.createElement('div');
                el.id = 'infinite-loader';
                el.className = 'col-12 text-center py-3';
                el.innerHTML = '<div class="spinner-border text-success" role="status"><span class="visually-hidden">Loading…</span></div>';
                productArea.appendChild(el);
            }

            function removeSpinner() {
                const el = document.getElementById('infinite-loader');
                if (el) el.remove();
            }

            function setupPagination() {
                // intercept clicks on pagination links
                $(document).off('click', '.ajax-pagination-links a').on('click', '.ajax-pagination-links a', function(e) {
                    e.preventDefault();
                    let url = $(this).attr('href');
                    if (url) {
                        isLoading = true;
                        // showSpinner(); // User requested to remove loader
                        fetch(url, {
                            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'text/html' }
                        })
                        .then(r => r.text())
                        .then(html => {
                            // removeSpinner();
                            productArea.innerHTML = html;
                            isLoading = false;
                            
                            // Scroll back to the top of the products section smoothly
                            document.querySelector('.product-tabs').scrollIntoView({ behavior: 'smooth' });
                        })
                        .catch(() => { 
                            // removeSpinner(); 
                            isLoading = false; 
                        });
                    }
                });
            }



            /* ── fresh load (replaces entire product area) ─────── */

            function loadProducts(url) {
                isLoading = false;

                fetch(url, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'text/html' }
                })
                .then(r => {
                    if (!r.ok) throw new Error('HTTP ' + r.status);
                    return r.text();
                })
                .then(html => {
                    productArea.innerHTML = html;
                })
                .catch(() => {
                    productArea.innerHTML =
                        '<div class="col-12 text-center py-5"><div class="alert alert-danger d-inline-block"><p class="mb-0">Error loading products. Please try again.</p></div></div>';
                });
            }

            /* ── category tab clicks ─────────────────────────── */

            if (categoryTabs) {
                categoryTabs.addEventListener('click', function (e) {
                    const btn = e.target.closest('.nav-link');
                    if (!btn) return;
                    e.preventDefault();

                    categoryTabs.querySelectorAll('.nav-link').forEach(b => b.classList.remove('active'));
                    btn.classList.add('active');

                    currentSlug = btn.dataset.slug || 'all';
                    loadProducts(`${baseFilterUrl}/${currentSlug}?page=1`);
                });
            }

            /* ── setup pagination for the initial page load ────── */
            setupPagination();
        });
    </script>
@endsection