

<?php $__env->startSection('seo_title', $product->seo_title ?: ($product->productname . ' - ' . config('app.name'))); ?>
<?php $__env->startSection('seo_description', $product->seo_description ?: ''); ?>
<?php $__env->startSection('seo_keywords', is_array($product->seo_keywords) ? implode(', ', $product->seo_keywords) : ($product->seo_keywords ?: '')); ?>
<?php $__env->startSection('og_title', $product->seo_title ?: ($product->productname . ' - ' . config('app.name'))); ?>
<?php $__env->startSection('og_description', $product->seo_description ?: ''); ?>
<?php $__env->startSection('content'); ?>
    <style>
        .rating {
            display: flex;
            flex-direction: row-reverse;
        }

        .rating input {
            display: none;
        }

        .rating label {
            font-size: 30px;
            color: #ddd;
            cursor: pointer;
        }

        .rating input:checked~label {
            color: gold;
        }

        .rating label:hover,
        .rating label:hover~label {
            color: gold;
        }

        .single-comment .d-flex.justify-content-between {
            align-items: center;
            gap: 10px;
        }

        .product-rate i {
            color: #f6a500 !important;
            font-size: 14px;
        }

        .single-comment .thumb a {
            display: block;
            font-weight: 600;
            margin-bottom: 5px;
        }

        /* 🟩 THUMBNAIL SLIDER - MAX 4 VISIBLE, NO SCROLLBAR, SIDE ARROWS */
        .custom-thumbnails-wrapper {
            position: relative;
            /* Max width: 4 thumbnails (80px each) + 3 gaps (10px) + padding for arrows */
            max-width: 390px;
            margin: 0 auto;
            padding: 0 45px;
            /* Space for side arrows */
        }

        .custom-thumbnails-container {
            display: flex;
            gap: 10px;
            overflow-x: hidden;
            /* HIDE horizontal scroll - only arrows navigate */
            overflow-y: hidden;
            padding: 10px 0;
            scroll-behavior: smooth;
            /* COMPLETELY HIDE SCROLLBAR */
            scrollbar-width: none;
            /* Firefox */
            -ms-overflow-style: none;
            /* IE/Edge */
        }

        /* COMPLETELY HIDE SCROLLBAR - All browsers */
        .custom-thumbnails-container::-webkit-scrollbar {
            display: none;
            width: 0;
            height: 0;
        }

        /* UNIFORM THUMBNAIL SIZING - 80px for 4 visible thumbnails */
        .thumbnail-item {
            width: 80px;
            height: 80px;
            min-width: 80px;
            min-height: 80px;
            flex-shrink: 0;
            /* Prevent shrinking */
            border: 2px solid #ddd;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            overflow: hidden;
            background: #f5f5f5;
        }

        .thumbnail-item.active {
            border-color: #3BB77E;
            box-shadow: 0 0 8px rgba(59, 183, 126, 0.4);
        }

        .thumbnail-item:hover {
            border-color: #3BB77E;
            transform: scale(1.05);
        }

        .thumbnail-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        /* NAVIGATION ARROWS - ONLY on sides of thumbnail row */
        .slider-nav-prev,
        .slider-nav-next {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(59, 183, 126, 0.9);
            color: white;
            border: none;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            z-index: 10;
            font-size: 18px;
        }

        .slider-nav-prev:hover,
        .slider-nav-next:hover {
            background: rgba(59, 183, 126, 1);
            transform: translateY(-50%) scale(1.1);
        }

        .slider-nav-prev {
            left: 0;
        }

        .slider-nav-next {
            right: 0;
        }

        /* Main product image container - stable dimensions - NO SLICK */
        .custom-main-image-container {
            max-width: 500px;
            margin: 0 auto;
            min-height: 500px;
            background: #fff;
        }

        .custom-main-image-container figure {
            min-height: 500px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fff;
        }

        #main-product-image {
            width: 500px !important;
            height: 500px !important;
            object-fit: cover !important;
            display: block !important;
        }

        @media (max-width: 768px) {
            .custom-main-image-container {
                max-width: 100% !important;
                min-height: auto !important;
            }
            .custom-main-image-container figure {
                min-height: auto !important;
            }
            #main-product-image {
                width: 100% !important;
                height: auto !important;
                aspect-ratio: 1 / 1 !important;
            }
        }


        /* 🟩 GREEN QUANTITY SELECTOR STYLING */
        .detail-extralink .detail-qty {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            background: #fff !important;
            border: 2px solid #3BB77E !important;
            border-radius: 5px !important;
            padding: 0 !important;
            max-width: 120px !important;
            min-width: 100px !important;
            height: 50px !important;
            position: relative !important;
        }

        .detail-extralink .detail-qty .qty-val {
            width: 50px !important;
            text-align: center !important;
            border: none !important;
            background: transparent !important;
            font-size: 16px !important;
            font-weight: 700 !important;
            color: #3BB77E !important;
            -moz-appearance: textfield !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        .detail-extralink .detail-qty .qty-val::-webkit-outer-spin-button,
        .detail-extralink .detail-qty .qty-val::-webkit-inner-spin-button {
            -webkit-appearance: none !important;
            margin: 0 !important;
        }

        .detail-extralink .detail-qty a.qty-up,
        .detail-extralink .detail-qty a.qty-down {
            position: absolute !important;
            right: 5px !important;
            width: 24px !important;
            height: 20px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            color: #3BB77E !important;
            font-size: 14px !important;
            cursor: pointer !important;
            transition: all 0.2s ease !important;
        }

        .detail-extralink .detail-qty a.qty-up {
            top: 2px !important;
            bottom: auto !important;
        }

        .detail-extralink .detail-qty a.qty-down {
            bottom: 2px !important;
            top: auto !important;
        }

        .detail-extralink .detail-qty a.qty-up:hover,
        .detail-extralink .detail-qty a.qty-down:hover {
            color: #29A56C !important;
            transform: scale(1.2) !important;
        }

        .detail-extralink .detail-qty a.qty-up i,
        .detail-extralink .detail-qty a.qty-down i {
            font-size: 14px !important;
            color: inherit !important;
        }

        /* 🔥 ALL IN ONE ROW - Quantity + Add to Cart + Wishlist */
        .detail-extralink {
            display: flex !important;
            flex-wrap: nowrap !important;
            align-items: center !important;
            gap: 10px !important;
        }

        .detail-extralink>div {
            margin-bottom: 0 !important;
        }

        .detail-extralink .detail-qty {
            margin: 0 !important;
            margin-right: 10px !important;
        }

        .detail-extralink .product-extra-link2 {
            display: flex !important;
            flex-wrap: nowrap !important;
            align-items: center !important;
            gap: 10px !important;
        }

        .detail-extralink .product-extra-link2 .button-add-to-cart {
            margin: 0 !important;
            white-space: nowrap !important;
        }

        .detail-extralink .product-extra-link2 .action-btn {
            margin: 0 !important;
        }

        /* Product img action wrap needs relative positioning for icons */
        .custom-main-image-container {
            position: relative;
            display: inline-block;
        }

        .custom-main-image-container figure {
            position: relative;
            margin: 0;
            padding: 0;
            display: inline-block;
        }

        .detail-gallery {
            position: relative;
        }

        /* Product Action Icons - Centered on Image like Homepage */
        .custom-main-image-container .product-action-1 {
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

        .related-products .product-img-action-wrap .product-action-1 {
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

        .custom-main-image-container:hover .product-action-1,
        .related-products .product-img-action-wrap:hover .product-action-1 {
            opacity: 1;
            visibility: visible;
        }

        .custom-main-image-container .product-action-1 .action-btn,
        .related-products .product-action-1 .action-btn {
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

        .custom-main-image-container .product-action-1 .action-btn:hover,
        .related-products .product-action-1 .action-btn:hover {
            background: #3BB77E;
            border-color: #3BB77E;
            color: #fff;
        }

        .custom-main-image-container .product-action-1 .action-btn.active,
        .custom-main-image-container .product-action-1 .action-btn.active i,
        .related-products .product-action-1 .action-btn.active,
        .related-products .product-action-1 .action-btn.active i {
            color: #ff0000 !important;
        }

        .custom-main-image-container .product-action-1 .action-btn i,
        .related-products .product-action-1 .action-btn i {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 100% !important;
            height: 100% !important;
            font-size: 16px !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        /* Related products action wrap positioning */
        .related-products .product-img-action-wrap {
            position: relative;
        }

        /* Shop alignment styles applied ONLY to Related Products */
        .related-products .product-cart-wrap .product-price,
        .related-products .product-cart-wrap .product-card-bottom .product-price {
            text-align: center !important;
        }

        .related-products .product-cart-wrap {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .related-products .product-content-wrap {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            gap: 0;
        }

        .related-products .product-content-wrap h2 {
            margin-bottom: 4px;
            text-align: center;
        }

        .related-products .product-card-bottom {
            padding-top: 0;
        }
        
        @media (max-width: 575px) {
            .related-products .col-6.pe-1, 
            .related-products .col-6.ps-1 {
                flex: 0 0 50%;
                max-width: 50%;
            }
        }

        /* Out of stock styling */
        .product-out-of-stock {
            opacity: 0.7;
            filter: grayscale(0.4);
            transition: all 0.4s ease;
        }

        .product-out-of-stock img {
            filter: grayscale(1);
            opacity: 0.8;
        }

        /* Mobile Overlay box perfect square override */
        @media (max-width: 768px) {
            .custom-main-image-container .product-action-1,
            .related-products .product-img-action-wrap .product-action-1,
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
            .custom-main-image-container .product-action-1 .action-btn,
            .related-products .product-action-1 .action-btn {
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
            .custom-main-image-container .product-action-1 .action-btn i,
            .related-products .product-action-1 .action-btn i {
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
            .custom-main-image-container .product-action-1 .quick-view-btn,
            .related-products .product-action-1 .quick-view-btn {
                display: none !important;
            }
        }

        /* Mobile View (≤575px) compact wish button */
        @media (max-width: 575px) {
            .product-action-1 .action-btn,
            .custom-main-image-container .product-action-1 .action-btn,
            .related-products .product-action-1 .action-btn {
                width: 28px !important;
                height: 28px !important;
                border-radius: 4px !important;
            }

            .product-action-1 .action-btn i,
            .custom-main-image-container .product-action-1 .action-btn i,
            .related-products .product-action-1 .action-btn i {
                font-size: 12px !important;
                line-height: 28px !important;
            }
        }
    </style>
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="<?php echo e(route('index')); ?>" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                    <?php if($product->category): ?>
                        <span></span>
                        <a href="<?php echo e(route('category.products', $product->category->id)); ?>"><?php echo e($product->category->name); ?></a>
                    <?php endif; ?>
                    <span></span> <?php echo e($product->productname); ?>

                </div>
            </div>
        </div>
        <div class="container my-3">
            <div class="row">
                        <div class="col-lg-12">
                            <div class="product-detail accordion-detail">
                                <div class="row">
                                    <div class="col-md-4 col-sm-12 col-xs-12 mb-md-0 mb-sm-5">
                                        <div class="detail-gallery">
                                            <!-- <span class="zoom-icon"><i class="fi-rs-search"></i></span> -->

                                            <!-- DECODE & PROCESS IMAGES IN BLADE -->
                                            <?php
                                                // productimage is already cast as array in the Product model
                                                $images = $product->productimage;

                                                // Ensure it's an array
                                                if (!is_array($images)) {
                                                    $images = [];
                                                }

                                                // Fix Windows backslashes to forward slashes
                                                $images = array_map(function ($img) {
                                                    $img = str_replace('\\', '/', $img);
                                                    // Remove duplicate 'uploads/' prefix (since ADMIN_ASSET_URL already has /uploads)
                                                    if (strpos($img, 'uploads/') === 0) {
                                                        $img = substr($img, 8);
                                                    }
                                                    return $img;
                                                }, $images);

                                                // Get primary image (first one)
                                                $primaryImage = $images[0] ?? null;
                                                $allImages = $images; // All images for thumbnails
                                            ?>

                                            <?php
                                                // Get stock count: use first variant's stock for variable products, or product stock for simple products
                                                $displayStock = 0;
                                                if ($isVariableProduct && $productVariants->count() > 0) {
                                                    $displayStock = $productVariants->first()->stock ?? 0;
                                                } else {
                                                    $displayStock = $product->stock ?? 0;
                                                }
                                            ?>
                                            <!-- MAIN PRODUCT IMAGE - NO SLICK -->
                                            <div class="custom-main-image-container d-flex justify-content-center">
                                                <figure class="border-radius-10">
                                                    <?php if($primaryImage): ?>
                                                        <img id="main-product-image"
                                                            src="<?php echo e(env('ADMIN_ASSET_URL')); ?>/<?php echo e($primaryImage); ?>"
                                                            alt="<?php echo e($product->productname); ?>"
                                                            style=""
                                                            onerror="this.src='<?php echo e(asset('assets/imgs/theme/icons/category-1.svg')); ?>'">
                                                    <?php else: ?>
                                                        <img id="main-product-image"
                                                            src="<?php echo e(asset('assets/imgs/theme/icons/category-1.svg')); ?>"
                                                            alt="<?php echo e($product->productname); ?>"
                                                            style="">
                                                    <?php endif; ?>
                                                    <div class="product-action-1" style="<?php echo e($displayStock <= 0 ? 'display: none !important;' : ''); ?>">
                                                        <?php
                                                            $isMainInWishlist = auth('customer')->check() && auth('customer')->user()->wishlist()->where('product_id', $product->id)->exists();
                                                        ?>
                                                        <a aria-label="Add To Wishlist"
                                                            class="action-btn add-to-wishlist <?php echo e($isMainInWishlist ? 'active' : ''); ?>"
                                                            data-id="<?php echo e($product->id); ?>" href="javascript:void(0)">
                                                            <i class="fi-rs-heart"></i>
                                                        </a>
                                                        <a aria-label="Quick view" class="action-btn quick-view-btn"
                                                            href="javascript:void(0)" data-product-id="<?php echo e($product->id); ?>">
                                                            <i class="fi-rs-eye"></i>
                                                        </a>
                                                    </div>
                                                    
                                                </figure>
                                            </div>

                                            <!-- THUMBNAIL SLIDER - NO SLICK - CUSTOM IMPLEMENTATION -->
                                            <?php if(count($allImages) > 0): ?>
                                                <div class="custom-thumbnails-wrapper mt-15">
                                                    <div class="custom-thumbnails-container" id="thumbnail-slider">
                                                        <?php $__currentLoopData = $allImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idx => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <div class="thumbnail-item <?php echo e($idx === 0 ? 'active' : ''); ?>"
                                                                data-index="<?php echo e($idx); ?>"
                                                                data-src="<?php echo e(env('ADMIN_ASSET_URL')); ?>/<?php echo e($image); ?>">
                                                                <img src="<?php echo e(env('ADMIN_ASSET_URL')); ?>/<?php echo e($image); ?>"
                                                                    alt="<?php echo e($product->productname); ?> - Image <?php echo e($idx + 1); ?>"
                                                                    class="thumbnail-image"
                                                                    onerror="this.src='<?php echo e(asset('assets/imgs/theme/icons/category-1.svg')); ?>'">
                                                            </div>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </div>
                                                    <button class="slider-nav-prev" id="slider-prev-btn"
                                                        aria-label="Previous image" type="button">
                                                        <i class="fi-rs-arrow-small-left"></i>
                                                    </button>
                                                    <button class="slider-nav-next" id="slider-next-btn" aria-label="Next image"
                                                        type="button">
                                                        <i class="fi-rs-arrow-small-right"></i>
                                                    </button>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-sm-12 col-xs-12">
                                        <div class="detail-info pr-30 pl-30 <?php echo e($displayStock <= 0 ? 'product-out-of-stock' : ''); ?>" id="main-product-info">
                                            <span class="stock-status out-stock">Sale Off</span>
                                            <h3 class="title-detail"><?php echo e($product->productname); ?></h3>
                                            <div class="clearfix product-price-cover">
                                                <div class="product-price primary-color float-left my-3">
                                                    <span class="current-price text-brand"
                                                        id="main-product-price">₹<?php echo e(number_format($displayPrice, 0)); ?></span>
                                                    <?php if(isset($displayMrpPrice) && $displayMrpPrice && $displayMrpPrice > $displayPrice): ?>
                                                        <span class="old-price" id="main-product-mrp"
                                                            style="text-decoration: line-through;">₹<?php echo e(number_format($displayMrpPrice, 0)); ?></span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>

                                            <div class="short-desc mb-3">
                                                <p class="font-lg">
                                                    <?php echo e($product->short_description ?? $product->description); ?>

                                                </p>
                                            </div>

                                            
                                            <?php if($isVariableProduct && $productVariants->count() > 0): ?>
                                                <?php
                                                    // Get offer info for calculating variant-specific offer prices
                                                    $hasOffer = isset($activeOffer) && $activeOffer !== null;
                                                    $discountType = $hasOffer ? $activeOffer->discount_type : null;
                                                    $discountValue = $hasOffer ? $activeOffer->discount_value : 0;
                                                ?>
                                                <div class="attr-detail attr-size mb-30" id="weight-selector">
                                                    <strong class="mr-10">Size / Weight:</strong>
                                                    <select class="form-control" id="variant-dropdown"
                                                        style="text-align: center; text-align-last: center; max-width: 220px; display: inline-block; appearance: none; -webkit-appearance: none; -moz-appearance: none; background-image: url('data:image/svg+xml;charset=UTF-8,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22%233BB77E%22%3E%3Cpath d=%22M7 10l5 5 5-5z%22/%3E%3C/svg%3E'); background-repeat: no-repeat; background-position: right 12px center; background-size: 20px; padding-right: 40px; cursor: pointer; border: 1px solid #BCE3C9; border-radius: 5px; height: 45px; font-size: 18px;">
                                                        <?php $__currentLoopData = $productVariants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $variant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php
                                                                // Calculate offer price for this variant
                                                                $variantMrp = $variant->price ?? 0;
                                                                $variantSellPrice = $variant->sell_price ?? $variant->price;
                                                                $variantOfferPrice = $variantSellPrice; // Default to sell price

                                                                if ($hasOffer && $variantSellPrice > 0) {
                                                                    if ($discountType === 'percentage') {
                                                                        $discount = ($variantSellPrice * $discountValue) / 100;
                                                                    } else {
                                                                        $discount = $discountValue;
                                                                    }
                                                                    $variantOfferPrice = max(0, round($variantSellPrice - $discount, 2));
                                                                }

                                                                // Determine display price
                                                                $displayPrice = $hasOffer ? $variantOfferPrice : $variantSellPrice;
                                                                $quantityLabel = $variant->quantity->name ?? $variant->quantity->label;
                                                            ?>
                                                            <option value="<?php echo e($variant->id); ?>" data-variant-id="<?php echo e($variant->id); ?>"
                                                                data-quantity-id="<?php echo e($variant->quantity_id); ?>"
                                                                data-price="<?php echo e($displayPrice); ?>"
                                                                data-sell-price="<?php echo e($variantSellPrice); ?>"
                                                                data-mrp-price="<?php echo e($hasOffer ? $variantSellPrice : $variantMrp); ?>"
                                                                data-offer-price="<?php echo e($hasOffer ? $variantOfferPrice : ''); ?>"
                                                                data-has-offer="<?php echo e($hasOffer ? '1' : '0'); ?>"
                                                                data-stock="<?php echo e($variant->stock ?? 0); ?>"
                                                                data-label="<?php echo e($quantityLabel); ?>" <?php echo e($index === 0 ? 'selected' : ''); ?>>
                                                                <?php echo e($quantityLabel); ?> - ₹<?php echo e(number_format($displayPrice, 0)); ?>

                                                            </option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                    
                                                    <input type="hidden" id="selected-variant-id" name="variant_id"
                                                        value="<?php echo e($productVariants->first()->id); ?>">
                                                    <input type="hidden" id="selected-quantity-id" name="quantity_id"
                                                        value="<?php echo e($productVariants->first()->quantity_id); ?>">
                                                    <input type="hidden" id="selected-variant-price" name="variant_price"
                                                        value="<?php echo e($productVariants->first()->sell_price ?? $productVariants->first()->price); ?>">
                                                    <input type="hidden" id="selected-weight" name="selected_weight"
                                                        value="<?php echo e($productVariants->first()->quantity->name ?? $productVariants->first()->quantity->label ?? ''); ?>">
                                                    
                                                    <input type="hidden" id="product-has-offer"
                                                        value="<?php echo e($hasOffer ? '1' : '0'); ?>">
                                                    <input type="hidden" id="offer-discount-type"
                                                        value="<?php echo e($discountType ?? ''); ?>">
                                                    <input type="hidden" id="offer-discount-value" value="<?php echo e($discountValue); ?>">
                                                </div>
                                            <?php elseif($product->weight): ?>
                                                
                                                <div class="attr-detail attr-size mb-30">
                                                    <strong class="mr-10">Weight:</strong>
                                                    <span><?php echo e($product->weight); ?>g</span>
                                                </div>
                                            <?php endif; ?>

                                            <?php
                                                // Stock calculation moved up to fix undefined variable error
                                            ?>

                                            <!-- Quantity & Cart -->
                                            <div class="detail-extralink mb-4">
                                                <div class="detail-qty border radius">
                                                    <a href="#" class="qty-down"><i class="fi-rs-angle-small-down"></i></a>
                                                    <input type="number" id="product-quantity" name="quantity"
                                                        class="qty-val" value="1" min="1" max="<?php echo e($product->stock); ?>" <?php echo e($displayStock <= 0 ? 'disabled' : ''); ?>>
                                                    <a href="#" class="qty-up"><i class="fi-rs-angle-small-up"></i></a>
                                                </div>
                                                <div class="product-extra-link2" style="<?php echo e($displayStock <= 0 ? 'display: none !important;' : ''); ?>">
                                                    <button type="button" id="add-to-cart-btn"
                                                        class="button button-add-to-cart"
                                                        onclick="addToCart(<?php echo e($product->id); ?>); return false;" <?php echo e($displayStock <= 0 ? 'disabled' : ''); ?>><i
                                                            class="fi-rs-shopping-cart"></i>Add to cart</button>
                                                    <?php
                                                        $isInWishlist = (auth('customer')->check() && auth('customer')->user()->wishlist()->where('product_id', $product->id)->exists()) || (!auth('customer')->check() && in_array($product->id, session()->get('guest_wishlist', [])));
                                                    ?>
                                                    <a aria-label="Add To Wishlist"
                                                        class="action-btn hover-up add-to-wishlist <?php echo e($isInWishlist ? 'active' : ''); ?>"
                                                        data-id="<?php echo e($product->id); ?>" href="javascript:void(0)">
                                                        <i class="fi-rs-heart"></i>
                                                    </a>
                                                    <!-- <a aria-label="Compare" class="action-btn hover-up" href="shop-compare.html"><i class="fi-rs-shuffle"></i></a> -->
                                                </div>
                                            </div>

                                            <!-- Additional Info -->
                                            <div class="font-lg">
                                                <!-- <ul class="mr-50 float-start">
                                                                                                                                                                                                                                                                                                        <li class="mb-5">Type: <span class="text-brand">Organic</span></li>
                                                                                                                                                                                                                                                                                                        <li class="mb-5">MFG: <span class="text-brand"><?php echo e($product->created_at ? $product->created_at->format('M Y') : 'N/A'); ?></span></li>
                                                                                                                                                                                                                                                                                                        <li>LIFE: <span class="text-brand">70 Days</span></li>
                                                                                                                                                                                                                                                                                                    </ul> -->

                                                <ul class="float-start">
                                                    <!-- <li class="mb-5">SKU: <a href="#"><?php echo e($product->sku); ?></a></li> -->
                                                    <!-- <li class="mb-5">Tags: <a href="#" rel="tag">Snack, Organic</a></li> -->
                                                    <li>Stock: <span
                                                            class="<?php echo e($displayStock > 0 ? 'in-stock text-brand' : 'out-stock text-danger'); ?> ml-5"
                                                            id="product-stock-display"><?php echo e($displayStock > 0 ? $displayStock . ' Available' : 'Out of Stock'); ?></span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-info">
                                    <div class="tab-style3">
                                        <ul class="nav nav-tabs text-uppercase">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="Description-tab" data-bs-toggle="tab"
                                                    href="#Description">Description</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="Additional-info-tab" data-bs-toggle="tab"
                                                    href="#Additional-info">Additional info</a>
                                            </li>
                                            <!-- <li class="nav-item">
                                                                                                                                                                                                                                                                                                    <a class="nav-link" id="Vendor-info-tab" data-bs-toggle="tab" href="#Vendor-info">Vendor</a>
                                                                                                                                                                                                                                                                                                </li> -->
                                            <!-- <li class="nav-item">
                                                                                                                                                                                                                <a class="nav-link" id="Reviews-tab" data-bs-toggle="tab"
                                                                                                                                                                                                                    href="#Reviews">Reviews (<?php echo e($product->reviews->count()); ?>)</a>
                                                                                                                                                                                                            </li> -->
                                        </ul>
                                        <div class="tab-content shop_info_tab entry-main-content">
                                            <div class="tab-pane fade show active" id="Description">
                                                <p class="font-lg">
                                                    <?php echo $product->description; ?>


                                                    <ul class="product-more-infor mt-30">
                                                        <?php if($product->taxable): ?>
                                                            <li><span>Tax Rate</span> <?php echo e($product->tax_rate); ?>%</li>
                                                        <?php endif; ?>

                                                    </ul>
                                                </p>
                                            </div>
                                            <div class="tab-pane fade" id="Additional-info">
                                                <table class="font-md">
                                                    <tbody>
                                                        <?php if($product->specifications && $product->specifications->count() > 0): ?>
                                                            <?php $__currentLoopData = $product->specifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $spec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <tr>
                                                                    <th><?php echo e($spec->spec_key); ?></th>
                                                                    <td>
                                                                        <p><?php echo e($spec->spec_value); ?></p>
                                                                    </td>
                                                                </tr>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php else: ?>
                                                            <tr>
                                                                <td colspan="2" class="text-muted text-center py-4">No additional information available.</td>
                                                            </tr>
                                                        <?php endif; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- <div class="tab-pane fade" id="Vendor-info">
                                                                                                                                                                                                                                                                                                    <div class="vendor-logo d-flex mb-30">
                                                                                                                                                                                                                                                                                                        <img src="<?php echo e(asset('assets/imgs/vendor/vendor-18.svg')); ?>" alt="" />
                                                                                                                                                                                                                                                                                                        <div class="vendor-name ml-15">
                                                                                                                                                                                                                                                                                                            <h6>
                                                                                                                                                                                                                                                                                                                <a href="vendor-details-2.html">Noodles Co.</a>
                                                                                                                                                                                                                                                                                                            </h6>
                                                                                                                                                                                                                                                                                                            <div class="product-rate-cover text-end">
                                                                                                                                                                                                                                                                                                                <div class="product-rate d-inline-block">
                                                                                                                                                                                                                                                                                                                    <div class="product-rating" style="width: 90%"></div>
                                                                                                                                                                                                                                                                                                                </div>
                                                                                                                                                                                                                                                                                                                <span class="font-small ml-5 text-muted"> (32 reviews)</span>
                                                                                                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                                                                                                    <ul class="contact-infor mb-50">
                                                                                                                                                                                                                                                                                                        <li><img src="<?php echo e(asset('assets/imgs/theme/icons/icon-location.svg')); ?>" alt="" /><strong>Address: </strong> <span>5171 W Campbell Ave undefined Kent, Utah 53127 United States</span></li>
                                                                                                                                                                                                                                                                                                        <li><img src="<?php echo e(asset('assets/imgs/theme/icons/icon-contact.svg')); ?>" alt="" /><strong>Contact Seller:</strong><span>(+91) - 540-025-553</span></li>
                                                                                                                                                                                                                                                                                                    </ul>
                                                                                                                                                                                                                                                                                                    <div class="d-flex mb-55">
                                                                                                                                                                                                                                                                                                        <div class="mr-30">
                                                                                                                                                                                                                                                                                                            <p class="text-brand font-xs">Rating</p>
                                                                                                                                                                                                                                                                                                            <h4 class="mb-0">92%</h4>
                                                                                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                                                                                        <div class="mr-30">
                                                                                                                                                                                                                                                                                                            <p class="text-brand font-xs">Ship on time</p>
                                                                                                                                                                                                                                                                                                            <h4 class="mb-0">100%</h4>
                                                                                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                                                                                        <div>
                                                                                                                                                                                                                                                                                                            <p class="text-brand font-xs">Chat response</p>
                                                                                                                                                                                                                                                                                                            <h4 class="mb-0">89%</h4>
                                                                                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                                                                                                    <p>
                                                                                                                                                                                                                                                                                                        Noodles & Company is an American fast-casual restaurant that offers international and American noodle dishes and pasta in addition to soups and salads. Noodles & Company was founded in 1995 by Aaron Kennedy and is headquartered in Broomfield, Colorado. The company went public in 2013 and recorded a $457 million revenue in 2017.In late 2018, there were 460 Noodles & Company locations across 29 states and Washington, D.C.
                                                                                                                                                                                                                                                                                                    </p>
                                                                                                                                                                                                                                                                                                </div> -->

                                        </div>
                                    </div>
                                </div>

                                <!-- FIXED: Related Products with proper images -->
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <h2 class="section-title style-1 mb-30">Related products</h2>
                                    </div>
                                    <div class="col-12">
                                        <div class="row related-products">
                                            <?php if(isset($relatedProducts) && count($relatedProducts) > 0): ?>
                                                <?php $__currentLoopData = $relatedProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $related): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php
                                                        // productimage is already cast as array in the Product model
                                                        $relatedImages = $related->productimage;

                                                        // Ensure it's an array
                                                        if (!is_array($relatedImages)) {
                                                            $relatedImages = [];
                                                        }

                                                        // Fix Windows backslashes
                                                        $relatedImages = array_map(function ($img) {
                                                            $img = str_replace('\\', '/', $img);
                                                            if (strpos($img, 'uploads/') === 0) {
                                                                $img = substr($img, 8);
                                                            }
                                                            return $img;
                                                        }, $relatedImages);

                                                        $relatedPrimaryImage = $relatedImages[0] ?? null;
                                                    ?>
                                                    <div class="col-lg-1-5 col-md-4 col-6 col-sm-6" style="margin-bottom: 15px;">
                                                        <?php
                                                            $relatedStock = $related->variants->first() ? ($related->variants->first()->stock ?? 0) : ($related->stock ?? 0);
                                                        ?>
                                                        <div class="product-cart-wrap hover-up mb-30 <?php echo e($relatedStock <= 0 ? 'product-out-of-stock' : ''); ?>">
                                                            <div class="product-img-action-wrap">
                                                                <div class="product-img product-img-zoom">
                                                                    <a href="<?php echo e(route('product.details', $related->id)); ?>" class="product-card-link">
                                                                        <?php if($relatedPrimaryImage): ?>
                                                                            <img class="default-img"
                                                                                src="<?php echo e(env('ADMIN_ASSET_URL')); ?>/<?php echo e($relatedPrimaryImage); ?>"
                                                                                alt="<?php echo e($related->productname); ?>"
                                                                                onerror="this.src='<?php echo e(asset('assets/imgs/theme/icons/category-1.svg')); ?>'"
                                                                                 />
                                                                        <?php else: ?>
                                                                            <img class="default-img"
                                                                                src="<?php echo e(asset('assets/imgs/theme/icons/category-1.svg')); ?>"
                                                                                alt="<?php echo e($related->productname); ?>"
                                                                                 />
                                                                        <?php endif; ?>
                                                                    </a>
                                                                </div>
                                                                <div class="product-action-1" style="<?php echo e($relatedStock <= 0 ? 'display: none !important;' : ''); ?>">
                                                                    <?php
                                                                        $isRelatedInWishlist = (auth('customer')->check() && auth('customer')->user()->wishlist()->where('product_id', $related->id)->exists()) || (!auth('customer')->check() && in_array($related->id, session()->get('guest_wishlist', [])));
                                                                    ?>
                                                                    <a aria-label="Add To Wishlist"
                                                                        class="action-btn add-to-wishlist <?php echo e($isRelatedInWishlist ? 'active' : ''); ?>"
                                                                        href="javascript:void(0)" data-id="<?php echo e($related->id); ?>">
                                                                        <i class="fi-rs-heart"></i>
                                                                    </a>
                                                                    <a aria-label="Quick view" class="action-btn quick-view-btn"
                                                                        href="javascript:void(0)"
                                                                        data-product-id="<?php echo e($related->id); ?>">
                                                                        <i class="fi-rs-eye"></i>
                                                                    </a>
                                                                </div>
                                                                <?php if($relatedStock <= 0): ?>
                                                                    <div class="product-badges product-badges-position product-badges-mrg">
                                                                        <span class="hot" style="background-color: #dc3545;">OUT OF STOCK</span>
                                                                    </div>
                                                                <?php elseif($related->stock < 10): ?>
                                                                    <div
                                                                        class="product-badges product-badges-position product-badges-mrg">
                                                                        <span class="hot">Hot</span>
                                                                    </div>
                                                                <?php endif; ?>
                                                            </div>
                                                            <div class="product-content-wrap">
                                                                <h2><a
                                                                        href="<?php echo e(route('product.details', $related->id)); ?>" class="product-card-link"><?php echo e($related->productname); ?></a>
                                                                </h2>
                                                                <!-- <?php
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            $relatedAvgRating = $related->reviews_avg_rating ? round($related->reviews_avg_rating, 1) : 0;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            $relatedAvgRatingPercent = $relatedAvgRating / 5 * 100;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        ?>

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <div class="product-rate-cover">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <div class="product-rate d-inline-block">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <div class="product-rating"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    style="width: <?php echo e($relatedAvgRatingPercent); ?>%"></div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <span
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                class="font-small ml-5 text-muted">(<?php echo e($relatedAvgRating ?: '0.0'); ?>)</span>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </div> -->

                                                                <div class="product-card-bottom" style="flex-direction: column; align-items: stretch;">
                                                                    <?php
                                                                        // Get first variant's prices if available
                                                                        $relatedFirstVariant = $related->variants->first();
                                                                        $relatedSellPrice = $relatedFirstVariant
                                                                            ? ($relatedFirstVariant->sell_price ?? $relatedFirstVariant->price)
                                                                            : ($related->sell_price ?? $related->price ?? 0);
                                                                        $relatedMrpPrice = $relatedFirstVariant
                                                                            ? $relatedFirstVariant->price
                                                                            : ($related->price ?? 0);

                                                                        // Check for active offer
                                                                        $relatedOfferPrice = $related->offer_price;
                                                                        $hasRelatedOffer = $relatedOfferPrice !== null;
                                                                        if ($hasRelatedOffer) {
                                                                            // Product has an offer - show offer price as main, MRP as strike-through
                                                                            $relatedCurrentPrice = $relatedOfferPrice;
                                                                            $relatedOriginalPrice = $related->offer_mrp;
                                                                        } else {
                                                                            // No offer - show sell_price as main, mrp_price as strike-through (if higher)
                                                                            $relatedCurrentPrice = $relatedSellPrice;
                                                                            $relatedOriginalPrice = ($relatedMrpPrice && $relatedMrpPrice > $relatedSellPrice) ? $relatedMrpPrice : null;
                                                                        }
                                                                        
                                                                        $relatedFirstVariantStock = $relatedFirstVariant ? ($relatedFirstVariant->stock ?? 0) : ($related->stock ?? 0);
                                                                    ?>

                                                                    
                                                                    <?php if($related->variants->count() > 0): ?>
                                                                        <?php
                                                                            $activeOffer = $related->getActiveOffer();
                                                                            $hasProductOffer = $activeOffer !== null;
                                                                            $discountType = $hasProductOffer ? $activeOffer->discount_type : null;
                                                                            $discountValue = $hasProductOffer ? $activeOffer->discount_value : 0;
                                                                        ?>
                                                                        <div class="product-variant-selector" style="text-align: center; margin-bottom: 8px;">
                                                                            <select class="form-control product_Dropdown variant-dropdown-<?php echo e($related->id); ?>"
                                                                                data-product-id="<?php echo e($related->id); ?>"
                                                                                style="width: 100%; display: inline-block; appearance: none; -webkit-appearance: none; -moz-appearance: none; background-image: url('data:image/svg+xml;charset=UTF-8,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22%233BB77E%22%3E%3Cpath d=%22M7 10l5 5 5-5z%22/%3E%3C/svg%3E'); background-repeat: no-repeat; background-position: right 12px center; background-size: 20px; padding-right: 40px; cursor: pointer; border: 1px solid #BCE3C9; border-radius: 5px; height: 45px; font-size: 18px;" <?php echo e($relatedFirstVariantStock <= 0 ? 'disabled' : ''); ?>>
                                                                                <?php $__currentLoopData = $related->variants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $variant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                    <?php
                                                                                        // Calculate offer price for this variant
                                                                                        $variantMrp = $variant->price ?? 0;
                                                                                        $variantSellPrice = $variant->sell_price ?? $variant->price;
                                                                                        $variantOfferPrice = $variantSellPrice;

                                                                                        if ($hasProductOffer && $variantSellPrice > 0) {
                                                                                            if ($discountType === 'percentage') {
                                                                                                $discount = ($variantSellPrice * $discountValue) / 100;
                                                                                            } else {
                                                                                                $discount = $discountValue;
                                                                                            }
                                                                                            $variantOfferPrice = max(0, round($variantSellPrice - $discount, 2));
                                                                                        }

                                                                                        $displayPrice = $hasProductOffer ? $variantOfferPrice : $variantSellPrice;
                                                                                        $quantityLabel = $variant->quantity->name ?? $variant->quantity->label;
                                                                                    ?>
                                                                                    <option value="<?php echo e($variant->id); ?>" data-variant-id="<?php echo e($variant->id); ?>"
                                                                                        data-price="<?php echo e($displayPrice); ?>" data-sell-price="<?php echo e($variantSellPrice); ?>"
                                                                                        data-mrp-price="<?php echo e($hasProductOffer ? $variantSellPrice : $variantMrp); ?>"
                                                                                        data-offer-price="<?php echo e($hasProductOffer ? $variantOfferPrice : ''); ?>"
                                                                                        data-has-offer="<?php echo e($hasProductOffer ? '1' : '0'); ?>" data-stock="<?php echo e($variant->stock ?? 0); ?>"
                                                                                        data-label="<?php echo e($quantityLabel); ?>" <?php echo e($index === 0 ? 'selected' : ''); ?>>
                                                                                        <?php echo e($quantityLabel); ?> - ₹<?php echo e(number_format($displayPrice, 0)); ?>

                                                                                    </option>
                                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                            </select>
                                                                        </div>
                                                                    <?php endif; ?>

                                                                    
                                                                    <div class="product-price" style="text-align: center; margin-bottom: 10px;">
                                                                        <div class="product-price-display-<?php echo e($related->id); ?>" style="font-size: 15px; font-weight: 600;">
                                                                            <?php if($relatedOriginalPrice && $relatedOriginalPrice > $relatedCurrentPrice): ?>
                                                                                <span class="product-mrp-display-<?php echo e($related->id); ?>"
                                                                                    style="text-decoration: line-through; color: #ADADAD; font-size: 15px; font-weight: 600; margin-right: 10px;">
                                                                                    ₹<?php echo e(number_format($relatedOriginalPrice, 0)); ?>

                                                                                </span>
                                                                            <?php else: ?>
                                                                                <span class="product-mrp-display-<?php echo e($related->id); ?>"
                                                                                    style="text-decoration: line-through; color: #ADADAD; display: none;">
                                                                                </span>
                                                                            <?php endif; ?>
                                                                            <span class="product-sell-price-<?php echo e($related->id); ?>"
                                                                                style="color: #3BB77E;">₹<?php echo e(number_format($relatedCurrentPrice, 0)); ?></span>
                                                                        </div>
                                                                    </div>

                                                                    
                                                                    <div
                                                                        style="display: flex; justify-content: space-between; align-items: flex-end; margin-top: auto;">
                                                                        
                                                                        <div style="display: flex; align-items: center;" class="col-6 pe-1">
                                                                            <label class="qty-label">Qty:</label>
                                                                            <input type="number" class="qty-input product-qty-<?php echo e($related->id); ?>" value="1" min="1" <?php echo e($relatedFirstVariantStock <= 0 ? 'disabled' : ''); ?>>
                                                                        </div>

                                                                        
                                                                        <div class="add-cart col-6 ps-1" style="<?php echo e($relatedFirstVariantStock <= 0 ? 'display: none !important;' : ''); ?>">
                                                                            <a href="javascript:void(0)" class="add col-12 add-to-cart-btn-<?php echo e($related->id); ?>"
                                                                                data-product-id="<?php echo e($related->id); ?>" data-price="<?php echo e($relatedCurrentPrice); ?>"
                                                                                data-stock="<?php echo e($relatedFirstVariantStock); ?>"
                                                                                style="justify-content:center;display: inline-flex; align-items: center; white-space: nowrap; padding: 7px 18px; font-size: 13px; font-weight: 600;">
                                                                                <i class="fi-rs-shopping-cart mr-5"></i>ADD
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php else: ?>
                                                
                                                <div class="col-12">
                                                    <p class="text-muted">No related products available</p>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- FIXED: Sidebar with icons -->
                        <style>
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
                        </style>

                        <!-- <div class="col-xl-3 primary-sidebar sticky-sidebar mt-30">
                            <div class="sidebar-widget widget-category-2 mb-30">
                                <h5 class="section-title style-1 mb-30">Category</h5>
                                <div class="category-scroll">
                                    <ul>
                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li>
                                                <?php
                                                    $sidebarCatImage = str_replace('uploads/', '', $cat->image);
                                                ?>
                                                <a href="<?php echo e(route('category.products', $cat->id)); ?>">
                                                    <img src="<?php echo e(env('ADMIN_ASSET_URL')); ?>/<?php echo e($sidebarCatImage); ?>"
                                                        alt="<?php echo e($cat->name); ?>"
                                                        style="width: 30px; height: 30px; object-fit: cover;">
                                                    <?php echo e($cat->name); ?>

                                                </a>
                                                
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </div>

                            </div>
                        </div> -->







                    




                
            </div>
        </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const csrfToken = '<?php echo e(csrf_token()); ?>';
            const isLoggedIn = <?php echo e(auth('customer')->check() ? 'true' : 'false'); ?>;

            // Configure toastr
            if (typeof toastr !== 'undefined') {
                toastr.options = {
                    "closeButton": true,
                    "debug": false,
                    "newestOnTop": true,
                    "progressBar": true,
                    "positionClass": "toast-top-right",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "500",
                    "extendedTimeOut": "500",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                };
            }

            // Add to Cart function - GUEST CART SUPPORTED (no login required)
            window.addToCart = function (productId) {
                // Check stock availability first
                const stockDisplay = document.getElementById('product-stock-display');
                const stockText = stockDisplay ? stockDisplay.textContent.trim() : '';

                // If stock shows "Out of Stock" or contains 0, prevent adding to cart
                if (stockText === 'Out of Stock' || stockText.startsWith('0 ')) {
                    if (typeof toastr !== 'undefined') {
                        toastr.error('This product is out of stock', 'Error');
                    }
                    return false;
                }

                // Get quantity from input field
                const quantityInput = document.getElementById('product-quantity');
                const quantity = quantityInput ? parseInt(quantityInput.value) || 1 : 1;

                // Get variant data if this is a variable product
                const variantIdInput = document.getElementById('selected-variant-id');
                const quantityIdInput = document.getElementById('selected-quantity-id');
                const variantPriceInput = document.getElementById('selected-variant-price');
                const selectedWeightInput = document.getElementById('selected-weight');

                const variantId = variantIdInput ? variantIdInput.value : null;
                const quantityId = quantityIdInput ? quantityIdInput.value : null;
                const variantPrice = variantPriceInput ? parseFloat(variantPriceInput.value) : null;
                const selectedWeight = selectedWeightInput ? selectedWeightInput.value : null;

                console.log('Adding to cart - Product ID:', productId, 'Quantity:', quantity, 'Variant ID:', variantId, 'Price:', variantPrice, 'Weight:', selectedWeight);

                // Build request body - selected_quantity is mandatory per contract
                const requestBody = {
                    product_id: productId,
                    selected_quantity: quantity,
                    variant_id: variantId || null,
                    unit_price: variantPrice || null,
                    selected_weight: selectedWeight || null
                };

                // Use fetch API for AJAX request
                fetch('<?php echo e(route("add-to-cart")); ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(requestBody)
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            if (typeof toastr !== 'undefined') {
                                toastr.success('Product added to cart! (Qty: ' + quantity + ')');
                            }
                            // Update cart count in header
                            if (data.cartCount) {
                                const headerCartCount = document.getElementById('header-cart-count');
                                if (headerCartCount) headerCartCount.textContent = data.cartCount;
                                const bottomCartCount = document.getElementById('bottom-header-cart-count');
                                if (bottomCartCount) bottomCartCount.textContent = data.cartCount;
                                const mobileCartCount = document.getElementById('mobile-cart-count');
                                if (mobileCartCount) mobileCartCount.textContent = data.cartCount;
                            }

                            // Update stock display with remaining stock from backend
                            if (typeof data.remainingStock !== 'undefined') {
                                const stockDisplay = document.getElementById('product-stock-display');
                                const additionalInfoStock = document.getElementById('additional-info-stock');
                                const addToCartBtn = document.getElementById('add-to-cart-btn');
                                const stockValue = parseInt(data.remainingStock) || 0;

                                // Update main stock display
                                if (stockDisplay) {
                                    if (stockValue > 0) {
                                        stockDisplay.textContent = stockValue + ' Available';
                                        stockDisplay.className = 'in-stock text-brand ml-5';
                                    } else {
                                        stockDisplay.textContent = 'Out of Stock';
                                        stockDisplay.className = 'out-stock text-danger ml-5';
                                    }
                                }

                                // Update additional info stock
                                if (additionalInfoStock) {
                                    if (stockValue > 0) {
                                        additionalInfoStock.textContent = 'Available';
                                    } else {
                                        additionalInfoStock.textContent = 'Out of Stock';
                                    }
                                }

                                // Update add to cart button state
                                if (addToCartBtn) {
                                    if (stockValue <= 0) {
                                        addToCartBtn.disabled = true;
                                        addToCartBtn.style.opacity = '0.5';
                                        addToCartBtn.style.cursor = 'not-allowed';
                                    } else {
                                        addToCartBtn.disabled = false;
                                        addToCartBtn.style.opacity = '1';
                                        addToCartBtn.style.cursor = 'pointer';
                                    }
                                }

                                // Update variant dropdown's data-stock attribute if variant product
                                const variantDropdown = document.getElementById('variant-dropdown');
                                if (variantDropdown && variantId) {
                                    const selectedOption = variantDropdown.options[variantDropdown.selectedIndex];
                                    if (selectedOption && selectedOption.getAttribute('data-variant-id') == variantId) {
                                        selectedOption.setAttribute('data-stock', stockValue);
                                    }
                                }
                            }

                            // Stay on the same page - no redirect
                        } else {
                            if (typeof toastr !== 'undefined') {
                                toastr.error(data.message || 'Error adding to cart', 'Error');
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Add to cart error:', error);
                        if (typeof toastr !== 'undefined') {
                            toastr.error('Error adding to cart', 'Error');
                        }
                    });
            };

            // Quantity incr    ease/decrease is handled by shop.js - removed duplicate handler to prevent double-increment bug
        });

        // THUMBNAIL SLIDER - SYNCHRONIZED IMAGE GALLERY WITH DISABLED ARROWS AT BOUNDARIES
        (function initGallery() {
            // Robust initialization: run immediately if DOM is ready, otherwise wait for DOMContentLoaded
            function initializeGalleryLogic() {
                const slider = document.getElementById('thumbnail-slider');
                const mainImage = document.getElementById('main-product-image');
                const thumbnails = document.querySelectorAll('.thumbnail-item');
                const prevBtn = document.getElementById('slider-prev-btn');
                const nextBtn = document.getElementById('slider-next-btn');

                if (!slider || !mainImage || thumbnails.length === 0) return;

                // Single current image index to synchronize all interactions
                let currentIndex = 0;
                const totalThumbnails = thumbnails.length;
                const itemWidth = 90;

                // Update arrow button disabled states based on current index
                function updateArrowStates() {
                    if (prevBtn) {
                        if (currentIndex <= 0) {
                            prevBtn.disabled = true;
                            prevBtn.style.opacity = '0.4';
                            prevBtn.style.cursor = 'not-allowed';
                        } else {
                            prevBtn.disabled = false;
                            prevBtn.style.opacity = '1';
                            prevBtn.style.cursor = 'pointer';
                        }
                    }
                    if (nextBtn) {
                        if (currentIndex >= totalThumbnails - 1) {
                            nextBtn.disabled = true;
                            nextBtn.style.opacity = '0.4';
                            nextBtn.style.cursor = 'not-allowed';
                        } else {
                            nextBtn.disabled = false;
                            nextBtn.style.opacity = '1';
                            nextBtn.style.cursor = 'pointer';
                        }
                    }
                }

                // Update main image and active thumbnail state
                function updateMainImage(index) {
                    if (index < 0 || index >= totalThumbnails) return;
                    const thumbnail = thumbnails[index];
                    if (!thumbnail) return;

                    let imgSrc = thumbnail.getAttribute('data-src');
                    if (!imgSrc || imgSrc === '' || imgSrc === 'null' || imgSrc === 'undefined') {
                        const thumbImg = thumbnail.querySelector('.thumbnail-image');
                        if (thumbImg && thumbImg.src) {
                            imgSrc = thumbImg.src;
                        }
                    }

                    if (!imgSrc || imgSrc === '' || imgSrc === 'null' || imgSrc === 'undefined') {
                        console.warn('Invalid image source for thumbnail index:', index);
                        return;
                    }

                    // Update active state on thumbnails
                    thumbnails.forEach(item => item.classList.remove('active'));
                    thumbnail.classList.add('active');

                    // Update main image
                    mainImage.src = imgSrc;

                    // Scroll thumbnail into view smoothly
                    const thumbCenterPos = (index * itemWidth) + (itemWidth / 2);
                    const sliderWidth = slider.clientWidth;
                    const targetScroll = thumbCenterPos - (sliderWidth / 2);
                    slider.scrollLeft = Math.max(0, targetScroll);

                    // Update current index
                    currentIndex = index;

                    // Update arrow disabled states
                    updateArrowStates();
                }

                // Navigate to previous or next image (no looping)
                function navigateToImage(direction) {
                    let newIndex = currentIndex;
                    if (direction === 'prev') {
                        newIndex = currentIndex - 1;
                        // Stop at first image, don't loop
                        if (newIndex < 0) {
                            return;
                        }
                    } else {
                        newIndex = currentIndex + 1;
                        // Stop at last image, don't loop
                        if (newIndex >= totalThumbnails) {
                            return;
                        }
                    }
                    updateMainImage(newIndex);
                }

                // Thumbnail click handlers
                thumbnails.forEach((thumbnail, index) => {
                    thumbnail.addEventListener('click', function (e) {
                        e.preventDefault();
                        e.stopPropagation();
                        updateMainImage(index);
                    });
                });

                // Previous button click handler
                if (prevBtn) {
                    prevBtn.addEventListener('click', function (e) {
                        e.preventDefault();
                        e.stopPropagation();
                        if (!prevBtn.disabled) {
                            navigateToImage('prev');
                        }
                    });
                }

                // Next button click handler
                if (nextBtn) {
                    nextBtn.addEventListener('click', function (e) {
                        e.preventDefault();
                        e.stopPropagation();
                        if (!nextBtn.disabled) {
                            navigateToImage('next');
                        }
                    });
                }

                // Initialize: first image is selected by default, set initial arrow states
                updateArrowStates();
            }

            // Check if DOM is already loaded, if so run immediately, otherwise wait
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initializeGalleryLogic);
            } else {
                // DOM is already ready, run immediately
                initializeGalleryLogic();
            }
        })();

        // VARIANT DROPDOWN SELECTOR - Dynamic Price Update
        document.addEventListener('DOMContentLoaded', function () {
            const variantDropdown = document.getElementById('variant-dropdown');
            const mainPriceEl = document.getElementById('main-product-price');
            const mainMrpEl = document.getElementById('main-product-mrp');
            const variantIdInput = document.getElementById('selected-variant-id');
            const quantityIdInput = document.getElementById('selected-quantity-id');
            const variantPriceInput = document.getElementById('selected-variant-price');

            if (!variantDropdown || !mainPriceEl) return;

            function formatPrice(price) {
                return '₹' + Math.round(parseFloat(price)).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
            }

            variantDropdown.addEventListener('change', function (e) {
                const selectedOption = this.options[this.selectedIndex];

                const variantId = selectedOption.getAttribute('data-variant-id');
                const quantityId = selectedOption.getAttribute('data-quantity-id');
                const sellPrice = selectedOption.getAttribute('data-sell-price') || selectedOption.getAttribute('data-price');
                const mrpPrice = selectedOption.getAttribute('data-mrp-price');
                const offerPrice = selectedOption.getAttribute('data-offer-price');
                const variantHasOffer = selectedOption.getAttribute('data-has-offer') === '1';
                const stockLabel = selectedOption.getAttribute('data-stock') || 0;
                const quantityLabel = selectedOption.getAttribute('data-label');

                if (!sellPrice) {
                    console.error('No price found for variant');
                    return;
                }

                let displayPrice = sellPrice;
                let showMrpStrike = false;

                if (variantHasOffer && offerPrice) {
                    displayPrice = offerPrice;
                    showMrpStrike = mrpPrice && parseFloat(mrpPrice) > parseFloat(offerPrice);
                } else if (mrpPrice && parseFloat(mrpPrice) > parseFloat(sellPrice)) {
                    showMrpStrike = true;
                }

                mainPriceEl.textContent = formatPrice(displayPrice);

                if (mainMrpEl) {
                    if (showMrpStrike && mrpPrice) {
                        mainMrpEl.textContent = formatPrice(mrpPrice);
                        mainMrpEl.style.display = 'inline';
                        mainMrpEl.style.textDecoration = 'line-through';
                    } else {
                        mainMrpEl.style.display = 'none';
                    }
                }

                if (variantIdInput) variantIdInput.value = variantId;
                if (quantityIdInput) quantityIdInput.value = quantityId;
                if (variantPriceInput) variantPriceInput.value = displayPrice;

                // Update selected weight label for cart submission
                const selectedWeightInput = document.getElementById('selected-weight');
                if (selectedWeightInput) selectedWeightInput.value = quantityLabel;

                // Update weight display in Additional info tab
                const additionalInfoWeight = document.getElementById('additional-info-weight');
                if (additionalInfoWeight) additionalInfoWeight.textContent = quantityLabel;

                // Update stock display when variant changes
                const stockDisplay = document.getElementById('product-stock-display');
                const additionalInfoStock = document.getElementById('additional-info-stock');
                const addToCartBtn = document.getElementById('add-to-cart-btn');
                var stockValue = parseInt(selectedOption.getAttribute('data-stock')) || 0;

                if (stockDisplay) {
                    if (stockValue > 0) {
                        stockDisplay.textContent = stockValue + ' Available';
                        stockDisplay.className = 'in-stock text-brand ml-5';
                    } else {
                        stockDisplay.textContent = 'Out of Stock';
                        stockDisplay.className = 'out-stock text-danger ml-5';
                    }
                }
                if (additionalInfoStock) {
                    if (stockValue > 0) {
                        additionalInfoStock.textContent = 'Available';
                    } else {
                        additionalInfoStock.textContent = 'Out of Stock';
                    }
                }

                // Enable/disable add to cart button based on stock
                const productInfo = document.getElementById('main-product-info');
                const mainImgContainer = document.querySelector('.custom-main-image-container');
                if (addToCartBtn) {
                    const productQty = document.getElementById('product-quantity');
                    const btnContainer = document.querySelector('.product-extra-link2');
                    if (stockValue <= 0) {
                        if (productQty) productQty.disabled = true;
                        if (btnContainer) btnContainer.setAttribute('style', 'display: none !important;');
                        if (productInfo) productInfo.classList.add('product-out-of-stock');
                        if (mainImgContainer) mainImgContainer.classList.add('product-out-of-stock');
                        const productAction = document.querySelector('.detail-gallery .product-action-1');
                        if (productAction) productAction.setAttribute('style', 'display: none !important;');
                        
                        // Add out of stock badge if not present
                        let badgeContainer = document.querySelector('.detail-gallery .product-badges');
                        if (!badgeContainer) {
                            badgeContainer = document.createElement('div');
                            badgeContainer.className = 'product-badges product-badges-position product-badges-mrg';
                            badgeContainer.innerHTML = '<span class="hot" style="background-color: #dc3545;">OUT OF STOCK</span>';
                            document.querySelector('.detail-gallery figure').appendChild(badgeContainer);
                        } else {
                            badgeContainer.style.display = 'block';
                            badgeContainer.querySelector('.hot').textContent = 'OUT OF STOCK';
                            badgeContainer.querySelector('.hot').style.backgroundColor = '#dc3545';
                        }
                    } else {
                        if (productQty) productQty.disabled = false;
                        if (btnContainer) btnContainer.setAttribute('style', 'display: flex !important;');
                        if (productInfo) productInfo.classList.remove('product-out-of-stock');
                        if (mainImgContainer) mainImgContainer.classList.remove('product-out-of-stock');
                        const productAction = document.querySelector('.detail-gallery .product-action-1');
                        if (productAction) productAction.setAttribute('style', 'display: flex !important;');
                        
                        // Hide out of stock badge
                        const badgeContainer = document.querySelector('.detail-gallery .product-badges');
                        if (badgeContainer) {
                            badgeContainer.style.display = 'none';
                        }
                    }
                }

                console.log('Variant selected:', {
                    variantId: variantId,
                    quantityId: quantityId,
                    sellPrice: sellPrice,
                    mrpPrice: mrpPrice,
                    offerPrice: offerPrice,
                    displayPrice: displayPrice,
                    hasOffer: variantHasOffer,
                    stock: stockValue,
                    label: quantityLabel
                });
            });
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            // Handle variant dropdown changes for related products
            $('[class*="variant-dropdown-"]').on('change', function () {
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
                const sellVal = parseFloat(sellPrice);
                const displayVal = parseFloat(displayPrice);

                // Show MRP if MRP > sell price OR MRP > offer price
                if (mrpVal && mrpVal > displayVal) {
                    mrpElement.text('₹' + Math.round(mrpVal).toLocaleString());
                    mrpElement.css('display', 'inline');
                } else if (mrpVal && mrpVal > sellVal) {
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
                // Need to find the parent container to scope the updates
                const productCard = $(this).closest('.product-cart-wrap');
                if(productCard.length === 0) return; // Ignore if not inside a product card (e.g. main product)
                
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

            // Handle add to cart button clicks for related products
            $('[class*="add-to-cart-btn-"]').on('click', function (e) {
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

                productsAddToCart(productId, unitPrice, variantId, quantity);
            });
        });

        function productsAddToCart(productId, displayPrice, variantId = null, quantity = 1) {
            const csrfToken = $('meta[name="csrf-token"]').attr('content');

            // Get selected_weight (gram value) from variant dropdown
            let selectedWeight = null;
            const variantDropdown = $(`.variant-dropdown-${productId}`);
            if (variantDropdown.length > 0) {
                selectedWeight = variantDropdown.find('option:selected').data('label') || null;
            }

            const requestData = {
                _token: csrfToken,
                product_id: productId,
                selected_quantity: quantity,
                unit_price: displayPrice
            };

            // Add variant ID if present
            if (variantId) {
                requestData.variant_id = variantId;
            }
            if (selectedWeight) {
                requestData.selected_weight = selectedWeight;
            }

            $.ajax({
                url: '<?php echo e(route("add-to-cart")); ?>',
                type: 'POST',
                data: requestData,
                success: function (response) {
                    if (response.success) {
                        // Show success notification (using toastr if available)
                        if (typeof toastr !== 'undefined') {
                            toastr.success(response.message);
                        } else {
                            alert(response.message);
                        }

                        // Update cart count in header
                        $('#header-cart-count').text(response.cartCount);
                        $('#bottom-header-cart-count').text(response.cartCount);
                        $('#mobile-cart-count').text(response.cartCount);

                        // Stay on the same page - no redirect
                    } else {
                        if (typeof toastr !== 'undefined') {
                            toastr.error(response.message);
                        } else {
                            alert('Error: ' + response.message);
                        }
                    }
                },
                error: function (xhr) {
                    let errorMsg = 'Something went wrong!';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }

                    if (typeof toastr !== 'undefined') {
                        toastr.error(errorMsg, 'Error');
                    } else {
                        alert('Error: ' + errorMsg);
                    }
                    console.error(xhr);
                }
            });
        }
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\chennais\frontend\resources\views/section/productdetails.blade.php ENDPATH**/ ?>