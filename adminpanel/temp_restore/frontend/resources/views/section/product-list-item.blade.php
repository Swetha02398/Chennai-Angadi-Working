@php
    $listItemStock = $product->variants->first() ? ($product->variants->first()->stock ?? 0) : ($product->stock ?? 0);
@endphp
<article class="row align-items-center hover-up {{ $listItemStock <= 0 ? 'product-out-of-stock' : '' }}">
    <figure class="col-md-4 mb-0">
        <a href="{{ route('product.details', $product->id) }}" class="product-card-link">
            @php
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
            @endphp
            <img class="default-img"
                src="{{ env('ADMIN_ASSET_URL') }}/products/{{ $primaryImage }}" width="90"
                height="90" alt="{{ $product->productname }}"
                onerror="this.src='{{ asset('assets/imgs/theme/icons/category-1.svg') }}'">
        </a>
    </figure>
    <div class="col-md-8 mb-0">
        <h6>
            <a href="{{ route('product.details', $product->id) }}">{{ $product->productname }}</a>
        </h6>


        <div class="product-price">
            @php
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
            @endphp
            <span>₹{{ number_format($displayPrice, 0) }}</span>
            @if($strikePrice && $strikePrice > $displayPrice)
                <span class="old-price" style="text-decoration: line-through;">₹{{ number_format($strikePrice, 0) }}</span>
            @endif
        </div>
    </div>
</article>
