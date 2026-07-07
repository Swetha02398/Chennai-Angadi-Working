

<?php $__env->startSection('seo_title', 'Shop - Authentic Chennai Groceries Online - ' . config('app.name')); ?>
<?php $__env->startSection('seo_description', 'Browse our full range of authentic Chennai groceries, snacks, and traditional sweets. Quality products delivered to your doorstep.'); ?>
<?php $__env->startSection('og_title', 'Shop - ' . config('app.name')); ?>
<?php $__env->startSection('og_description', 'Authentic Chennai groceries and snacks online.'); ?>
<?php $__env->startSection('content'); ?>
    <!-- Main -->
    <style>
        /* Center product price on all screen sizes */
        .product-cart-wrap .product-price,
        .product-cart-wrap .product-card-bottom .product-price {
            text-align: center !important;
        }

        .product-cart-wrap {
            display: flex;
            flex-direction: column;
        }

        .product-content-wrap {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            gap: 0;
        }

        .product-content-wrap h2 {
            margin-bottom: 4px;
        }

        .product-card-bottom {
            padding-top: 0;
        }

        /* Center icons inside action buttons */
        .product-action-1 {
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

        .product-action-1 .action-btn {
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

        .product-action-1 .action-btn:hover {
            background: #3BB77E;
            border-color: #3BB77E;
            color: #fff;
        }

        .product-action-1 .action-btn.active,
        .product-action-1 .action-btn.active i {
            color: #ff0000 !important;
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

        .product-img-action-wrap {
            position: relative;
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
    <main class="main">
        <div class="page-header my-3 mb-1">
            <div class="container">
                <div class="archive-header">
                    <div class="row align-items-center">
                        <div class="col-xl-12">
                            <h4 class="mb-2">Shop</h4>
                            <div class="breadcrumb">
                                <a href="<?php echo e(route('index')); ?>" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                                <span></span> Shop <span></span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="container mb-30">
            <div class="row">
                <div class="col-12">
                    <div class="shop-product-fillter pb-1">
                        <div class="totall-product">
                            <p>We found <strong class="text-brand"><?php echo e($totalProducts); ?></strong> items for you!</p>
                        </div>
                        <div class="sort-by-product-area">
                            <div class="sort-by-cover">
                                <div class="sort-by-product-wrap">
                                    <div class="sort-by">
                                        <span><i class="fi-rs-apps-sort"></i>Sort by:</span>
                                    </div>
                                    <div class="sort-by-dropdown-wrap">
                                        <span>
                                            <?php if(request('sort') == 'low'): ?>
                                                Price: Low to High
                                            <?php elseif(request('sort') == 'high'): ?>
                                                Price: High to Low
                                            <?php else: ?>
                                                Featured
                                            <?php endif; ?>
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
                    <div class="row product-grid">
                        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $firstVariantStock = $p->variants->first() ? ($p->variants->first()->stock ?? 0) : ($p->stock ?? 0);
                            ?>
                            <div class="col-lg-1-5 col-md-4 col-6 col-sm-6" style="margin-bottom: 15px;">
                                <div class="product-cart-wrap mb-30 product-card-<?php echo e($p->id); ?> <?php echo e($firstVariantStock <= 0 ? 'product-out-of-stock' : ''); ?>">
                                    <div class="product-img-action-wrap">
                                        <div class="product-img product-img-zoom">
                                            <a href="<?php echo e(route('product.details', $p->id)); ?>" class="product-card-link">
                                                <?php
                                                    // productimage is already cast as array in the Product model
                                                    $images = $p->productimage;

                                                    // Ensure it's an array and get the first image
                                                    if (is_array($images) && count($images) > 0) {
                                                        $primaryImage = $images[0];
                                                    } else {
                                                        $primaryImage = null;
                                                    }
                                                    if ($primaryImage) {
                                                        $primaryImage = str_replace('\\', '/', $primaryImage);
                                                        $primaryImage = basename($primaryImage);
                                                    }
                                                ?>
                                                <img class="default-img"
                                                    src="<?php echo e(env('ADMIN_ASSET_URL')); ?>/products/<?php echo e($primaryImage); ?>"
                                                     alt="<?php echo e($p->productname); ?>"
                                                    onerror="this.src='<?php echo e(asset('assets/imgs/theme/icons/category-1.svg')); ?>'">
                                            </a>
                                        </div>
                                        <div class="product-action-1" style="<?php echo e($firstVariantStock <= 0 ? 'display: none !important;' : ''); ?>">
                                            <a aria-label="Add To Wishlist"
                                                class="action-btn add-to-wishlist <?php echo e((auth('customer')->check() && auth('customer')->user()->wishlist()->where('product_id', $p->id)->exists()) || (!auth('customer')->check() && in_array($p->id, session()->get('guest_wishlist', []))) ? 'active' : ''); ?>"
                                                data-id="<?php echo e($p->id); ?>" href="javascript:void(0)">
                                                <i class="fi-rs-heart"></i>
                                            </a>
                                            <a aria-label="Quick view" class="action-btn quick-view-btn"
                                                href="javascript:void(0)" data-product-id="<?php echo e($p->id); ?>">
                                                <i class="fi-rs-eye"></i>
                                            </a>
                                        </div>
                                        <?php if($firstVariantStock <= 0): ?>
                                            <div class="product-badges product-badges-position product-badges-mrg">
                                                <span class="hot" style="background-color: #dc3545;">OUT OF STOCK</span>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="product-content-wrap">
                                        <h2 style="text-align: center;">
                                            <a href="<?php echo e(route('product.details', $p->id)); ?>" class="product-card-link">
                                                <?php echo e($p->productname); ?>

                                            </a>
                                        </h2>

                                        <div class="product-card-bottom" style="flex-direction: column; align-items: stretch;">
                                            <?php
                                                // Get first variant's prices if available
                                                $firstVariant = $p->variants->first();
                                                $sellPrice = $firstVariant
                                                    ? ($firstVariant->sell_price ?? $firstVariant->price)
                                                    : ($p->sell_price ?? $p->price ?? 0);
                                                $mrpPrice = $firstVariant
                                                    ? $firstVariant->price
                                                    : ($p->price ?? 0);

                                                // Check for active offer
                                                $offerPrice = $p->offer_price;
                                                $hasOffer = $offerPrice !== null;
                                                if ($hasOffer) {
                                                    $currentPrice = $offerPrice;
                                                    $originalPrice = $p->offer_mrp;
                                                } else {
                                                    $currentPrice = $sellPrice;
                                                    $originalPrice = ($mrpPrice && $mrpPrice > $sellPrice) ? $mrpPrice : null;
                                                }
                                            ?>

                                            
                                            <?php if($p->variants->count() > 0): ?>
                                                <?php
                                                    $activeOffer = $p->getActiveOffer();
                                                    $hasProductOffer = $activeOffer !== null;
                                                    $discountType = $hasProductOffer ? $activeOffer->discount_type : null;
                                                    $discountValue = $hasProductOffer ? $activeOffer->discount_value : 0;
                                                ?>
                                                <div class="product-variant-selector" style="text-align: center; margin-bottom: 8px;">
                                                    <select class="form-control product_Dropdown variant-dropdown-<?php echo e($p->id); ?>"
                                                        data-product-id="<?php echo e($p->id); ?>"
                                                        style="width: 100%; display: inline-block; appearance: none; -webkit-appearance: none; -moz-appearance: none; background-image: url('data:image/svg+xml;charset=UTF-8,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22%233BB77E%22%3E%3Cpath d=%22M7 10l5 5 5-5z%22/%3E%3C/svg%3E'); background-repeat: no-repeat; background-position: right 12px center; background-size: 20px; padding-right: 40px; cursor: pointer; border: 1px solid #BCE3C9; border-radius: 5px; height: 45px; font-size: 18px;" <?php echo e($firstVariantStock <= 0 ? 'disabled' : ''); ?>>
                                                        <?php $__currentLoopData = $p->variants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $variant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                                                                data-price="<?php echo e($displayPrice); ?>"
                                                                data-sell-price="<?php echo e($variantSellPrice); ?>"
                                                                data-mrp-price="<?php echo e($hasProductOffer ? $variantSellPrice : $variantMrp); ?>"
                                                                data-offer-price="<?php echo e($hasProductOffer ? $variantOfferPrice : ''); ?>"
                                                                data-has-offer="<?php echo e($hasProductOffer ? '1' : '0'); ?>"
                                                                data-stock="<?php echo e($variant->stock ?? 0); ?>"
                                                                data-label="<?php echo e($quantityLabel); ?>" <?php echo e($index === 0 ? 'selected' : ''); ?>>
                                                                <?php echo e($quantityLabel); ?> - ₹<?php echo e(number_format($displayPrice, 0)); ?>

                                                            </option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>
                                            <?php endif; ?>

                                            
                                            <div class="product-price" style="text-align: center; margin-bottom: 10px;">
                                                <div class="product-price-display-<?php echo e($p->id); ?>"
                                                    style="font-size: 15px; font-weight: 600;">
                                                    <?php if($originalPrice && $originalPrice > $currentPrice): ?>
                                                        <span class="product-mrp-display-<?php echo e($p->id); ?>"
                                                            style="text-decoration: line-through; color: #ADADAD; font-size: 18px; font-weight: 400; margin-right: 6px;">
                                                            ₹<?php echo e(number_format($originalPrice, 0)); ?>

                                                        </span>
                                                    <?php else: ?>
                                                        <span class="product-mrp-display-<?php echo e($p->id); ?>"
                                                            style="text-decoration: line-through; color: #ADADAD; display: none;">
                                                        </span>
                                                    <?php endif; ?>
                                                    <span class="product-sell-price-<?php echo e($p->id); ?>"
                                                        style="color: #3BB77E;">₹<?php echo e(number_format($currentPrice, 0)); ?></span>
                                                </div>
                                            </div>

                                            
                                            <div
                                                style="display: flex; justify-content: space-between; align-items: flex-end; margin-top: auto;">
                                                
                                                
                                                <div style="display: flex; align-items: center;" class="col-6 pe-1">
                                                    <label class="qty-label">Qty:</label>
                                                    <input type="number" class="qty-input product-qty-<?php echo e($p->id); ?>" value="1" min="1" <?php echo e($firstVariantStock <= 0 ? 'disabled' : ''); ?>>
                                                </div>

                                                
                                                <div class="add-cart col-6 ps-1" style="<?php echo e($firstVariantStock <= 0 ? 'display: none !important;' : ''); ?>">
                                                    <a href="javascript:void(0)" class="add col-12 add-to-cart-btn-<?php echo e($p->id); ?>"
                                                        data-product-id="<?php echo e($p->id); ?>" data-price="<?php echo e($currentPrice); ?>"
                                                        data-stock="<?php echo e($firstVariantStock); ?>"
                                                        style="display:flex; justify-content:center; align-items: center; white-space: nowrap; padding: 7px 18px; font-size: 13px; font-weight: 600;">
                                                        <i class="fi-rs-shopping-cart mr-5"></i>ADD
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <div class="mt-3">
                        <?php echo e($products->links()); ?>

                    </div>

                    <!--product grid-->
                    <div class="pagination-area mt-20 mb-20">
                        <?php
                            $totalPages = $products->lastPage();
                            $currentPage = $products->currentPage();
                        ?>

                        <ul class="pagination justify-content-start">
                            <!-- Previous arrow -->
                            <li class="page-item <?php echo e($currentPage == 1 ? 'disabled' : ''); ?>">
                                <a class="page-link d-flex align-items-center justify-content-center" href="<?php echo e($products->url($currentPage - 1)); ?>"><i
                                        class="fi-rs-angle-left"></i></a>
                            </li>

                            <?php for($i = 1; $i <= $totalPages; $i++): ?>
                                <li class="page-item <?php echo e($i == $currentPage ? 'active' : ''); ?>">
                                    <a class="page-link d-flex align-items-center justify-content-center" href="<?php echo e($products->url($i)); ?>"><?php echo e($i); ?></a>
                                </li>
                            <?php endfor; ?>

                            <!-- Next arrow -->
                            <li class="page-item <?php echo e($currentPage == $totalPages ? 'disabled' : ''); ?>">
                                <a class="page-link d-flex align-items-center justify-content-center " href="<?php echo e($products->url($currentPage + 1)); ?>"><i
                                        class="fi-rs-angle-right"></i></a>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </main>
    <!-- End Main -->
<?php $__env->stopSection(); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    $(document).ready(function () {
        // Handle variant dropdown changes - dynamic price update
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
        $('[class*="add-to-cart-btn-"]').on('click', function (e) {
            e.preventDefault();

            // Check stock before proceeding
            const stockValue = parseInt($(this).data('stock')) || 0;
            if (stockValue <= 0) {
                toastr.error('This product is out of stock', 'Error');
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

            shopAddToCart(productId, unitPrice, variantId, quantity);
        });
    });

    /**
     * ADD TO CART FUNCTION
     */
    function shopAddToCart(productId, displayPrice, variantId, quantity) {
        const csrfToken = $('meta[name="csrf-token"]').attr('content') || '<?php echo e(csrf_token()); ?>';

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
                    toastr.success(response.message);
                    $('#header-cart-count').text(response.cartCount);
                    $('#bottom-header-cart-count').text(response.cartCount);
                    $('#mobile-cart-count').text(response.cartCount);
                } else {
                    toastr.error(response.message);
                }
            },
            error: function (xhr) {
                const errorMsg = xhr.responseJSON ? xhr.responseJSON.message : 'Something went wrong!';
                toastr.error(errorMsg, 'Error');
                console.log(xhr.responseText);
            }
        });
    }

    document.querySelectorAll('.sort-by-dropdown a').forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            const sort = this.getAttribute('data-sort');

            // AJAX call
            fetch(`/filter/products?sort=${sort}`)
                .then(res => res.text())
                .then(html => {
                    document.querySelector('#productArea').innerHTML = html;
                });
        });
    });
</script>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/kidsmittaisbhask/public_html/chennaiangadi/frontend/resources/views/section/shop.blade.php ENDPATH**/ ?>