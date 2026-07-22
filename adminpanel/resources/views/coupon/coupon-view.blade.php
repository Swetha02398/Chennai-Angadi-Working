@extends('layouts.app')

@section('content')
    <section class="content-main">

        <div class="container mt-4">

            <h2 class="mb-4">View Coupon Details</h2>

            <div class="card p-4">

                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Coupon Code</label>
                        <input type="text" class="form-control" value="{{ $coupon->code }}" disabled>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Description</label>
                        <input type="text" class="form-control" value="{{ $coupon->description }}" disabled>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Discount Type</label>
                        <input type="text" class="form-control" value="{{ $coupon->type }}" disabled>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Discount Value</label>
                        <input type="number" class="form-control" value="{{ $coupon->value }}" disabled>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Minimum Amount</label>
                        <input type="number" class="form-control" value="{{ $coupon->min_amount }}" disabled>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Maximum Discount</label>
                        <input type="number" class="form-control" value="{{ $coupon->max_discount }}" disabled>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Usage Limit</label>
                        <input type="number" class="form-control" value="{{ $coupon->usage_limit }}" disabled>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Per User Limit</label>
                        <input type="number" class="form-control" value="{{ $coupon->per_user_limit }}" disabled>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Start Date</label>
                        <input type="date" class="form-control"
                            value="{{ $coupon->start_date ? date('Y-m-d', strtotime($coupon->start_date)) : '' }}" disabled>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">End Date</label>
                        <input type="date" class="form-control"
                            value="{{ $coupon->end_date ? date('Y-m-d', strtotime($coupon->end_date)) : '' }}" disabled>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Start Time</label>
                        <input type="time" class="form-control"
                            value="{{ $coupon->start_time ? date('H:i', strtotime($coupon->start_time)) : '' }}" disabled>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">End Time</label>
                        <input type="time" class="form-control"
                            value="{{ $coupon->end_time ? date('H:i', strtotime($coupon->end_time)) : '' }}" disabled>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-4">
                        @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('coupons-edit'))
                        <a href="{{ route('coupon.edit', $coupon->id) }}" class="btn btn-primary"><i class="bi bi-pencil-square me-1"></i> Edit</a>
                        @endif
                        <a href="{{ route('coupon.table') }}" class="btn btn-secondary"><i class="bi bi-x-circle me-1"></i> Cancel</a>
                    </div>

                </div>
            </div>

    </section>
@endsection