@extends('layouts.app')
@section('content')
    <section class="content-main">
        <div class="container mt-4">

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <h2 class="mb-4">Edit Coupon</h2>

            <form id="couponForm" action="{{ route('coupon.update', $coupon->id) }}" method="POST" novalidate>
                @csrf
                @method('PUT')

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Coupon Code *</label>
                        <input type="text" name="code" id="code" class="form-control" value="{{ old('code', $coupon->code) }}" required>
                        <small class="text-danger d-none" id="codeError">Coupon code is required.</small>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Description</label>
                        <input type="text" name="description" class="form-control"
                            value="{{ old('description', $coupon->description) }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Discount Type *</label>
                        <select name="type" id="type" class="form-select" required>
                            <option value="">Select Type</option>
                            <option value="percentage" {{ old('type', $coupon->type) == 'percentage' ? 'selected' : '' }}>
                                Percentage</ option>
                            <option value="fixed" {{ old('type', $coupon->type) == 'fixed' ? 'selected' : '' }}>Fixed</option>
                        </select>
                        <small class="text-danger d-none" id="typeError">Discount type is required.</small>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Discount Value *</label>
                        <input type="number" step="0.01" name="value" id="value" class="form-control"
                            value="{{ old('value', $coupon->value) }}" required>
                        <small class="text-danger d-none" id="valueError">Discount value is required.</small>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Minimum Cart Amount</label>
                        <input type="number" step="0.01" name="min_amount" class="form-control"
                            value="{{ old('min_amount', $coupon->min_amount) }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Maximum Discount (For % type)</label>
                        <input type="number" step="0.01" name="max_discount" class="form-control"
                            value="{{ old('max_discount', $coupon->max_discount) }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Usage Limit (Total)</label>
                        <input type="number" name="usage_limit" class="form-control"
                            value="{{ old('usage_limit', $coupon->usage_limit) }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Per User Limit</label>
                        <input type="number" name="per_user_limit" class="form-control"
                            value="{{ old('per_user_limit', $coupon->per_user_limit) }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Start Date</label>
                        <input type="date" name="start_date" class="form-control"
                            value="{{ old('start_date', $coupon->start_date ? date('Y-m-d', strtotime($coupon->start_date)) : '') }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">End Date</label>
                        <input type="date" name="end_date" class="form-control"
                            value="{{ old('end_date', $coupon->end_date ? date('Y-m-d', strtotime($coupon->end_date)) : '') }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">Start Time *</label>
                        <input type="time" name="start_time" id="start_time" class="form-control"
                            value="{{ old('start_time', $coupon->start_time ? date('H:i', strtotime($coupon->start_time)) : '') }}" required>
                        <small class="text-danger d-none" id="startTimeError">Start time is required.</small>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold">End Time *</label>
                        <input type="time" name="end_time" id="end_time" class="form-control"
                            value="{{ old('end_time', $coupon->end_time ? date('H:i', strtotime($coupon->end_time)) : '') }}" required>
                        <small class="text-danger d-none" id="endTimeError">End time is required.</small>
                    </div>

                    <div class="col-md-12 mt-3">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> Update</button>
                        <a href="{{ route('coupon.table') }}" class="btn btn-secondary"><i class="bi bi-x-circle me-1"></i> Cancel</a>
                    </div>

                </div>
            </form>
        </div>

        {{-- FRONTEND VALIDATION --}}
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const form = document.getElementById("couponForm");

                form.addEventListener("submit", function (e) {
                    let valid = true;
                    const required = {
                        code: "codeError",
                        type: "typeError",
                        value: "valueError",
                        start_time: "startTimeError",
                        end_time: "endTimeError"
                    };

                    for (let id in required) {
                        const input = document.getElementById(id);
                        const error = document.getElementById(required[id]);
                        if (!input.value.trim()) {
                            input.classList.add('is-invalid');
                            error.classList.remove('d-none');
                            valid = false;
                        } else {
                            input.classList.remove('is-invalid');
                            error.classList.add('d-none');
                        }
                    }

                    if (!valid) e.preventDefault();
                });

                // Clear validation errors when typing/changing
                const requiredIds = ["code", "type", "value", "start_time", "end_time"];
                requiredIds.forEach(id => {
                    const input = document.getElementById(id);
                    if (input) {
                        const eventType = input.tagName === 'SELECT' ? 'change' : 'input';
                        input.addEventListener(eventType, function () {
                            this.classList.remove('is-invalid');
                            const errorId = id === "code" ? "codeError" : 
                                            id === "type" ? "typeError" :
                                            id === "value" ? "valueError" :
                                            id === "start_time" ? "startTimeError" :
                                            id === "end_time" ? "endTimeError" : null;
                            if (errorId) {
                                document.getElementById(errorId).classList.add('d-none');
                            }
                        });
                    }
                });
            });
        </script>

    </section>
@endsection