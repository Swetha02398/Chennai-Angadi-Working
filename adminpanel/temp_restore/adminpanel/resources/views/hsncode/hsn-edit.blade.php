@extends('layouts.app')

@section('content')
<section class="content-main">
<div class="container mt-4">
     <h2 class="mb-4">Edit HSN Code</h2>

    <form id="hsnForm" method="POST" action="{{ route('hsncode.update', $hsn->id) }}" novalidate>
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>HSN Code</label>
            <input type="text" name="code" id="code" value="{{ $hsn->code }}" class="form-control" required>
            <small class="text-danger d-none" id="codeError">HSN code is required.</small>
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" rows="3" class="form-control">{{ $hsn->description }}</textarea>
        </div>

        <div class="mb-3">
            <label>GST Rate (%)</label>
            <input type="number" name="gst_rate" id="gst_rate" value="{{ $hsn->gst_rate }}" step="0.01" class="form-control" required>
            <small class="text-danger d-none" id="gstRateError">GST rate is required.</small>
        </div>

        <div class="row">
            <div class="col-md-4">
                <label>CGST (%)</label>
                <input type="number" name="cgst_rate" value="{{ $hsn->cgst_rate }}" step="0.01" class="form-control">
            </div>
            <div class="col-md-4">
                <label>SGST (%)</label>
                <input type="number" name="sgst_rate" value="{{ $hsn->sgst_rate }}" step="0.01" class="form-control">
            </div>
            <div class="col-md-4">
                <label>IGST (%)</label>
                <input type="number" name="igst_rate" value="{{ $hsn->igst_rate }}" step="0.01" class="form-control">
            </div>
        </div>

        <div class="mt-3 row">
            <div class="col-md-6">
                <label>Effective From</label>
                <input type="date" name="effective_from" value="{{ $hsn->effective_from }}" class="form-control">
            </div>
            <div class="col-md-6">
                <label>Effective To</label>
                <input type="date" name="effective_to" value="{{ $hsn->effective_to }}" class="form-control">
            </div>
        </div>

        <div class="mt-3 mb-3">
            <label>Category</label>
            <input type="text" name="category" value="{{ $hsn->category }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="1" {{ $hsn->status ? 'selected' : '' }}>Active</option>
                <option value="0" {{ !$hsn->status ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('hsncode.table') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>

{{-- FRONTEND VALIDATION --}}
<script>
document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("hsnForm");

    form.addEventListener("submit", function(e) {
        let valid = true;
        const codeInput = document.getElementById('code');
        const gstInput = document.getElementById('gst_rate');

        if (!codeInput.value.trim()) {
            codeInput.classList.add('is-invalid');
            document.getElementById('codeError').classList.remove('d-none');
            valid = false;
        } else {
            codeInput.classList.remove('is-invalid');
            document.getElementById('codeError').classList.add('d-none');
        }

        if (!gstInput.value.trim()) {
            gstInput.classList.add('is-invalid');
            document.getElementById('gstRateError').textContent = "GST rate is required";
            document.getElementById('gstRateError').classList.remove('d-none');
            valid = false;
        } else if (gstInput.value < 0 || gstInput.value > 100) {
            gstInput.classList.add('is-invalid');
            document.getElementById('gstRateError').textContent = "Enter valid GST rate (0-100)";
            document.getElementById('gstRateError').classList.remove('d-none');
            valid = false;
        } else {
            gstInput.classList.remove('is-invalid');
            document.getElementById('gstRateError').classList.add('d-none');
        }

        if (!valid) e.preventDefault();
    });

    document.getElementById('code').addEventListener('input', function () {
        this.classList.remove('is-invalid');
        document.getElementById('codeError').classList.add('d-none');
    });

    document.getElementById('gst_rate').addEventListener('input', function () {
        this.classList.remove('is-invalid');
        document.getElementById('gstRateError').classList.add('d-none');
    });
});
</script>
</section>
@endsection
