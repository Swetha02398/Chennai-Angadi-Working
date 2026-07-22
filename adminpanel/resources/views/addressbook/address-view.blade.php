@extends('layouts.app')

@section('content')
<section class="content-main">

<div class="container mt-4">

    <h2 class="mb-4">View Address Details</h2>

    <div class="card p-4">

        <div class="row g-4">
            <div class="col-md-6">
                <label class="form-label fw-bold">Customer Name</label>
                <input type="text" class="form-control" value="{{ $address->customer->username ?? '-' }}" disabled>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Customer Type</label>
                <input type="text" class="form-control" value="{{ $address->customer_type == 1 ? 'Customer' : 'Other' }}" disabled>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Title</label>
                <input type="text" class="form-control" value="{{ $address->title }}" disabled>
            </div>

            

            <div class="col-md-6">
                <label class="form-label fw-bold">Phone</label>
                <input type="text" class="form-control" value="{{ $address->phone }}" disabled>
            </div>

            

            

            <div class="col-md-6">
                <label class="form-label fw-bold">Landmark</label>
                <input type="text" class="form-control" value="{{ $address->landmark }}" disabled>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">City</label>
                <input type="text" class="form-control" value="{{ $address->city }}" disabled>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">State</label>
                <input type="text" class="form-control" value="{{ $address->state }}" disabled>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Pincode</label>
                <input type="text" class="form-control" value="{{ $address->pincode }}" disabled>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Country</label>
                <input type="text" class="form-control" value="{{ $address->country }}" disabled>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Latitude</label>
                <input type="text" class="form-control" value="{{ $address->latitude }}" disabled>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Longitude</label>
                <input type="text" class="form-control" value="{{ $address->longitude }}" disabled>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Default Address</label>
                <input type="text" class="form-control" value="{{ $address->is_default ? 'Yes' : 'No' }}" disabled>
            </div>

            <div class="col-md-12">
                <label class="form-label fw-bold">Address</label>
                <textarea class="form-control" rows="2" disabled>{{ $address->address }}</textarea>
            </div>

            
        </div>

        <div class="col-md-4 mt-4">
             @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('addressbook-edit'))
             <a href="{{ route('addressbook.edit', $address->id) }}" class="btn btn-primary"><i class="bi bi-pencil-square me-1"></i> Edit</a>
             @endif
            <a href="{{ route('addressbook.table') }}" class="btn btn-secondary">canel</a>
        </div>

    </div>
</div>

</section>
@endsection
