@extends('layouts.app')

@section('seo_title', config('app.name') . ' - Authentic Chennai Groceries & Sweets')
@section('seo_description', 'Shop for authentic Chennai groceries, traditional sweets, and snacks online at ' . config('app.name') . '. Quality products delivered to your doorstep.')
@section('og_title', config('app.name') . ' - Authentic Chennai Groceries')
@section('og_description', 'Fresh groceries and traditional Chennai treats delivered home.')
@section('content')
    @include('includes.alert')
    <main class="main">
        <style>
            .top-rating-scroll {
                max-height: 350px;
                overflow-y: auto;
                overflow-x: hidden;
                /* <-- IMPORTANT */
                padding-right: 5px;
                direction: rtl;
            }

            .top-rating-scroll>* {
                direction: ltr;
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
                width: 35px;
                height: 35px;
                border: 1px solid #3BB77E;
                background: #fff;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                transition: all 0.3s ease;
                color: #3BB77E;
                flex-shrink: 0;
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
                font-size: 14px;
            }

            @media (max-width: 768px) {
                .category-tabs-container {
                    max-width: calc(100% - 70px);
                }

                .category-nav-arrow {
                    width: 30px;
                    height: 30px;
                }

                .category-nav-arrow i {
                    font-size: 12px;
                }
            }

        </style>
        <section class="home-slider position-relative mb-10">
            <div class="container">
                <div class="home-slide-cover mt-10">
                    <div class="hero-slider-1 style-4 dot-style-1 dot-style-1-position-1">
                        @if($topSliders->count() > 0)
                            @foreach($topSliders as $slider)
                                @php
                                    $topImg = $slider->image;
                                    $topImg = str_replace('\\', '/', $topImg);
                                    $topImg = str_replace('uploads/', '', $topImg);
                                    $topImg = ltrim($topImg, '/');
                                    $adminUrl = rtrim(config('app.admin_asset_url'), '/');
                                @endphp
                                <div class="single-hero-slider single-animation-wrap"
                                    style="background-image: url('{{ $adminUrl }}/{{ $topImg }}'); background-size: cover; background-position: center;">
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
        <section class="popular-categories pt-5">
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
                        <div class="product-list-small animated animated">
                            @foreach($topSellingProducts as $product)
                                @include('section.product-list-item', ['product' => $product])
                            @endforeach
                        </div>
                    </div>

                    {{-- ========== TRENDING PRODUCTS (trending_product = 1) ========== --}}
                    <div class="col-xl-3 col-lg-4 col-md-6 mb-md-0 wow animate__animated animate__fadeInUp"
                        data-wow-delay=".1s">
                        <h4 class="section-title style-1 mb-10 animated animated">Trending Products</h4>
                        <div class="product-list-small animated animated">
                            @foreach($trendingProducts as $product)
                                @include('section.product-list-item', ['product' => $product])
                            @endforeach
                        </div>
                    </div>

                    {{-- ========== RECENTLY ADDED (latest created) ========== --}}
                    <div class="col-xl-3 col-lg-4 col-md-6 mb-sm-5 mb-md-0 d-none d-lg-block wow animate__animated animate__fadeInUp"
                        data-wow-delay=".2s">
                        <h4 class="section-title style-1 mb-10 animated animated">Recently added</h4>
                        <div class="product-list-small animated animated">
                            @foreach($recentlyAddedProducts as $product)
                                @include('section.product-list-item', ['product' => $product])
                            @endforeach
                        </div>
                    </div>

                    {{-- ========== HOT DEALS (hot_deal = 1) ========== --}}
                    <div class="col-xl-3 col-lg-4 col-md-6 mb-sm-5 mb-md-0 d-none d-xl-block wow animate__animated animate__fadeInUp"
                        data-wow-delay=".3s">
                        <h4 class="section-title style-1 mb-10">Hot Deals</h4>
                        <div class="top-rating-scroll">
                            <div class="product-list-small">
                                @foreach($hotDealProducts as $product)
                                    @include('section.product-list-item', ['product' => $product])
                                @endforeach
                            </div>
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
        document.addEventListener('DOMContentLoaded', function() {
            const categoryTabs = document.querySelector('#categoryTabs');
            const productArea = document.querySelector('#productArea');
            const baseFilterUrl = "{{ route('filter.products') }}";
            let currentSlug = 'all';

            function loadProducts(url) {
                // Load products instantly without spinner placeholder
                fetch(url, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'text/html'
                    }
                })
                .then(response => {
                    if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                    return response.text();
                })
                .then(html => {
                    productArea.innerHTML = html;
                })
                .catch(error => {
                    console.error('Error:', error);
                    productArea.innerHTML = `
                        <div class="col-12 text-center py-5">
                            <div class="alert alert-danger d-inline-block">
                                <p class="mb-0">Error loading products. Please try again.</p>
                            </div>
                        </div>
                    `;
                });
            }

            // Category Tabs Clicks
            if (categoryTabs) {
                categoryTabs.addEventListener('click', function(e) {
                    const btn = e.target.closest('.nav-link');
                    if (!btn) return;
                    e.preventDefault();

                    // Update active tab styling
                    categoryTabs.querySelectorAll('.nav-link').forEach(b => b.classList.remove('active'));
                    btn.classList.add('active');

                    // Get category slug
                    currentSlug = btn.dataset.slug || 'all';

                    // Build AJAX URL
                    const url = `${baseFilterUrl}/${currentSlug}?page=1`;
                    loadProducts(url);
                });
            }

            // Intercept Pagination Clicks inside #productArea using Event Delegation
            if (productArea) {
                productArea.addEventListener('click', function(e) {
                    const paginationLink = e.target.closest('.pagination-ajax-link');
                    if (!paginationLink) return;
                    e.preventDefault();

                    const url = paginationLink.getAttribute('href');
                    if (!url) return;

                    // Load new page
                    loadProducts(url);

                    // Smooth scroll back to top of the products area
                    const tabsSection = document.querySelector('.product-tabs');
                    if (tabsSection) {
                        tabsSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                });
            }
        });
    </script>
@endsection