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

    <h2 class="mb-4">Add New GST Setting</h2>

    <form id="gstForm" method="POST" action="{{ route('gsthsn.store') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Default Tax Rate (%) *</label>
            <input type="number"
                name="default_tax_rate"
                step="0.01"
                min="0" max="100"
                class="form-control">
            <small id="taxError" class="text-danger d-none">Enter a valid tax rate (0 - 100)</small>
        </div>

        <div class="mb-3">
            <label class="form-label">Enable Auto GST *</label>
            <select name="enable_auto_gst" class="form-control">
                <option value="">Select Option</option>
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>
            <small id="enableError" class="text-danger d-none">Auto GST selection is required.</small>
        </div>

        <div class="mb-3">
            <label class="form-label">Rounding Method *</label>
            <select name="rounding_method" class="form-control">
                <option value="">Select Method</option>
                <option value="nearest">Nearest</option>
                <option value="up">Up</option>
                <option value="down">Down</option>
            </select>
            <small id="roundError" class="text-danger d-none">Rounding method is required.</small>
        </div>

        <div class="mb-3">
            <label class="form-label">Notes</label>
            <textarea name="notes" rows="3" class="form-control" placeholder="Optional notes"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
       <a href="{{ route('gsthsn.table') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
</section>

<script>
document.getElementById('gstForm').addEventListener('submit', function(e) {

    let valid = true;

    function requireField(name, errorId) {
        const el = document.querySelector(`[name="${name}"]`);
        const error = document.getElementById(errorId);

        if (el.value.trim() === "") {
            error.classList.remove("d-none");
            el.classList.add("is-invalid");
            valid = false;
        } else {
            error.classList.add("d-none");
            el.classList.remove("is-invalid");
        }
    }

    // --- exact same pattern as create1 ---
    requireField("default_tax_rate", "taxError");
    requireField("enable_auto_gst", "enableError");
    requireField("rounding_method", "roundError");

    // additional tax range check
    const tax = document.querySelector('[name="default_tax_rate"]');
    if (tax.value !== "" && (tax.value < 0 || tax.value > 100)) {
        document.getElementById("taxError").classList.remove("d-none");
        valid = false;
    }

    if (!valid) e.preventDefault();
});
</script>

@endsection
