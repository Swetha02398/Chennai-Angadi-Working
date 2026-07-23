@extends('layouts.app')
@section('content')
    <main class="main">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="{{ route('index') }}"><i class="fi-rs-home mr-5"></i>Home</a>
                    <span></span> Wishlist
                </div>
            </div>
        </div>

        <div class="container my-3">
            <div class="row">
                <div class="col-lg-12 m-auto">
                    <div class="mb-2">
                        <h5 class="heading-2 mb-1">Your Wishlist</h5>
                        <h6 class="text-body">
                            There are
                            <span class="text-brand">{{ $wishlists->count() }}</span>
                            products in this list
                        </h6>
                    </div>

                    <div class="table-responsive shopping-summery">
                        <table class="table table-wishlist table-bordered" style="border: 1px solid #dee2e6;">
                            <thead>
                                <tr class="main-heading">
                                    <th class="custome-checkbox start ps-3">
                                        <input class="form-check-input" type="checkbox" id="selectAll">
                                        <label class="form-check-label" for="selectAll"></label>
                                    </th>
                                    <th colspan="2">Product</th>
                                    <th>Price</th>
                                    <th colspan="2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($wishlists as $item)
                                    @if($item->product)
                                        @php $p = $item->product; @endphp
                                        <tr class="pt-30">

                                            <td class="custome-checkbox ps-3">
                                                <input class="form-check-input item-checkbox" type="checkbox" id="item_{{ $p->id }}"
                                                    value="{{ $p->id }}">
                                                <label class="form-check-label" for="item_{{ $p->id }}"></label>
                                            </td>
                                            <td class="image product-thumbnail">
                                                @php
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
                                                @endphp
                                                <img src="{{ env('ADMIN_ASSET_URL') }}/products/{{ $primaryImage }}"
                                                    alt="{{ $p->productname }}"
                                                    onerror="this.src='{{ asset('assets/imgs/theme/icons/category-1.svg') }}'"
                                                    style="width:auto;height:50px;object-fit:cover;border-radius:8px;">
                                            </td>


                                            <td class="product-des product-name">
                                                <h6>
                                                    <a class="product-name mb-10" href="javascript:void(0)">
                                                        {{ $p->productname }}
                                                    </a>
                                                </h6>
                                                <!-- <div class="product-rate-cover">
                                                                                                                            <div class="product-rate d-inline-block">
                                                                                                                                <div class="product-rating" style="width: 90%"></div>
                                                                                                                            </div>
                                                                                                                            <span class="font-small ml-5 text-muted">(4.0)</span>
                                                                                                                        </div> -->
                                            </td>

                                            <td class="price" data-title="Price">
                                                @php
                                                    // Get first variant's prices if available
                                                    $firstVariant = $p->variants->first();
                                                    if ($firstVariant && $firstVariant->sell_price) {
                                                        $displayPrice = $firstVariant->sell_price;
                                                        $mrpPrice = $firstVariant->price; // price is MRP in database
                                                    } else {
                                                        $displayPrice = $p->sell_price ?? $p->price;
                                                        $mrpPrice = $p->price;
                                                    }
                                                    $hasDiscount = $mrpPrice && $displayPrice && $mrpPrice > $displayPrice;
                                                @endphp
                                                <h3 class="text-brand">₹{{ number_format($displayPrice, 2) }} 

                                                 <span class="old-price"
                                                        style="text-decoration: line-through;">₹{{ number_format($mrpPrice, 2) }}</span>
                                                </h3>
                                                @if($hasDiscount)
                                                   
                                                @endif
                                            </td>

                                            <td colspan="2" data-title="Actions">
                                                <div class="d-flex align-items-center flex-wrap" style="gap:6px;">
                                                    <button type="button"
                                                        class="btn btn-sm wishlist-add-to-cart-btn"
                                                        data-product-id="{{ $p->id }}"
                                                        style="width:110px;height:38px;border-radius:5px;font-size:12px;font-weight:600;padding:0;white-space:nowrap;display:flex;align-items:center;justify-content:center;">
                                                        <i class="fi-rs-shopping-cart mr-5"></i> Add Cart
                                                    </button>
                                                    <button type="button"
                                                        class="btn btn-sm wishlist-remove-btn"
                                                        data-product-id="{{ $p->id }}"
                                                        style="width:110px;height:38px;border-radius:5px;font-size:12px;font-weight:600;padding:0;background:#dc3545;color:#fff;border-color:#dc3545;white-space:nowrap;display:flex;align-items:center;justify-content:center;">
                                                        <i class="fi-rs-trash mr-5"></i> Remove
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <p>You haven’t added any products to your wishlist yet.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </main>

@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            // Select All checkbox
            $('#selectAll').on('change', function () {
                $('.item-checkbox').prop('checked', $(this).prop('checked'));
            });

            // Wishlist Remove Button - AJAX based
            $(document).on('click', '.wishlist-remove-btn', function (e) {
                e.preventDefault();

                var button = $(this);
                var productId = button.data('product-id');
                var row = button.closest('tr');

                // Confirm before removing
                if (!confirm('Are you sure you want to remove this product from your wishlist?')) {
                    return;
                }

                $.ajax({
                    url: "{{ route('wishlist.toggle') }}",
                    method: "POST",
                    data: {
                        product_id: productId,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (res) {
                        if (res.removed) {
                            // Fade out and remove the row
                            row.fadeOut(400, function () {
                                $(this).remove();

                                // Update count display on the page
                                var remainingRows = $('.table-wishlist tbody tr').length;
                                $('.text-brand').first().text(remainingRows);

                                // Show empty message if no items left
                                if (remainingRows === 0) {
                                    $('.table-wishlist tbody').html(
                                        '<tr><td colspan="7" class="text-center py-4"><p>You haven\'t added any products to your wishlist yet.</p></td></tr>'
                                    );
                                }
                            });

                            // Update header wishlist count
                            $('#wishlist-count').text(res.count);

                            toastr.info('Removed from wishlist');
                        }
                    },
                    error: function (xhr) {
                        toastr.error('Failed to remove from wishlist');
                        console.error(xhr);
                    }
                });
            });

            // Add to Cart Button in Wishlist - AJAX based
            $(document).on('click', '.wishlist-add-to-cart-btn', function (e) {
                e.preventDefault();

                var button = $(this);
                var productId = button.data('product-id');

                $.ajax({
                    url: "{{ route('add-to-cart') }}",
                    method: "POST",
                    data: {
                        product_id: productId,
                        selected_quantity: 1,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (res) {
                        if (res.success) {
                            toastr.success(res.message || 'Product added to cart!');

                            // Update cart count in header
                            if (res.cartCount) {
                                $('#header-cart-count').text(res.cartCount);
                                $('#bottom-header-cart-count').text(res.cartCount);
                                $('#mobile-cart-count').text(res.cartCount);
                            }
                        } else {
                            toastr.error(res.message || 'Failed to add to cart');
                        }
                    },
                    error: function (xhr) {
                        toastr.error('Failed to add to cart');
                        console.error(xhr);
                    }
                });
            });
        });
    </script>
@endpush