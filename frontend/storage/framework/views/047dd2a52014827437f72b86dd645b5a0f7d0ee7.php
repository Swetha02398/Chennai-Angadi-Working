<header class="header-area header-style-1 header-height-2">
    <!-- <div class="mobile-promotion">
        <span>Grand opening, <strong>up to 15%</strong> off all items. Only <strong>3 days</strong> left</span>
    </div> -->
    <div class="header-top header-top-ptb-1 d-none d-lg-block">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <!-- Left Side: Phone Number -->
                <div class="col-auto">
                    <div class="header-info">
                        <ul>
                            <li>Welcome to chennaiangadi</li>
                        </ul>
                    </div>
                </div>
                <!-- Right Side: Navigation Links -->
                <div class="col-auto">
                    <div class="header-info header-info-right">
                        <ul>
                            <!-- <li><a href="<?php echo e(route('pages.about')); ?>">About Us</a></li> -->
                            <li><a href="<?php echo e(route('customer.wishlist')); ?>">My Wishlist</a></li>
                            <li><a href="<?php echo e(route('order.track')); ?>">Order Tracking</a></li>
                            <?php if(Auth::guard('customer')->check()): ?>
                                <li class="header-account-dropdown">
                                    <a href="<?php echo e(route('customer.myAccount')); ?>" class="header-account-toggle" 
                                       style="display: flex; flex-direction: row; align-items: center; justify-content: center; line-height: 1; padding: 0 5px; position: relative; gap: 6px;">
                                        <?php
                                            $user = Auth::guard('customer')->user();
                                            $profileImagePath = public_path('uploads/profile/' . $user->profile_image);
                                        ?>
                                        <?php if(!empty($user->profile_image) && file_exists($profileImagePath)): ?>
                                            <img src="<?php echo e(asset('uploads/profile/' . $user->profile_image)); ?>" 
                                                 alt="Profile" 
                                                 style="width: 26px; height: 26px; border-radius: 50%; object-fit: cover; border: 1.5px solid #3BB77E; margin-bottom: 0;">
                                        <?php else: ?>
                                            <i class="fi-rs-user" style="font-size: 16px; color: #3BB77E; margin-bottom: 0;"></i>
                                        <?php endif; ?>
                                        <span class="username-text" style="font-size: 11px; font-weight: 700; color: #253D4E; text-transform: capitalize;"><?php echo e($user->username); ?></span>
                                    </a>
                                    <div class="header-account-menu">
                                        <ul>
                                            <li>
                                                <a href="<?php echo e(route('customer.myAccount')); ?>?tab=account-detail&edit=1">
                                                    <i class="fi-rs-user"></i> Account Details
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo e(route('customer.myAccount')); ?>?tab=orders">
                                                    <i class="fi-rs-shopping-bag"></i> Orders
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo e(route('logout')); ?>">
                                                    <i class="fi-rs-sign-out"></i> Logout
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            <?php else: ?>
                                <li><a href="javascript:void(0);" onclick="openLoginModal()">Sign In</a></li>
                            <?php endif; ?>
                        </ul>
                        <style>
                            /* Account Dropdown - Hover Based */
                            .header-top {
                                padding-top: 5px !important;
                                padding-bottom: 5px !important;
                            }
                            .header-account-dropdown {
                                position: relative !important;
                            }
                            .header-account-toggle {
                                cursor: pointer;
                            }
                            .header-account-menu {
                                position: absolute;
                                top: calc(100% + 10px);
                                right: 0;
                                min-width: 190px;
                                background: #fff;
                                border-radius: 6px;
                                box-shadow: 0 5px 20px rgba(0, 0, 0, 0.12);
                                border: 1px solid #f0f0f0;
                                padding: 8px 0;
                                opacity: 0;
                                visibility: hidden;
                                transform: translateY(8px);
                                transition: all 0.25s ease;
                                z-index: 9999;
                            }
                            .header-account-dropdown:hover .header-account-menu {
                                opacity: 1;
                                visibility: visible;
                                transform: translateY(0);
                            }
                            .header-account-menu ul {
                                list-style: none;
                                margin: 0;
                                padding: 0;
                            }
                            .header-account-menu ul li {
                                margin: 0;
                                padding: 0;
                            }
                            .header-account-menu ul li a {
                                display: flex;
                                align-items: center;
                                gap: 10px;
                                padding: 10px 20px;
                                font-size: 13px;
                                font-weight: 500;
                                color: #253D4E;
                                text-decoration: none;
                                transition: background 0.2s ease, color 0.2s ease;
                                white-space: nowrap;
                                background: none !important;
                                background-image: none !important;
                                padding-right: 20px !important;
                            }
                            .header-account-menu ul li a::after,
                            .header-account-menu ul li a::before {
                                display: none !important;
                                content: none !important;
                            }
                            .header-account-menu ul li a:hover {
                                background: #f0faf4 !important;
                                color: #3BB77E;
                            }
                            .header-account-menu ul li a i {
                                font-size: 14px;
                                width: 18px;
                                text-align: center;
                                color: #7E7E7E;
                                display: inline-block !important;
                                visibility: visible !important;
                            }
                            .header-account-menu ul li a:hover i {
                                color: #3BB77E;
                            }
                            .header-account-menu ul li:last-child a {
                                border-top: 1px solid #f0f0f0;
                            }
                        </style>
                    </div>
                </div>
                <!-- <div class="col-xl-6 col-lg-4">
                    <div class="text-center">
                        <div id="news-flash" class="d-inline-block">
                                <ul>
                                    <li>100% Secure delivery without contacting the courier</li>
                                    <li>Supper Value Deals - Save more with coupons</li>
                                    <li>Trendy 25silver jewelry, save up 35% off today</li>
                                </ul>
                            </div>
                    </div>
                </div> -->
                <!-- <div class="col-xl-3 col-lg-4">
                    <div class="header-info header-info-right">
                        <ul>
                            <li><strong class="text-brand"> +91 90946 76665</strong></li>

                        </ul>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
    <div class="header-middle header-middle-ptb-1 d-none d-lg-block">
        <div class="container">
            <div class="header-wrap">
                <div class="logo logo-width-1 pt-1">
                    <a href="<?php echo e(url('/')); ?>"><img src="<?php echo e(asset('assets/imgs/images/chennai-angadi-logo.svg')); ?>"
                            alt="logo" /></a>
                </div>
                <div class="header-right">
                    <div class="search-style-2">
                        <form action="<?php echo e(route('search')); ?>" method="GET" id="header-search-form">
                            <select class="select-active" name="category" id="search-category">
                                <option value="">All Categories</option>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($cat->id); ?>" <?php echo e(request('category') == $cat->id ? 'selected' : ''); ?>>
                                        <?php echo e($cat->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>

                            <input type="text" name="q" id="search-input" placeholder="Search for items..."
                                value="<?php echo e(request('q')); ?>" autocomplete="off" />

                            <!-- Live Search Suggestions Dropdown -->
                            <div id="search-suggestions" class="search-suggestions-dropdown" style="display: none;">
                            </div>
                        </form>
                    </div>
                    <div class="header-action-right">
                        <div class="header-action-2">
                            <div class="hotline" style="display: flex; align-items: center;">
                        <img src="<?php echo e(asset('assets/imgs/images/free-delivery.svg')); ?>" alt="Free Delivery" style="width:40px;"/>
                        <div class="col-auto m-0 p-0 flex-row">
                            <p class="m-0 p-0 fs-6">Free Delivery*</p>
                            <span>On Orders above ₹500 |TN</span>
                        </div>
                    </div>

                            <!-- <div class="header-action-icon-2">
                                <a href="<?php if(Auth::guard('customer')->check()): ?><?php echo e(route('customer.wishlist')); ?><?php else: ?><?php echo e(route('login')); ?><?php endif; ?>"
                                    class="wishlist-link">
                                    <i class="fi-rs-heart"></i>
                                    <span class="pro-count blue" id="wishlist-count">
                                        <?php echo e(auth('customer')->check() ? auth('customer')->user()->wishlist()->count() : 0); ?>

                                    </span>
                                </a>
                                <a href="<?php if(Auth::guard('customer')->check()): ?><?php echo e(route('customer.wishlist')); ?><?php else: ?><?php echo e(route('login')); ?><?php endif; ?>"
                                    class="wishlist-link"><span class="lable ml-0">Wishlist</span></a>
                            </div> -->
                            <!-- <div class="header-action-icon-2">
                                <a class="mini-cart-icon" href="<?php echo e(route('cart.page')); ?>">
                                    <img alt="Nest" src="<?php echo e(asset('assets/imgs/theme/icons/icon-cart.svg')); ?>" />
                                    <span class="pro-count blue"
                                        id="header-cart-count"><?php echo e(Auth::guard('customer')->check() ? \App\Models\Cart::where('customer_id', Auth::guard('customer')->id())->count() : count(session()->get('guest_cart', []))); ?></span>
                                </a>
                                <a href="<?php echo e(route('cart.page')); ?>"><span class="lable">Cart</span></a>
                            </div> -->
                            <!-- <div class="header-action-icon-2">
                                <a href="page-account.html">
                                    <img class="svgInject" alt="Nest"
                                        src="<?php echo e(asset('assets/imgs/theme/icons/icon-user.svg')); ?>" />
                                </a>
                                <a href="<?php echo e(route('customer.myAccount')); ?>"><span class="lable ml-0">Account</span></a>
                                <div class="cart-dropdown-wrap cart-dropdown-hm2 account-dropdown">
                                    <ul>
                                        <li>
                                            <a href="<?php echo e(route('customer.myAccount')); ?>"><i
                                                    class="fi fi-rs-user mr-10"></i>My Account</a>
                                        </li>
                                        <li>
                                            <a href="page-account.html"><i class="fi fi-rs-location-alt mr-10"></i>Order
                                                Tracking</a>
                                        </li>
                                        <li>
                                            <a href="page-account.html"><i class="fi fi-rs-label mr-10"></i>My
                                                Voucher</a>
                                        </li>
                                        <li>
                                            <a href="shop-wishlist.html"><i class="fi fi-rs-heart mr-10"></i>My
                                                Wishlist</a>
                                        </li>
                                        <li>
                                            <a href="page-account.html"><i
                                                    class="fi fi-rs-settings-sliders mr-10"></i>Setting</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo e(route('logout')); ?>"><i class="fi fi-rs-sign-out mr-10"></i>Sign
                                                out</a>
                                        </li>
                                    </ul>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-bottom header-bottom-bg-color sticky-bar">
        <div class="container">
            <div class="header-wrap header-space-between position-relative">
                <div class="logo logo-width-1 d-block d-lg-none">
                    <a href="<?php echo e(url('/')); ?>"><img src="<?php echo e(asset('assets/imgs/images/ChennaiAngadiLogo.png')); ?>"
                            alt="Chennai Angadi logo" /></a>
                </div>
                <div class="header-nav d-none d-lg-flex">
                    <div class="main-categori-wrap d-none d-lg-block">
                        <a class="categories-button-active" href="#">
                            <span class="d-flex align-items-center">
                                <span class="fi-rs-apps mr-5"></span>
                                <span class="et">Browse</span>&nbsp;All Categories
                            </span>
                            <i class="fi-rs-angle-down"></i>
                        </a>

                        <div class="categories-dropdown-wrap categories-dropdown-active-large font-heading catfly-wrap">
                            <div class="catfly-container">
                                
                                <ul class="catfly-left">
                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li class="catfly-item" data-cat-id="<?php echo e($cat->id); ?>">
                                            <a href="<?php echo e(route('category.products', $cat->id)); ?>">
                                                <?php
                                                    $mainImage = str_replace('uploads/', '', $cat->image);
                                                ?>
                                                <img src="<?php echo e(config('app.admin_asset_url')); ?>/<?php echo e($mainImage); ?>"
                                                    alt="<?php echo e($cat->name); ?>" class="catfly-img" />
                                                <span><?php echo e($cat->name); ?></span>
                                                <?php if($cat->subcategories->count() > 0): ?>
                                                    <i class="fi-rs-angle-right catfly-arrow"></i>
                                                <?php endif; ?>
                                            </a>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                                
                                <div class="catfly-right">
                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($cat->subcategories->count() > 0): ?>
                                            <div class="catfly-sub-panel" data-cat-id="<?php echo e($cat->id); ?>">
                                                <ul class="catfly-sub-list">
                                                    <?php $__currentLoopData = $cat->subcategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <li class="catfly-sub-item">
                                                            <a href="<?php echo e(route('subcategory.products', $sub->id)); ?>">
                                                                <?php if($sub->subimage): ?>
                                                                    <?php
                                                                        $subImage = str_replace('uploads/', '', $sub->subimage);
                                                                    ?>
                                                                    <img src="<?php echo e(config('app.admin_asset_url')); ?>/<?php echo e($subImage); ?>" alt="<?php echo e($sub->name); ?>"
                                                                        class="catfly-menu-img">
                                                                <?php endif; ?>
                                                                <span><?php echo e($sub->name); ?></span>
                                                                <?php if($sub->childCategories->count() > 0): ?>
                                                                    <i class="fi-rs-angle-right catfly-arrow"></i>
                                                                <?php endif; ?>
                                                            </a>
                                                            <?php if($sub->childCategories->count() > 0): ?>
                                                                <ul class="catfly-child">
                                                                    <?php $__currentLoopData = $sub->childCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <li>
                                                                            <a href="<?php echo e(route('subcategory.products', $sub->id)); ?>">
                                                                                <?php if($child->childimage): ?>
                                                                                    <?php
                                                                                        $childImage = str_replace('uploads/', '', $child->childimage);
                                                                                    ?>
                                                                                    <img src="<?php echo e(config('app.admin_asset_url')); ?>/<?php echo e($childImage); ?>"
                                                                                        alt="<?php echo e($child->name); ?>" class="catfly-menu-img">
                                                                                <?php endif; ?>
                                                                                <?php echo e($child->name); ?>

                                                                            </a>
                                                                        </li>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </ul>
                                                            <?php endif; ?>
                                                        </li>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </ul>
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="main-menu main-menu-padding-1 main-menu-lh-2 d-none d-lg-block font-heading">
                        <nav>
                            <ul>

                                <li>
                                    <a class="<?php echo e(request()->routeIs('index') || request()->routeIs('home') || request()->is('/') ? 'active' : ''); ?>"
                                        href="<?php echo e(url('/')); ?>">Home </a>
                                </li>
                                <li>
                                    <a class="<?php echo e(request()->routeIs('pages.about') ? 'active' : ''); ?>"
                                        href="<?php echo e(route('pages.about')); ?>">About</a>
                                </li>
                                <li>
                                    <a class="<?php echo e(request()->routeIs('shop') ? 'active' : ''); ?>"
                                        href="<?php echo e(route('shop')); ?>">Shop</a>
                                </li>

                                <!-- <li class="position-static mega-parent">
                                    <a class="<?php echo e(request()->routeIs('category.products') || request()->routeIs('subcategory.products') ? 'active' : ''); ?>"
                                        href="#">Mega menu <i class="fi-rs-angle-down"></i></a>

                                    <ul class="mega-menu horizontal-scroll">
                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li class="sub-mega-menu block-item">
                                                <a class="menu-title" href="<?php echo e(route('category.products', $cat->id)); ?>">
                                                    <?php echo e($cat->name); ?>

                                                </a>

                                                <ul class="mega-scroll">
                                                    <?php $__currentLoopData = $cat->subcategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <li><a
                                                                href="<?php echo e(route('subcategory.products', $sub->id)); ?>"><?php echo e($sub->name); ?></a>
                                                        </li>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </ul>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </li> -->

                                <li>
                                    <a class="<?php echo e(request()->routeIs('pages.offer') ? 'active' : ''); ?>"
                                        href="<?php echo e(route('pages.offer')); ?>">Offer</a>
                                </li>

                                <li>
                                    <a class="<?php echo e(request()->routeIs('pages.contact') ? 'active' : ''); ?>"
                                        href="<?php echo e(route('pages.contact')); ?>">Contact</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="header-right-group d-none d-lg-flex" style="display: flex; align-items: center; gap: 15px;">
                    <div class="header-action-icon-2 bottom-cart-icon" style="display: flex; align-items: center;">
                        <a class="mini-cart-icon" href="<?php echo e(route('checkout-order')); ?>">
                            <img alt="Cart" src="<?php echo e(asset('assets/imgs/theme/icons/icon-cart.svg')); ?>" />
                            <span class="pro-count blue"
                                id="bottom-header-cart-count"><?php echo e(Auth::guard('customer')->check() ? \App\Models\Cart::where('customer_id', Auth::guard('customer')->id())->count() : count(session()->get('guest_cart', []))); ?></span>
                        </a>
                        <a href="<?php echo e(route('checkout-order')); ?>"><span class="lable ms-2"> Cart</span></a>
                    </div>
                    <div class="hotline" style="display: flex; align-items: center;">
                        <img src="<?php echo e(asset('assets/imgs/theme/icons/icon-headphone.svg')); ?>" alt="hotline" />
                        <div class="col-auto m-0 p-0 flex-row">
                            <p class="m-0 p-0">90946 76665</p>
                            <span>10AM - 7PM, Mon - Sat</span>
                        </div>
                    </div>
                </div>
                <div class="header-action-icon-2 d-block d-lg-none">
                    <div class="burger-icon burger-icon-white">
                        <span class="burger-icon-top"></span>
                        <span class="burger-icon-mid"></span>
                        <span class="burger-icon-bottom"></span>
                    </div>
                </div>
                <div class="header-action-right mobile-header-icons mobile-only-icons">
                    <div class="header-action-2">
                        <!-- Mobile Search Icon -->
                        <div class="header-action-icon-2 mobile-search-toggle-icon">
                            <a href="javascript:void(0);" id="mobile-header-search-toggle">
                                <i class="fi-rs-search" style="font-size: 20px; color: #253D4E;"></i>
                            </a>
                        </div>

                        <div class="header-action-icon-2">
                            <a class="mini-cart-icon" href="<?php echo e(route('checkout-order')); ?>">
                                <img alt="Cart" src="<?php echo e(asset('assets/imgs/theme/icons/icon-cart.svg')); ?>" />
                                <span class="pro-count blue"
                                    id="mobile-cart-count"><?php echo e(Auth::guard('customer')->check() ? \App\Models\Cart::where('customer_id', Auth::guard('customer')->id())->count() : count(session()->get('guest_cart', []))); ?></span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Mobile Header Search Bar (hidden by default) -->
                <div id="mobile-header-search-bar" style="display: none; position: absolute; top: 100%; left: 0; right: 0; z-index: 9999; background: #fff; box-shadow: 0 5px 20px rgba(0,0,0,0.15); padding: 10px 15px;">
                    <form action="<?php echo e(route('search')); ?>" method="GET" id="mobile-header-search-form" style="position: relative;">
                        <div style="display: flex; align-items: center; border: 2px solid #3BB77E; border-radius: 8px; overflow: hidden;">
                            <input type="text" name="q" id="mobile-header-search-input" placeholder="Search for items..."
                                value="<?php echo e(request('q')); ?>" autocomplete="off"
                                style="flex: 1; border: none; outline: none; padding: 10px 15px; font-size: 14px;" />
                            <button type="submit" style="background: #3BB77E; border: none; padding: 10px 15px; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                                <i class="fi-rs-search" style="color: #fff; font-size: 16px;"></i>
                            </button>
                        </div>
                        <!-- Live Search Suggestions -->
                        <div id="mobile-header-search-suggestions" class="search-suggestions-dropdown" style="display: none;"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</header>

<style>


    /* 🔒 FIX: Prevent stray zoomContainer from overlapping header/logo */
    /* elevateZoom appends .zoomContainer directly to <body>, not inside header */
    body > .zoomContainer {
        display: none !important;
        pointer-events: none !important;
        width: 0 !important;
        height: 0 !important;
        opacity: 0 !important;
    }

    /* � FIX: Remove arrow icons from header top navigation links */
    .header-info-right ul li a::after,
    .header-info-right ul li a::before,
    .header-info-right ul li::after {
        display: none !important;
        content: none !important;
        background: none !important;
        background-image: none !important;
    }

    .header-info-right ul li a {
        background: none !important;
        background-image: none !important;
        padding-right: 0 !important;
    }



    /* �🔴 MOBILE-ONLY ICONS - Hide on desktop, show on mobile */

    /* Hide on desktop (992px and above) */
    .mobile-only-icons {
        display: none !important;
    }

    /* Show on mobile only (below 992px) */
    @media (max-width: 991px) {
        /* Fix header layout: Burger Left, Logo Center, Icons Right */
        .header-bottom .header-wrap.header-space-between {
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            flex-wrap: nowrap !important;
            width: 100% !important;
            padding: 10px 0 !important;
        }

        .header-action-icon-2.d-block.d-lg-none {
            order: 1 !important; /* Burger menu on left */
        }
        
        .logo.logo-width-1.d-block.d-lg-none {
            order: 2 !important;
            width: 130px !important; /* Make sure the logo spans nicely */
            max-width: 45% !important;
            margin: 0 auto !important;
            text-align: center !important;
        }

        .logo.logo-width-1.d-block.d-lg-none img {
            width: 100% !important;
            height: auto !important;
            object-fit: contain !important;
            display: inline-block !important;
        }

        .mobile-only-icons {
            order: 3 !important; /* Icons on right */
            display: flex !important;
            align-items: center;
        }

        .mobile-only-icons .header-action-2 {
            display: flex !important;
            align-items: center;
            gap: 15px; /* Ensure space between icons */
        }

        .mobile-only-icons .header-action-icon-2 {
            display: flex !important;
            align-items: center;
            padding: 0 !important;
            position: relative;
        }

        .mobile-only-icons .header-action-icon-2 a {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .mobile-only-icons .header-action-icon-2 img {
            width: 26px !important;
            max-width: 26px !important;
            height: auto !important;
        }

        .mobile-only-icons .pro-count {
            position: absolute !important;
            top: -6px !important;
            right: -10px !important;
            background-color: #3BB77E !important;
            color: #fff !important;
            font-size: 11px !important;
            font-weight: 600 !important;
            height: 18px !important;
            width: 18px !important;
            line-height: 18px !important;
            border-radius: 50% !important;
            text-align: center !important;
            display: inline-block !important;
            box-shadow: 0 1px 3px rgba(0,0,0,0.15) !important;
        }
    }

    /* Desktop wishlist icon */
    .header-action-icon-2 i.fi-rs-heart {
        font-size: 20px !important;
        display: inline-block !important;
        visibility: visible !important;
    }

    /* 🟩 MAIN: Mega menu horizontal scroll */
    ul.mega-menu {
        display: flex !important;
        flex-wrap: nowrap !important;
        overflow-x: auto !important;
        /* SCROLLBAR visible */
        overflow-y: hidden !important;
        white-space: nowrap;
        gap: 25px;
        max-width: 100%;
        padding: 15px 10px;
        scroll-behavior: smooth;
    }

    /* 🟦 each category block width */
    ul.mega-menu>li {
        min-width: 240px !important;
        max-width: 240px !important;
        display: inline-block;
    }

    /* 🟧 SCROLLBAR STYLE */
    ul.mega-menu::-webkit-scrollbar {
        height: 10px;
    }

    ul.mega-menu::-webkit-scrollbar-thumb {
        background: #bbb;
        border-radius: 5px;
    }

    ul.mega-menu::-webkit-scrollbar-thumb:hover {
        background: #888;
    }

    /* 🟥 HEADER parents MUST NOT hide overflow */
    .header-bottom,
    .header-wrap,
    .main-menu,
    .position-static,
    .mega-parent {
        overflow: visible !important;
    }

    /* 🟪 Some templates hide mega menu: override that */
    .mega-menu,
    .mega-menu * {
        position: relative;
    }

    /* 🔍 SEARCH SUGGESTIONS DROPDOWN */
    .search-style-2 {
        position: relative;
    }

    .search-suggestions-dropdown {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: #fff;
        border: 1px solid #ddd;
        border-top: none;
        border-radius: 0 0 10px 10px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        z-index: 9999;
        max-height: 400px;
        overflow-y: auto;
    }

    .suggestion-item {
        display: flex;
        align-items: center;
        padding: 12px 15px;
        border-bottom: 1px solid #f0f0f0;
        cursor: pointer;
        transition: background 0.2s ease;
    }

    .suggestion-item:last-child {
        border-bottom: none;
    }

    .suggestion-item:hover {
        background: #f8f9fa;
    }

    .suggestion-item img {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 6px;
        margin-right: 12px;
        border: 1px solid #eee;
    }

    .suggestion-item .suggestion-info {
        flex: 1;
    }

    .suggestion-item .suggestion-name {
        font-size: 14px;
        font-weight: 600;
        color: #253D4E;
        display: block;
        margin-bottom: 3px;
    }

    .suggestion-item .suggestion-category {
        font-size: 12px;
        color: #7E7E7E;
    }

    .suggestion-item .suggestion-arrow {
        color: #ccc;
        font-size: 12px;
    }

    .search-no-results {
        padding: 20px 15px;
        text-align: center;
        color: #888;
    }

    .search-view-all {
        display: block;
        padding: 15px;
        text-align: center;
        background: #f8f9fa;
        color: #3BB77E;
        font-weight: 600;
        border-radius: 0 0 10px 10px;
        transition: background 0.2s ease;
    }

    .search-view-all:hover {
        background: #3BB77E;
        color: #fff;
    }

    /* Bottom header cart icon badge */
    .bottom-cart-icon {
        position: relative;
        align-items: center;
    }

    .bottom-cart-icon .mini-cart-icon {
        position: relative;
        display: inline-block;
    }

    .bottom-cart-icon .pro-count {
        position: absolute !important;
        top: -7px !important;
        right: -10px !important;
        background-color: #3BB77E !important;
        color: #fff !important;
        font-size: 12px !important;
        height: 20px !important;
        width: 20px !important;
        line-height: 20px !important;
        border-radius: 50% !important;
        text-align: center !important;
        display: inline-block !important;
    }

    /* ========== CATEGORY MENU (Side-by-Side with JS Hover) ========== */

    /* Dropdown wrap — starts narrow, expands when right panel is visible */
    .catfly-wrap {
        padding: 0 !important;
        min-width: 270px !important;
        width: auto !important;
        max-width: 600px !important;
        border-radius: 0 0 10px 10px !important;
        overflow: visible !important;
    }

    /* Flex container: left + right side-by-side */
    .catfly-container {
        display: flex !important;
    }

    /* LEFT: scrollable main categories */
    .catfly-left {
        list-style: none !important;
        margin: 0 !important;
        padding: 8px 0 !important;
        min-width: 260px !important;
        width: 260px !important;
        max-height: 420px !important;
        overflow-y: auto !important;
        border-right: 1px solid #ececec;
    }

    .catfly-left::-webkit-scrollbar {
        width: 4px;
    }

    .catfly-left::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 3px;
    }

    /* Reset template's .categories-dropdown-wrap ul li styles */
    .catfly-wrap .catfly-left>.catfly-item,
    .catfly-wrap .catfly-sub-list>.catfly-sub-item,
    .catfly-wrap .catfly-child>li {
        display: block !important;
        border: none !important;
        border-radius: 0 !important;
        padding: 0 !important;
        margin: 0 !important;
        height: auto !important;
        line-height: normal !important;
    }

    /* Unified category link style (Main, Sub, Child) */
    .catfly-item > a,
    .catfly-sub-item > a,
    .catfly-child li a {
        display: flex !important;
        align-items: center !important;
        padding: 9px 15px !important;
        color: #253D4E !important;
        font-size: 13px !important;
        font-weight: 500 !important;
        text-decoration: none !important;
        transition: background 0.15s ease, color 0.15s ease !important;
        line-height: 1.4 !important;
    }

    /* Unified Hover/Active style */
    .catfly-item:hover > a,
    .catfly-item.active > a,
    .catfly-sub-item:hover > a,
    .catfly-child li a:hover {
        background: #e8f5ee !important;
        color: #3BB77E !important;
    }

    /* Arrow color on hover */
    .catfly-item:hover > a .catfly-arrow,
    .catfly-item.active > a .catfly-arrow,
    .catfly-sub-item:hover > a .catfly-arrow {
        color: #3BB77E !important;
    }

    /* Unified image style for all category levels */
    .catfly-img,
    .catfly-menu-img {
        width: 28px !important;
        height: 28px !important;
        object-fit: cover !important;
        margin-right: 10px !important;
        border-radius: 4px !important;
    }

    .catfly-arrow {
        margin-left: auto !important;
        font-size: 10px !important;
        color: #aaa !important;
        transition: color 0.15s ease !important;
    }

    /* RIGHT: subcategory panels area - hidden by default */
    .catfly-right {
        display: none;
        position: absolute; /* Take out of flow to prevent wrapper expansion */
        top: 0;
        left: 260px; /* Attach next to left panel (width of .catfly-left) */
        width: auto;
        min-width: 150px;
        background: transparent;
        border: none;
        box-shadow: none;
        margin-left: 10px;
        overflow: visible !important;
        z-index: 999;
    }

    .catfly-right.active {
        display: block;
    }

    .catfly-right::-webkit-scrollbar {
        width: 4px;
    }

    .catfly-right::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 3px;
    }

    /* Each subcategory panel — hidden by default */
    .catfly-sub-panel {
        display: none !important;
        background: #fff;
        border: 1px solid #ececec;
        border-radius: 8px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        padding: 10px 0;
        min-width: 230px;
    }

    .catfly-sub-panel.active {
        display: block !important;
    }

    /* Subcategory list */
    .catfly-sub-list {
        list-style: none !important;
        margin: 0 !important;
        padding: 0 !important;
    }


    .catfly-sub-item {
        position: relative !important;
    }



    /* Child categories flyout (from subcategory) */
    .catfly-child {
        position: absolute !important;
        top: 0 !important;
        left: 100% !important;
        min-width: 210px !important;
        background: #fff !important;
        border: 1px solid #ececec !important;
        border-radius: 8px !important;
        box-shadow: 4px 4px 15px rgba(0, 0, 0, 0.08) !important;
        list-style: none !important;
        margin: 0 !important;
        padding: 8px 0 !important;
        z-index: 10000 !important;
        display: none !important;
        max-height: 350px;
        overflow-y: auto;
    }

    .catfly-sub-item:hover>.catfly-child {
        display: block !important;
    }



    .catfly-child::-webkit-scrollbar {
        width: 4px;
    }

    .catfly-child::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 3px;
    }



    /* Ensure parent containers don't clip */
    .main-categori-wrap {
        position: relative;
        overflow: visible !important;
        width: 270px !important;
    }

    .main-categori-wrap > a.categories-button-active {
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        width: 100% !important;
    }

    .categories-dropdown-wrap.catfly-wrap {
        overflow: visible !important;
    }

    /* 🟩 Force Browse Categories Dropdown to show OVER banner when clicked/active */
    .main-categori-wrap .categories-dropdown-active-large {
        display: block !important;
        opacity: 0 !important;
        visibility: hidden !important;
        position: fixed !important;
        z-index: 999999 !important;
        transition: opacity 0.25s ease-in-out, visibility 0.25s ease-in-out !important;
        pointer-events: none !important;
    }

    .main-categori-wrap .categories-dropdown-active-large.open {
        opacity: 1 !important;
        visibility: visible !important;
        display: block !important;
        pointer-events: auto !important;
    }

    /* Remove right-side scrollbar from catfly-right panel */
    .catfly-right {
        overflow: visible !important;
        overflow-y: visible !important;
    }
    .catfly-right::-webkit-scrollbar {
        display: none !important;
        width: 0 !important;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var mainItems = document.querySelectorAll('.catfly-item');
        var subPanels = document.querySelectorAll('.catfly-sub-panel');
        var rightPanel = document.querySelector('.catfly-right');

        mainItems.forEach(function (item) {
            item.addEventListener('mouseenter', function () {
                var catId = this.getAttribute('data-cat-id');

                // Highlight active main category
                mainItems.forEach(function (mi) { mi.classList.remove('active'); });
                this.classList.add('active');

                // Hide all sub panels
                subPanels.forEach(function (p) { p.classList.remove('active'); });

                // Show matching sub panel
                var target = document.querySelector('.catfly-sub-panel[data-cat-id="' + catId + '"]');
                if (target && rightPanel) {
                    rightPanel.classList.add('active');
                    target.classList.add('active');

                    // Calculate vertical position relative to container
                    var containerRect = document.querySelector('.catfly-container').getBoundingClientRect();
                    var itemRect = this.getBoundingClientRect();
                    var topOffset = itemRect.top - containerRect.top;
                    
                    if (topOffset < 0) topOffset = 0; 
                    
                    // Use 'top' with absolute positioning
                    rightPanel.style.top = topOffset + 'px';
                } else if (rightPanel) {
                    rightPanel.classList.remove('active');
                    rightPanel.style.top = '0px';
                }
            });
        });

        // Hide right panel when mouse leaves the entire menu
        var wrap = document.querySelector('.catfly-wrap');
        if (wrap) {
            wrap.addEventListener('mouseleave', function () {
                mainItems.forEach(function (mi) { mi.classList.remove('active'); });
                subPanels.forEach(function (p) { p.classList.remove('active'); });
                if (rightPanel) rightPanel.classList.remove('active');
            });
        }
    });
</script>

<script>
    // Position the fixed dropdown correctly below the categories button
    document.addEventListener('DOMContentLoaded', function () {
        var catBtn = document.querySelector('.categories-button-active');
        var dropdown = document.querySelector('.categories-dropdown-active-large');

        function positionDropdown() {
            if (!catBtn || !dropdown) return;
            var rect = catBtn.getBoundingClientRect();
            dropdown.style.top = (rect.bottom + 2) + 'px';
            dropdown.style.left = rect.left + 'px';
        }

        // Reposition on open
        if (catBtn) {
            catBtn.addEventListener('click', function () {
                positionDropdown();
            });
        }

        // Reposition on scroll/resize (when sticky)
        window.addEventListener('scroll', function () {
            if (dropdown && dropdown.classList.contains('open')) {
                positionDropdown();
            }
        });
        window.addEventListener('resize', function () {
            if (dropdown && dropdown.classList.contains('open')) {
                positionDropdown();
            }
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function (e) {
            if (!catBtn || !dropdown) return;
            if (!catBtn.contains(e.target) && !dropdown.contains(e.target)) {
                catBtn.classList.remove('open');
                dropdown.classList.remove('open');
            }
        });
    });
</script>


<!-- 🔍 LIVE SEARCH JAVASCRIPT -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('search-input');
        const searchSuggestions = document.getElementById('search-suggestions');
        const searchForm = document.getElementById('header-search-form');
        const categorySelect = document.getElementById('search-category');

        // 🔥 CATEGORY DROPDOWN CLICK - Redirect to category page when selected
        // Use both native and Select2 events for maximum compatibility
        if (categorySelect) {
            // Native change event (backup)
            categorySelect.addEventListener('change', function () {
                const categoryId = this.value;
                if (categoryId && categoryId !== '') {
                    window.location.href = '<?php echo e(url("/category")); ?>/' + categoryId;
                }
            });
        }

        // Also bind using jQuery/Select2 AFTER page fully loads
        // This runs after Select2 initializes in main.js
        if (typeof jQuery !== 'undefined') {
            jQuery(document).ready(function ($) {
                // Wait a bit for Select2 to fully initialize
                setTimeout(function () {
                    var $catSelect = $('#search-category');
                    if ($catSelect.length) {
                        // Bind to Select2's select event
                        $catSelect.on('select2:select', function (e) {
                            var categoryId = e.params.data.id;
                            if (categoryId && categoryId !== '') {
                                window.location.href = '<?php echo e(url("/category")); ?>/' + categoryId;
                            }
                        });

                        // Also bind to regular change event (via jQuery)
                        $catSelect.on('change', function () {
                            var categoryId = $(this).val();
                            if (categoryId && categoryId !== '') {
                                window.location.href = '<?php echo e(url("/category")); ?>/' + categoryId;
                            }
                        });
                    }
                }, 500); // Small delay for Select2 init
            });
        }

        if (!searchInput || !searchSuggestions) return;

        let debounceTimer;
        let currentQuery = '';

        // Handle input typing
        searchInput.addEventListener('input', function () {
            const query = this.value.trim();
            currentQuery = query;

            // Clear previous timer
            clearTimeout(debounceTimer);

            // Hide suggestions if query is too short
            if (query.length < 2) {
                hideSuggestions();
                return;
            }

            // Debounce the search (wait 300ms after user stops typing)
            debounceTimer = setTimeout(function () {
                fetchSuggestions(query);
            }, 300);
        });

        // Handle focus
        searchInput.addEventListener('focus', function () {
            if (currentQuery.length >= 2) {
                fetchSuggestions(currentQuery);
            }
        });

        // Handle click outside to close dropdown
        document.addEventListener('click', function (e) {
            if (!searchInput.contains(e.target) && !searchSuggestions.contains(e.target)) {
                hideSuggestions();
            }
        });

        // Handle Enter key - redirect to full search results page
        searchInput.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                const query = this.value.trim();
                if (query.length >= 2) {
                    hideSuggestions();
                    // Allow form to submit naturally to search results page
                } else {
                    e.preventDefault(); // Prevent submission if query too short
                }
            }
        });

        // Form submission - redirect to search results page
        // (Let the form submit naturally via action="<?php echo e(route('search')); ?>")

        // Fetch suggestions via AJAX
        function fetchSuggestions(query) {
            const categoryId = categorySelect ? categorySelect.value : '';
            const url = '<?php echo e(route("search.suggestions")); ?>?q=' + encodeURIComponent(query);

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        showSuggestions(data, query);
                    } else {
                        showNoResults(query);
                    }
                })
                .catch(error => {
                    console.error('Search error:', error);
                    hideSuggestions();
                });
        }

        // Show suggestions dropdown
        function showSuggestions(products, query) {
            let html = '';

            products.forEach(product => {
                // Highlight matching text
                const highlightedName = highlightMatch(product.name, query);

                html += `
                <a href="${product.url}" class="suggestion-item">
                    <img src="${product.image}" alt="${product.name}" 
                         onerror="this.src='<?php echo e(asset('assets/imgs/images/default-product.png')); ?>'" />
                    <div class="suggestion-info">
                        <span class="suggestion-name">${highlightedName}</span>
                        <span class="suggestion-category">${product.category}</span>
                    </div>
                    <span class="suggestion-arrow"><i class="fi-rs-angle-right"></i></span>
                </a>
            `;
            });

            // Add "View all results" link to redirect to full search page
            const searchUrl = '<?php echo e(route("search")); ?>?q=' + encodeURIComponent(query);
            html += `
            <a href="${searchUrl}" class="search-view-all" style="display: block; padding: 12px 15px; text-align: center; background: #f8f9fa; color: #3BB77E; font-weight: 600; text-decoration: none; border-radius: 0 0 10px 10px; transition: background 0.2s;">
                View all ${products.length} result${products.length > 1 ? 's' : ''} for "${query}" →
            </a>
        `;

            searchSuggestions.innerHTML = html;
            searchSuggestions.style.display = 'block';
        }

        // Show no results message
        function showNoResults(query) {
            searchSuggestions.innerHTML = `
            <div class="search-no-results">
                <p>No products found for "<strong>${query}</strong>"</p>
                <small>Try different keywords or browse categories</small>
            </div>
        `;
            searchSuggestions.style.display = 'block';
        }

        // Hide suggestions dropdown
        function hideSuggestions() {
            searchSuggestions.style.display = 'none';
        }

        // Highlight matching text in product name
        function highlightMatch(text, query) {
            const regex = new RegExp('(' + escapeRegex(query) + ')', 'gi');
            return text.replace(regex, '<mark style="background:#fff3cd;padding:0 2px;border-radius:2px;">$1</mark>');
        }

        // Escape special regex characters
        function escapeRegex(string) {
            return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
        }
    });
</script>

<!-- 🔍 MOBILE HEADER SEARCH JAVASCRIPT -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const mobileSearchToggle = document.getElementById('mobile-header-search-toggle');
        const mobileSearchBar = document.getElementById('mobile-header-search-bar');
        const mobileSearchInput = document.getElementById('mobile-header-search-input');
        const mobileSearchSuggestions = document.getElementById('mobile-header-search-suggestions');

        if (!mobileSearchToggle || !mobileSearchBar || !mobileSearchInput) return;

        // Toggle search bar visibility
        mobileSearchToggle.addEventListener('click', function (e) {
            e.preventDefault();
            if (mobileSearchBar.style.display === 'none' || mobileSearchBar.style.display === '') {
                mobileSearchBar.style.display = 'block';
                mobileSearchInput.focus();
            } else {
                mobileSearchBar.style.display = 'none';
                if (mobileSearchSuggestions) mobileSearchSuggestions.style.display = 'none';
            }
        });

        // Close search bar when clicking outside
        document.addEventListener('click', function (e) {
            if (!mobileSearchBar.contains(e.target) && !mobileSearchToggle.contains(e.target)) {
                mobileSearchBar.style.display = 'none';
                if (mobileSearchSuggestions) mobileSearchSuggestions.style.display = 'none';
            }
        });

        // Live search logic
        let mobileDebounceTimer;
        let mobileCurrentQuery = '';

        mobileSearchInput.addEventListener('input', function () {
            const query = this.value.trim();
            mobileCurrentQuery = query;
            clearTimeout(mobileDebounceTimer);

            if (query.length < 2) {
                mobileHideSuggestions();
                return;
            }

            mobileDebounceTimer = setTimeout(function () {
                mobileFetchSuggestions(query);
            }, 300);
        });

        mobileSearchInput.addEventListener('focus', function () {
            if (mobileCurrentQuery.length >= 2) {
                mobileFetchSuggestions(mobileCurrentQuery);
            }
        });

        mobileSearchInput.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                const query = this.value.trim();
                if (query.length >= 2) {
                    mobileHideSuggestions();
                } else {
                    e.preventDefault();
                }
            }
        });

        function mobileFetchSuggestions(query) {
            const url = '<?php echo e(route("search.suggestions")); ?>?q=' + encodeURIComponent(query);

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        mobileShowSuggestions(data, query);
                    } else {
                        mobileShowNoResults(query);
                    }
                })
                .catch(error => {
                    console.error('Mobile search error:', error);
                    mobileHideSuggestions();
                });
        }

        function mobileShowSuggestions(products, query) {
            let html = '';
            products.forEach(product => {
                const highlightedName = mobileHighlightMatch(product.name, query);
                html += `
                <a href="${product.url}" class="suggestion-item">
                    <img src="${product.image}" alt="${product.name}"
                         onerror="this.src='<?php echo e(asset('assets/imgs/images/default-product.png')); ?>'" />
                    <div class="suggestion-info">
                        <span class="suggestion-name">${highlightedName}</span>
                        <span class="suggestion-category">${product.category}</span>
                    </div>
                    <span class="suggestion-arrow"><i class="fi-rs-angle-right"></i></span>
                </a>
                `;
            });

            const searchUrl = '<?php echo e(route("search")); ?>?q=' + encodeURIComponent(query);
            html += `
            <a href="${searchUrl}" class="search-view-all" style="display: block; padding: 12px 15px; text-align: center; background: #f8f9fa; color: #3BB77E; font-weight: 600; text-decoration: none; border-radius: 0 0 10px 10px; transition: background 0.2s;">
                View all ${products.length} result${products.length > 1 ? 's' : ''} for "${query}" →
            </a>
            `;

            mobileSearchSuggestions.innerHTML = html;
            mobileSearchSuggestions.style.display = 'block';
        }

        function mobileShowNoResults(query) {
            mobileSearchSuggestions.innerHTML = `
            <div class="search-no-results">
                <p>No products found for "<strong>${query}</strong>"</p>
                <small>Try different keywords or browse categories</small>
            </div>
            `;
            mobileSearchSuggestions.style.display = 'block';
        }

        function mobileHideSuggestions() {
            if (mobileSearchSuggestions) mobileSearchSuggestions.style.display = 'none';
        }

        function mobileHighlightMatch(text, query) {
            const regex = new RegExp('(' + mobileEscapeRegex(query) + ')', 'gi');
            return text.replace(regex, '<mark style="background:#fff3cd;padding:0 2px;border-radius:2px;">$1</mark>');
        }

        function mobileEscapeRegex(string) {
            return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
        }
    });
</script><?php /**PATH C:\xampp\htdocs\chennais\frontend\resources\views/partials/header.blade.php ENDPATH**/ ?>