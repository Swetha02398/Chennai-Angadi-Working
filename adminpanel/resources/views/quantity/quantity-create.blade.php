@extends('layouts.app')
@section('content')
    @include('includes.alert')
<section class="content-main">
    <div class="content-header">
        <h2 class="content-title">Add Weight</h2>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('quantity.store') }}" id="quantityForm" novalidate>
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-bold">Name <span class="text-danger"></span></label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Enter weight name" value="{{ old('name') }}">
                    <small class="text-danger d-none" id="quantitynameError">Please enter a weight name.</small>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Weight <span class="text-danger"></span></label>
                    <input type="text" name="label" id="label" class="form-control " placeholder="e.g. 250g, 500g" value="{{ old('label') }}">
                    <small class="text-danger d-none" id="quantitylabelError">Weight cannot be empty.</small>
                </div>

                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> Save</button>
                     <a href="{{ route('quantity.table') }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left-circle me-1"></i> Back</a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
<script>
// Wait for DOM to load
document.addEventListener('DOMContentLoaded', function() {
    const quantityForm = document.getElementById('quantityForm');
    const nameInput = document.getElementById('name');
    const labelInput = document.getElementById('label');
    const nameError = document.getElementById('quantitynameError');
    const labelError = document.getElementById('quantitylabelError');
    
    // Form submit handler
    quantityForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        let isValid = true;
        
        // Validate Name field
        if (!nameInput.value.trim()) {
            nameError.classList.remove('d-none');
            nameInput.classList.add('is-invalid');
            isValid = false;
        } else {
            nameError.classList.add('d-none');
            nameInput.classList.remove('is-invalid');
        }
        
        // Validate Label field
        if (!labelInput.value.trim()) {
            labelError.classList.remove('d-none');
            labelInput.classList.add('is-invalid');
            isValid = false;
        } else {
            labelError.classList.add('d-none');
            labelInput.classList.remove('is-invalid');
        }
        
        // Submit form only if valid
        if (isValid) {
            quantityForm.submit();
        }
    });
    
    // Clear error messages when user starts typing
    nameInput.addEventListener('input', function() {
        if (this.value.trim()) {
            nameError.classList.add('d-none');
        }
    });
    
    labelInput.addEventListener('input', function() {
        if (this.value.trim()) {
            labelError.classList.add('d-none');
        }
    });
});
</script>

