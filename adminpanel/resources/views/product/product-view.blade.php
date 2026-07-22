@extends('layouts.app')

@section('content')
<section class="content-main">
<div class="container mt-4">

<h2 class="mb-4">Product Details</h2>

<div class="card p-4">
<div class="row">

    {{-- LEFT SIDE --}}
    <div class="col-md-8">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="fw-bold">Product Name</label>
                <input class="form-control" value="{{ $product->productname }}" disabled>
            </div>

            <div class="col-md-6">
                <label class="fw-bold">SKU</label>
                <input class="form-control" value="{{ $product->sku }}" disabled>
            </div>

            <!-- <div class="col-md-6">
                <label class="fw-bold">Base Price</label>
                <input class="form-control" value="₹{{ $product->price }}" disabled>
            </div> -->

            <div class="col-md-6">
                <label class="fw-bold">Slug</label>
                <input class="form-control" value="{{ $product->slug }}" disabled>
            </div>

            <div class="col-md-6">
                <label class="fw-bold">Main Category</label>
                <input class="form-control" value="{{ $product->maincategory->name ?? 'N/A' }}" disabled>
            </div>

            <div class="col-md-6">
                <label class="fw-bold">Sub Category</label>
                <input class="form-control" value="{{ $product->subcategory->name ?? 'N/A' }}" disabled>
            </div>

            <div class="col-md-6">
                <label class="fw-bold">Child Category</label>
                <input class="form-control" value="{{ $product->childcategory->name ?? 'N/A' }}" disabled>
            </div>

            <div class="col-md-6">
                <label class="fw-bold">Featured</label>
                <input class="form-control" value="{{ $product->featured ? 'Yes' : 'No' }}" disabled>
            </div>
            <div class="col-md-6">
                <label class="fw-bold">Order By</label>
                <input class="form-control" value="{{ $product->orderby ?? 'N/A' }}" disabled>
            </div>
            <div class="col-md-6">
    <label class="fw-bold">HSN Code</label>
    <input class="form-control" value="{{ $product->hsn ?? 'N/A' }}" disabled>
</div>

<div class="col-md-6">
    <label class="fw-bold">GST %</label>
    <input class="form-control" value="{{ $product->gst ?? '0' }}" disabled>
</div>

<div class="col-md-6">
    <label class="fw-bold">IGST %</label>
    <input class="form-control" value="{{ $product->igst ?? '0' }}" disabled>
</div>

<div class="col-md-6">
    <label class="fw-bold">SGST %</label>
    <input class="form-control" value="{{ $product->sgst ?? '0' }}" disabled>
</div>


            <div class="col-md-12">
                <label class="fw-bold">Short Description</label>
                <textarea class="form-control" rows="2" disabled>{{ $product->short_description }}</textarea>
            </div>

            <div class="col-md-12">
                <label class="fw-bold">Full Description</label>
                <textarea class="form-control" rows="4" disabled>{{ $product->description }}</textarea>
            </div>
        </div>

        <hr>

        {{-- ADDITIONAL INFORMATION --}}
        <h5 class="mt-3">Additional Information</h5>
        <div class="row g-3 mt-1">
            @forelse($product->specifications as $spec)
                <div class="col-md-6">
                    <label class="fw-bold">{{ $spec->spec_key }}</label>
                    <input class="form-control" value="{{ $spec->spec_value }}" disabled>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-muted">No additional information available for this product.</p>
                </div>
            @endforelse
        </div>

        <hr>

        {{-- VARIANTS --}}
        <h5 class="mt-3">Product Variants</h5>
        <table class="table table-bordered mt-2">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Variant (Unit - Pieces/Weight)</th>
                    <th>MRP</th>
                    <th>Selling Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th>Last Updated By</th>
                    <th>Updated At</th>
                </tr>
            </thead>
            <tbody>
            @forelse($product->variants as $i => $variant)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>
                        {{ $variant->quantity->name ?? '' }} 
                        @if(!empty($variant->quantity->label))
                            - {{ $variant->quantity->label }}
                        @endif
                    </td>
                    <td>₹{{ $variant->price }}</td>
                    <td>₹{{ $variant->sell_price }}</td>
                    <td>{{ $variant->stock }}</td>
                    <td>
                        <span class="badge {{ $variant->stock > 0 ? 'bg-success' : 'bg-danger' }}">
                            {{ $variant->stock > 0 ? 'In Stock' : 'Out of Stock' }}
                        </span>
                    </td>
                    <td>{{ $variant->stockUpdater->username ?? $variant->stockUpdater->name ?? 'N/A' }}</td>
                    <td>{{ $variant->stock_updated_at ? \Carbon\Carbon::parse($variant->stock_updated_at)->format('d M Y, h:i A') : 'N/A' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No variants added</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        <hr>

        {{-- SEO DETAILS --}}
        <h5>SEO Information</h5>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="fw-bold">SEO Title</label>
                <input class="form-control" value="{{ $product->seo_title }}" disabled>
            </div>
            <div class="col-md-6">
                <label class="fw-bold">SEO Keywords</label>
                <input class="form-control" value="{{ $product->seo_keywords }}" disabled>
            </div>
            <div class="col-md-12">
                <label class="fw-bold">SEO Description</label>
                <textarea class="form-control" rows="2" disabled>{{ $product->seo_description }}</textarea>
            </div>
        </div>

        <hr>
        {{-- ACTION BUTTONS --}}
        <div class="mt-4">
            @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('products-edit'))
            <a href="{{ route('product.edit', $product->id) }}" class="btn btn-primary"><i class="bi bi-pencil-square me-1"></i> Edit</a>
            @endif
            <a href="{{ route('product.table') }}" class="btn btn-secondary"><i class="bi bi-arrow-left-circle me-1"></i> Back</a>
        </div>
    </div>

    {{-- RIGHT SIDE: IMAGES --}}
    <div class="col-md-4">
        <label class="fw-bold">Product Images</label>
        <div class="row mt-2">
            @if(!empty($product->productimage) && is_array($product->productimage))
                @foreach(array_slice($product->productimage, 0, 5) as $img)
                    <div class="col-6 mb-3">
                        <img src="{{ asset($img) }}" class="img-fluid img-thumbnail" style="height:150px; object-fit:cover;">
                    </div>
                @endforeach
            @else
                <p class="text-muted">No images uploaded</p>
            @endif
        </div>
    </div>

</div>
</div>

</div>
</section>
@endsection
