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

    <h2 class="mb-4">Add New Slider</h2>

    <form id="sliderForm" action="{{ route('slider.store') }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf

        <div class="row">

            <div class="mb-3 col-md-6">
                <label>Slider Position *</label>
                <select name="slider_position" class="form-control" value="{{ old('slider_position') }}">
                    <option value="">Select Position</option>
                    <option value="top" {{ old('slider_position') == 'top' ? 'selected' : '' }}>Top</option>
                    <option value="middle" {{ old('slider_position') == 'middle' ? 'selected' : '' }}>Middle</option>
                    <option value="bottom" {{ old('slider_position') == 'bottom' ? 'selected' : '' }}>Bottom</option>
                </select>
                <small id="positionError" class="text-danger d-none">Slider position is required.</small>
            </div>

            <div class="mb-3 col-md-6">
                <label>Slider Text (Optional)</label>
                <input type="text" name="title_text" class="form-control" placeholder="Enter text for image" value="{{ old('title_text') }}">
            </div>

            <div class="mb-3 col-md-12">
                <label>Slider Images (Multiple) *</label>
                <input type="file" name="image[]" class="form-control" multiple accept="image/*">
                <small id="imageError" class="text-danger d-none">At least one image is required.</small>
                <small class="text-muted">Supported formats: JPEG, PNG, JPG, WebP (Max 2MB each)</small>
            </div>

            <div class="col-md-12">
                <div class="form-check mb-3">
                    <input type="checkbox" name="status" value="1" checked class="form-check-input" id="statusCheckbox">
                    <label class="form-check-label" for="statusCheckbox">Active</label>
                </div>
            </div>

        </div>

        <button type="submit" class="btn btn-primary">Save Slider</button>
        <a href="{{ route('slider.table') }}" class="btn btn-secondary">Cancel</a>

    </form>

</div>
</section>

<script>
const counts = @json($counts ?? ['top' => 0, 'middle' => 0, 'bottom' => 0]);
const limits = { 'top': 5, 'middle': 3, 'bottom': 1 };

document.getElementById('sliderForm').addEventListener('submit', function(e) {

    let valid = true;

    function requireField(name, errorId) {
        const el = document.querySelector(`[name="${name}"]`);
        if (el && el.value.trim() === "") {
            document.getElementById(errorId).classList.remove("d-none");
            el.classList.add("is-invalid");
            valid = false;
        } else if(el) {
            document.getElementById(errorId).classList.add("d-none");
            el.classList.remove("is-invalid");
        }
        return el ? el.value : "";
    }

    function requireFiles(name, errorId) {
        const el = document.querySelector(`[name="${name}"]`);
        if (el && el.files.length === 0) {
            document.getElementById(errorId).classList.remove("d-none");
            el.classList.add("is-invalid");
            valid = false;
        } else if(el) {
            document.getElementById(errorId).classList.add("d-none");
            el.classList.remove("is-invalid");
        }
        return el ? el.files.length : 0;
    }

    // All required fields
    const position = requireField("slider_position", "positionError");
    const newFilesCount = requireFiles("image[]", "imageError");

    if (valid && position && limits[position]) {
        const currentCount = counts[position] || 0;
        const totalAfter = currentCount + newFilesCount;

        if (totalAfter > limits[position]) {
            e.preventDefault();
            alert(`Limit Exceeded for ${position.toUpperCase()} position!\n\n` + 
                  `Maximum allowed: ${limits[position]}\n` +
                  `Already uploaded: ${currentCount}\n` +
                  `You are trying to add: ${newFilesCount}\n\n` +
                  `Please remove some images or delete existing ones first.`);
            return;
        }
    }

    if (!valid) e.preventDefault();
});
</script>

@endsection
