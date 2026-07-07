<?php
    // Get user's wishlist product IDs for checking active state
    // Support both logged-in users (database) and guests (session)
    $wishlistProductIds = [];
    if (auth('customer')->check()) {
        $wishlistProductIds = auth('customer')->user()->wishlist()->pluck('product_id')->toArray();
    } else {
        // Guest user - get from session
        $wishlistProductIds = session()->get('guest_wishlist', []);
    }
?>

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

    .product-action-1 .action-btn {
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        width: 40px !important;
        height: 40px !important;
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
        font-size: 16px !important;
        margin: 0 !important;
        padding: 0 !important;
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

    /* Out of stock product card styling */
</style>

<?php if($products->count() > 0): ?>
    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $firstVariantStock = $product->variants->first() ? ($product->variants->first()->stock ?? 0) : ($product->stock ?? 0);
        ?>
        <div class="col-lg-1-5 col-md-4 col-6 col-sm-6" style="margin-bottom: 15px;">
            <div class="product-cart-wrap product-card-<?php echo e($product->id); ?> <?php echo e($firstVariantStock <= 0 ? 'product-out-of-stock' : ''); ?>">
                <div class="product-img-action-wrap position-relative">
                    <?php
                        // productimage is already cast as array in the Product model
                        $images = $product->productimage;

                        // Ensure it's an array and get the first image
                        if (is_array($images) && count($images) > 0) {
                            $primaryImage = $images[0];
                        } else {
                            $primaryImage = null;
                        }

                        // Fix Windows backslashes to web-safe forward slashes
                        if ($primaryImage) {
                            $primaryImage = str_replace('\\', '/', $primaryImage);
                            // Remove leading 'uploads/' if present
                            if (strpos($primaryImage, 'uploads/') === 0) {
                                $primaryImage = substr($primaryImage, 8);
                            }
                        }
                    ?>
                    <a href="<?php echo e(route('product.details', $product->id)); ?>" class="product-card-link">
                        <?php if($primaryImage): ?>
                            <img class="default-img" src="<?php echo e(config('app.admin_asset_url')); ?>/<?php echo e($primaryImage); ?>" 
                                alt="<?php echo e($product->productname); ?>"
                                onerror="this.src='<?php echo e(asset('assets/imgs/theme/icons/category-1.svg')); ?>'">
                        <?php else: ?>
                            <img class="default-img" src="<?php echo e(asset('assets/imgs/theme/icons/category-1.svg')); ?>" 
                                 alt="<?php echo e($product->productname); ?>">
                        <?php endif; ?>
                    </a>
                    <div class="product-action-1" style="<?php echo e($firstVariantStock <= 0 ? 'display: none !important;' : ''); ?>">
                        <a aria-label="Add To Wishlist"
                            class="action-btn add-to-wishlist <?php echo e(in_array($product->id, $wishlistProductIds) ? 'active' : ''); ?>"
                            data-id="<?php echo e($product->id); ?>" href="javascript:void(0)">
                            <i class="fi-rs-heart"></i>
                        </a>
                        <a aria-label="Quick view" class="action-btn quick-view-btn"
                            href="javascript:void(0)" data-product-id="<?php echo e($product->id); ?>">
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
                        <a href="<?php echo e($firstVariantStock <= 0 ? 'javascript:void(0)' : route('product.details', $product->id)); ?>" class="product-card-link">
                            <?php echo e($product->productname); ?>

                        </a>
                    </h2>

                    <div class="product-card-bottom" style="flex-direction: column; align-items: stretch;">
                        <?php
                            // Get first variant's prices if available
                            $firstVariant = $product->variants->first();
                            $sellPrice = $firstVariant
                                ? ($firstVariant->sell_price ?? $firstVariant->price)
                                : ($product->sell_price ?? $product->price ?? 0);
                            $mrpPrice = $firstVariant
                                ? $firstVariant->price
                                : ($product->price ?? 0);

                            // Check for active offer
                            $offerPrice = $product->offer_price;
                            $hasOffer = $offerPrice !== null;
                            if ($hasOffer) {
                                // Product has an offer - show offer price as main, MRP as strike-through
                                $currentPrice = $offerPrice;
                                $originalPrice = $product->offer_mrp;
                            } else {
                                // No offer - show sell_price as main, mrp_price as strike-through (if higher)
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
                                <select class="form-control product_Dropdown variant-dropdown-<?php echo e($product->id); ?>"
                                    data-product-id="<?php echo e($product->id); ?>"
                                    style="width: 100%; display: inline-block; appearance: none; -webkit-appearance: none; -moz-appearance: none; background-image: url('data:image/svg+xml;charset=UTF-8,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22%233BB77E%22%3E%3Cpath d=%22M7 10l5 5 5-5z%22/%3E%3C/svg%3E'); background-repeat: no-repeat; background-position: right 12px center; background-size: 20px; padding-right: 40px; cursor: pointer; border: 1px solid #BCE3C9; border-radius: 5px; height: 45px; font-size: 18px;" <?php echo e($firstVariantStock <= 0 ? 'disabled' : ''); ?>>
                                    <?php $__currentLoopData = $product->variants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $variant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                            <div class="product-price-display-<?php echo e($product->id); ?>" style="font-size: 15px; font-weight: 600;">
                                <?php if($originalPrice && $originalPrice > $currentPrice): ?>
                                    <span class="product-mrp-display-<?php echo e($product->id); ?>"
                                        style="text-decoration: line-through; color: #ADADAD; font-size: 15px; font-weight: 600; margin-right: 10px;">
                                        ₹<?php echo e(number_format($originalPrice, 0)); ?>

                                    </span>
                                <?php else: ?>
                                    <span class="product-mrp-display-<?php echo e($product->id); ?>"
                                        style="text-decoration: line-through; color: #ADADAD; display: none;">
                                    </span>
                                <?php endif; ?>
                                <span class="product-sell-price-<?php echo e($product->id); ?>"
                                    style="color: #3BB77E;">₹<?php echo e(number_format($currentPrice, 0)); ?></span>
                            </div>
                        </div>

                        
                        <div
                            style="display: flex; justify-content: space-between; align-items: flex-end; margin-top: auto;">
                            
                            <div style="display: flex; align-items: center;" class="col-6 pe-1">
                                <label class="qty-label">Qty:</label>
                                <input type="number" class="qty-input product-qty-<?php echo e($product->id); ?>" value="1" min="1" <?php echo e($firstVariantStock <= 0 ? 'disabled' : ''); ?>>
                            </div>

                            
                            <div class="add-cart col-6 ps-1" style="<?php echo e($firstVariantStock <= 0 ? 'display: none !important;' : ''); ?>">
                                <a href="javascript:void(0)" class="add col-12 add-to-cart-btn-<?php echo e($product->id); ?>"
                                    data-product-id="<?php echo e($product->id); ?>" data-price="<?php echo e($currentPrice); ?>"
                                    data-stock="<?php echo e($firstVariantStock); ?>"
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

    <?php if($products instanceof \Illuminate\Pagination\LengthAwarePaginator && $products->hasPages()): ?>
        <div class="col-12 mt-20 mb-20 d-flex justify-content-center">
            <div class="pagination-area">
                <?php
                    $totalPages = $products->lastPage();
                    $currentPage = $products->currentPage();
                ?>

                <ul class="pagination justify-content-center">
                    <!-- Previous arrow -->
                    <li class="page-item <?php echo e($currentPage == 1 ? 'disabled' : ''); ?>">
                        <a class="page-link d-flex align-items-center justify-content-center pagination-ajax-link" href="<?php echo e($products->url($currentPage - 1)); ?>"><i
                                class="fi-rs-angle-left"></i></a>
                    </li>

                    <?php for($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?php echo e($i == $currentPage ? 'active' : ''); ?>">
                            <a class="page-link d-flex align-items-center justify-content-center pagination-ajax-link" href="<?php echo e($products->url($i)); ?>"><?php echo e($i); ?></a>
                        </li>
                    <?php endfor; ?>

                    <!-- Next arrow -->
                    <li class="page-item <?php echo e($currentPage == $totalPages ? 'disabled' : ''); ?>">
                        <a class="page-link d-flex align-items-center justify-content-center pagination-ajax-link" href="<?php echo e($products->url($currentPage + 1)); ?>"><i
                                class="fi-rs-angle-right"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    <?php endif; ?>
<?php else: ?>
    <div class="col-12">
        <div class="alert alert-info text-center">
            <p class="mb-0">No products found in this category.</p>
        </div>
    </div>
<?php endif; ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        // Handle variant dropdown changes
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

    /**
    * ADD TO CART FUNCTION
    * @param productId - Product ID
    * @param displayPrice - The calculated display price (offer_price or sell_price or variant price)
    * @param variantId - Variant ID (optional, for variable products)
    * @param quantity - Quantity to add (default 1)
    */
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

</script><?php /**PATH C:\xampp\htdocs\chennai\frontend\resources\views/section/products.blade.php ENDPATH**/ ?>