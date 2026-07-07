@extends('layouts.app')
@section('content')

<section class="content-main">
    <div class="content-header">
        <h2 class="content-title">Add Shipping State</h2>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('shipping.state.store') }}" id="stateForm" novalidate>
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-bold">Shipping Zone <span class="text-danger"></span></label>
                    <select name="shipping_zone_id" id="shipping_zone_id" class="form-select">
                        <option value="">-- Select Zone --</option>
                        @foreach($zones as $z)
                            <option value="{{ $z->id }}">{{ $z->name }}</option>
                        @endforeach
                    </select>
                    <small class="text-danger d-none" id="zoneError">Zone selection cannot be empty.</small>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">State Name <span class="text-danger"></span></label>
                    <input type="text"
                           name="state"
                           id="state"
                           class="form-control"
                           placeholder="Eg: Tamil Nadu">
                    <small class="text-danger d-none" id="stateError">State name cannot be empty.</small>
                </div>

                <div>
                    <button type="submit" class="btn btn-primary">
                        Save State
                    </button>
                    <a href="{{ route('shipping.state.table') }}" class="btn btn-secondary px-4">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</section>

@endsection
<script>
document.addEventListener('DOMContentLoaded', function() {
    const stateForm = document.getElementById('stateForm');
    const zoneSelect = document.getElementById('shipping_zone_id');
    const stateInput = document.getElementById('state');
    const zoneError = document.getElementById('zoneError');
    const stateError = document.getElementById('stateError');
    
    stateForm.addEventListener('submit', function(e) {
        e.preventDefault();
        let isValid = true;
        
        if (!zoneSelect.value.trim()) {
            zoneError.classList.remove('d-none');
            zoneSelect.classList.add('is-invalid');
            isValid = false;
        } else {
            zoneError.classList.add('d-none');
            zoneSelect.classList.remove('is-invalid');
        }
        
        if (!stateInput.value.trim()) {
            stateError.classList.remove('d-none');
            stateInput.classList.add('is-invalid');
            isValid = false;
        } else {
            stateError.classList.add('d-none');
            stateInput.classList.remove('is-invalid');
        }
        
        if (isValid) {
            stateForm.submit();
        }
    });
    
    zoneSelect.addEventListener('change', function() {
        if (this.value.trim()) zoneError.classList.add('d-none');
    });
    
    stateInput.addEventListener('input', function() {
        if (this.value.trim()) stateError.classList.add('d-none');
    });
});
</script>
