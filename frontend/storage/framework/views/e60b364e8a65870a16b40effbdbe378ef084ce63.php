

<?php $__env->startSection('title', $query ? 'Search: ' . $query : 'Search Products'); ?>

<?php $__env->startSection('content'); ?>
    <main class="main">
        <!-- Breadcrumb -->
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="<?php echo e(route('index')); ?>" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                    <span></span> Search Results
                </div>
            </div>
        </div>

        <!-- Search Results Section -->
        <div class="container mb-30 mt-30">
            <div class="row">
                <div class="col-12">
                    <!-- Search Header -->
                    <div class="search-header mb-30">
                        <h1 class="heading-1 mb-15">
                            <?php if($query): ?>
                                Search Results for "<?php echo e($query); ?>"
                            <?php else: ?>
                                All Products
                            <?php endif; ?>
                        </h1>
                        <p class="text-muted">
                            Found <strong><?php echo e($products->total()); ?></strong> product(s)
                            <?php if($categoryId && $categories->where('id', $categoryId)->first()): ?>
                                in <strong><?php echo e($categories->where('id', $categoryId)->first()->name); ?></strong>
                            <?php endif; ?>
                        </p>
                    </div>

                    <hr class="mb-30">

                    <!-- Product Grid -->
                    <?php if($products->count() > 0): ?>
                        <div class="row product-grid">
                            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    // Get first image
                                    $images = $product->productimage;
                                    $imageName = '';
                                    if (is_array($images) && count($images) > 0) {
                                        $imageName = basename(str_replace('\\', '/', $images[0]));
                                    } elseif (is_string($images) && !empty($images)) {
                                        $imageName = basename(str_replace('\\', '/', $images));
                                    }
                                    $adminAssetUrl = env('ADMIN_ASSET_URL', 'http://localhost/chennaiangadi/adminpanel/public/uploads');
                                    $imageUrl = $adminAssetUrl . '/products/' . $imageName;

                                    // Get variant pricing
                                    $firstVariant = $product->variants->first();
                                    $sellPrice = $firstVariant ? ($firstVariant->sell_price ?? $firstVariant->price) : ($product->sell_price ?? $product->price ?? 0);
                                    $mrpPrice = $firstVariant ? $firstVariant->price : ($product->price ?? 0);

                                    // Calculate discount percentage
                                    $discountPercent = 0;
                                    if ($mrpPrice && $sellPrice && $sellPrice < $mrpPrice) {
                                        $discountPercent = round((($mrpPrice - $sellPrice) / $mrpPrice) * 100);
                                    }

                                    // Check wishlist status
                                    $inWishlist = false;
                                    if (auth('customer')->check()) {
                                        $inWishlist = auth('customer')->user()->wishlist()->where('product_id', $product->id)->exists();
                                    } else {
                                        $sessionWishlist = session('guest_wishlist', []);
                                        $inWishlist = in_array($product->id, $sessionWishlist);
                                    }
                                ?>

                                <div class="col-lg-3 col-md-4 col-sm-6 col-6 mb-30">
                                    <div class="product-cart-wrap d-flex flex-column h-100">
                                        <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href="<?php echo e(route('product.details', $product->id)); ?>">
                                                    <img class="default-img" src="<?php echo e($imageUrl); ?>" alt="<?php echo e($product->productname); ?>"
                                                        onerror="this.src='<?php echo e(asset('assets/imgs/images/default-product.png')); ?>'" />
                                                    <img class="hover-img" src="<?php echo e($imageUrl); ?>" alt="<?php echo e($product->productname); ?>"
                                                        onerror="this.src='<?php echo e(asset('assets/imgs/images/default-product.png')); ?>'" />
                                                </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label="Add To Wishlist"
                                                    class="action-btn wishlist-btn <?php echo e($inWishlist ? 'active' : ''); ?>"
                                                    href="javascript:void(0);" data-product-id="<?php echo e($product->id); ?>">
                                                    <i class="fi-rs-heart"></i>
                                                </a>
                                                <a aria-label="Quick view" class="action-btn quick-view-btn"
                                                    href="javascript:void(0);" data-product-id="<?php echo e($product->id); ?>">
                                                    <i class="fi-rs-eye"></i>
                                                </a>
                                            </div>

                                            <?php if($discountPercent > 0): ?>
                                                <div class="product-badges product-badges-position product-badges-mrg">
                                                    <span class="hot">-<?php echo e($discountPercent); ?>%</span>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="product-content-wrap">
                                            <h2 style="text-align: center;">
                                                <a
                                                    href="<?php echo e(route('product.details', $product->id)); ?>"><?php echo e(Str::limit($product->productname, 40)); ?></a>
                                            </h2>

                                            <div class="product-card-bottom" style="flex-direction: column; align-items: stretch;">
                                                <?php
                                                    // Check for active offer
                                                    $offerPrice = $product->offer_price;
                                                    $hasOffer = $offerPrice !== null;
                                                    if ($hasOffer) {
                                                        $currentPrice = $offerPrice;
                                                        $originalPrice = $product->offer_mrp;
                                                    } else {
                                                        $currentPrice = $sellPrice;
                                                        $originalPrice = ($mrpPrice && $mrpPrice > $sellPrice) ? $mrpPrice : null;
                                                    }
                                                ?>

                                                
                                                <?php if($product->variants->count() > 0): ?>
                                                    <?php
                                                        $activeOffer = $product->getActiveOffer();
                                                        $hasProductOffer = $activeOffer !== null;
                                                        $discountType = $hasProductOffer ? $activeOffer->discount_type : null;
                                                        $discountValue = $hasProductOffer ? $activeOffer->discount_value : 0;
                                                    ?>
                                                    <div class="product-variant-selector" style="text-align: center; margin-bottom: 8px;">
                                                        <select class="form-control form-control-sm sr-variant-dropdown-<?php echo e($product->id); ?>"
                                                            data-product-id="<?php echo e($product->id); ?>"
                                                            style="font-size: 18px; padding: 5px 28px 5px 10px; height: 45px; width: 100%; display: block; text-align: center; appearance: none; -webkit-appearance: none; -moz-appearance: none; background-image: url('data:image/svg+xml;charset=UTF-8,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22%233BB77E%22%3E%3Cpath d=%22M7 10l5 5 5-5z%22/%3E%3C/svg%3E'); background-repeat: no-repeat; background-position: right 12px center; background-size: 20px; cursor: pointer; border: 1px solid #BCE3C9; border-radius: 5px;">
                                                            <?php $__currentLoopData = $product->variants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $variant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <?php
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
                                                    <div class="sr-product-price-display-<?php echo e($product->id); ?>" style="font-size: 15px; font-weight: 600;">
                                                        <?php if($originalPrice && $originalPrice > $currentPrice): ?>
                                                            <span class="sr-product-mrp-display-<?php echo e($product->id); ?>"
                                                                style="text-decoration: line-through; color: #ADADAD; font-size: 13px; font-weight: 400; margin-right: 6px;">
                                                                ₹<?php echo e(number_format($originalPrice, 0)); ?>

                                                            </span>
                                                        <?php else: ?>
                                                            <span class="sr-product-mrp-display-<?php echo e($product->id); ?>"
                                                                style="text-decoration: line-through; color: #ADADAD; display: none;">
                                                            </span>
                                                        <?php endif; ?>
                                                        <span class="sr-product-sell-price-<?php echo e($product->id); ?>"
                                                            style="color: #3BB77E;">₹<?php echo e(number_format($currentPrice, 0)); ?></span>
                                                    </div>
                                                </div>

                                                
                                                <div style="display: flex; justify-content: space-between; align-items: flex-end; gap: 10px; margin-top: auto;">
                                                    <div style="display: flex; align-items: center; gap: 5px;">
                                                        <label style="font-size: 11px; color: #7E7E7E; margin: 0;">Qty:</label>
                                                        <input type="number" class="sr-product-qty-<?php echo e($product->id); ?>" value="1" min="1" style="width: 40px; height: 28px; font-size: 12px; text-align: center; border: 1px solid #BCE3C9; border-radius: 4px; padding: 0; outline: none;">
                                                    </div>

                                                    <?php
                                                        $firstVariantStock = $product->variants->first() ? ($product->variants->first()->stock ?? 0) : ($product->stock ?? 0);
                                                    ?>
                                                    <div class="add-cart">
                                                        <a href="javascript:void(0)" class="add sr-add-to-cart-btn-<?php echo e($product->id); ?>"
                                                            data-product-id="<?php echo e($product->id); ?>" data-price="<?php echo e($currentPrice); ?>"
                                                            data-stock="<?php echo e($firstVariantStock); ?>"
                                                            style="display: inline-flex; align-items: center; white-space: nowrap; padding: 7px 18px; font-size: 13px; font-weight: 600; <?php echo e($firstVariantStock <= 0 ? 'opacity: 0.5; cursor: not-allowed; pointer-events: none; color: #fff; background-color: #dc3545; border-color: #dc3545;' : ''); ?>">
                                                            <i class="fi-rs-shopping-cart mr-5"></i><?php echo e($firstVariantStock <= 0 ? 'OUT OF STOCK' : 'ADD'); ?>

                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                        <!-- Pagination -->
                        <div class="pagination-area mt-20 mb-20">
                            <nav aria-label="Page navigation">
                                <?php echo e($products->links()); ?>

                            </nav>
                        </div>
                    <?php else: ?>
                        <!-- No Results -->
                        <div class="no-results-wrapper text-center py-5">
                            <div class="no-results-icon mb-4">
                                <i class="fi-rs-search" style="font-size: 80px; color: #ccc;"></i>
                            </div>
                            <h3 class="mb-3">No products found</h3>
                            <p class="text-muted mb-4">
                                <?php if($query): ?>
                                    We couldn't find any products matching "<strong><?php echo e($query); ?></strong>"
                                <?php else: ?>
                                    Please enter a search term to find products.
                                <?php endif; ?>
                            </p>
                            <div class="search-suggestions-box">
                                <p class="mb-2"><strong>Try:</strong></p>
                                <ul class="list-unstyled">
                                    <li><i class="fi-rs-check mr-2"></i> Using different or more general keywords</li>
                                    <li><i class="fi-rs-check mr-2"></i> Checking your spelling</li>
                                    <li><i class="fi-rs-check mr-2"></i> Browsing our <a href="<?php echo e(route('shop')); ?>">shop
                                            page</a></li>
                                </ul>
                            </div>
                            <a href="<?php echo e(route('shop')); ?>" class="btn btn-primary mt-4">
                                <i class="fi-rs-shopping-bag mr-10"></i> Browse All Products
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>

    <style>
        /* Center product price on all screen sizes */
        .product-cart-wrap .product-price,
        .product-cart-wrap .product-card-bottom .product-price {
            text-align: center !important;
        }

        /* Search Results Page Styles */
        .search-header {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 25px 30px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .search-header h1 {
            font-size: 1.8rem;
            color: #253D4E;
            margin-bottom: 5px;
        }

        .search-form-inline .input-group {
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .search-form-inline .form-select {
            border: none;
            background-color: #f5f5f5;
            padding: 12px 15px;
            font-size: 14px;
        }

        .search-form-inline .form-control {
            border: none;
            padding: 12px 15px;
            font-size: 14px;
        }

        .search-form-inline .btn-primary {
            background-color: #3BB77E;
            border: none;
            padding: 12px 20px;
        }

        .search-form-inline .btn-primary:hover {
            background-color: #29a56c;
        }

        /* Product Card Styles — even alignment */
        .product-grid .col-lg-3,
        .product-grid .col-md-4,
        .product-grid .col-sm-6,
        .product-grid .col-6 {
            display: flex;
        }

        .product-cart-wrap {
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            width: 100%;
        }

        .product-cart-wrap:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .product-grid .product-img-action-wrap .product-img {
            height: 220px !important;
            overflow: hidden !important;
        }

        .product-grid .product-img-action-wrap .product-img img.default-img,
        .product-grid .product-img-action-wrap .product-img img.hover-img {
            width: 100% !important;
            height: 220px !important;
            object-fit: contain !important;
            background: #fff;
        }

        .product-grid .product-content-wrap {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .product-grid .product-card-bottom {
            margin-top: auto;
        }

        /* No Results Styles */
        .no-results-wrapper {
            padding: 60px 20px;
            background: #f8f9fa;
            border-radius: 12px;
        }

        .search-suggestions-box {
            display: inline-block;
            text-align: left;
            background: #fff;
            padding: 20px 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .search-suggestions-box li {
            padding: 5px 0;
            color: #666;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .search-header h1 {
                font-size: 1.4rem;
            }

            .search-form-inline {
                margin-top: 15px;
            }

            .search-form-inline .form-select {
                max-width: 100% !important;
            }

            .product-grid .product-img-action-wrap .product-img {
                height: 120px !important;
            }

            .product-grid .product-img-action-wrap .product-img img.default-img,
            .product-grid .product-img-action-wrap .product-img img.hover-img {
                height: 120px !important;
            }
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

    <?php $__env->startPush('scripts'); ?>
    <script>
        $(document).ready(function () {
            // Handle variant dropdown changes
            $('[class*="sr-variant-dropdown-"]').on('change', function () {
                const productId = $(this).data('product-id');
                const selectedOption = $(this).find('option:selected');

                const displayPrice = selectedOption.data('price');
                const mrpPrice = selectedOption.data('mrp-price');
                const sellPrice = selectedOption.data('sell-price');
                const hasOffer = selectedOption.data('has-offer') === 1;
                const stockValue = parseInt(selectedOption.data('stock')) || 0;

                // Update sell price display
                $(`.sr-product-sell-price-${productId}`).text('₹' + Math.round(displayPrice).toLocaleString());

                // Update MRP strike-through price
                const mrpElement = $(`.sr-product-mrp-display-${productId}`);
                const mrpVal = parseFloat(mrpPrice);
                const displayVal = parseFloat(displayPrice);

                if (mrpVal && mrpVal > displayVal) {
                    mrpElement.text('₹' + Math.round(mrpVal).toLocaleString());
                    mrpElement.css('display', 'inline');
                } else {
                    mrpElement.css('display', 'none');
                }

                // Update add to cart button
                const addToCartBtn = $(`.sr-add-to-cart-btn-${productId}`);
                addToCartBtn.data('price', displayPrice);
                addToCartBtn.data('variant-id', selectedOption.data('variant-id'));
                addToCartBtn.data('stock', stockValue);

                if (stockValue <= 0) {
                    addToCartBtn.css({
                        'opacity': '0.5', 'cursor': 'not-allowed', 'pointer-events': 'none',
                        'color': '#fff', 'background-color': '#dc3545', 'border-color': '#dc3545'
                    });
                    addToCartBtn.html('<i class="fi-rs-shopping-cart mr-5"></i>OUT OF STOCK');
                } else {
                    addToCartBtn.css({
                        'opacity': '1', 'cursor': 'pointer', 'pointer-events': 'auto',
                        'color': '', 'background-color': '', 'border-color': ''
                    });
                    addToCartBtn.html('<i class="fi-rs-shopping-cart mr-5"></i>ADD');
                }
            });

            // Handle add to cart
            $('[class*="sr-add-to-cart-btn-"]').on('click', function (e) {
                e.preventDefault();
                const stockValue = parseInt($(this).data('stock')) || 0;
                if (stockValue <= 0) {
                    if (typeof toastr !== 'undefined') toastr.error('This product is out of stock', 'Error');
                    return false;
                }

                const productId = $(this).data('product-id');
                const variantDropdown = $(`.sr-variant-dropdown-${productId}`);
                const qtyInput = $(`.sr-product-qty-${productId}`);

                let variantId = null;
                let unitPrice = $(this).data('price');
                let quantity = qtyInput.length > 0 ? parseInt(qtyInput.val()) || 1 : 1;
                let selectedWeight = null;

                if (variantDropdown.length > 0) {
                    const selectedOption = variantDropdown.find('option:selected');
                    variantId = selectedOption.data('variant-id');
                    unitPrice = selectedOption.data('price');
                    selectedWeight = selectedOption.data('label') || null;
                }

                const csrfToken = $('meta[name="csrf-token"]').attr('content');
                const requestData = {
                    _token: csrfToken,
                    product_id: productId,
                    selected_quantity: quantity,
                    unit_price: unitPrice
                };
                if (variantId) requestData.variant_id = variantId;
                if (selectedWeight) requestData.selected_weight = selectedWeight;

                $.ajax({
                    url: '<?php echo e(route("add-to-cart")); ?>',
                    type: 'POST',
                    data: requestData,
                    success: function (response) {
                        if (response.success) {
                            if (typeof toastr !== 'undefined') toastr.success(response.message);
                            $('#header-cart-count').text(response.cartCount);
                            $('#bottom-header-cart-count').text(response.cartCount);
                            $('#mobile-cart-count').text(response.cartCount);
                        } else {
                            if (typeof toastr !== 'undefined') toastr.error(response.message);
                        }
                    },
                    error: function (xhr) {
                        let errorMsg = 'Something went wrong!';
                        if (xhr.responseJSON && xhr.responseJSON.message) errorMsg = xhr.responseJSON.message;
                        if (typeof toastr !== 'undefined') toastr.error(errorMsg, 'Error');
                    }
                });
            });
        });
    </script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/kidsmittaisbhask/public_html/chennaiangadi/frontend/resources/views/section/search-results.blade.php ENDPATH**/ ?>