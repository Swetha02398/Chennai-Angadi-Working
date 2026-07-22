@extends('layouts.app')

@section('content')
<section class="content-main">
<div class="container mt-4">

    <h2 class="mb-4">Cart Item Details</h2>

    <div class="card p-4">

        <div class="row g-4">
            <div class="col-md-6">
                <label class="form-label fw-bold">Customer ID</label>
                <input type="text" class="form-control" value="{{ $cartItem->customer->username ?? '' }}" disabled>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Product Name</label>
                <input type="text" class="form-control" value="{{ $cartItem->product->productname ?? '' }}" disabled>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Quantity</label>
                <input type="number" class="form-control" value="{{ $cartItem->quantity }}" disabled>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Price at Add Time</label>
                <input type="text" class="form-control" value="{{ $cartItem->price_at_add_time }}" disabled>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Taxable</label>
                <input type="text" class="form-control" value="{{ $cartItem->taxable ? 'Yes' : 'No' }}" disabled>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Tax Rate (%)</label>
                <input type="text" class="form-control" value="{{ $cartItem->tax_rate }}" disabled>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Tax Amount</label>
                <input type="text" class="form-control" value="{{ $cartItem->tax_amount }}" disabled>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Row Total</label>
                <input type="text" class="form-control" value="{{ $cartItem->row_total }}" disabled>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">User Type</label>
                <input type="text" class="form-control" value="{{ $cartItem->user_type == 1 ? 'Admin Added' : 'Customer Added' }}" disabled>
            </div>
        </div>

        <div class="col-md-4 mt-4">
            <a href="{{ route('cart.table') }}" class="btn btn-primary"><i class="bi bi-arrow-left-circle me-1"></i> Back</a>
        </div>

    </div>
</div>
</section>
@endsection
