@extends('layouts.app')
@section('content')

<section class="content-main">
<div class="container mt-4">

    {{-- Backend validation errors --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Success message --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <h2 class="mb-4">Edit GST Setting</h2>

    <form id="gstForm" action="{{ route('gsthsn.update', $gst->id) }}" method="POST" novalidate>
        @csrf

        <div class="row g-3">

            {{-- Default Tax Rate --}}
            <div class="col-md-12">
                <label class="form-label fw-bold">Default Tax Rate (%) *</label>
                <input type="number" step="0.01" name="default_tax_rate" id="default_tax_rate" class="form-control"
                       value="{{ old('default_tax_rate', $gst->default_tax_rate) }}">
                <small class="text-danger d-none" id="taxRateError">Default tax rate is required.</small>
            </div>

            {{-- Auto GST --}}
            <div class="col-md-12">
                <label class="form-label fw-bold">Enable Auto GST *</label>
                <select name="enable_auto_gst" id="enable_auto_gst" class="form-control">
                    <option value="1" {{ old('enable_auto_gst',$gst->enable_auto_gst)==1?'selected':'' }}>Yes</option>
                    <option value="0" {{ old('enable_auto_gst',$gst->enable_auto_gst)==0?'selected':'' }}>No</option>
                </select>
                <small class="text-danger d-none" id="autoGstError">Auto GST selection is required.</small>
            </div>

            {{-- Rounding --}}
            <div class="col-md-12">
                <label class="form-label fw-bold">Rounding Method *</label>
                <select name="rounding_method" id="rounding_method" class="form-control">
                    <option value="nearest" {{ old('rounding_method',$gst->rounding_method)=='nearest'?'selected':'' }}>Nearest</option>
                    <option value="up" {{ old('rounding_method',$gst->rounding_method)=='up'?'selected':'' }}>Up</option>
                    <option value="down" {{ old('rounding_method',$gst->rounding_method)=='down'?'selected':'' }}>Down</option>
                </select>
                <small class="text-danger d-none" id="roundingError">Rounding method is required.</small>
            </div>

            {{-- Notes --}}
            <div class="col-md-12">
                <label class="form-label fw-bold">Notes</label>
                <textarea name="notes" rows="3" class="form-control">{{ old('notes', $gst->notes) }}</textarea>
            </div>

            {{-- Submit + Cancel --}}
            <div class="col-md-12 mt-3">
                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> Update</button>
                <a href="{{ route('gsthsn.table') }}" class="btn btn-secondary"><i class="bi bi-x-circle me-1"></i> Cancel</a>
            </div>

        </div>

    </form>
</div>

{{-- FRONTEND VALIDATION --}}
<script>
document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("gstForm");

    form.addEventListener("submit", function(e) {
        let valid = true;
        const taxRate = document.getElementById('default_tax_rate');
        const autoGst = document.getElementById('enable_auto_gst');
        const rounding = document.getElementById('rounding_method');

        if (!taxRate.value.trim()) {
            taxRate.classList.add('is-invalid');
            document.getElementById('taxRateError').classList.remove('d-none');
            valid = false;
        } else {
            taxRate.classList.remove('is-invalid');
            document.getElementById('taxRateError').classList.add('d-none');
        }

        if (autoGst.value === "") {
            autoGst.classList.add('is-invalid');
            document.getElementById('autoGstError').classList.remove('d-none');
            valid = false;
        } else {
            autoGst.classList.remove('is-invalid');
            document.getElementById('autoGstError').classList.add('d-none');
        }

        if (!rounding.value) {
            rounding.classList.add('is-invalid');
            document.getElementById('roundingError').classList.remove('d-none');
            valid = false;
        } else {
            rounding.classList.remove('is-invalid');
            document.getElementById('roundingError').classList.add('d-none');
        }

        if (!valid) e.preventDefault();
    });

    document.getElementById('default_tax_rate').addEventListener('input', function () {
        this.classList.remove('is-invalid');
        document.getElementById('taxRateError').classList.add('d-none');
    });

    document.getElementById('enable_auto_gst').addEventListener('change', function () {
        this.classList.remove('is-invalid');
        document.getElementById('autoGstError').classList.add('d-none');
    });

    document.getElementById('rounding_method').addEventListener('change', function () {
        this.classList.remove('is-invalid');
        document.getElementById('roundingError').classList.add('d-none');
    });
});
</script>

</section>
@endsection
