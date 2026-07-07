@extends('layouts.app') 
@section('content')

<section class="content-main">
<div class="container mt-4">
    <h2 class="mb-4">Add New HSN Code</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="hsnForm" method="POST" action="{{ route('hsncode.store') }}" novalidate>
        @csrf

        <div class="mb-3">
            <label>HSN Code *</label>
            <input type="text" name="code" class="form-control" value="{{ old('code') }}">
            <small id="codeError" class="text-danger d-none">HSN Code is required.</small>
        </div>

        <div class="mb-3">
            <label>Description *</label>
            <textarea name="description" rows="3" class="form-control">{{ old('description') }}</textarea>
            <small id="descriptionError" class="text-danger d-none">Description is required.</small>
        </div>

        <div class="mb-3">
            <label>GST Rate (%) *</label>
            <input type="number" name="gst_rate" step="0.01" class="form-control" value="{{ old('gst_rate') }}">
            <small id="gstError" class="text-danger d-none">Enter valid GST rate (0-100).</small>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label>CGST (%) *</label>
                <input type="number" name="cgst_rate" step="0.01" class="form-control" value="{{ old('cgst_rate') }}">
                <small id="cgstError" class="text-danger d-none">CGST is required.</small>
            </div>

            <div class="col-md-4 mb-3">
                <label>SGST (%) *</label>
                <input type="number" name="sgst_rate" step="0.01" class="form-control" value="{{ old('sgst_rate') }}">
                <small id="sgstError" class="text-danger d-none">SGST is required.</small>
            </div>

            <div class="col-md-4 mb-3">
                <label>IGST (%) *</label>
                <input type="number" name="igst_rate" step="0.01" class="form-control" value="{{ old('igst_rate') }}">
                <small id="igstError" class="text-danger d-none">IGST is required.</small>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-6 mb-3">
                <label>Effective From *</label>
                <input type="date" name="effective_from" class="form-control" value="{{ old('effective_from') }}">
                <small id="effectiveFromError" class="text-danger d-none">Start date is required.</small>
            </div>

            <div class="col-md-6 mb-3">
                <label>Effective To *</label>
                <input type="date" name="effective_to" class="form-control" value="{{ old('effective_to') }}">
                <small id="effectiveToError" class="text-danger d-none">End date is required.</small>
            </div>
        </div>

        <div class="mt-3 mb-3">
            <label>Category (Optional)</label>
            <input type="text" name="category" class="form-control" value="{{ old('category') }}">
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
        <a href="{{ route('hsncode.table') }}" class="btn btn-secondary">Back</a>
    </form>
</div>

<script>
document.getElementById('hsnForm').addEventListener('submit', function(e) {

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

    // Required fields
    requireField("code", "codeError");
    // requireField("description", "descriptionError");
    requireField("gst_rate", "gstError");
    requireField("cgst_rate", "cgstError");
    requireField("sgst_rate", "sgstError");
    requireField("igst_rate", "igstError");
    requireField("effective_from", "effectiveFromError");
    requireField("effective_to", "effectiveToError");

    // GST rate range check
    const gst = document.querySelector('[name="gst_rate"]');
    if (gst.value !== "" && (gst.value < 0 || gst.value > 100)) {
        document.getElementById("gstError").classList.remove("d-none");
        valid = false;
    }

    if (!valid) e.preventDefault();
});
</script>

</section>
@endsection
