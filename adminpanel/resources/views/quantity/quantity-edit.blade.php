@extends('layouts.app')
@section('content')
    @include('includes.alert')
<section class="content-main">
<div class="container mt-4">
    <h3>Edit Weight</h3>
    <form id="quantityForm" method="POST" action="{{ route('quantity.update',$quantity->id) }}" novalidate>
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $quantity->name) }}" required>
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
            <small class="text-danger d-none" id="nameError">Name is required.</small>
        </div>
        <div class="mb-3">
            <label>Weight</label>
            <input type="text" name="label" id="label" class="form-control @error('label') is-invalid @enderror" value="{{ old('label', $quantity->label) }}" required>
            @error('label') <small class="text-danger">{{ $message }}</small> @enderror
            <small class="text-danger d-none" id="labelError">Weight value is required.</small>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <button type="reset" class="btn btn-secondary">Reset</button>
    </form>
</div>
</section>

<script>
    document.getElementById('quantityForm').addEventListener('submit', function (e) {
        let valid = true;
        const name = document.querySelector('input[name="name"]');
        const label = document.querySelector('input[name="label"]');

        if (!name.value.trim()) {
            name.classList.add('is-invalid');
            document.getElementById('nameError').classList.remove('d-none');
            valid = false;
        } else {
            name.classList.remove('is-invalid');
            document.getElementById('nameError').classList.add('d-none');
        }

        if (!label.value.trim()) {
            label.classList.add('is-invalid');
            document.getElementById('labelError').classList.remove('d-none');
            valid = false;
        } else {
            label.classList.remove('is-invalid');
            document.getElementById('labelError').classList.add('d-none');
        }

        if (!valid) e.preventDefault();
    });

    // Clear validation errors when typing
    document.getElementById('name').addEventListener('input', function () {
        this.classList.remove('is-invalid');
        document.getElementById('nameError').classList.add('d-none');
    });

    document.getElementById('label').addEventListener('input', function () {
        this.classList.remove('is-invalid');
        document.getElementById('labelError').classList.add('d-none');
    });

    // Handle reset button to completely clear the form and remove errors
    document.getElementById('quantityForm').addEventListener('reset', function(e) {
        e.preventDefault(); // Prevent default reset (which restores old values)
        
        const nameInput = document.getElementById('name');
        const labelInput = document.getElementById('label');
        
        // Clear values
        nameInput.value = '';
        labelInput.value = '';
        
        // Remove error states
        nameInput.classList.remove('is-invalid');
        labelInput.classList.remove('is-invalid');
        document.getElementById('nameError').classList.add('d-none');
        document.getElementById('labelError').classList.add('d-none');
    });
</script>
@endsection
