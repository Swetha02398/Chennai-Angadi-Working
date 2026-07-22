@extends('layouts.app')
@section('content')

    <section class="content-main">
        <div class="container mt-4">

            {{-- Laravel backend errors --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <h2 class="mb-4">Add New Coupon</h2>

            <form id="couponForm" action="{{ route('coupon.store') }}" method="POST" novalidate>
                @csrf

                <input type="hidden" name="created_by" value="{{ auth()->user()->id }}">

                <div class="row">

                    <div class="mb-3 col-md-6">
                        <label>Coupon Code *</label>
                        <input type="text" name="code" class="form-control" value="{{ old('code') }}">
                        <small id="codeError" class="text-danger d-none">Coupon code is required.</small>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label>Description *</label>
                        <input type="text" name="description" class="form-control" value="{{ old('description') }}">
                        <small id="descriptionError" class="text-danger d-none">Description is required.</small>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label>Discount Type *</label>
                        <select name="type" class="form-select" value="{{ old('type') }}">
                            <option value="">Select Type</option>
                            <option value="percentage">Percentage</option>
                            <option value="fixed">Fixed</option>
                        </select>
                        <small id="typeError" class="text-danger d-none">Discount type is required.</small>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label>Discount Value *</label>
                        <input type="number" name="value" class="form-control" value="{{ old('value') }}">
                        <small id="valueError" class="text-danger d-none">Discount value is required.</small>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label>Minimum Cart Amount *</label>
                        <input type="number" name="min_amount" class="form-control" value="{{ old('min_amount') }}">
                        <small id="minAmountError" class="text-danger d-none">Minimum cart amount is required.</small>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label>Maximum Discount *</label>
                        <input type="number" name="max_discount" class="form-control" value="{{ old('max_discount') }}">
                        <small id="maxDiscountError" class="text-danger d-none">Maximum discount is required.</small>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label>Usage Limit *</label>
                        <input type="number" name="usage_limit" class="form-control" value="{{ old('usage_limit') }}">
                        <small id="usageLimitError" class="text-danger d-none">Usage limit is required.</small>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label>Per User Limit *</label>
                        <input type="number" name="per_user_limit" class="form-control" value="{{ old('per_user_limit') }}">
                        <small id="perUserLimitError" class="text-danger d-none">Per user limit is required.</small>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label>Start Date *</label>
                        <input type="date" name="start_date" class="form-control" value="{{ old('start_date') }}">
                        <small id="startDateError" class="text-danger d-none">Start date is required.</small>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label>End Date *</label>
                        <input type="date" name="end_date" class="form-control" value="{{ old('end_date') }}">
                        <small id="endDateError" class="text-danger d-none">End date is required.</small>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label>Start Time *</label>
                        <input type="time" name="start_time" class="form-control" value="{{ old('start_time') }}">
                        <small id="startTimeError" class="text-danger d-none">Start time is required.</small>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label>End Time *</label>
                        <input type="time" name="end_time" class="form-control" value="{{ old('end_time') }}">
                        <small id="endTimeError" class="text-danger d-none">End time is required.</small>
                    </div>

                </div>

                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> Create</button>
                <a href="{{ route('coupon.table') }}" class="btn btn-secondary"><i class="bi bi-x-circle me-1"></i> Cancel</a>

            </form>

        </div>
    </section>

    <script>
        document.getElementById('couponForm').addEventListener('submit', function (e) {

            let valid = true;

            function requireField(name, errorId) {
                const el = document.querySelector(`[name="${name}"]`);
                if (el.value.trim() === "") {
                    document.getElementById(errorId).classList.remove("d-none");
                    el.classList.add("is-invalid");
                    valid = false;
                } else {
                    document.getElementById(errorId).classList.add("d-none");
                    el.classList.remove("is-invalid");
                }
            }

            // All required fields
            requireField("code", "codeError");
            // requireField("description", "descriptionError");
            requireField("type", "typeError");
            requireField("value", "valueError");
            requireField("min_amount", "minAmountError");
            requireField("max_discount", "maxDiscountError");
            requireField("usage_limit", "usageLimitError");
            requireField("per_user_limit", "perUserLimitError");
            requireField("start_date", "startDateError");
            requireField("end_date", "endDateError");
            requireField("start_time", "startTimeError");
            requireField("end_time", "endTimeError");

            if (!valid) e.preventDefault();
        });
    </script>

@endsection