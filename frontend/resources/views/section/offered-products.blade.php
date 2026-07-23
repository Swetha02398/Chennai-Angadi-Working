<section class="pt-5 pb-2">
    <div class="container">
        <div class="section-title wow animate__animated animate__fadeIn">
            <h3>Offered Products</h3>
        </div>

        @forelse($offers as $index => $offer)
            <div class="row mb-3">
                <!-- Banner -->
                <div class="col-lg-2 offer-banner-col">
                    <div class="banner-img style-2 banner-glass"
                        style="background-image:url('{{ env('ADMIN_ASSET_URL') }}/offers/{{ $offer->banner_image }}');
                                                                                                        width:100%; height:370px; object-fit:cover; border-radius:8px;">
                        <div class="banner-text">
                            <h2>{{ $offer->title }}</h2>
                            <a href="{{ route('shop') }}" class="btn btn-xs">Shop Now <i
                                    class="fi-rs-arrow-small-right"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Products horizontal scroll -->
                <div class="col-lg-10 col-md-12 wow animate__animated animate__fadeIn" data-wow-delay=".3s">
                    <div class="scroll-wrapper position-relative">
                        <div class="scroll-container" id="scroll-container-{{ $offer->id }}">
                            @forelse($offerProducts[$offer->id] as $product)
                                @php
                                    $firstVariantStock = $product->variants->first() ? ($product->variants->first()->stock ?? 0) : ($product->stock ?? 0);
                                @endphp
                                <div class="product-cart-wrap offer-product-card-{{ $product->id }} {{ $firstVariantStock <= 0 ? 'product-out-of-stock' : '' }}">
                                    <div class="product-img-action-wrap">
                                            <div class="product-img product-img-zoom">
                                                <a href="{{ route('product.details', $product->slug) }}" class="product-card-link">
                                                    @php
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
                                                    @endphp
                                                    <img class="default-img"
                                                        src="{{ env('ADMIN_ASSET_URL') }}/products/{{ $primaryImage }}"
                                                        alt="{{ $product->productname }}"
                                                        style="width:100%; height:150px; object-fit:cover; border-radius:8px;"
                                                        onerror="this.src='{{ asset('assets/imgs/theme/icons/category-1.svg') }}'">
                                                </a>
                                            </div>
                                            <div class="product-action-1" style="{{ $firstVariantStock <= 0 ? 'display: none !important;' : '' }}">
                                                <a aria-label="Add To Wishlist"
                                                    class="action-btn add-to-wishlist {{ in_array($product->id, $wishlistProductIds ?? []) ? 'active' : '' }}"
                                                    data-id="{{ $product->id }}" href="javascript:void(0)"><i
                                                        class="fi-rs-heart"></i></a>
                                                <a aria-label="Quick view" class="action-btn quick-view-btn"
                                                    href="javascript:void(0)" data-product-id="{{ $product->id }}">
                                                    <i class="fi-rs-eye"></i>
                                                </a>
                                            </div>
                                            <div class="product-badges product-badges-position product-badges-mrg">
                                                @if($firstVariantStock <= 0)
                                                    <span class="hot" style="background-color: #dc3545;">OUT OF STOCK</span>
                                                @else
                                                     @if ($offer->discount_type === 'percentage')
                                                        <span class="hot">Save {{ (float)$offer->discount_value }}%</span>
                                                    @else
                                                        <span class="hot">Save ₹{{ (float)$offer->discount_value }}</span>
                                                    @endif
                                                @endif
                                            </div>
                                    </div>
                                    <div class="product-content-wrap">
                                        <h2 style="text-align: center;"><a
                                                href="{{ route('product.details', $product->slug) }}" class="product-card-link">{{ $product->productname }}</a>
                                        </h2>

                                        <div class="product-card-bottom" style="flex-direction: column; align-items: stretch;">
                                            @php
                                                // Offer discount info from the current $offer
                                                $discountType = $offer->discount_type;
                                                $discountValue = $offer->discount_value;
                                            @endphp

                                            {{-- Variant Dropdown - Centered --}}
                                            @if($product->variants->count() > 0)
                                                @php
                                                    $firstVariant = $product->variants->first();
                                                    // Calculate offer price for first variant (initial display)
                                                    $firstSell = $firstVariant ? ($firstVariant->sell_price ?? $firstVariant->price) : ($product->sell_price ?? $product->price);
                                                    $firstMrp = $firstSell;
                                                    if ($discountType === 'percentage') {
                                                        $firstDiscount = ($firstSell * $discountValue) / 100;
                                                    } else {
                                                        $firstDiscount = $discountValue;
                                                    }
                                                    $firstOfferPrice = max(0, round($firstSell - $firstDiscount, 2));
                                                @endphp
                                                <div class="product-variant-selector" style="text-align: center;">
                                                    <select class="form-control form-control-sm product_Dropdown offer-variant-dropdown-{{ $product->id }}"
                                                        data-product-id="{{ $product->id }}" {{ $firstVariantStock <= 0 ? 'disabled' : '' }}>
                                                        @foreach($product->variants as $vIndex => $variant)
                                                            @php
                                                                $variantMrp = $variant->price ?? 0;
                                                                $variantSellPrice = $variant->sell_price ?? $variant->price;
                                                                // Apply offer discount to each variant's selling price
                                                                if ($discountType === 'percentage') {
                                                                    $vDiscount = ($variantSellPrice * $discountValue) / 100;
                                                                } else {
                                                                    $vDiscount = $discountValue;
                                                                }
                                                                $variantOfferPrice = max(0, round($variantSellPrice - $vDiscount, 2));
                                                                $quantityLabel = $variant->quantity->name ?? $variant->quantity->label;
                                                            @endphp
                                                            <option value="{{ $variant->id }}"
                                                                data-variant-id="{{ $variant->id }}"
                                                                data-offer-price="{{ $variantOfferPrice }}"
                                                                data-mrp-price="{{ $variantSellPrice }}"
                                                                data-stock="{{ $variant->stock ?? 0 }}"
                                                                data-label="{{ $quantityLabel }}"
                                                                {{ $vIndex === 0 ? 'selected' : '' }}>
                                                                {{ $quantityLabel }} - ₹{{ number_format($variantOfferPrice, 2) }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                {{-- Price Display - Centered --}}
                                                <div class="product-price" style="text-align: center; margin-bottom: 10px;">
                                                    <div class="offer-price-display-{{ $product->id }}" style="font-size: 15px; font-weight: 600;">
                                                        @if($firstMrp > $firstOfferPrice)
                                                            <span class="offer-mrp-display-{{ $product->id }}"
                                                                style="text-decoration: line-through; color: #ADADAD; margin-right: 6px;">
                                                                ₹{{ number_format($firstMrp, 2) }}
                                                            </span>
                                                        @else
                                                            <span class="offer-mrp-display-{{ $product->id }}"
                                                                style="text-decoration: line-through; color: #ADADAD; display: none;">
                                                            </span>
                                                        @endif
                                                        <span class="offer-sell-price-{{ $product->id }}"
                                                            style="color: #3BB77E;">₹{{ number_format($firstOfferPrice, 2) }}</span>
                                                    </div>
                                                </div>
                                            @else
                                                {{-- No variants - show product-level offer price --}}
                                                <div class="product-price" style="text-align: center; margin-bottom: 10px;">
                                                    <div style="font-size: 15px; font-weight: 600;">
                                                        @if($product->original_price && $product->original_price > $product->final_price)
                                                            <span style="text-decoration: line-through; color: #ADADAD; margin-right: 6px;">
                                                                ₹{{ number_format($product->original_price, 2) }}
                                                            </span>
                                                        @endif
                                                        <span style="color: #3BB77E;">₹{{ number_format($product->final_price, 2) }}</span>
                                                    </div>
                                                </div>
                                            @endif

                                            {{-- Bottom Row: Qty + ADD Button --}}
                                            <div class="product-bottom-action" style="display: flex; justify-content: space-between; align-items: center; gap: 8px; margin-top: auto; width: 100%;">
                                                {{-- Quantity Input --}}
                                                <div class="qty-container" style="display: flex; align-items: center; flex: 1; min-width: 0;">
                                                    <label class="qty-label">Qty:</label>
                                                    <input type="number" class="qty-input offer-product-qty-{{ $product->id }}" value="1" min="1" {{ $firstVariantStock <= 0 ? 'disabled' : '' }}>
                                                </div>

                                                {{-- Add to Cart Button --}}
                                                <div class="add-cart" style="flex: 1; min-width: 0; {{ $firstVariantStock <= 0 ? 'display: none !important;' : '' }}">
                                                    <a href="javascript:void(0)" class="add col-12 offer-add-to-cart-btn-{{ $product->id }}"
                                                        data-product-id="{{ $product->id }}"
                                                        data-price="{{ $product->variants->count() > 0 ? $firstOfferPrice : $product->final_price }}"
                                                        data-stock="{{ $firstVariantStock }}">
                                                        <i class="fi-rs-shopping-cart mr-5"></i>ADD
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @empty
                                <div class="col-12 text-center">
                                    <p>No products available for this offer.</p>
                                </div>
                            @endforelse
                        </div>

                        <!-- Arrow buttons -->
                        <button class="scroll-btn left"><i class="fi-rs-angle-left"></i></button>
                        <button class="scroll-btn right"><i class="fi-rs-angle-right"></i></button>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center mt-5">
                <p>No offers available at the moment.</p>
            </div>
        @endforelse
    </div>
</section>

<!-- CSS -->
<style>
    /* Offer banner column - desktop flex, mobile full-width */
    .offer-banner-col {
        display: flex;
    }

    .banner-glass {
        position: relative;
        width: 100%;
        height: 370px;
        border-radius: 12px;
        overflow: hidden;
        background-size: cover;
        background-position: center;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Glass / Light Blur Layer */
    .banner-glass::after {
        content: "";
        position: absolute;
        inset: 0;
        background: rgba(255, 255, 255, 0.15);
        /* slight glass tint */
        backdrop-filter: blur(4px) brightness(0.9);
        -webkit-backdrop-filter: blur(4px) brightness(0.9);
    }



    .scroll-wrapper {
        position: relative;
        width: 100%;
        overflow: visible;
        z-index: 5;
        padding: 0 25px;
    }


    .scroll-container {
        display: flex;
        gap: 15px;
        overflow-x: auto;
        overflow-y: hidden;
        scroll-behavior: auto;
        padding-bottom: 10px;
        scrollbar-width: none;
        /* Firefox hide */
    }

    .scroll-container::-webkit-scrollbar {
        display: none;
        /* Chrome, Safari hide */
    }

    /* Product cards */
    .scroll-container .product-cart-wrap {
        background: #fff;
        border-radius: 8px;
        overflow: hidden;
        transition: all 0.3s ease;
        display: flex !important;
        flex-direction: column !important;
        justify-content: space-between !important;
    }

    @media (min-width: 769px) {
        .scroll-container .product-cart-wrap {
            width: 240px !important;
            min-width: 240px !important;
            max-width: 240px !important;
            height: 370px !important;
        }
    }

    @media (max-width: 768px) {
        .scroll-container .product-cart-wrap {
            width: 160px !important;
            min-width: 160px !important;
            max-width: 160px !important;
            height: 300px !important;
        }
        .scroll-container .product-cart-wrap .product-img-action-wrap img {
            height: 110px !important;
        }
    }

    .scroll-container .product-cart-wrap:hover {
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        transform: translateY(-3px);
    }

    /* Arrow Buttons */
    .scroll-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: #28a745;
        color: #fff;
        border: none;
        width: 35px;
        height: 35px;
        border-radius: 50%;
        cursor: pointer;
        z-index: 10;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .scroll-btn:hover {
        opacity: 1;
    }

    .scroll-btn.left {
        left: -20px;
    }

    .scroll-btn.right {
        right: -5px;
    }

    @media (max-width: 768px) {
        .scroll-btn {
            display: flex;
            width: 30px;
            height: 30px;
        }
        .scroll-btn.left {
            left: 2px;
        }
        .scroll-btn.right {
            right: 2px;
        }

        /* Handled by .scroll-container .product-cart-wrap media queries */

        /* Mobile offer banner: full width, compact */
        .offer-banner-col {
            flex: 0 0 100%;
            max-width: 100%;
            margin-bottom: 12px;
        }

        .offer-banner-col .banner-glass {
            height: 150px !important;
            border-radius: 8px;
        }

        .offer-banner-col .banner-text h2 {
            font-size: 1.3rem;
            margin-bottom: 10px !important;
        }

        .offer-banner-col .banner-text .btn {
            font-size: 12px;
            padding: 5px 12px;
        }
    }

    .banner-text h2 {
        color: #fff;
        text-shadow:
            2px 2px 8px rgba(0, 0, 0, 0.9),
            -2px -2px 8px rgba(0, 0, 0, 0.4);
        font-weight: 700;
        letter-spacing: 0.3px;
    }

    /* Center banner text over glass layer — covers full banner area.
       Overrides theme's .banner-img.style-2 .banner-text { top:50px; transform:none }
       and base .banner-img .banner-text { top:50%; transform:translateY(-50%); padding:0 50px } */
    .banner-glass .banner-text {
        position: absolute !important;
        inset: 0 !important;
        top: 0 !important;
        left: 0 !important;
        right: 0 !important;
        bottom: 0 !important;
        transform: none !important;
        z-index: 2;
        display: flex !important;
        flex-direction: column !important;
        justify-content: center !important;
        align-items: center !important;
        text-align: center;
        padding: 20px !important;
    }

    .banner-glass .banner-text h2,
    .banner-glass .banner-text h4 {
        margin: 0 0 12px !important;
        min-height: unset !important;
    }

    .banner-glass .banner-text .btn {
        margin-top: 10px;
    }

    /* Center product price on all screen sizes */
    .product-cart-wrap .product-price,
    .product-cart-wrap .product-card-bottom .product-price {
        text-align: center !important;
    }

    .scroll-container .product-cart-wrap .product-content-wrap {
        flex: 1 !important;
        display: flex !important;
        flex-direction: column !important;
        justify-content: space-between !important;
        padding: 10px !important;
    }

    .scroll-container .product-cart-wrap .product-content-wrap h2 {
        margin-bottom: 4px !important;
        font-size: 14px !important;
        line-height: 1.3 !important;
    }
    
    .scroll-container .product-cart-wrap .product-content-wrap h2 a {
        font-size: 14px !important;
    }

    @media (max-width: 768px) {
        .scroll-container .product-cart-wrap .product-content-wrap h2,
        .scroll-container .product-cart-wrap .product-content-wrap h2 a {
            font-size: 12px !important;
        }
    }

    .scroll-container .product-cart-wrap .product-content-wrap .product-card-bottom {
        flex: 1 !important;
        display: flex !important;
        flex-direction: column !important;
        justify-content: space-between !important;
        margin-top: auto !important;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll('.scroll-wrapper').forEach(wrapper => {

            const container = wrapper.querySelector('.scroll-container');
            const leftBtn = wrapper.querySelector('.scroll-btn.left');
            const rightBtn = wrapper.querySelector('.scroll-btn.right');

            let autoScrollDirection = 1;
            let autoScrollPaused = false;
            let pauseTimeout;
            let scrollPos = container.scrollLeft;

            // --- AUTO SCROLL ---
            function autoScroll() {
                if (!autoScrollPaused) {
                    scrollPos += 0.7 * autoScrollDirection; // smooth speed
                    container.scrollLeft = scrollPos;

                    // End detection (only if container is scrollable)
                    if (container.scrollWidth > container.clientWidth) {
                        if (container.scrollLeft + container.clientWidth >= container.scrollWidth - 1) {
                            autoScrollDirection = -1;
                            scrollPos = container.scrollLeft; // Sync to actual boundary
                        } else if (container.scrollLeft <= 0) {
                            autoScrollDirection = 1;
                            scrollPos = 0;
                        }
                    } else {
                        scrollPos = 0;
                    }
                }

                requestAnimationFrame(autoScroll);
            }

            requestAnimationFrame(autoScroll);

            // --- AUTO SCROLL PAUSE/RESUME FUNCTION ---
            function pauseAutoScroll() {
                autoScrollPaused = true;
                clearTimeout(pauseTimeout);
                pauseTimeout = setTimeout(() => {
                    autoScrollPaused = false;
                    scrollPos = container.scrollLeft; // Sync after pause
                }, 2000); // pause for 2 seconds after manual interaction
            }

            // Sync scrollPos on manual scroll events (touch swipe, wheel scroll)
            container.addEventListener('scroll', () => {
                if (autoScrollPaused || Math.abs(container.scrollLeft - scrollPos) > 1.5) {
                    scrollPos = container.scrollLeft;
                }
            });

            // Pause auto-scroll on hover or touch to allow users to interact comfortably
            container.addEventListener('mouseenter', () => {
                autoScrollPaused = true;
            });
            container.addEventListener('mouseleave', () => {
                autoScrollPaused = false;
                scrollPos = container.scrollLeft;
            });
            container.addEventListener('touchstart', () => {
                autoScrollPaused = true;
            }, { passive: true });
            container.addEventListener('touchend', () => {
                autoScrollPaused = false;
                scrollPos = container.scrollLeft;
            }, { passive: true });

            // --- MANUAL BUTTON SCROLL ---
            leftBtn.addEventListener('click', () => {
                pauseAutoScroll();
                container.scrollBy({ left: -350, behavior: 'smooth' });
            });

            rightBtn.addEventListener('click', () => {
                pauseAutoScroll();
                container.scrollBy({ left: 350, behavior: 'smooth' });
            });

        });
    });
</script>


<!-- wishlist -->
<style>
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

    .action-btn i {
        font-size: 16px;
        transition: all 0.3s ease;
    }

    /* when active, switch to red color for wishlist heart */
    .action-btn.active i,
    .action-btn.active {
        color: #ff0000 !important;
    }

    .action-btn.active .fi-rs-heart::before {
        color: #ff0000 !important;
    }



    /* Out of stock product card styling */
    .product-cart-wrap.product-out-of-stock {
        opacity: 0.7;
        filter: grayscale(0.4);
        transition: all 0.4s ease;
    }

    .product-cart-wrap.product-out-of-stock .product-img-action-wrap img {
        filter: grayscale(1);
        opacity: 0.8;
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


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        // Handle offer variant dropdown changes - dynamic price update
        $(document).on('change', '[class*="offer-variant-dropdown-"]', function () {
            const productId = $(this).data('product-id');
            const selectedOption = $(this).find('option:selected');

            const offerPrice = selectedOption.data('offer-price');
            const mrpPrice = selectedOption.data('mrp-price');
            const stockValue = parseInt(selectedOption.data('stock')) || 0;

            // Update sell price display
            $(`.offer-sell-price-${productId}`).text('₹' + Math.round(offerPrice).toLocaleString());

            // Update MRP strike-through price
            const mrpElement = $(`.offer-mrp-display-${productId}`);
            if (mrpPrice && mrpPrice > offerPrice) {
                mrpElement.text('₹' + Math.round(mrpPrice).toLocaleString());
                mrpElement.css('display', 'inline');
            } else {
                mrpElement.css('display', 'none');
            }

            // Update add to cart button data and state
            const addToCartBtn = $(`.offer-add-to-cart-btn-${productId}`);
            addToCartBtn.data('price', offerPrice);
            addToCartBtn.data('variant-id', selectedOption.data('variant-id'));
            addToCartBtn.data('stock', stockValue);
            
            // Enable/disable button based on stock
            const productCard = $(`.offer-product-card-${productId}`);
            const productAction = productCard.find('.product-action-1');
            const productQty = productCard.find(`.offer-product-qty-${productId}`);
            const btnContainer = productCard.find('.add-cart');

            if (stockValue <= 0) {
                productCard.addClass('product-out-of-stock');
                productAction.attr('style', 'display: none !important;');
                productQty.prop('disabled', true);
                btnContainer.attr('style', 'display: none !important;');
                $(`.offer-variant-dropdown-${productId}`).prop('disabled', true);
                
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
                $(`.offer-variant-dropdown-${productId}`).prop('disabled', false);
            }
        });

        // Handle offer add to cart button clicks
        $(document).on('click', '[class*="offer-add-to-cart-btn-"]', function (e) {
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
            const variantDropdown = $(`.offer-variant-dropdown-${productId}`);
            const qtyInput = $(`.offer-product-qty-${productId}`);

            let variantId = null;
            let unitPrice = $(this).data('price');
            let quantity = qtyInput.length > 0 ? parseInt(qtyInput.val()) || 1 : 1;

            // If product has variants, get selected variant
            if (variantDropdown.length > 0) {
                const selectedOption = variantDropdown.find('option:selected');
                variantId = selectedOption.data('variant-id');
                unitPrice = selectedOption.data('offer-price');
            }

            const csrfToken = "{{ csrf_token() }}";

            // Get selected_weight (gram value) from offer variant dropdown
            let selectedWeight = null;
            const offerVarDropdown = $(`.offer-variant-dropdown-${productId}`);
            if (offerVarDropdown.length > 0) {
                selectedWeight = offerVarDropdown.find('option:selected').data('label') || null;
            }

            const requestData = {
                _token: csrfToken,
                product_id: productId,
                selected_quantity: quantity,
                unit_price: unitPrice
            };

            if (variantId) {
                requestData.variant_id = variantId;
            }
            if (selectedWeight) {
                requestData.selected_weight = selectedWeight;
            }

        });
    });
</script>