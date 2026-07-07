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

    <h2 class="mb-4">Edit Slider</h2>

    <form id="sliderForm" action="{{ route('slider.update', $slider->id) }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf
        @method('PUT')

        <div class="row g-3">

            <div class="col-md-6">
                <label class="form-label fw-bold">Slider Position *</label>
                <select name="slider_position" id="slider_position" class="form-control" required>
                    <option value="">Select Position</option>
                    <option value="top" {{ old('slider_position', $slider->slider_position) == 'top' ? 'selected' : '' }}>Top</option>
                    <option value="middle" {{ old('slider_position', $slider->slider_position) == 'middle' ? 'selected' : '' }}>Middle</option>
                    <option value="bottom" {{ old('slider_position', $slider->slider_position) == 'bottom' ? 'selected' : '' }}>Bottom</option>
                </select>
                <small class="text-danger d-none" id="positionError">Slider position is required.</small>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Slider Text</label>
                <input type="text" name="title_text" class="form-control" value="{{ old('title_text', $slider->title_text) }}">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Current Image</label><br>
                <img src="{{ asset($slider->image) }}" width="150" class="img-thumbnail">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Change Image (Optional)</label>
                <input type="file" name="image" class="form-control" accept="image/*">
                <small class="text-muted">Supported formats: JPEG, PNG, JPG, WebP (Max 2MB)</small>
            </div>

            <div class="col-md-6">
                <div class="form-check">
                    <input type="checkbox" name="status" value="1" {{ $slider->status ? 'checked' : '' }} class="form-check-input" id="statusCheckbox">
                    <label class="form-check-label fw-bold" for="statusCheckbox">Active</label>
                </div>
            </div>

            <div class="col-md-12 mt-3">
                <button type="submit" class="btn btn-primary">Update Slider</button>
                <a href="{{ route('slider.table') }}" class="btn btn-secondary">Cancel</a>
            </div>

        </div>
    </form>
</div>

{{-- FRONTEND VALIDATION --}}
<script>
document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("sliderForm");

    form.addEventListener("submit", function(e) {
        let valid = true;
        const position = document.getElementById('slider_position');

        if (!position.value) {
            position.classList.add('is-invalid');
            document.getElementById('positionError').classList.remove('d-none');
            valid = false;
        } else {
            position.classList.remove('is-invalid');
            document.getElementById('positionError').classList.add('d-none');
        }

        if (!valid) e.preventDefault();
    });

    document.getElementById('slider_position').addEventListener('change', function () {
        this.classList.remove('is-invalid');
        document.getElementById('positionError').classList.add('d-none');
    });
});
</script>

</section>
@endsection
