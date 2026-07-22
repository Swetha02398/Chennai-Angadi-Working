@extends('layouts.app')
@section('content')
@include('includes.alert')

<section class="content-main">
<div class="container mt-4">

    <h4 class="mb-3">Review Details</h4>

    <div class="card p-4">

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label fw-bold">Product</label>
                <input type="text" class="form-control" value="{{ $review->product->productname ?? '-' }}" disabled>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Rating</label>
                <input type="text" class="form-control" value="{{ $review->rating }}" disabled>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Name</label>
                <input type="text" class="form-control" value="{{ $review->name }}" disabled>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Email</label>
                <input type="text" class="form-control" value="{{ $review->email }}" disabled>
            </div>

            <div class="col-md-12">
                <label class="form-label fw-bold">Comment</label>
                <textarea class="form-control" rows="4" disabled>{{ $review->comment }}</textarea>
            </div>

            <div class="col-md-6 mt-3">
                <label class="form-label fw-bold">Status</label>
                <input type="text" class="form-control" 
                       value="{{ $review->approved ? 'Approved' : 'Pending' }}" disabled>
            </div>
        </div>

        <div class="mt-3">

            @if(!$review->approved)
            <form action="{{ route('review.approve', $review->id) }}" method="POST" style="display:inline-block;">
                @csrf
                <button class="btn btn-success">Approve</button>
            </form>
            @endif


            <a href="{{ route('review.table') }}" class="btn btn-secondary"><i class="bi bi-arrow-left-circle me-1"></i> Back</a>
        </div>

    </div>

</div>
</section>

@endsection
