

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
                            <?php echo $__env->make('section.product-cards', ['products' => $products], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
    </style>


    <?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('assets/js/plugins/lazysizes.min.js')); ?>" async=""></script>
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
                const displayVal = parseFloat(displayPrice);

                if (mrpVal && mrpVal > displayVal) {
                    mrpElement.text('₹' + Math.round(mrpVal).toLocaleString());
                    mrpElement.css('display', 'inline');
                } else {
                    mrpElement.css('display', 'none');
                }

                // Update add to cart button
                const addToCartBtn = $(`.add-to-cart-btn-${productId}`);
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
            $('[class*="add-to-cart-btn-"]').on('click', function (e) {
                e.preventDefault();
                const stockValue = parseInt($(this).data('stock')) || 0;
                if (stockValue <= 0) {
                    if (typeof toastr !== 'undefined') toastr.error('This product is out of stock', 'Error');
                    return false;
                }

                const productId = $(this).data('product-id');
                const variantDropdown = $(`.variant-dropdown-${productId}`);
                const qtyInput = $(`.product-qty-${productId}`);

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
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\chennais\frontend\resources\views/section/search-results.blade.php ENDPATH**/ ?>