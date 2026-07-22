@extends('layouts.app')
@section('content')

<section class="content-main">
    <h2>Edit Zone State</h2>

    <form id="stateForm" method="POST" action="{{ route('shipping.state.update',$state->id) }}" novalidate>
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Zone</label>
            <select name="shipping_zone_id" class="form-select">
                @foreach($zones as $zone)
                    <option value="{{ $zone->id }}"
                        {{ $state->shipping_zone_id == $zone->id ? 'selected':'' }}>
                        {{ $zone->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>State</label>
            <input type="text" name="state" id="stateInput" value="{{ $state->state }}" class="form-control" required>
            <small class="text-danger d-none" id="stateError">State is required.</small>
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="is_active" class="form-select">
                <option value="1" {{ $state->is_active ? 'selected':'' }}>Active</option>
                <option value="0" {{ !$state->is_active ? 'selected':'' }}>Inactive</option>
            </select>
        </div>

        <button class="btn btn-primary"><i class="bi bi-save me-1"></i> Update</button>
    </form>
</section>

<script>
    document.getElementById('stateForm').addEventListener('submit', function (e) {
        const input = document.getElementById('stateInput');
        if (!input.value.trim()) {
            e.preventDefault();
            input.classList.add('is-invalid');
            document.getElementById('stateError').classList.remove('d-none');
        } else {
            input.classList.remove('is-invalid');
            document.getElementById('stateError').classList.add('d-none');
        }
    });

    document.getElementById('stateInput').addEventListener('input', function () {
        this.classList.remove('is-invalid');
        document.getElementById('stateError').classList.add('d-none');
    });
</script>
@endsection
