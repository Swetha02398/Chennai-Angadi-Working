<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <!-- Prevent bfcache glitch & FOUC (loaded early for instant execution) -->
    <script>
        (function () {
            // 1. Bulletproof bfcache recovery: Force reload if restoring from cache
            window.addEventListener('pageshow', function (event) {
                var isBfCache = event.persisted;
                if (!isBfCache && window.performance) {
                    var entries = window.performance.getEntriesByType("navigation");
                    if (entries.length > 0 && entries[0].type === "back_forward") {
                        isBfCache = true;
                    } else if (window.performance.navigation && window.performance.navigation.type === 2) {
                        isBfCache = true;
                    }
                }
                if (isBfCache) {
                    window.location.reload();
                }
            });

            // 2. FOUC prevention: Immediately hide HTML opacity
            document.documentElement.style.opacity = '0';
            
            // Re-show when DOM is ready
            document.addEventListener('DOMContentLoaded', function() {
                document.documentElement.style.opacity = '1';
                document.documentElement.style.transition = 'opacity 0.25s ease-in-out';
            });
            
            // Re-show fallback for slow assets
            window.addEventListener('load', function() {
                document.documentElement.style.opacity = '1';
            });
            
            // Absolute safety timeout
            setTimeout(function() {
                document.documentElement.style.opacity = '1';
            }, 1200);
        })();
    </script>

    <style>
        /* Modern mobile responsive overflow fixes */
        html, body {
            max-width: 100%;
            overflow-x: clip; /* Clean overflow cropping */
            position: relative;
        }
        body {
            overflow-x: clip !important;
        }
        .main-wrap, .main {
            max-width: 100% !important;
            overflow-x: clip !important;
        }

        /* Prevent slider horizontal layout shifts before Slick initializes */
        .carausel-10-columns:not(.slick-initialized),
        .hero-slider-1:not(.slick-initialized),
        .carausel-8-columns:not(.slick-initialized),
        .carausel-4-columns:not(.slick-initialized),
        .carausel-3-columns:not(.slick-initialized),
        .product-slider-active-1:not(.slick-initialized) {
            display: flex !important;
            overflow: hidden !important;
            white-space: nowrap !important;
            flex-wrap: nowrap !important;
            gap: 15px;
        }
        
        .carausel-10-columns:not(.slick-initialized) > *,
        .carausel-8-columns:not(.slick-initialized) > *,
        .carausel-4-columns:not(.slick-initialized) > *,
        .carausel-3-columns:not(.slick-initialized) > *,
        .product-slider-active-1:not(.slick-initialized) > * {
            flex: 0 0 auto !important;
            width: 100% !important;
        }
        
        /* Hero slider uninitialized states */
        .hero-slider-1:not(.slick-initialized) > * {
            display: none;
        }
        .hero-slider-1:not(.slick-initialized) > *:first-child {
            display: block !important;
            width: 100% !important;
        }
    </style>

    <meta charset="utf-8" />
    <title><?php echo $__env->yieldContent('seo_title', config('app.name')); ?></title>
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="description" content="<?php echo $__env->yieldContent('seo_description', ''); ?>" />
    <meta name="keywords" content="<?php echo $__env->yieldContent('seo_keywords', ''); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes" />
    <meta property="og:title" content="<?php echo $__env->yieldContent('og_title', config('app.name')); ?>" />
    <meta property="og:description" content="<?php echo $__env->yieldContent('og_description', ''); ?>" />
    <meta property="og:type" content="website" />
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href=" <?php echo e(asset('assets/imgs/images/favicon.png')); ?>" />
    <!-- Template CSS -->
    <link rel="stylesheet" href=" <?php echo e(asset('assets/css/plugins/animate.min.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/main.css')); ?>?v=<?php echo e(file_exists(public_path('assets/css/main.css')) ? filemtime(public_path('assets/css/main.css')) : '6.5'); ?>" />
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css">
    <!-- Lazysizes for image lazy loading -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.3.2/lazysizes.min.js" async></script>

    <!-- Wishlist Active State CSS - Only when active, NOT on hover -->
    <style>
        /* Center product titles globally */
        .product-content-wrap h2 {
            text-align: center !important;
        }

        .add-to-wishlist.active i,
        .add-to-wishlist.active {
            color: #ff0000 !important;
        }

        /* Center icons inside action buttons - Global styling */
        .product-action-1 {
            display: flex !important;
            gap: 5px !important;
        }

        .product-action-1 .action-btn {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 40px !important;
            height: 40px !important;
            line-height: 40px !important;
            text-align: center !important;
            border-radius: 4px !important;
        }

        .product-action-1 .action-btn i {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 100% !important;
            height: 100% !important;
            font-size: 16px !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        /* Custom Dropdown Arrow Fix - Global */
        .product_Dropdown {
            appearance: none !important;
            -webkit-appearance: none !important;
            -moz-appearance: none !important;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%233BB77E' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E") !important;
            background-repeat: no-repeat !important;
            background-position: right 10px center !important;
            background-size: 12px !important;
            padding-right: 30px !important;
            border: 1px solid #ececec !important;
            cursor: pointer !important;
            background-color: #fff !important;
            height: 40px !important;
            border-radius: 5px !important;
            padding-left: 10px !important;
        }

        /* Out of stock product styling - Global */
        .product-out-of-stock {
            opacity: 0.7;
            filter: grayscale(0.4);
            transition: all 0.4s ease;
        }

        .product-out-of-stock .product-img-action-wrap img {
            filter: grayscale(1);
            opacity: 0.8;
        }

        /* Prevent clicking out of stock product links */
        .product-out-of-stock .product-card-link {
            pointer-events: none !important;
            cursor: default !important;
        }

        /* ============================================================
           MOBILE RESPONSIVE: Product Cards & Variant Dropdowns
           Permanent fix for dropdown overflow on ALL mobile devices
           (Galaxy S8+, S20 Ultra, iPhone SE/12/14, Pixel, etc.)
           
           FIX 1: box-sizing: border-box (padding+border inside width)
           FIX 2: position: relative on card (dropdown stays inside)
           FIX 3: min-width: 0 + flex shrink (flexbox shrink fix)
           FIX 4: viewport meta tag updated in <head>
           ============================================================ */

        /* ---- FIX 1 & 2: Product Card Container ---- */
        .product-cart-wrap {
            position: relative !important;  /* FIX 2: dropdown stays inside */
            overflow: hidden !important;
            box-sizing: border-box !important; /* FIX 1: padding inside width */
            width: 100% !important;
            min-width: 0 !important;        /* FIX 3: allows flex shrink */
            word-wrap: break-word !important;
        }

        /* ---- FIX 3: Grid column wrapper (flex child needs min-width: 0) ---- */
        .product-grid > [class*="col-"],
        .product-grid-4 > [class*="col-"],
        .row.product-grid > [class*="col-"],
        [class*="col-lg-1-5"],
        .col-md-4, .col-6, .col-sm-6 {
            min-width: 0 !important;        /* FIX 3: critical for flex shrink */
            box-sizing: border-box !important;
        }

        /* Product content wrapper - contains all card content */
        .product-content-wrap {
            overflow: hidden !important;
            box-sizing: border-box !important;
            min-width: 0 !important;        /* FIX 3: flex child shrink */
            width: 100% !important;
            word-wrap: break-word !important;
        }

        /* ---- FIX 1: Variant selector container ---- */
        .product-variant-selector {
            width: 100% !important;
            max-width: 100% !important;
            overflow: hidden !important;
            box-sizing: border-box !important;
            min-width: 0 !important;
        }

        /* ---- FIX 1: ALL dropdowns inside product cards ---- */
        .product-cart-wrap select,
        .product-cart-wrap .product_Dropdown,
        .product-cart-wrap .form-control,
        .product-cart-wrap [class*="variant-dropdown-"],
        .product-cart-wrap [class*="offer-variant-dropdown-"],
        .product-cart-wrap [class*="sr-variant-dropdown-"] {
            width: 100% !important;
            max-width: 100% !important;
            box-sizing: border-box !important; /* FIX 1: padding+border inside width */
            min-width: 0 !important;           /* FIX 3: flexbox shrink */
            overflow: hidden !important;
            text-overflow: ellipsis !important;
            white-space: nowrap !important;
        }

        /* ---- FIX 1: Product card bottom row ---- */
        .product-card-bottom {
            overflow: hidden !important;
            box-sizing: border-box !important;
            min-width: 0 !important;
            width: 100% !important;
        }

        /* ---- FIX 3: Qty + ADD bottom row flex fix ---- */
        .product-card-bottom > div {
            min-width: 0 !important;
            box-sizing: border-box !important;
        }

        /* ---- FIX 3: Swiper/Scroll container product cards ---- */
        .scroll-container .product-cart-wrap {
            flex: 0 0 auto !important;
            min-width: 0 !important;
            box-sizing: border-box !important;
        }

        /* Validation Icons and Colors */
        .is-invalid, .is-invalid:focus {
            border-color: #dc3545 !important;
            background-color: #fff6f6 !important;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e") !important;
            background-repeat: no-repeat !important;
            background-position: right 10px center !important;
            background-size: 20px 20px !important;
            padding-right: 40px !important;
            transition: none !important;
            box-shadow: none !important;
            appearance: none !important;
        }

        .is-valid, .is-valid:focus {
            border-color: #198754 !important;
            background-color: #f6fff6 !important;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8' fill='%23198754'%3e%3cpath d='M2.3 6.73.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e") !important;
            background-repeat: no-repeat !important;
            background-position: right 10px center !important;
            background-size: 20px 20px !important;
            padding-right: 40px !important;
            transition: none !important;
            box-shadow: none !important;
            appearance: none !important;
        }

        /* Autofill Handling */
        input:-webkit-autofill,
        input:-webkit-autofill:hover, 
        input:-webkit-autofill:focus, 
        input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0px 1000px #f6fff6 inset !important;
            -webkit-text-fill-color: #333 !important;
            transition: background-color 5000s ease-in-out 0s;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8' fill='%23198754'%3e%3cpath d='M2.3 6.73.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e") !important;
            background-repeat: no-repeat !important;
            background-position: right calc(.375em + .1875rem) center !important;
            background-size: calc(.75em + .375rem) calc(.75em + .375rem) !important;
        }

        /* ============================================
           MOBILE BREAKPOINT: Tablets & below (≤768px)
           ============================================ */
        @media (max-width: 768px) {

            /* Force all product cards to shrink properly */
            .product-cart-wrap {
                overflow: hidden !important;
                flex: 1 1 auto !important;  /* FIX 3: allow shrink */
                min-width: 0 !important;
            }

            .product-content-wrap {
                padding: 6px 8px !important;
                overflow: hidden !important;
                min-width: 0 !important;
            }

            /* Scale down ALL variant dropdowns on mobile */
            .product-cart-wrap select,
            .product-cart-wrap .product_Dropdown,
            .product-cart-wrap .form-control,
            .product-cart-wrap [class*="variant-dropdown-"],
            .product-cart-wrap [class*="offer-variant-dropdown-"],
            .product-cart-wrap [class*="sr-variant-dropdown-"] {
                font-size: 11px !important;
                height: 32px !important;
                padding: 4px 24px 4px 6px !important;
                background-size: 10px !important;
                background-position: right 6px center !important;
                border-width: 1px !important;
                border-radius: 4px !important;
                line-height: 1.3 !important;
                min-width: 0 !important;
            }

            /* Reduce product name size on mobile */
            .product-content-wrap h2 {
                font-size: 12px !important;
                line-height: 1.3 !important;
                margin-bottom: 4px !important;
                word-wrap: break-word !important;
                overflow-wrap: break-word !important;
            }

            .product-content-wrap h2 a {
                font-size: 12px !important;
            }

            /* Compact price display on mobile */
            .product-cart-wrap .product-price {
                margin-bottom: 6px !important;
            }

            .product-cart-wrap .product-price div {
                font-size: 13px !important;
            }

            .product-cart-wrap .product-price span {
                font-size: 13px !important;
            }

            /* Compact Qty label and input */
            .product-cart-wrap .qty-label {
                font-size: 10px !important;
                margin-right: 3px !important;
            }

            .product-cart-wrap .qty-input {
                width: 35px !important;
                height: 26px !important;
                font-size: 11px !important;
                padding: 2px !important;
                box-sizing: border-box !important;
            }

            /* Compact ADD button on mobile */
            .product-cart-wrap .add-cart .add {
                font-size: 11px !important;
                padding: 5px 8px !important;
                white-space: nowrap !important;
                min-width: 0 !important;
            }

            .product-cart-wrap .add-cart .add i {
                font-size: 11px !important;
                margin-right: 3px !important;
            }

            /* Variant selector margin */
            .product-variant-selector {
                margin-bottom: 5px !important;
                min-width: 0 !important;
            }

            /* FIX 3: Scroll/Swiper container cards on mobile */
            .scroll-container .product-cart-wrap {
                min-width: 140px !important;
                flex: 0 0 calc(45% - 8px) !important;
            }

            /* Prevent horizontal page scroll from any overflow */
            body {
                overflow-x: clip !important;
            }

            .main, .main-wrap {
                overflow-x: clip !important;
            }

            /* Force show wishlist and quickview action icons on mobile always, styled exactly like Image 2 */
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
                z-index: 99 !important; /* Ensure it is on the very top of everything */
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
                pointer-events: auto !important; /* Ensure pointer events are active */
                cursor: pointer !important;
            }

            .product-action-1 .action-btn i {
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

            /* Mobile responsive styling for Quick View Modal - Compact to fit full content on small viewports */
            #quickViewModal .modal-dialog {
                margin: 10px !important;
                max-width: calc(100% - 20px) !important;
            }

            #quickViewModal .modal-content {
                border-radius: 10px !important;
            }

            #quickViewModal .modal-body {
                padding: 10px 15px !important; /* Reduced padding */
            }

            #quickViewModal .quickview-img-box,
            #quickViewModal #quickview-main-image {
                height: 140px !important; /* Reduced height to save 60px vertical space */
                width: 100% !important;
                object-fit: contain !important;
                border-radius: 8px !important;
            }

            #quickViewModal .detail-info {
                padding-top: 8px !important; /* Reduced padding to save 7px vertical space */
            }

            #quickViewModal .title-detail {
                font-size: 18px !important; /* Reduced font size to save vertical wrapping space */
                line-height: 1.3 !important;
                margin-bottom: 5px !important;
            }

            #quickViewModal .product-price-cover {
                margin-bottom: 8px !important; /* Reduced margin */
            }

            #quickViewModal .current-price {
                font-size: 22px !important;
            }

            #quickViewModal .save-price {
                font-size: 11px !important;
                margin-left: 6px !important;
            }

            #quickViewModal .old-price {
                font-size: 15px !important;
                margin-left: 6px !important;
            }

            #quickViewModal .detail-extralink {
                flex-wrap: wrap !important;
                gap: 8px !important;
            }

            #quickViewModal .detail-qty {
                max-width: 100% !important;
                width: 100% !important;
                justify-content: center !important;
                margin-right: 0 !important;
                margin-bottom: 8px !important;
                padding: 6px 30px 6px 12px !important; /* Slimmer padding */
            }

            #quickViewModal .product-extra-link2 {
                width: 100% !important;
                flex: unset !important;
            }

            #quickViewModal .button-add-to-cart {
                width: 100% !important;
                height: 42px !important; /* Slimmer height */
                font-size: 14px !important;
            }
        }

        /* ================================================
           COMPACT WISH BUTTON: Mobile View (≤575px)
           ================================================ */
        @media (max-width: 575px) {
            .product-action-1 .action-btn,
            .product-img-action-wrap .product-action-1 .action-btn {
                width: 28px !important;
                height: 28px !important;
            }

            .product-action-1 .action-btn i,
            .product-img-action-wrap .product-action-1 .action-btn i {
                font-size: 12px !important;
                line-height: 28px !important;
            }
        }

        /* ================================================
           EXTRA SMALL: Galaxy S8+ (360px), iPhone SE (320px)
           ================================================ */
        @media (max-width: 400px) {
            .product-content-wrap {
                padding: 4px 5px !important;
            }

            .product-cart-wrap select,
            .product-cart-wrap .product_Dropdown,
            .product-cart-wrap .form-control,
            .product-cart-wrap [class*="variant-dropdown-"],
            .product-cart-wrap [class*="offer-variant-dropdown-"],
            .product-cart-wrap [class*="sr-variant-dropdown-"] {
                font-size: 10px !important;
                height: 28px !important;
                padding: 3px 20px 3px 4px !important;
                background-size: 9px !important;
                background-position: right 4px center !important;
            }

            .product-content-wrap h2,
            .product-content-wrap h2 a {
                font-size: 11px !important;
            }

            .product-cart-wrap .product-price div,
            .product-cart-wrap .product-price span {
                font-size: 12px !important;
            }

            .product-cart-wrap .qty-input {
                width: 30px !important;
                height: 24px !important;
                font-size: 10px !important;
            }

            .product-cart-wrap .add-cart .add {
                font-size: 10px !important;
                padding: 4px 6px !important;
            }

            /* Swiper cards extra small screens */
            .scroll-container .product-cart-wrap {
                min-width: 130px !important;
                flex: 0 0 calc(48% - 6px) !important;
            }
        }
        /* Custom Validation Styles */
        .is-valid {
            border-color: #198754 !important;
            background-color: #f6fff6 !important;
        }
        .is-invalid {
            border-color: #dc3545 !important;
            background-color: #fff6f6 !important;
        }
    </style>
    <style>
        .quickview-img-box {
            
            height: 350px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border-radius: 10px;
            background: #fff;
            border: none !important;
            box-shadow: none !important;
            padding: 0;
        }

        #quickview-main-image {
           
            height: 350px !important;
            object-fit: cover !important;
            display: block;
            border: none !important;
            box-shadow: none !important;
            outline: none !important;
        }

        .detail-gallery figure,
        .detail-gallery figure img {
            border: none !important;
            box-shadow: none !important;
            outline: none !important;
            margin: 0;
            padding: 0;
        }

        /* Quick View Modal Quantity Control - Green Up/Down Arrows (Like Image 2) */
        #quickViewModal .detail-qty {
            position: relative;
            display: flex;
            align-items: center;
            border: 2px solid #3BB77E !important;
            border-radius: 5px;
            padding: 9px 35px 9px 15px !important;
            background: #fff;
            max-width: 80px;
            height: auto;
        }

        #quickViewModal .detail-qty .qty-val {
            width: 100%;
            text-align: center;
            border: none;
            background: transparent;
            font-size: 16px;
            font-weight: 700;
            color: #253D4E;
            -moz-appearance: textfield;
        }

        #quickViewModal .detail-qty .qty-val::-webkit-outer-spin-button,
        #quickViewModal .detail-qty .qty-val::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        #quickViewModal .detail-qty .qty-up,
        #quickViewModal .detail-qty .qty-down {
            position: absolute;
            right: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 20px;
            height: 18px;
            background: transparent;
            color: #3BB77E !important;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        #quickViewModal .detail-qty .qty-up {
            top: 2px;
        }

        #quickViewModal .detail-qty .qty-down {
            bottom: 2px;
        }

        #quickViewModal .detail-qty .qty-up:hover,
        #quickViewModal .detail-qty .qty-down:hover {
            color: #2a9d5c !important;
        }

        #quickViewModal .detail-qty .qty-up i,
        #quickViewModal .detail-qty .qty-down i {
            color: #3BB77E !important;
            font-size: 16px;
        }

        #quickViewModal .detail-qty .qty-up:hover i,
        #quickViewModal .detail-qty .qty-down:hover i {
            color: #2a9d5c !important;
        }
    </style>

</head>

<body>
    <?php echo $__env->make('partials.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <!-- Quick view Modal -->
    <div class="modal fade custom-modal" id="quickViewModal" tabindex="-1" aria-labelledby="quickViewModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12 mb-md-0 mb-sm-5">
                            <div class="detail-gallery">
                                <!-- <span class="zoom-icon"><i class="fi-rs-search"></i></span> -->
                                <div class="product-image-slider text-center">
                                    <figure class="quickview-img-box"
                                       >
                                        <img id="quickview-main-image"
                                            src="<?php echo e(asset('assets/imgs/theme/loading.gif')); ?>" alt="product image"
                                            style="height:350px !important; object-fit:cover !important; border:none !important; box-shadow:none !important; outline:none !important; display:block;" />
                                    </figure>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="detail-info">
                                <span class="stock-status out-stock" id="quickview-badge">Sale Off</span>
                                <h3 class="title-detail"><a href="#" class="text-heading"
                                        id="quickview-product-name">Product Name</a></h3>
                                <div class="clearfix product-price-cover">
                                    <div class="product-price primary-color float-left">
                                        <span class="current-price text-brand" id="quickview-price">₹0</span>
                                        <span>
                                            <span class="old-price font-md ml-15" id="quickview-old-price">₹0</span>
                                        </span>
                                    </div>
                                </div>
                                
                                <div id="quickview-variant-wrapper" style="margin-bottom: 15px; display: none;">
                                    <select id="quickview-variant-dropdown" class="form-control form-control-sm product_Dropdown"
                                       >
                                    </select>
                                </div>
                                <div class="detail-extralink d-flex justify-content-between">
                                    <div class="detail-qty border radius me-3">
                                        <input type="number" id="quickview-qty" class="qty-val" value="1" min="1"
                                            readonly>
                                        <a href="javascript:void(0)" class="qty-up" id="quickview-qty-up"><i
                                                class="fi-rs-angle-small-up"></i></a>
                                        <a href="javascript:void(0)" class="qty-down" id="quickview-qty-down"><i
                                                class="fi-rs-angle-small-down"></i></a>
                                    </div>
                                    <div class="product-extra-link2 d-flex col-auto flex-fill">
                                        <button type="button" class="button button-add-to-cart col-12"
                                            id="quickview-add-to-cart" data-product-id="">
                                            <i class="fi-rs-shopping-cart"></i>Add to cart
                                        </button>
                                    </div>
                                </div>
                                <div class="font-md">
                                    <ul class="float-start">
                                        <li>Stock: <span class="in-stock text-brand ml-5" id="quickview-stock">Available
                                            </span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Header -->
    <div class="mobile-header-active mobile-header-wrapper-style">
        <div class="mobile-header-wrapper-inner">
            <div class="mobile-header-top">
                <div class="mobile-header-logo">
                    <a href="<?php echo e(url('/')); ?>"><img src="<?php echo e(asset('assets/imgs/images/ChennaiAngadiLogo.png')); ?>"
                            alt="Chennai Angadi logo" /></a>
                </div>
                <div class="mobile-menu-close close-style-wrap close-style-position-inherit">
                    <button class="close-style search-close">
                        <i class="icon-top"></i>
                        <i class="icon-bottom"></i>
                    </button>
                </div>


            </div>
            <div class="mobile-header-content-area">
                <!-- <div class="mobile-search search-style-3 mobile-header-border">
                    <form action="<?php echo e(route('search')); ?>" method="GET" id="mobile-search-form">
                        <input type="text" name="q" id="mobile-search-input" placeholder="Search for items…"
                            value="<?php echo e(request('q')); ?>" autocomplete="off" />
                        <button type="submit"><i class="fi-rs-search"></i></button>
                    </form>
                </div> -->
                <!-- Mobile Sidebar Tabs -->
                <div class="mobile-sidebar-tabs">
                    <div class="mobile-tab-header">
                        <button class="mobile-tab-btn active" data-tab="mob-categories">CATEGORIES</button>
                        <button class="mobile-tab-btn" data-tab="mob-menu">MENU</button>
                    </div>

                    <!-- Categories Tab -->
                    <div class="mobile-tab-content active" id="mob-categories">
                        <ul class="mobile-cat-list">
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="mobile-cat-item">
                                    <a href="<?php echo e(route('category.products', $cat->slug)); ?>" class="mobile-cat-link">
                                        <?php $catImg = str_replace('uploads/', '', $cat->image); ?>
                                        <img src="<?php echo e(config('app.admin_asset_url')); ?>/<?php echo e($catImg); ?>" alt="<?php echo e($cat->name); ?>"
                                            class="mobile-cat-img" onerror="this.style.display='none'">
                                        <span><?php echo e($cat->name); ?></span>
                                        <?php if($cat->subcategories->count() > 0): ?>
                                            <i class="fi-rs-angle-right mobile-cat-arrow"></i>
                                        <?php endif; ?>
                                    </a>
                                    <?php if($cat->subcategories->count() > 0): ?>
                                        <ul class="mobile-sub-list">
                                            <?php $__currentLoopData = $cat->subcategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li class="mobile-sub-item">
                                                    <a href="<?php echo e(route('subcategory.products', $sub->slug)); ?>" class="mobile-sub-link">
                                                        <?php if($sub->subimage): ?>
                                                            <?php $subImg = str_replace('uploads/', '', $sub->subimage); ?>
                                                            <img src="<?php echo e(config('app.admin_asset_url')); ?>/<?php echo e($subImg); ?>" alt="<?php echo e($sub->name); ?>"
                                                                class="mobile-cat-img" onerror="this.style.display='none'">
                                                        <?php endif; ?>
                                                        <span><?php echo e($sub->name); ?></span>
                                                        <?php if($sub->childCategories->count() > 0): ?>
                                                            <i class="fi-rs-angle-right mobile-cat-arrow"></i>
                                                        <?php endif; ?>
                                                    </a>
                                                    <?php if($sub->childCategories->count() > 0): ?>
                                                        <ul class="mobile-child-list">
                                                            <?php $__currentLoopData = $sub->childCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <li>
                                                                    <a href="<?php echo e(route('childcategory.products', $child->slug)); ?>">
                                                                        <?php if($child->childimage): ?>
                                                                            <?php $childImg = str_replace('uploads/', '', $child->childimage); ?>
                                                                            <img src="<?php echo e(config('app.admin_asset_url')); ?>/<?php echo e($childImg); ?>"
                                                                                alt="<?php echo e($child->name); ?>" class="mobile-cat-img"
                                                                                onerror="this.style.display='none'">
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
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>

                    <!-- Menu Tab -->
                    <div class="mobile-tab-content" id="mob-menu">
                        <ul class="mobile-menu-list">
                            <li><a href="<?php echo e(url('/')); ?>" class="<?php echo e(request()->is('/') ? 'active' : ''); ?>"><i
                                        class="fi-rs-home"></i> Home</a></li>
                            <li><a href="<?php echo e(route('pages.about')); ?>"><i class="fi-rs-info"></i> About</a></li>
                            <li><a href="<?php echo e(route('pages.offer')); ?>"
                                    class="<?php echo e(request()->routeIs('pages.offer') ? 'active' : ''); ?>"><i
                                        class="fi-rs-label"></i> Offer</a></li>
                            <li><a href="<?php echo e(url('shop')); ?>"><i class="fi-rs-shop"></i> Shop</a></li>
                            <li><a href="<?php echo e(route('pages.contact')); ?>"><i class="fi-rs-headphones"></i> Contact</a></li>
                        </ul>
                    </div>
                </div>

                <style>
                    /* Mobile Sidebar Tabs */
                    .mobile-sidebar-tabs {
                        padding: 0;
                    }

                    .mobile-tab-header {
                        display: flex;
                        border-bottom: 2px solid #eee;
                        background: #fff;
                        position: sticky;
                        top: 0;
                        z-index: 5;
                    }

                    .mobile-tab-btn {
                        flex: 1;
                        padding: 14px 10px;
                        border: none;
                        background: none;
                        font-size: 13px;
                        font-weight: 700;
                        color: #999;
                        cursor: pointer;
                        letter-spacing: 0.5px;
                        position: relative;
                        transition: color 0.3s;
                    }

                    .mobile-tab-btn.active {
                        color: #253D4E;
                    }

                    .mobile-tab-btn.active::after {
                        content: '';
                        position: absolute;
                        bottom: -2px;
                        left: 10%;
                        right: 10%;
                        height: 3px;
                        background: #3BB77E;
                        border-radius: 2px;
                    }

                    .mobile-tab-content {
                        display: none;
                    }

                    .mobile-tab-content.active {
                        display: block;
                    }

                    /* Categories List */
                    .mobile-cat-list {
                        list-style: none;
                        margin: 0;
                        padding: 0;
                    }

                    .mobile-cat-item {
                        border-bottom: 1px solid #f0f0f0;
                    }

                    .mobile-cat-link,
                    .mobile-sub-link {
                        display: flex;
                        align-items: center;
                        padding: 12px 20px;
                        color: #253D4E;
                        font-size: 16px;
                        font-weight: 600;
                        text-decoration: none;
                        transition: background 0.2s;
                    }

                    .mobile-cat-link:hover,
                    .mobile-sub-link:hover {
                        background: #f0faf4;
                    }

                    .mobile-cat-img {
                        width: 30px;
                        height: 30px;
                        object-fit: cover;
                        border-radius: 5px;
                        margin-right: 12px;
                        flex-shrink: 0;
                    }

                    .mobile-cat-arrow {
                        margin-left: auto;
                        font-size: 17px;
                        color: #000000;
                        transition: transform 0.3s;
                        cursor: pointer;
                        width: 32px;
                        height: 32px;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        flex-shrink: 0;
                        border-radius: 4px;
                    }

                    .mobile-cat-arrow:hover {
                        background: #eee;
                    }

                    .mobile-cat-item.open>.mobile-cat-link .mobile-cat-arrow,
                    .mobile-sub-item.open>.mobile-sub-link .mobile-cat-arrow {
                        transform: rotate(90deg);
                        color: #3BB77E;
                    }

                    .mobile-sub-list {
                        list-style: none;
                        margin: 0;
                        padding: 0;
                        display: none;
                        background: #f9faf9;
                    }

                    .mobile-cat-item.open>.mobile-sub-list {
                        display: block;
                    }

                    .mobile-sub-list .mobile-sub-link {
                        padding-left: 40px;
                        font-size: 16px;
                        color: #000000;
                        border-top: 1px solid #eee;
                    }

                    .mobile-sub-list .mobile-sub-link .mobile-cat-img {
                        width: 24px;
                        height: 24px;
                    }

                    .mobile-child-list {
                        list-style: none;
                        margin: 0;
                        padding: 0;
                        display: none;
                        background: #f3f5f3;
                    }

                    .mobile-sub-item.open>.mobile-child-list {
                        display: block;
                    }

                    .mobile-child-list li a {
                        display: flex;
                        align-items: center;
                        padding: 10px 20px 10px 60px;
                        color: #666;
                        font-size: 13px;
                        text-decoration: none;
                        border-top: 1px solid #eaeaea;
                        transition: background 0.2s;
                    }

                    .mobile-child-list li a:hover {
                        background: #e8f5ee;
                        color: #3BB77E;
                    }

                    .mobile-child-list li a .mobile-cat-img {
                        width: 22px;
                        height: 22px;
                        margin-right: 10px;
                    }

                    /* Menu List */
                    .mobile-menu-list {
                        list-style: none;
                        margin: 0;
                        padding: 0;
                    }

                    .mobile-menu-list li {
                        border-bottom: 1px solid #f0f0f0;
                    }

                    .mobile-menu-list li a {
                        display: flex;
                        align-items: center;
                        gap: 12px;
                        padding: 14px 20px;
                        color: #253D4E;
                        font-size: 16px;
                        font-weight: 700;
                        text-decoration: none;
                        transition: background 0.2s;
                    }

                    .mobile-menu-list li a:hover {
                        background: #f0faf4;
                    }

                    .mobile-menu-list li a.active {
                        color: #3BB77E;
                        font-weight: 600;
                    }

                    .mobile-menu-list li a i {
                        font-size: 16px;
                        width: 20px;
                        text-align: center;
                        color: #3BB77E;
                    }

                    .mobile-menu-list li a.active i {
                        color: #3BB77E;
                    }
                </style>

                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        // Tab switching
                        document.querySelectorAll('.mobile-tab-btn').forEach(function (btn) {
                            btn.addEventListener('click', function () {
                                document.querySelectorAll('.mobile-tab-btn').forEach(function (b) { b.classList.remove('active'); });
                                document.querySelectorAll('.mobile-tab-content').forEach(function (c) { c.classList.remove('active'); });
                                btn.classList.add('active');
                                document.getElementById(btn.dataset.tab).classList.add('active');
                            });
                        });

                        // Category accordion — only arrow toggles, name/image navigates
                        document.querySelectorAll('.mobile-cat-item').forEach(function (item) {
                            var arrow = item.querySelector(':scope > .mobile-cat-link .mobile-cat-arrow');
                            if (!arrow) return;
                            arrow.addEventListener('click', function (e) {
                                e.preventDefault();
                                e.stopPropagation();
                                document.querySelectorAll('.mobile-cat-item.open').forEach(function (o) { if (o !== item) o.classList.remove('open'); });
                                item.classList.toggle('open');
                            });
                        });

                        // Subcategory accordion — only arrow toggles
                        document.querySelectorAll('.mobile-sub-item').forEach(function (item) {
                            var arrow = item.querySelector(':scope > .mobile-sub-link .mobile-cat-arrow');
                            if (!arrow) return;
                            arrow.addEventListener('click', function (e) {
                                e.preventDefault();
                                e.stopPropagation();
                                document.querySelectorAll('.mobile-sub-item.open').forEach(function (o) { if (o !== item) o.classList.remove('open'); });
                                item.classList.toggle('open');
                            });
                        });
                    });
                </script>
                <div class="mobile-header-info-wrap">                    
                    <div class="single-mobile-header-info">
                        <?php if(Auth::guard('customer')->check()): ?>
                            <?php
                                $user = Auth::guard('customer')->user();
                                $profileImagePath = public_path('uploads/profile/' . $user->profile_image);
                            ?>
                            <a href="<?php echo e(route('customer.myAccount')); ?>" style="display: flex; flex-direction: column; align-items: center; gap: 5px; padding: 10px 0;">
                                <?php if(!empty($user->profile_image) && file_exists($profileImagePath)): ?>
                                    <img src="<?php echo e(asset('uploads/profile/' . $user->profile_image)); ?>" 
                                         alt="Profile" 
                                         style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover; border: 2px solid #3BB77E;">
                                <?php else: ?>
                                    <i class="fi-rs-user" style="font-size: 24px; color: #3BB77E;"></i>
                                <?php endif; ?>
                                <span style="font-weight: 700; color: #253D4E; text-transform: capitalize;"><?php echo e($user->username); ?></span>
                            </a>
                        <?php else: ?>
                            <a href="javascript:void(0);" onclick="openLoginModal()"><i class="fi-rs-user"></i>Log In / Sign
                                Up </a>
                        <?php endif; ?>
                    </div>
                    <div class="single-mobile-header-info">
                        <a href="<?php echo e(route('order.track')); ?>"><i class="fi-rs-marker"></i> Order Tracking </a>
                    </div>
                    <div class="single-mobile-header-info">
                        <a href="<?php echo e(route('pages.contact')); ?>"><i class="fi-rs-marker"></i> Contact Us </a>
                    </div>
                    <div class="single-mobile-header-info">
                        <a href="tel:919094676665"><i class="fi-rs-headphones"></i>91 90946 76665</a>
                    </div>
                </div>
                <div class="mobile-social-icon">
                   <a href="https://www.facebook.com/chennaiangaadi" target="_blank"><img
                            src="<?php echo e(asset('assets/imgs/theme/icons/icon-facebook-white.svg')); ?> " alt="" /></a>
                    <a href="https://twitter.com/ChennaiAngadi" target="_blank"><img
                            src="<?php echo e(asset('assets/imgs/theme/icons/icon-twitter-white.svg')); ?> " alt="" /></a>
                    <a href="https://www.instagram.com/chennaiangadii/" target="_blank"><img
                            src="<?php echo e(asset('assets/imgs/theme/icons/icon-instagram-white.svg')); ?> " alt="" /></a>
                    <a href="https://www.linkedin.com/company/35949244/admin/dashboard/" target="_blank"><img
                            src="<?php echo e(asset('assets/imgs/theme/icons/icon-linkedin-white.svg')); ?> " alt="" /></a>
                    <!-- <a href="#"><img src="<?php echo e(asset('assets/imgs/theme/icons/icon-pinterest-white.svg')); ?> "
                            alt="" /></a> -->
                    <a href="https://www.youtube.com/@chennaiangadi" target="_blank"><img
                            src="<?php echo e(asset('assets/imgs/theme/icons/icon-youtube-white.svg')); ?> " alt="" /></a>
                    <a href="https://wa.me/919094676665" target="_blank"><img
                            src="<?php echo e(asset('assets/imgs/theme/icons/icon-whatsapp-white.svg')); ?> " alt="WhatsApp" style="width: 22px; max-width: 22px; vertical-align: middle; margin-left:2px; transform: scale(1.1);" /></a>
                </div>
                <!-- <div class="site-copyright"><a href="<?php echo e(url('/')); ?>">Copyright <?php echo e(now()->year); ?> Chennai Angadi. All
                        rights reserved.</a></div> -->
            </div>
        </div>
    </div>
    <!--End header-->

    <main class="main-wrap">
        <?php echo $__env->yieldContent('content'); ?>
        <?php echo $__env->make('partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </main>

    <!-- Preloader Start -->
    <!-- <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="text-center">
                    <img src=" <?php echo e(asset('assets/imgs/theme/loading.gif')); ?>" alt="" />
                </div>
            </div>
        </div>
    </div> -->

    <!-- Vendor JS-->
    <script src=" <?php echo e(asset('assets/js/vendor/modernizr-3.6.0.min.js')); ?>"></script>
    <script src=" <?php echo e(asset('assets/js/vendor/jquery-3.6.0.min.js')); ?>"></script>
    <script src=" <?php echo e(asset('assets/js/vendor/jquery-migrate-3.3.0.min.js')); ?>"></script>
    <script src=" <?php echo e(asset('assets/js/vendor/bootstrap.bundle.min.js')); ?>"></script>
    <script src=" <?php echo e(asset('assets/js/plugins/slick.js')); ?>"></script>
    <script src=" <?php echo e(asset('assets/js/plugins/jquery.syotimer.min.js')); ?>"></script>
    <script src=" <?php echo e(asset('assets/js/plugins/waypoints.js')); ?>"></script>
    <script src=" <?php echo e(asset('assets/js/plugins/wow.js')); ?>"></script>
    <script src=" <?php echo e(asset('assets/js/plugins/perfect-scrollbar.js')); ?>"></script>
    <script src=" <?php echo e(asset('assets/js/plugins/magnific-popup.js')); ?>"></script>
    <script src=" <?php echo e(asset('assets/js/plugins/select2.min.js')); ?>"></script>
    <script src=" <?php echo e(asset('assets/js/plugins/counterup.js')); ?>"></script>
    <script src=" <?php echo e(asset('assets/js/plugins/jquery.countdown.min.js')); ?>"></script>
    <script src=" <?php echo e(asset('assets/js/plugins/images-loaded.js')); ?>"></script>
    <script src=" <?php echo e(asset('assets/js/plugins/isotope.js')); ?>"></script>
    <script src=" <?php echo e(asset('assets/js/plugins/scrollup.js')); ?>"></script>
    <script src=" <?php echo e(asset('assets/js/plugins/jquery.vticker-min.js')); ?>"></script>
    <script src=" <?php echo e(asset('assets/js/plugins/jquery.theia.sticky.js')); ?>"></script>
    <script src=" <?php echo e(asset('assets/js/plugins/jquery.elevatezoom.js')); ?>"></script>
    <!-- Template  JS -->
    <script src="<?php echo e(asset('assets/js/main.js')); ?>?v=<?php echo e(file_exists(public_path('assets/js/main.js')) ? filemtime(public_path('assets/js/main.js')) : '6.5'); ?>"></script>
    <script src="<?php echo e(asset('assets/js/shop.js')); ?>?v=<?php echo e(file_exists(public_path('assets/js/shop.js')) ? filemtime(public_path('assets/js/shop.js')) : '6.5'); ?>"></script>

    <!-- Toaster Js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>

    <script>
        // Recalculate Slick slider layouts on window load to prevent overlaps and timing/sizing bugs
        function recalculateSliders() {
            if (typeof $ !== 'undefined') {
                var sliders = $('.carausel-10-columns, .hero-slider-1, .carausel-8-columns, .carausel-4-columns, .carausel-3-columns, .product-slider-active-1');
                sliders.each(function() {
                    if ($(this).hasClass('slick-initialized')) {
                        $(this).slick('setPosition');
                    }
                });
                // Force layout recalculations by triggering window resize
                window.dispatchEvent(new Event('resize'));
            }
        }
        
        window.addEventListener('load', function () {
            recalculateSliders();
            // Perform fallback recalcs in case of delayed font/image loading
            setTimeout(recalculateSliders, 200);
            setTimeout(recalculateSliders, 600);
        });



        function addToCart(productId) {
            fetch('<?php echo e(route("add-to-cart")); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    product_id: productId
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        if (typeof toastr !== 'undefined') {
                            toastr.success(data.product.name + ' added to cart!');
                        }

                        if (data.cartCount) {
                            updateCartCount(data.cartCount);
                        }

                        // Stay on the same page - no redirect
                    } else {
                        if (typeof toastr !== 'undefined') {
                            toastr.error(data.message || 'Failed to add product');
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    if (typeof toastr !== 'undefined') {
                        toastr.error('Error adding product to cart');
                    }
                });
        }

        function updateCartCount(count) {
            const cartElements = document.querySelectorAll('[data-cart-count], .cart-count, .header-action-number, #header-cart-count, #bottom-header-cart-count, #mobile-cart-count');
            cartElements.forEach(el => {
                el.textContent = count;
            });
        }
    </script>

    <!-- Wishlist JavaScript - Works for both guests and logged-in users -->
    <script>
        document.addEventListener('click', function (e) {
            const btn = e.target.closest('.add-to-wishlist');
            if (!btn) return;

            e.preventDefault();
            e.stopPropagation();
            let product_id = btn.getAttribute('data-id');

            if (!product_id) {
                console.error('No product ID found');
                return;
            }

            fetch("<?php echo e(route('wishlist.toggle')); ?>", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    "Accept": "application/json"
                },
                body: JSON.stringify({
                    product_id: product_id
                })
            })
                .then(res => res.json())
                .then(res => {
                    // Update ALL wishlist buttons for this product on the page
                    document.querySelectorAll('.add-to-wishlist[data-id="' + product_id + '"]').forEach(function (button) {
                        if (res.added) {
                            button.classList.add('active');
                        } else {
                            button.classList.remove('active');
                        }
                    });

                    // Update header wishlist count
                    const countEle = document.getElementById('wishlist-count');
                    if (countEle) countEle.textContent = res.count;

                    // Debug log
                    console.log('Wishlist toggle response:', res);

                    // Show toast notification
                    if (typeof toastr !== 'undefined') {
                        if (res.added) {
                            toastr.success('Added to wishlist!');
                        } else {
                            toastr.info('Removed from wishlist');
                        }
                    }
                })
                .catch(err => {
                    console.error('Wishlist error:', err);
                    if (typeof toastr !== 'undefined') {
                        toastr.error('Error updating wishlist');
                    }
                });
        });
    </script>

    <!-- Quick View JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Quick View click handler - using event delegation
            document.addEventListener('click', function (e) {
                const quickViewBtn = e.target.closest('.quick-view-btn');
                if (!quickViewBtn) return;

                e.preventDefault();
                e.stopPropagation();
                const productId = quickViewBtn.getAttribute('data-product-id');

                if (!productId) {
                    console.error('No product ID found');
                    return;
                }

                // Show loading state
                if (typeof toastr !== 'undefined') {
                    toastr.info('Loading product details...');
                }

                // Fetch product data
                fetch(`<?php echo e(url('/product/quick-view')); ?>/${productId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            throw new Error(data.message || 'Product not found');
                        }

                        if (typeof toastr !== 'undefined') {
                            toastr.clear();
                        }

                        // Set image
                        const imgElement = document.getElementById('quickview-main-image');
                        if (imgElement) {
                            imgElement.src = "<?php echo e(asset('assets/imgs/theme/loading.gif')); ?>";
                            imgElement.onerror = function () {
                                this.onerror = null;
                                this.src = "<?php echo e(asset('assets/imgs/shop/product-1-1.jpg')); ?>";
                            };
                            const rawImage = data.raw_image || '';
                            const imageName = rawImage.split('/').pop() || rawImage.split('\\\\').pop() || rawImage;
                            const imageUrl = imageName ? '<?php echo e(config('app.admin_asset_url')); ?>/products/' + imageName : "<?php echo e(asset('assets/imgs/shop/product-1-1.jpg')); ?>";
                            imgElement.src = imageUrl;
                        }

                        document.getElementById('quickview-product-name').textContent = data.name;
                        document.getElementById('quickview-product-name').href = `<?php echo e(url('/product')); ?>/${data.id}`;
                        document.getElementById('quickview-add-to-cart').setAttribute('data-product-id', data.id);
                        document.getElementById('quickview-qty').value = 1;

                        // Populate variant dropdown
                        const variantWrapper = document.getElementById('quickview-variant-wrapper');
                        const variantDropdown = document.getElementById('quickview-variant-dropdown');

                        if (data.variants && data.variants.length > 0) {
                            variantDropdown.innerHTML = '';
                            data.variants.forEach((v, idx) => {
                                const opt = document.createElement('option');
                                opt.value = v.id;
                                opt.dataset.variantId = v.id;
                                opt.dataset.price = v.display_price;
                                opt.dataset.sellPrice = v.sell_price;
                                opt.dataset.mrpPrice = v.price;
                                opt.dataset.offerPrice = v.offer_price || '';
                                opt.dataset.hasOffer = v.has_offer ? '1' : '0';
                                opt.dataset.stock = v.stock;
                                opt.dataset.label = v.label;
                                opt.textContent = v.label + ' - ₹' + Math.round(v.display_price);
                                if (idx === 0) opt.selected = true;
                                variantDropdown.appendChild(opt);
                            });
                            variantWrapper.style.display = 'block';

                            // Use first variant data
                            quickViewUpdateFromVariant(data.variants[0]);
                        } else {
                            variantWrapper.style.display = 'none';

                            // No variants - simple product
                            quickViewUpdatePrice(data.price, data.old_price, data.discount_percent);
                            quickViewUpdateStock(data.stock);
                        }

                        // Show modal
                        const modal = new bootstrap.Modal(document.getElementById('quickViewModal'));
                        modal.show();
                    })
                    .catch(error => {
                        console.error('Error fetching product:', error);
                        if (typeof toastr !== 'undefined') {
                            toastr.clear();
                            toastr.error(error.message || 'Error loading product details');
                        }
                    });
            });

            // --- Variant dropdown change handler ---
            const variantDropdown = document.getElementById('quickview-variant-dropdown');
            if (variantDropdown) {
                variantDropdown.addEventListener('change', function () {
                    const opt = this.options[this.selectedIndex];
                    const variantData = {
                        display_price: parseFloat(opt.dataset.price),
                        sell_price: parseFloat(opt.dataset.sellPrice),
                        price: parseFloat(opt.dataset.mrpPrice),
                        offer_price: opt.dataset.offerPrice ? parseFloat(opt.dataset.offerPrice) : null,
                        has_offer: opt.dataset.hasOffer === '1',
                        stock: parseInt(opt.dataset.stock) || 0,
                    };
                    quickViewUpdateFromVariant(variantData);
                });
            }

            // Helper: update price/stock/button from variant data
            function quickViewUpdateFromVariant(v) {
                const displayPrice = v.display_price;
                const mrp = v.price;

                // Discount percent
                let discountPercent = 0;
                if (mrp && displayPrice && displayPrice < mrp) {
                    discountPercent = Math.round(((mrp - displayPrice) / mrp) * 100);
                }

                quickViewUpdatePrice(displayPrice, mrp, discountPercent);
                quickViewUpdateStock(v.stock);
            }

            function quickViewUpdatePrice(sellPrice, mrpPrice, discountPercent) {
                document.getElementById('quickview-price').textContent = '₹' + Math.round(sellPrice);

                const oldPriceEl = document.getElementById('quickview-old-price');
                const badge = document.getElementById('quickview-badge');

                if (mrpPrice && mrpPrice > sellPrice) {
                    oldPriceEl.textContent = '₹' + Math.round(mrpPrice);
                    oldPriceEl.style.display = 'inline';
                    badge.textContent = discountPercent + '% Off';
                    badge.style.display = 'inline-block';
                } else {
                    oldPriceEl.style.display = 'none';
                    badge.style.display = 'none';
                }
            }

            function quickViewUpdateStock(stock) {
                const stockEl = document.getElementById('quickview-stock');
                const addBtn = document.getElementById('quickview-add-to-cart');

                if (stock <= 0) {
                    stockEl.textContent = 'Out of Stock';
                    stockEl.style.color = '#dc3545';
                    stockEl.classList.remove('text-brand');
                    addBtn.innerHTML = '<i class="fi-rs-shopping-cart"></i>OUT OF STOCK';
                    addBtn.style.opacity = '0.5';
                    addBtn.style.cursor = 'not-allowed';
                    addBtn.style.pointerEvents = 'none';
                    addBtn.style.backgroundColor = '#dc3545';
                    addBtn.style.borderColor = '#dc3545';
                    addBtn.style.color = '#fff';
                    addBtn.disabled = true;
                } else {
                    stockEl.textContent = stock + ' Available';
                    stockEl.style.color = '';
                    stockEl.classList.add('text-brand');
                    addBtn.innerHTML = '<i class="fi-rs-shopping-cart"></i>Add to cart';
                    addBtn.style.opacity = '';
                    addBtn.style.cursor = '';
                    addBtn.style.pointerEvents = '';
                    addBtn.style.backgroundColor = '';
                    addBtn.style.borderColor = '';
                    addBtn.style.color = '';
                    addBtn.disabled = false;
                }
            }

            // --- Add to Cart handler ---
            const addToCartBtn = document.getElementById('quickview-add-to-cart');
            if (addToCartBtn) {
                addToCartBtn.addEventListener('click', function (e) {
                    e.preventDefault();

                    if (this.disabled) return;

                    const productId = this.getAttribute('data-product-id');
                    const quantity = parseInt(document.getElementById('quickview-qty').value) || 1;
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    if (!productId) {
                        toastr.error('Product not found');
                        return;
                    }

                    // Build request data matching products.blade.php flow
                    const requestData = {
                        product_id: productId,
                        selected_quantity: quantity
                    };

                    const variantDD = document.getElementById('quickview-variant-dropdown');
                    if (variantDD && variantDD.options.length > 0) {
                        const selectedOpt = variantDD.options[variantDD.selectedIndex];
                        requestData.variant_id = selectedOpt.dataset.variantId;
                        requestData.unit_price = selectedOpt.dataset.price;
                        if (selectedOpt.dataset.label) {
                            requestData.selected_weight = selectedOpt.dataset.label;
                        }
                    } else {
                        requestData.unit_price = document.getElementById('quickview-price').textContent.replace('₹', '');
                    }

                    fetch('<?php echo e(route("add-to-cart")); ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(requestData)
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                if (typeof toastr !== 'undefined') {
                                    toastr.success(data.message || 'Product added to cart!');
                                }

                                if (data.cartCount) {
                                    document.querySelectorAll('.cart-count, #header-cart-count, #bottom-header-cart-count, #mobile-cart-count, .header-action-number').forEach(el => {
                                        el.textContent = data.cartCount;
                                    });
                                }

                                const modal = bootstrap.Modal.getInstance(document.getElementById('quickViewModal'));
                                if (modal) modal.hide();
                            } else {
                                if (typeof toastr !== 'undefined') {
                                    toastr.error(data.message || 'Failed to add product');
                                }
                            }
                        })
                        .catch(error => {
                            console.error('Add to cart error:', error);
                            if (typeof toastr !== 'undefined') {
                                toastr.warning('Please login to add items to cart');
                            }
                            setTimeout(function () {
                                openLoginModal();
                            }, 500);
                        });
                });
            }
        });
    </script>

    <!-- Fix: Ensure modals appear above all content on mobile (z-index stacking context fix) -->
    <style>
        /* Force Bootstrap modals and backdrops above all animated/positioned content */
        .modal-backdrop {
            z-index: 10040 !important;
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            width: 100vw !important;
            height: 100vh !important;
        }
        .modal {
            z-index: 10050 !important;
        }
        .modal-dialog {
            z-index: 10060 !important;
        }

        /* Lock body scroll when modal is open - use overflow only, no position:fixed */
        body.modal-open {
            overflow: hidden !important;
            padding-right: 0 !important;
        }

        /* Ensure animated/wow elements don't create competing stacking contexts above modal */
        .modal-open .scroll-wrapper,
        .modal-open .scroll-container,
        .modal-open .scroll-btn,
        .modal-open .wow,
        .modal-open .animate__animated,
        .modal-open .position-relative,
        .modal-open .home-slider,
        .modal-open .hero-slider-1,
        .modal-open .product-tabs,
        .modal-open .section-padding,
        .modal-open main.main,
        .modal-open .category-nav-arrow,
        .modal-open .mobile-header-active,
        .modal-open .main-wrap,
        .modal-open header {
            z-index: auto !important;
        }

        /* Mobile specific: make sure modal is fully visible */
        @media (max-width: 768px) {
            .modal-backdrop.show {
                opacity: 0.4 !important;
            }
            #globalLoginModal .modal-dialog,
            #globalRegisterModal .modal-dialog,
            #globalForgotPasswordModal .modal-dialog {
                margin: 15px !important;
                max-width: calc(100% - 30px) !important;
            }
        }
    </style>

    <!-- Global Login Modal -->
    <div class="modal fade" id="globalLoginModal" tabindex="-1" aria-labelledby="globalLoginModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0" style="border-radius: 15px; box-shadow: 0 10px 40px rgba(0,0,0,0.15); background-color: #f8f9fa;">
                <div class="modal-header border-0 pb-0" style="padding: 25px 30px 0;">
                    <div>
                        <h4 class="modal-title fw-bold mb-1" id="globalLoginModalLabel">Login</h4>
                        <p class="text-muted font-sm mb-0">Don't have an account? <a href="javascript:void(0);"
                                onclick="openRegisterModal()" style="color: #3BB77E;">Create here</a></p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 pt-3">
                    <form id="globalLoginForm" onsubmit="return handleGlobalLogin(event)" novalidate>
                        <?php echo csrf_field(); ?>
                        <div class="form-group mb-3">
                            <input type="text" name="login_id" id="globalLoginId" class="form-control"
                                placeholder="Username / Email" required
                                style="height: 50px; border-radius: 8px; border: 1px solid #ddd; padding: 10px 15px; font-size: 14px;">
                            <small class="text-danger error-text d-none" id="err-login_id">Login ID is required</small>
                        </div>
                        <div class="form-group mb-2">
                            <input type="password" name="password" id="globalLoginPassword" class="form-control"
                                placeholder="Your password *" required
                                style="height: 50px; border-radius: 8px; border: 1px solid #ddd; padding: 10px 15px; font-size: 14px;">
                            <small class="text-danger error-text d-none" id="err-password_login">Password is required</small>
                        </div>
                        <div class="mb-3 text-end">
                            <a href="javascript:void(0);" onclick="openForgotPasswordModal()"
                                style="font-size: 0.85rem; color: #3BB77E;">Forgot
                                Password?</a>
                        </div>
                        <div class="form-group">
                            <button type="submit" id="globalLoginBtn" class="btn btn-heading btn-block hover-up w-100"
                                style="height: 48px; border-radius: 8px; font-weight: 600; font-size: 15px;">
                                Log in
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Global Register Modal -->
    <div class="modal fade" id="globalRegisterModal" tabindex="-1" aria-labelledby="globalRegisterModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0" style="border-radius: 15px; box-shadow: 0 10px 40px rgba(0,0,0,0.15); background-color: #f8f9fa;">
                <div class="modal-header border-0 pb-0" style="padding: 25px 30px 0;">
                    <div>
                        <h4 class="modal-title fw-bold mb-1" id="globalRegisterModalLabel">Create an Account</h4>
                        <p class="text-muted font-sm mb-0">Already have an account? <a href="javascript:void(0);"
                                onclick="openLoginModal()" style="color: #3BB77E;">Login</a></p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 pt-3">
                    <form id="globalRegisterForm" onsubmit="return handleGlobalRegister(event)" novalidate>
                        <?php echo csrf_field(); ?>
                        <div class="form-group mb-3">
                            <input type="text" id="regUsername" class="form-control" placeholder="Username *" required
                                style="height: 45px; border-radius: 8px; border: 1px solid #ddd; padding: 10px 15px; font-size: 14px;">
                            <small class="text-danger error-text d-none" id="err-username">Username is required</small>
                        </div>
                        <div class="form-group mb-3">
                            <input type="email" id="regEmail" class="form-control" placeholder="Email *" required
                                style="height: 45px; border-radius: 8px; border: 1px solid #ddd; padding: 10px 15px; font-size: 14px;">
                            <small class="text-danger error-text d-none" id="err-email">Email is required</small>
                        </div>
                        <div class="row mb-3">
                            <div class="col-6">
                                <input type="password" id="regPassword" class="form-control" placeholder="Password *"
                                    required
                                    style="height: 45px; border-radius: 8px; border: 1px solid #ddd; padding: 10px 15px; font-size: 14px;">
                                <small class="text-danger error-text d-none" id="err-password">Password is required</small>
                            </div>
                            <div class="col-6">
                                <input type="password" id="regPasswordConfirm" class="form-control"
                                    placeholder="Confirm Password *" required
                                    style="height: 45px; border-radius: 8px; border: 1px solid #ddd; padding: 10px 15px; font-size: 14px;">
                                <small class="text-danger error-text d-none" id="err-password_confirmation">Confirmation is required</small>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <input type="tel" id="regMobile" class="form-control" placeholder="Mobile Number *" required
                                style="height: 45px; border-radius: 8px; border: 1px solid #ddd; padding: 10px 15px; font-size: 14px;">
                            <small class="text-danger error-text d-none" id="err-mobilenumber">Mobile number must be 10 digits</small>
                        </div>
                        <div class="form-group mb-3">
                            <div class="custome-checkbox">
                                <input class="form-check-input" type="checkbox" id="regAgree" required />
                                <label class="form-check-label" for="regAgree" style="font-size: 13px;">
                                    <span>I agree to terms & <a href="<?php echo e(route('pages.privacy-policy')); ?>"
                                            target="_blank" style="color: #3BB77E;">Policy.</a></span>
                                </label>
                            </div>
                            <small class="text-danger error-text d-none" id="err-agree">You must agree to the terms</small>
                        </div>
                        <div class="form-group">
                            <button type="submit" id="globalRegisterBtn"
                                class="btn btn-heading btn-block hover-up w-100"
                                style="height: 48px; border-radius: 8px; font-weight: 600; font-size: 15px;">
                                Register
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Global Forgot Password Modal -->
    <div class="modal fade" id="globalForgotPasswordModal" tabindex="-1" aria-labelledby="globalForgotPasswordLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0" style="border-radius: 15px; box-shadow: 0 10px 40px rgba(0,0,0,0.1);">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" id="globalForgotPasswordLabel">Forgot Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 pt-2">

                    <!-- Step 1: Send OTP -->
                    <div id="fpStep1">
                        <p class="text-muted mb-3 font-sm">Enter your email to receive an OTP.</p>
                        <form onsubmit="return handleSendOtp(event)" novalidate>
                            <div class="form-group mb-3">
                                <label class="fw-bold mb-1">Email</label>
                                <input type="text" id="fpLoginId" class="form-control" placeholder="Enter details..."
                                    required style="height: 45px; border-radius: 8px;">
                                <small class="text-danger error-text d-none" id="err-fp_login_id">Email is required</small>
                            </div>
                            <div class="d-grid">
                                <button type="submit" id="fpSendOtpBtn" class="btn btn-heading btn-block hover-up"
                                    style="border-radius: 8px;">Send OTP</button>
                            </div>
                        </form>
                        <div class="text-center mt-3">
                            <a href="javascript:void(0);" onclick="backToLoginModal()"
                                style="font-size: 0.85rem; color: #3BB77E;">
                                <i class="fi-rs-arrow-small-left"></i> Back to Login
                            </a>
                        </div>
                    </div>

                    <!-- Step 2: Verify OTP -->
                    <div id="fpStep2" style="display: none;">
                        <p class="text-muted mb-3 font-sm">We've sent an OTP to <strong id="fpSentTo"></strong>.</p>
                        <form onsubmit="return handleVerifyOtp(event)" novalidate>
                            <div class="form-group mb-3">
                                <label class="fw-bold mb-1">Enter OTP</label>
                                <input type="text" id="fpOtpInput" class="form-control" placeholder="6-digit code"
                                    required
                                    style="height: 45px; border-radius: 8px; letter-spacing: 2px; text-align: center; font-size: 1.2rem;">
                            </div>
                            <div class="d-grid">
                                <button type="submit" id="fpVerifyOtpBtn" class="btn btn-heading btn-block hover-up"
                                    style="border-radius: 8px;">Verify OTP</button>
                            </div>
                        </form>
                    </div>

                    <!-- Step 3: Reset Password -->
                    <div id="fpStep3" style="display: none;">
                        <p class="text-muted mb-3 font-sm">Set a new password for your account.</p>
                        <form onsubmit="return handleResetPassword(event)" novalidate>
                            <div class="form-group mb-3">
                                <label class="fw-bold mb-1">New Password</label>
                                <input type="password" id="fpNewPassword" class="form-control"
                                    placeholder="New password" required style="height: 45px; border-radius: 8px;">
                                <small class="text-danger error-text d-none" id="err-fp_password">Password is required</small>
                            </div>
                            <div class="form-group mb-3">
                                <label class="fw-bold mb-1">Confirm Password</label>
                                <input type="password" id="fpConfirmPassword" class="form-control"
                                    placeholder="Confirm password" required style="height: 45px; border-radius: 8px;">
                                <small class="text-danger error-text d-none" id="err-fp_password_confirmation"></small>
                                <span id="fpPasswordError" class="text-danger small mt-1 d-block"></span>
                            </div>
                            <div class="d-grid">
                                <button type="submit" id="fpResetBtn" class="btn btn-heading btn-block hover-up"
                                    style="border-radius: 8px;">Reset Password</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Global Login & Forgot Password Scripts -->
    <script>
        // ========== LOGIN MODAL ==========
        // Store scroll position for body lock
        var __savedScrollPos = 0;

        // Global listener to save scroll position before any modal opens
        document.addEventListener('show.bs.modal', function () {
            if (!document.querySelector('.modal.show')) {
                __savedScrollPos = window.pageYOffset || document.documentElement.scrollTop;
            }
        });

        function cleanupDuplicateBackdrops() {
            // Remove any stacked/duplicate modal backdrops
            var backdrops = document.querySelectorAll('.modal-backdrop');
            if (backdrops.length > 1) {
                for (var i = 1; i < backdrops.length; i++) {
                    backdrops[i].remove();
                }
            }
        }

        function openLoginModal() {
            var mobileWrapper = document.querySelector('.mobile-header-active');
            if (mobileWrapper && mobileWrapper.classList.contains('sidebar-visible')) {
                mobileWrapper.classList.remove('sidebar-visible');
            }
            // Close register modal if open
            var regModalEl = document.getElementById('globalRegisterModal');
            var regModal = bootstrap.Modal.getInstance(regModalEl);
            
            if (regModal && regModalEl.classList.contains('show')) {
                regModalEl.addEventListener('hidden.bs.modal', function() {
                    var loginModalEl = document.getElementById('globalLoginModal');
                    var loginModal = bootstrap.Modal.getInstance(loginModalEl) || new bootstrap.Modal(loginModalEl);
                    loginModal.show();
                    setTimeout(cleanupDuplicateBackdrops, 100);
                }, { once: true });
                regModal.hide();
            } else {
                var loginModalEl = document.getElementById('globalLoginModal');
                var loginModal = bootstrap.Modal.getInstance(loginModalEl) || new bootstrap.Modal(loginModalEl);
                loginModal.show();
                setTimeout(cleanupDuplicateBackdrops, 100);
            }
        }

        // Restore scroll position and clean up backdrops when any modal is hidden
        document.addEventListener('hidden.bs.modal', function() {
            // Delay to ensure Bootstrap has fully updated the body classes
            setTimeout(function() {
                if (!document.body.classList.contains('modal-open') && !document.querySelector('.modal.show')) {
                    // Force remove ALL remaining backdrops
                    document.querySelectorAll('.modal-backdrop').forEach(function(backdrop) {
                        backdrop.remove();
                    });
                    // Clean up body classes and styles
                    document.body.classList.remove('modal-open');
                    document.body.classList.remove('mobile-menu-active');
                    document.body.style.overflow = '';
                    document.body.style.paddingRight = '';
                    document.body.style.top = '';
                    document.body.style.position = '';
                    if (typeof __savedScrollPos !== 'undefined') {
                        window.scrollTo(0, __savedScrollPos);
                    }
                }
            }, 150);
        });

        // Global Toastr Options
        if (typeof toastr !== 'undefined') {
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "timeOut": "500",
                "extendedTimeOut": "500",
                "positionClass": "toast-top-right"
            };
        }

        // ========== REGISTER MODAL ==========

        // Real-time validation clear
        function setupRealTimeValidation(formId) {
            const form = document.getElementById(formId);
            if (!form) return;

            const inputs = form.querySelectorAll('input, select, textarea');
            
            function checkValue(input) {
                if (input.value.trim() || (input.type === 'checkbox' && input.checked)) {
                    input.classList.remove('is-invalid');
                    input.classList.add('is-valid');
                } else if (input.hasAttribute('required')) {
                    input.classList.remove('is-valid');
                } else {
                    input.classList.remove('is-valid');
                }
            }

            inputs.forEach(input => {
                // Check initial value
                checkValue(input);

                input.addEventListener('input', function() {
                    checkValue(this);
                    // Find associated error message and hide it
                    let errorId = '';
                    if (this.id === 'regUsername') errorId = 'err-username';
                    else if (this.id === 'regEmail') errorId = 'err-email';
                    else if (this.id === 'regPassword') errorId = 'err-password';
                    else if (this.id === 'regPasswordConfirm') errorId = 'err-password_confirmation';
                    else if (this.id === 'regMobile') errorId = 'err-mobilenumber';
                    else if (this.id === 'globalLoginId') errorId = 'err-login_id';
                    else if (this.id === 'globalLoginPassword') errorId = 'err-password_login';
                    else if (this.id === 'fpLoginId') errorId = 'err-fp_login_id';
                    else if (this.id === 'fpNewPassword') errorId = 'err-fp_password';
                    else if (this.id === 'fpConfirmPassword') {
                        errorId = 'err-fp_password_confirmation';
                        const fpErr = document.getElementById('fpPasswordError');
                        if (fpErr) fpErr.textContent = '';
                    }

                    if (errorId) {
                        const errorMsg = document.getElementById(errorId);
                        if (errorMsg) errorMsg.classList.add('d-none');
                    }
                });

                input.addEventListener('change', function() {
                    if (this.type === 'checkbox' && this.checked) {
                        this.classList.remove('is-invalid');
                        this.classList.add('is-valid');
                        const errorMsg = document.getElementById('err-agree');
                        if (errorMsg) errorMsg.classList.add('d-none');
                    } else if (this.type === 'checkbox') {
                        this.classList.remove('is-valid');
                    }
                });
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            setupRealTimeValidation('globalLoginForm');
            setupRealTimeValidation('globalRegisterForm');
            setupRealTimeValidation('fpStep1');
            setupRealTimeValidation('fpStep2');
            setupRealTimeValidation('fpStep3');
        });

        function openRegisterModal() {
            var mobileWrapper = document.querySelector('.mobile-header-active');
            if (mobileWrapper && mobileWrapper.classList.contains('sidebar-visible')) {
                mobileWrapper.classList.remove('sidebar-visible');
            }
            // Close login modal if open
            var loginModalEl = document.getElementById('globalLoginModal');
            var loginModal = bootstrap.Modal.getInstance(loginModalEl);

            if (loginModal && loginModalEl.classList.contains('show')) {
                loginModalEl.addEventListener('hidden.bs.modal', function() {
                    var regModalEl = document.getElementById('globalRegisterModal');
                    var regModal = bootstrap.Modal.getInstance(regModalEl) || new bootstrap.Modal(regModalEl);
                    regModal.show();
                    setTimeout(cleanupDuplicateBackdrops, 100);
                }, { once: true });
                loginModal.hide();
            } else {
                var regModalEl = document.getElementById('globalRegisterModal');
                var regModal = bootstrap.Modal.getInstance(regModalEl) || new bootstrap.Modal(regModalEl);
                regModal.show();
                setTimeout(cleanupDuplicateBackdrops, 100);
            }
        }

        function handleGlobalRegister(e) {
            e.preventDefault();
            var username = document.getElementById('regUsername').value.trim();
            var email = document.getElementById('regEmail').value.trim();
            var password = document.getElementById('regPassword').value;
            var passwordConfirm = document.getElementById('regPasswordConfirm').value;
            var mobile = document.getElementById('regMobile').value.trim();
            var regBtn = document.getElementById('globalRegisterBtn');
            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Client-side validation (Immediate red text)
            let valid = true;
            function check(id, errorId, condition) {
                let input = document.getElementById(id);
                let error = document.getElementById(errorId);
                if (!input) return;
                
                let isInvalid = false;
                if (id === 'regAgree') {
                    isInvalid = !input.checked;
                } else if (condition !== undefined) {
                    isInvalid = condition;
                } else {
                    isInvalid = !input.value.trim();
                }

                if (isInvalid) {
                    error.classList.remove('d-none');
                    input.classList.add('is-invalid');
                    input.classList.remove('is-valid');
                    valid = false;
                } else {
                    error.classList.add('d-none');
                    input.classList.remove('is-invalid');
                    if (input.value.trim() || (input.type === 'checkbox' && input.checked)) {
                        input.classList.add('is-valid');
                    }
                }
            }

            // Reset specific errors before checking
            document.querySelectorAll('#globalRegisterForm .form-control').forEach(function(el) { 
                el.classList.remove('is-invalid');
                el.classList.remove('is-valid');
            });

            check('regUsername', 'err-username');
            check('regEmail', 'err-email');
            check('regPassword', 'err-password');
            const passVal = document.getElementById('regPassword').value;
            const confirmVal = document.getElementById('regPasswordConfirm').value;
            const passMatchErr = (confirmVal !== passVal) || !confirmVal.trim();
            
            check('regPasswordConfirm', 'err-password_confirmation', passMatchErr);
            if (passMatchErr) {
                if (confirmVal !== passVal && confirmVal.trim() && passVal.trim()) {
                    document.getElementById('err-password_confirmation').textContent = 'Passwords do not match';
                } else if (!confirmVal.trim()) {
                    document.getElementById('err-password_confirmation').textContent = 'Confirm password is required';
                }
                document.getElementById('err-password_confirmation').classList.remove('d-none');
                document.getElementById('regPasswordConfirm').classList.add('is-invalid');
                document.getElementById('regPasswordConfirm').classList.remove('is-valid');
            }
            check('regMobile', 'err-mobilenumber', document.getElementById('regMobile').value.length !== 10);
            check('regAgree', 'err-agree');

            if (!valid) return false;

            regBtn.disabled = true;
            regBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Registering...';

            fetch('<?php echo e(route("store")); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    username: username,
                    email: email,
                    password: password,
                    password_confirmation: passwordConfirm,
                    mobilenumber: mobile,
                    agree: true
                })
            })
                .then(function (response) {
                    return response.json().then(function (data) {
                        return { status: response.status, data: data };
                    }).catch(function () {
                        // If not JSON, it might be a redirect (success)
                        if (response.ok || response.redirected) {
                            return { status: 200, data: { success: true } };
                        }
                        return { status: response.status, data: { message: 'Registration failed' } };
                    });
                })
                .then(function (result) {
                    if (result.status === 200 || result.status === 201 || (result.data && result.data.success)) {
                        if (typeof toastr !== 'undefined') toastr.success('Account created successfully! Logging you in...');
                        setTimeout(function () { window.location.reload(); }, 1000);
                    } else if (result.status === 422 && result.data.errors) {
                        var errors = result.data.errors;
                        // Display field-specific errors from server
                        for (var field in errors) {
                            var errorMsg = Array.isArray(errors[field]) ? errors[field][0] : errors[field];
                            var errSpan = document.getElementById('err-' + field);
                            if (errSpan) {
                                errSpan.textContent = errorMsg;
                                errSpan.classList.remove('d-none');
                            }
                            // Highlight field
                            var input = null;
                            if (field === 'mobilenumber') input = document.getElementById('regMobile');
                            if (field === 'username') input = document.getElementById('regUsername');
                            if (field === 'email') input = document.getElementById('regEmail');
                            if (field === 'password') input = document.getElementById('regPassword');
                            if (field === 'password_confirmation') input = document.getElementById('regPasswordConfirm');
                            
                            if (input) input.classList.add('is-invalid');
                        }
                        if (typeof toastr !== 'undefined') toastr.error('Please correct the highlighted errors');
                        regBtn.disabled = false;
                        regBtn.innerHTML = 'Register';
                    } else {
                        if (typeof toastr !== 'undefined') toastr.error(result.data.message || 'Registration failed');
                        regBtn.disabled = false;
                        regBtn.innerHTML = 'Register';
                    }
                })
                .catch(function (error) {
                    console.error('Register error:', error);
                    if (typeof toastr !== 'undefined') toastr.error('Something went wrong. Please try again.');
                    regBtn.disabled = false;
                    regBtn.innerHTML = 'Register';
                });
            return false;
        }

        function handleGlobalLogin(e) {
            e.preventDefault();
            var loginId = document.getElementById('globalLoginId').value.trim();
            var password = document.getElementById('globalLoginPassword').value.trim();
            var loginBtn = document.getElementById('globalLoginBtn');
            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Clear previous errors
            document.querySelectorAll('.error-text').forEach(function(el) { el.classList.add('d-none'); });
            document.querySelectorAll('#globalLoginForm .form-control').forEach(function(el) { el.classList.remove('is-invalid'); });

            let valid = true;
            if (!loginId) {
                document.getElementById('err-login_id').classList.remove('d-none');
                document.getElementById('globalLoginId').classList.add('is-invalid');
                document.getElementById('globalLoginId').classList.remove('is-valid');
                valid = false;
            }
            if (!password) {
                document.getElementById('err-password_login').classList.remove('d-none');
                document.getElementById('globalLoginPassword').classList.add('is-invalid');
                document.getElementById('globalLoginPassword').classList.remove('is-valid');
                valid = false;
            }

            if (!valid) return false;

            loginBtn.disabled = true;
            loginBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Logging in...';

            fetch('<?php echo e(route("checkout.login")); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ login_id: loginId, password: password })
            })
                .then(function (response) {
                    return response.json().then(function (data) {
                        return { status: response.status, data: data };
                    });
                })
                .then(function (result) {
                    if (result.data.success) {
                        if (typeof toastr !== 'undefined') toastr.success('Login successful! Refreshing...');
                        setTimeout(function () { window.location.reload(); }, 800);
                    } else {
                        if (typeof toastr !== 'undefined') toastr.error(result.data.message || 'Invalid login credentials');
                        loginBtn.disabled = false;
                        loginBtn.innerHTML = 'Log in';
                        // Clean up any duplicate backdrops that may have stacked
                        cleanupDuplicateBackdrops();
                    }
                })
                .catch(function (error) {
                    console.error('Login error:', error);
                    if (typeof toastr !== 'undefined') toastr.error('Something went wrong. Please try again.');
                    loginBtn.disabled = false;
                    loginBtn.innerHTML = 'Log in';
                    // Clean up any duplicate backdrops that may have stacked
                    cleanupDuplicateBackdrops();
                });
            return false;
        }

        // ========== FORGOT PASSWORD MODAL ==========
        var fpStoredLoginId = '';

        function openForgotPasswordModal() {
            // Close login modal first
            var loginModalEl = document.getElementById('globalLoginModal');
            var loginModal = bootstrap.Modal.getInstance(loginModalEl);
            if (loginModal) loginModal.hide();

            // Reset to step 1
            document.getElementById('fpStep1').style.display = 'block';
            document.getElementById('fpStep2').style.display = 'none';
            document.getElementById('fpStep3').style.display = 'none';
            document.getElementById('fpLoginId').value = '';
            fpStoredLoginId = '';

            // Wait for login modal to close, then open forgot password modal
            setTimeout(function () {
                var fpModalEl = document.getElementById('globalForgotPasswordModal');
                var fpModal = bootstrap.Modal.getInstance(fpModalEl) || new bootstrap.Modal(fpModalEl);
                fpModal.show();
                setTimeout(cleanupDuplicateBackdrops, 100);
            }, 300);
        }

        function backToLoginModal() {
            var fpModalEl = document.getElementById('globalForgotPasswordModal');
            var fpModal = bootstrap.Modal.getInstance(fpModalEl);
            if (fpModal) fpModal.hide();

            setTimeout(function () {
                openLoginModal();
            }, 300);
        }

        // Step 1: Send OTP
        function handleSendOtp(e) {
            e.preventDefault();
            var loginId = document.getElementById('fpLoginId').value.trim();
            var btn = document.getElementById('fpSendOtpBtn');
            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Clear errors
            document.getElementById('err-fp_login_id').classList.add('d-none');
            document.getElementById('fpLoginId').classList.remove('is-invalid');
            document.getElementById('fpLoginId').classList.remove('is-valid');

            if (!loginId) {
                document.getElementById('err-fp_login_id').classList.remove('d-none');
                document.getElementById('fpLoginId').classList.add('is-invalid');
                document.getElementById('fpLoginId').classList.remove('is-valid');
                return false;
            }

            btn.disabled = true;
            btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Sending OTP...';

            fetch('<?php echo e(route("sendotp")); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ login_id: loginId })
            })
                .then(function (response) {
                    return response.json().then(function (data) {
                        return { status: response.status, data: data };
                    });
                })
                .then(function (result) {
                    btn.disabled = false;
                    btn.innerHTML = 'Send OTP';
                    if (result.data.success) {
                        fpStoredLoginId = result.data.login_id || loginId;
                        document.getElementById('fpSentTo').textContent = fpStoredLoginId;
                        document.getElementById('fpStep1').style.display = 'none';
                        document.getElementById('fpStep2').style.display = 'block';
                        if (typeof toastr !== 'undefined') toastr.success(result.data.message || 'OTP sent!');
                    } else {
                        if (typeof toastr !== 'undefined') toastr.error(result.data.message || 'User not found');
                    }
                })
                .catch(function (error) {
                    console.error('Send OTP error:', error);
                    btn.disabled = false;
                    btn.innerHTML = 'Send OTP';
                    if (typeof toastr !== 'undefined') toastr.error('Failed to send OTP. Please try again.');
                });
            return false;
        }

        // Step 2: Verify OTP
        function handleVerifyOtp(e) {
            e.preventDefault();
            var otp = document.getElementById('fpOtpInput').value.trim();
            var btn = document.getElementById('fpVerifyOtpBtn');
            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            if (!otp) {
                if (typeof toastr !== 'undefined') toastr.warning('Please enter the OTP');
                document.getElementById('fpOtpInput').classList.add('is-invalid');
                document.getElementById('fpOtpInput').classList.remove('is-valid');
                return false;
            }

            btn.disabled = true;
            btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Verifying...';

            fetch('<?php echo e(route("verifyotp")); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ login_id: fpStoredLoginId, otp: otp })
            })
                .then(function (response) {
                    return response.json().then(function (data) {
                        return { status: response.status, data: data };
                    });
                })
                .then(function (result) {
                    btn.disabled = false;
                    btn.innerHTML = 'Verify OTP';
                    if (result.data.success) {
                        document.getElementById('fpStep2').style.display = 'none';
                        document.getElementById('fpStep3').style.display = 'block';
                        if (typeof toastr !== 'undefined') toastr.success(result.data.message || 'OTP verified!');
                    } else {
                        if (typeof toastr !== 'undefined') toastr.error(result.data.message || 'Incorrect OTP');
                        document.getElementById('fpOtpInput').classList.add('is-invalid');
                        document.getElementById('fpOtpInput').classList.remove('is-valid');
                    }
                })
                .catch(function (error) {
                    console.error('Verify OTP error:', error);
                    btn.disabled = false;
                    btn.innerHTML = 'Verify OTP';
                    if (typeof toastr !== 'undefined') toastr.error('Verification failed. Please try again.');
                });
            return false;
        }

        // Step 3: Reset Password
        function handleResetPassword(e) {
            e.preventDefault();
            var newPass = document.getElementById('fpNewPassword').value;
            var confirmPass = document.getElementById('fpConfirmPassword').value;
            var errorSpan = document.getElementById('fpPasswordError');
            var btn = document.getElementById('fpResetBtn');
            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            errorSpan.textContent = '';

            if (newPass.length < 6) {
                errorSpan.textContent = 'Password must be at least 6 characters.';
                document.getElementById('fpNewPassword').classList.add('is-invalid');
                document.getElementById('fpNewPassword').classList.remove('is-valid');
                return false;
            }
            if (newPass !== confirmPass) {
                errorSpan.textContent = 'Passwords do not match!';
                document.getElementById('fpNewPassword').classList.add('is-invalid');
                document.getElementById('fpNewPassword').classList.remove('is-valid');
                document.getElementById('fpConfirmPassword').classList.add('is-invalid');
                document.getElementById('fpConfirmPassword').classList.remove('is-valid');
                return false;
            }

            btn.disabled = true;
            btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Resetting...';

            fetch('<?php echo e(route("resetpassword")); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    login_id: fpStoredLoginId,
                    password: newPass,
                    password_confirmation: confirmPass
                })
            })
                .then(function (response) {
                    return response.json().then(function (data) {
                        return { status: response.status, data: data };
                    });
                })
                .then(function (result) {
                    btn.disabled = false;
                    btn.innerHTML = 'Reset Password';
                    if (result.data.success) {
                        if (typeof toastr !== 'undefined') toastr.success(result.data.message || 'Password changed successfully!');
                        // Close forgot password modal and open login modal
                        var fpModalEl = document.getElementById('globalForgotPasswordModal');
                        var fpModal = bootstrap.Modal.getInstance(fpModalEl);
                        if (fpModal) fpModal.hide();
                        setTimeout(function () { openLoginModal(); }, 500);
                    } else {
                        if (typeof toastr !== 'undefined') toastr.error(result.data.message || 'Failed to reset password');
                    }
                })
                .catch(function (error) {
                    console.error('Reset password error:', error);
                    btn.disabled = false;
                    btn.innerHTML = 'Reset Password';
                    if (typeof toastr !== 'undefined') toastr.error('Failed to reset password. Please try again.');
                });
            return false;
        }
    </script>


    <!-- WhatsApp Floating Icon -->
    <a href="https://wa.me/919094676665" class="whatsapp-floating-icon" target="_blank" rel="noopener noreferrer">
        <i class="fab fa-whatsapp"></i>
    </a>
    <style>
        .whatsapp-floating-icon {
            position: fixed;
            bottom: 80px; /* Positioned slightly higher to not overlap with standard scroll-to-top */
            right: 30px;
            width: 50px;
            height: 50px;
            background-color: #25d366;
            color: white;
            border-radius: 50%;
            text-align: center;
            font-size: 30px;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .whatsapp-floating-icon:hover {
            background-color: #128c7e;
            color: white;
            transform: scale(1.1);
        }
        
        @media (max-width: 768px) {
            .whatsapp-floating-icon {
                bottom: 20px;
                right: 20px;
                width: 45px;
                height: 45px;
                font-size: 26px;
            }
        }
    </style>

    <?php echo $__env->yieldPushContent('scripts'); ?>

</body>

</html><?php /**PATH C:\xampp\htdocs\chennais\frontend\resources\views/layouts/app.blade.php ENDPATH**/ ?>