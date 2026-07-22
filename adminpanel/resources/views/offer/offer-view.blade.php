@extends('layouts.app')

@section('content')

<section class="content-main">

    <h2 class="content-title mb-4">View Offer Details</h2>

    <div class="card p-4">

        <div class="row g-3">

            <!-- Title -->
            <div class="col-md-6">
                <label class="form-label fw-bold">Title</label>
                <input type="text" class="form-control" value="{{ $offer->title }}" disabled>
            </div>

            <!-- Discount Type -->
            <div class="col-md-6">
                <label class="form-label fw-bold">Discount Type</label>
                <input type="text" class="form-control" value="{{ ucfirst($offer->discount_type) }}" disabled>
            </div>

            <!-- Discount Value -->
            <div class="col-md-6">
                <label class="form-label fw-bold">Discount Value</label>
                <input type="text" class="form-control" value="{{ $offer->discount_value }}" disabled>
            </div>

            <!-- Priority -->
            <div class="col-md-6">
                <label class="form-label fw-bold">Priority</label>
                <input type="text" class="form-control" value="{{ $offer->priority }}" disabled>
            </div>

            <!-- Start Date -->
            <div class="col-md-6">
                <label class="form-label fw-bold">Start Date</label>
                <input type="text" class="form-control" value="{{ $offer->start_date }}" disabled>
            </div>

            <!-- End Date -->
            <div class="col-md-6">
                <label class="form-label fw-bold">End Date</label>
                <input type="text" class="form-control" value="{{ $offer->end_date }}" disabled>
            </div>

            <!-- Description -->
            <div class="col-md-6">
                <label class="form-label fw-bold">Description</label>
                <textarea class="form-control" rows="3" disabled>{{ $offer->description }}</textarea>
            </div>

            
            <!-- Products -->
            <div class="col-md-6">
                <label class="form-label fw-bold">Products</label>
               @php
$productNames = [];

if (!empty($offer->product_ids)) {
    // Check type first
    if (is_array($offer->product_ids)) {
        $productIds = $offer->product_ids; // already array
    } else {
        $productIds = json_decode($offer->product_ids, true); // string aana decode pannu
    }

    // Safety check
    if (is_array($productIds)) {
        $productNames = \App\Models\Product::whereIn('id', $productIds)->pluck('productname')->toArray();
    }
}
@endphp

                <textarea class="form-control" rows="2" disabled>
{{ implode(', ', $productNames) ?: 'No products selected' }}
                </textarea>
            </div>


            <!-- Banner Image -->
            @if($offer->banner_image)
            <div class="col-md-6">
                <label class="form-label fw-bold">Banner Image</label><br>
                <img src="{{ asset('uploads/offers/'.$offer->banner_image) }}" 
                     width="250" class="rounded border shadow-sm">
            </div>
            @endif

        </div>

        <div class="mt-4">
            @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('offers-edit'))
            <a href="{{ route('offer.edit', $offer->id) }}" class="btn btn-primary"><i class="bi bi-pencil-square me-1"></i> Edit</a>
            @endif
            <a href="{{ route('offer.table') }}" class="btn btn-secondary"><i class="bi bi-arrow-left-circle me-1"></i> Back</a>
        </div>

    </div>

</section>

@endsection