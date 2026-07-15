<?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php
        $firstVariantStock = $product->variants->first() ? ($product->variants->first()->stock ?? 0) : ($product->stock ?? 0);
    ?>
    <div class="col-lg-1-5 col-md-4 col-6 col-sm-6 product-card-wrapper" style="margin-bottom: 15px;">
        <div class="product-cart-wrap mb-30 product-card-<?php echo e($product->id); ?> <?php echo e($firstVariantStock <= 0 ? 'product-out-of-stock' : ''); ?>">
            <div class="product-img-action-wrap">
                <div class="product-img product-img-zoom">
                    <a href="<?php echo e(route('product.details', $product->slug)); ?>" class="product-card-link">
                        <?php
                            // productimage is already cast as array in the Product model
                            $images = $product->productimage;

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
                        <img class="default-img lazyload"
                            data-src="<?php echo e(rtrim(config('app.admin_asset_url', env('ADMIN_ASSET_URL', 'http://localhost/chennais/adminpanel/public/uploads')), '/')); ?>/products/<?php echo e($primaryImage); ?>"
                            src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs="
                             alt="<?php echo e($product->productname); ?>"
                            onerror="this.src='<?php echo e(asset('assets/imgs/theme/icons/category-1.svg')); ?>'">
                    </a>
                </div>
                <div class="product-action-1" style="<?php echo e($firstVariantStock <= 0 ? 'display: none !important;' : ''); ?>">
                    <a aria-label="Add To Wishlist"
                        class="action-btn add-to-wishlist <?php echo e((auth('customer')->check() && auth('customer')->user()->wishlist()->where('product_id', $product->id)->exists()) || (!auth('customer')->check() && in_array($product->id, session()->get('guest_wishlist', []))) ? 'active' : ''); ?>"
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
                    <a href="<?php echo e(route('product.details', $product->slug)); ?>" class="product-card-link">
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
                            <select class="form-control product_Dropdown variant-dropdown-<?php echo e($product->id); ?>"
                                data-product-id="<?php echo e($product->id); ?>"
                                style="width: 100%; display: inline-block; appearance: none; -webkit-appearance: none; -moz-appearance: none; background-image: url('data:image/svg+xml;charset=UTF-8,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22%233BB77E%22%3E%3Cpath d=%22M7 10l5 5 5-5z%22/%3E%3C/svg%3E'); background-repeat: no-repeat; background-position: right 12px center; background-size: 20px; padding-right: 40px; cursor: pointer; border: 1px solid #BCE3C9; border-radius: 5px; height: 45px; font-size: 18px;" <?php echo e($firstVariantStock <= 0 ? 'disabled' : ''); ?>>
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
                        <div class="product-price-display-<?php echo e($product->id); ?>"
                            style="font-size: 15px; font-weight: 600;">
                            <?php if($originalPrice && $originalPrice > $currentPrice): ?>
                                <span class="product-mrp-display-<?php echo e($product->id); ?>"
                                    style="text-decoration: line-through; color: #ADADAD; font-size: 18px; font-weight: 400; margin-right: 6px;">
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

<?php if($products instanceof \Illuminate\Pagination\LengthAwarePaginator && $products->hasPages() && in_array(request()->route()->getName(), ['home', 'index', 'shop', 'filter.products'])): ?>
    <div class="pagination-area mt-30 mb-50 col-12 d-flex justify-content-center ajax-pagination-links">
        <?php echo e($products->appends(request()->query())->links('vendor.pagination.custom')); ?>

    </div>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\chennais\frontend\resources\views/section/product-cards.blade.php ENDPATH**/ ?>