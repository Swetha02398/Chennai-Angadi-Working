

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
                    <div class="row product-grid" id="infinite-scroll-grid">
                        <?php echo $__env->make('section.product-cards', ['products' => $products], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>

                    <!-- Loading Spinner & End Message -->
                    <div id="infinite-scroll-loader" class="text-center" style="display: none; padding: 20px;">
                        <div class="spinner-border text-success" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                    <div id="infinite-scroll-end" class="text-center" style="display: none; padding: 20px; color: #777;">
                        <p>No More Products Available</p>
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
            const sort = this.getAttribute('href').split('sort=')[1];

            // Re-fetch the first page of products based on sort parameter using infinite scroll loader
            isLoading = true;
            currentPage = 1;
            hasMoreProducts = true;
            document.getElementById('infinite-scroll-grid').innerHTML = ''; // Clear existing
            document.getElementById('infinite-scroll-loader').style.display = 'block';
            document.getElementById('infinite-scroll-end').style.display = 'none';

            let fetchUrl = new URL(window.location.href);
            fetchUrl.searchParams.set('sort', sort);
            fetchUrl.searchParams.set('page', 1);

            fetch(fetchUrl, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(res => res.json())
            .then(data => {
                document.getElementById('infinite-scroll-loader').style.display = 'none';
                if (data.html) {
                    document.getElementById('infinite-scroll-grid').innerHTML = data.html;
                }
                hasMoreProducts = data.hasMore;
                if (!hasMoreProducts) {
                    document.getElementById('infinite-scroll-end').style.display = 'block';
                }
                isLoading = false;
                
                // Update URL gently
                window.history.pushState(null, '', fetchUrl.pathname + '?sort=' + sort);
            })
            .catch(err => {
                console.error(err);
                document.getElementById('infinite-scroll-loader').style.display = 'none';
                isLoading = false;
            });
        });
    });

    let currentPage = 1;
    let isLoading = false;
    let hasMoreProducts = true;
    
    function handleScroll() {
        if (isLoading || !hasMoreProducts) return;
        
        if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight - 400) {
            isLoading = true;
            currentPage++;
            
            document.getElementById('infinite-scroll-loader').style.display = 'block';
            
            let fetchUrl = new URL(window.location.href);
            fetchUrl.searchParams.set('page', currentPage);
            
            fetch(fetchUrl, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('infinite-scroll-loader').style.display = 'none';
                
                if (data.html) {
                    document.getElementById('infinite-scroll-grid').insertAdjacentHTML('beforeend', data.html);
                }
                
                hasMoreProducts = data.hasMore;
                
                if (!hasMoreProducts) {
                    document.getElementById('infinite-scroll-end').style.display = 'block';
                }
                
                isLoading = false;
            })
            .catch(error => {
                console.error('Error fetching products:', error);
                document.getElementById('infinite-scroll-loader').style.display = 'none';
                isLoading = false;
            });
        }
    }

    // Attach scroll event dynamically
    window.addEventListener('scroll', handleScroll);
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.3.2/lazysizes.min.js" async></script>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\chennais\frontend\resources\views/section/shop.blade.php ENDPATH**/ ?>