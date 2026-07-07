@extends('layouts.app')
@section('content')

<section class="content-main">
    <div class="content-header">
        <h2 class="content-title">Add Shipping Zone</h2>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('shipping.zone.store') }}" id="zoneForm" novalidate>
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-bold">Zone Name <span class="text-danger"></span></label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Enter Zone Name" value="{{ old('name') }}">
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                    <small class="text-danger d-none" id="nameError">Zone name cannot be empty.</small>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Priority <span class="text-danger"></span></label>
                    <input type="number" name="priority" id="priority" class="form-control" value="{{ old('priority', 1) }}" min="1">
                    @error('priority')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                    <small class="text-danger d-none" id="priorityError">Priority cannot be empty.</small>
                </div>

                <div>
                    <button type="submit" class="btn btn-primary">Save Zone</button>
                    <a href="{{ route('shipping.zone.table') }}" class="btn btn-secondary px-4">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</section>

@endsection
<script>
document.addEventListener('DOMContentLoaded', function() {
    const zoneForm = document.getElementById('zoneForm');
    const nameInput = document.getElementById('name');
    const priorityInput = document.getElementById('priority');
    const nameError = document.getElementById('nameError');
    const priorityError = document.getElementById('priorityError');
    
    zoneForm.addEventListener('submit', function(e) {
        e.preventDefault();
        let isValid = true;
        
        if (!nameInput.value.trim()) {
            nameError.classList.remove('d-none');
            nameInput.classList.add('is-invalid');
            isValid = false;
        } else {
            nameError.classList.add('d-none');
            nameInput.classList.remove('is-invalid');
        }
        
        if (!priorityInput.value.trim()) {
            priorityError.classList.remove('d-none');
            priorityInput.classList.add('is-invalid');
            isValid = false;
        } else {
            priorityError.classList.add('d-none');
            priorityInput.classList.remove('is-invalid');
        }
        
        if (isValid) {
            zoneForm.submit();
        }
    });
    
    nameInput.addEventListener('input', function() {
        if (this.value.trim()) nameError.classList.add('d-none');
    });
    
    priorityInput.addEventListener('input', function() {
        if (this.value.trim()) priorityError.classList.add('d-none');
    });
});
</script>
