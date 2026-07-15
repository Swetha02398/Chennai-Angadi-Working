<?php
    $listItemStock = $product->variants->first() ? ($product->variants->first()->stock ?? 0) : ($product->stock ?? 0);
?>
<article class="row align-items-center hover-up <?php echo e($listItemStock <= 0 ? 'product-out-of-stock' : ''); ?>">
    <figure class="col-md-4 mb-0">
        <a href="<?php echo e(route('product.details', $product->slug)); ?>" class="product-card-link">
            <?php
                $images = $product->productimage;
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
                src="<?php echo e(env('ADMIN_ASSET_URL')); ?>/products/<?php echo e($primaryImage); ?>" width="90"
                height="90" alt="<?php echo e($product->productname); ?>"
                onerror="this.src='<?php echo e(asset('assets/imgs/theme/icons/category-1.svg')); ?>'">
        </a>
    </figure>
    <div class="col-md-8 mb-0">
        <h6>
            <a href="<?php echo e(route('product.details', $product->slug)); ?>"><?php echo e($product->productname); ?></a>
        </h6>


        <div class="product-price">
            <?php
                $firstVariant = $product->variants->first();
                $sellPrice = $firstVariant
                    ? ($firstVariant->sell_price ?? $firstVariant->price)
                    : ($product->sell_price ?? $product->price);
                $mrpPrice = $firstVariant
                    ? $firstVariant->price
                    : $product->price;

                $offerPrice = $product->offer_price;
                $hasOffer = $offerPrice !== null;
                if ($hasOffer) {
                    $displayPrice = $offerPrice;
                    $strikePrice = $product->offer_mrp;
                } else {
                    $displayPrice = $sellPrice;
                    $strikePrice = ($mrpPrice && $mrpPrice > $sellPrice) ? $mrpPrice : null;
                }
            ?>
            <span>₹<?php echo e(number_format($displayPrice, 0)); ?></span>
            <?php if($strikePrice && $strikePrice > $displayPrice): ?>
                <span class="old-price" style="text-decoration: line-through;">₹<?php echo e(number_format($strikePrice, 0)); ?></span>
            <?php endif; ?>
        </div>
    </div>
</article>
<?php /**PATH C:\xampp\htdocs\chennais\frontend\resources\views/section/product-list-item.blade.php ENDPATH**/ ?>