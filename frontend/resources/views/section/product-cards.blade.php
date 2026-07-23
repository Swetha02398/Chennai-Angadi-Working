@foreach($products as $product)
    @php
        $firstVariantStock = $product->variants->first() ? ($product->variants->first()->stock ?? 0) : ($product->stock ?? 0);
    @endphp
    <div class="col-lg-1-5 col-md-4 col-6 col-sm-6 product-card-wrapper" style="margin-bottom: 15px;">
        <div class="product-cart-wrap mb-30 product-card-{{ $product->id }} {{ $firstVariantStock <= 0 ? 'product-out-of-stock' : '' }}">
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
                        <img class="default-img lazyload"
                            data-src="{{ rtrim(config('app.admin_asset_url', env('ADMIN_ASSET_URL', 'http://localhost/chennais/adminpanel/public/uploads')), '/') }}/products/{{ $primaryImage }}"
                            src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs="
                             alt="{{ $product->productname }}"
                            onerror="this.src='{{ asset('assets/imgs/theme/icons/category-1.svg') }}'">
                    </a>
                </div>
                <div class="product-action-1" style="{{ $firstVariantStock <= 0 ? 'display: none !important;' : '' }}">
                    <a aria-label="Add To Wishlist"
                        class="action-btn add-to-wishlist {{ (auth('customer')->check() && auth('customer')->user()->wishlist()->where('product_id', $product->id)->exists()) || (!auth('customer')->check() && in_array($product->id, session()->get('guest_wishlist', []))) ? 'active' : '' }}"
                        data-id="{{ $product->id }}" href="javascript:void(0)">
                        <i class="fi-rs-heart"></i>
                    </a>
                    <a aria-label="Quick view" class="action-btn quick-view-btn"
                        href="javascript:void(0)" data-product-id="{{ $product->id }}">
                        <i class="fi-rs-eye"></i>
                    </a>
                </div>
                @if($firstVariantStock <= 0)
                    <div class="product-badges product-badges-position product-badges-mrg">
                        <span class="hot" style="background-color: #dc3545;">OUT OF STOCK</span>
                    </div>
                @endif
            </div>

            <div class="product-content-wrap">
                <h2 style="text-align: center;">
                    <a href="{{ route('product.details', $product->slug) }}" class="product-card-link">
                        {{ $product->productname }}
                    </a>
                </h2>

                <div class="product-card-bottom" style="flex-direction: column; align-items: stretch;">
                    @php
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
                    @endphp

                    {{-- Variant Dropdown - Centered --}}
                    @if($product->variants->count() > 0)
                        @php
                            $activeOffer = $product->getActiveOffer();
                            $hasProductOffer = $activeOffer !== null;
                            $discountType = $hasProductOffer ? $activeOffer->discount_type : null;
                            $discountValue = $hasProductOffer ? $activeOffer->discount_value : 0;
                        @endphp
                        <div class="product-variant-selector" style="text-align: center; margin-bottom: 8px;">
                            <select class="form-control product_Dropdown variant-dropdown-{{ $product->id }}"
                                data-product-id="{{ $product->id }}"
                                style="width: 100%; display: inline-block; appearance: none; -webkit-appearance: none; -moz-appearance: none; background-image: url('data:image/svg+xml;charset=UTF-8,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22%233BB77E%22%3E%3Cpath d=%22M7 10l5 5 5-5z%22/%3E%3C/svg%3E'); background-repeat: no-repeat; background-position: right 12px center; background-size: 20px; padding-right: 40px; cursor: pointer; border: 1px solid #BCE3C9; border-radius: 5px; height: 45px; font-size: 18px;" {{ $firstVariantStock <= 0 ? 'disabled' : '' }}>
                                @foreach($product->variants as $index => $variant)
                                    @php
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
                                    @endphp
                                    <option value="{{ $variant->id }}" data-variant-id="{{ $variant->id }}"
                                        data-price="{{ $displayPrice }}"
                                        data-sell-price="{{ $variantSellPrice }}"
                                        data-mrp-price="{{ $hasProductOffer ? $variantSellPrice : $variantMrp }}"
                                        data-offer-price="{{ $hasProductOffer ? $variantOfferPrice : '' }}"
                                        data-has-offer="{{ $hasProductOffer ? '1' : '0' }}"
                                        data-stock="{{ $variant->stock ?? 0 }}"
                                        data-label="{{ $quantityLabel }}" {{ $index === 0 ? 'selected' : '' }}>
                                        {{ $quantityLabel }} - ₹{{ number_format($displayPrice, 2) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    {{-- Price Display - Centered --}}
                    <div class="product-price" style="text-align: center; margin-bottom: 10px;">
                        <div class="product-price-display-{{ $product->id }}"
                            style="font-size: 15px; font-weight: 600;">
                            @if($originalPrice && $originalPrice > $currentPrice)
                                <span class="product-mrp-display-{{ $product->id }}"
                                    style="text-decoration: line-through; color: #ADADAD; margin-right: 6px;">
                                    ₹{{ number_format($originalPrice, 2) }}
                                </span>
                            @else
                                <span class="product-mrp-display-{{ $product->id }}"
                                    style="text-decoration: line-through; color: #ADADAD; display: none;">
                                </span>
                            @endif
                            <span class="product-sell-price-{{ $product->id }}"
                                style="color: #3BB77E;">₹{{ number_format($currentPrice, 2) }}</span>
                        </div>
                    </div>

                    {{-- Bottom Row: Qty + ADD Button --}}
                    <div class="product-bottom-action"
                        style="display: flex; justify-content: space-between; align-items: center; gap: 8px; margin-top: auto; width: 100%;">
                        {{-- Quantity Input --}}
                        <div class="qty-container" style="display: flex; align-items: center; flex: 1; min-width: 0;">
                            <label class="qty-label">Qty:</label>
                            <input type="number" class="qty-input product-qty-{{ $product->id }}" value="1" min="1" {{ $firstVariantStock <= 0 ? 'disabled' : '' }}>
                        </div>

                        {{-- Add to Cart Button --}}
                        <div class="add-cart" style="flex: 1; min-width: 0; {{ $firstVariantStock <= 0 ? 'display: none !important;' : '' }}">
                            <a href="javascript:void(0)" class="add col-12 add-to-cart-btn-{{ $product->id }}"
                                data-product-id="{{ $product->id }}" data-price="{{ $currentPrice }}"
                                data-stock="{{ $firstVariantStock }}">
                                <i class="fi-rs-shopping-cart mr-5"></i>ADD
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endforeach

@if($products instanceof \Illuminate\Pagination\LengthAwarePaginator && $products->hasPages() && in_array(request()->route()->getName(), ['home', 'index', 'shop', 'filter.products']))
    <div class="pagination-area mt-30 mb-50 col-12 d-flex justify-content-center ajax-pagination-links">
        {{ $products->appends(request()->query())->links('vendor.pagination.custom') }}
    </div>
@endif
