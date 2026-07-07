@extends('layouts.app')

@section('content')
<section class="content-main">

<div class="container mt-4">

    <h2 class="mb-4">View HSN Code Details</h2>

    <div class="card p-4">

        <div class="row g-4">
            <div class="col-md-6">
                <label class="form-label fw-bold">HSN Code</label>
                <input type="text" class="form-control" value="{{ $hsn->code }}" disabled>
            </div>

            

            <div class="col-md-6">
                <label class="form-label fw-bold">GST Rate (%)</label>
                <input type="number" class="form-control" value="{{ $hsn->gst_rate }}" disabled>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">CGST (%)</label>
                <input type="number" class="form-control" value="{{ $hsn->cgst_rate }}" disabled>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">SGST (%)</label>
                <input type="number" class="form-control" value="{{ $hsn->sgst_rate }}" disabled>
            </div>

            <div class="col-md-6 mt-3">
                <label class="form-label fw-bold">IGST (%)</label>
                <input type="number" class="form-control" value="{{ $hsn->igst_rate }}" disabled>
            </div>

            <div class="col-md-6 mt-3">
                <label class="form-label fw-bold">Effective From</label>
                <input type="date" class="form-control" value="{{ $hsn->effective_from ? $hsn->effective_from->format('Y-m-d') : '' }}" disabled>
            </div>

            <div class="col-md-6 mt-3">
                <label class="form-label fw-bold">Effective To</label>
                <input type="date" class="form-control" value="{{ $hsn->effective_to ? $hsn->effective_to->format('Y-m-d') : '' }}" disabled>
            </div>

            <div class="col-md-6 mt-3">
                <label class="form-label fw-bold">Category</label>
                <input type="text" class="form-control" value="{{ $hsn->category }}" disabled>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Description</label>
                <textarea class="form-control" disabled>{{ $hsn->description }}</textarea>
            </div>

        </div>

        <div class="mt-4">
            @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('hsncode-edit'))
            <a href="{{ route('hsncode.edit', $hsn->id) }}" class="btn btn-primary">Edit</a>
            @endif
            <a href="{{ route('hsncode.table') }}" class="btn btn-secondary">Cancel</a>
        </div>

    </div>
</div>

</section>
@endsection
