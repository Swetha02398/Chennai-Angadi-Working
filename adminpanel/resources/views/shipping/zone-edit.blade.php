@extends('layouts.app')
@section('content')

<section class="content-main">
    <h2>Edit Shipping Zone</h2>

    <form id="zoneForm" method="POST" action="{{ route('shipping.zone.update',$zone->id) }}" novalidate>
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Zone Name</label>
            <input type="text" name="name" id="nameInput" value="{{ old('name', $zone->name) }}" class="form-control" required>
            @error('name')
                <small class="text-danger">{{ $message }}</small>
            @enderror
            <small class="text-danger d-none" id="nameError">Zone name is required.</small>
        </div>

        <div class="mb-3">
            <label>Priority</label>
            <input type="number" name="priority" value="{{ old('priority', $zone->priority) }}" class="form-control">
            @error('priority')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="is_active" class="form-select">
                <option value="1" {{ old('is_active', $zone->is_active) ? 'selected':'' }}>Active</option>
                <option value="0" {{ !old('is_active', $zone->is_active) ? 'selected':'' }}>Inactive</option>
            </select>
            @error('is_active')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <button class="btn btn-primary">Update</button>
    </form>
</section>

<script>
    document.getElementById('zoneForm').addEventListener('submit', function (e) {
        const input = document.getElementById('nameInput');
        if (!input.value.trim()) {
            e.preventDefault();
            input.classList.add('is-invalid');
            document.getElementById('nameError').classList.remove('d-none');
        } else {
            input.classList.remove('is-invalid');
            document.getElementById('nameError').classList.add('d-none');
        }
    });

    document.getElementById('nameInput').addEventListener('input', function () {
        this.classList.remove('is-invalid');
        document.getElementById('nameError').classList.add('d-none');
    });
</script>
@endsection
