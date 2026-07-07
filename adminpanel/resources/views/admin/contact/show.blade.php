@extends('layouts.app')

@section('content')
<div class="content-main">
    <div class="content-header">
        <div>
            <h2 class="content-title card-title">Enquiry Details</h2>
            <p>Details for enquiry #{{ $enquiry->id }}</p>
        </div>
        <div>
            <a href="{{ route('admin.contact.index') }}" class="btn btn-primary"><i class="material-icons md-arrow_back"></i> Back to List</a>
        </div>
    </div>

    <div class="card">
        <header class="card-header">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 mb-lg-0 mb-15">
                    <span>
                        <i class="material-icons md-calendar_today"></i> <b>{{ $enquiry->created_at->format('M d, Y, h:i A') }}</b>
                    </span> <br>
                    <small class="text-muted">Enquiry ID: {{ $enquiry->id }}</small>
                </div>
                <div class="col-lg-6 col-md-6 ms-auto text-md-end">
                    <span class="badge rounded-pill alert-info">{{ ucfirst($enquiry->status) }}</span>
                </div>
            </div>
        </header> 
        <div class="card-body">
            <div class="row mb-50 mt-20 order-info-wrap">
                <div class="col-md-4">
                    <article class="icontext">
                        <span class="icon icon-sm rounded-circle bg-primary-light">
                            <i class="text-primary material-icons md-person"></i>
                        </span>
                        <div class="text">
                            <h6 class="mb-1">Customer</h6>
                            <p class="mb-1">
                                {{ $enquiry->name }} <br>
                                {{ $enquiry->email }} <br>
                                {{ $enquiry->telephone }}
                            </p>
                        </div>
                    </article>
                </div> <!-- col// -->
                <div class="col-md-4">
                    <article class="icontext">
                        <span class="icon icon-sm rounded-circle bg-primary-light">
                            <i class="text-primary material-icons md-info"></i>
                        </span>
                        <div class="text">
                            <h6 class="mb-1">Enquiry Info</h6>
                            <p class="mb-1">
                                Status: {{ ucfirst($enquiry->status) }}
                            </p>
                        </div>
                    </article>
                </div> <!-- col// -->
            </div> <!-- row // -->
            
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-body mb-4">
                        <h6 class="mb-3">Message</h6>
                        <p class="text-muted">
                            {{ $enquiry->message }}
                        </p>
                    </div>
                </div> <!-- col// -->
            </div> <!-- row // -->
        </div> <!-- card-body end// -->
    </div> <!-- card end// -->
</div>
@endsection
