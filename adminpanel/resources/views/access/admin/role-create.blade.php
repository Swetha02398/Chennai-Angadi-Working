@extends('layouts.app')
@section('content')
@include('includes.alert')

<section class="content-main">
    <div class="content-header">
        <div>
            <h2 class="content-title card-title">Create New Role</h2>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">

            <form id="roleForm" action="{{ route('admin.roles.store') }}" method="POST" novalidate>
                @csrf

                {{-- Role Name & Description --}}
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label">Role Name <span class="text-danger"></span></label>
                        <input type="text" name="name" id="roleName" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required placeholder="Enter role name">
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        <small class="text-danger d-none" id="nameError">Role name is required.</small>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Description</label>
                        <input type="text" name="description" class="form-control" value="{{ old('description') }}" placeholder="Enter description">
                    </div>
                </div>

                <hr>

                {{-- Permissions --}}
                <h5 class="mb-3">
                    <i class="bi bi-shield-check"></i> Assign Permissions
                </h5>

                <div class="mb-3 d-flex flex-wrap gap-2">
                    <button type="button" class="btn btn-sm btn-primary" id="selectAll">
                        <i class="bi bi-check-all"></i> Select All
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary" id="clearAll">
                        <i class="bi bi-x-circle"></i> Clear All
                    </button>

                    <button type="button" class="btn btn-sm btn-info text-black column-toggle-btn btn-action-col d-inline-flex align-items-center justify-content-center " data-column="view"><i class="bi bi-eye me-1"></i> View</button>
                    <button type="button" class="btn btn-sm btn-info text-black column-toggle-btn" data-column="create">
                        <i class="bi bi-plus-circle"></i> Create
                    </button>
                    <button type="button" class="btn btn-sm btn-info text-black column-toggle-btn" data-column="edit">
                        <i class="bi bi-pencil-square"></i> Edit
                    </button>
                    <button type="button" class="btn btn-sm btn-info text-black column-toggle-btn btn-action-col d-inline-flex align-items-center justify-content-center " data-column="delete"><i class="bi bi-trash me-1"></i> Delete</button>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th style="min-width: 180px;">Module</th>
                                <th class="text-center" style="width: 100px;">View</th>
                                <th class="text-center" style="width: 100px;">Create</th>
                                <th class="text-center" style="width: 100px;">Edit</th>
                                <th class="text-center" style="width: 100px;">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($permissions as $module => $modulePermissions)
                            <tr>
                                <td>
                                    <strong>{{ ucwords(str_replace('-', ' ', $module)) }}</strong>
                                </td>
                                @foreach(['view', 'create', 'edit', 'delete'] as $action)
                                    <td class="text-center">
                                        @php
                                            $perm = $modulePermissions->firstWhere('action', $action);
                                        @endphp
                                        @if($perm)
                                            <div class="form-check d-flex justify-content-center">
                                                <input class="form-check-input permission-checkbox"
                                                    type="checkbox"
                                                    name="permissions[]"
                                                    value="{{ $perm->id }}"
                                                    data-action="{{ $action }}"
                                                    {{ in_array($perm->id, old('permissions', [])) ? 'checked' : '' }}>
                                            </div>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Create Role</button>
                    <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</section>

@push('scripts')
<script>
    document.getElementById('selectAll').addEventListener('click', function() {
        document.querySelectorAll('.permission-checkbox').forEach(cb => cb.checked = true);
    });

    document.getElementById('clearAll').addEventListener('click', function() {
        document.querySelectorAll('.permission-checkbox').forEach(cb => cb.checked = false);
    });

    // Column toggle buttons - check all checkboxes in that column
    document.querySelectorAll('.column-toggle-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var column = this.getAttribute('data-column');
            var checkboxes = document.querySelectorAll('.permission-checkbox[data-action="' + column + '"]');
            // If all are already checked, uncheck all; otherwise check all
            var allChecked = Array.from(checkboxes).every(cb => cb.checked);
            checkboxes.forEach(cb => cb.checked = !allChecked);
        });
    });

    document.getElementById('roleForm').addEventListener('submit', function(e) {
        const nameInput = document.getElementById('roleName');
        const nameError = document.getElementById('nameError');
        if (!nameInput.value.trim()) {
            e.preventDefault();
            nameInput.classList.add('is-invalid');
            nameInput.classList.remove('is-valid');
            if (nameError) nameError.classList.remove('d-none');
            window.scrollTo({ top: 0, behavior: 'smooth' });
        } else {
            nameInput.classList.remove('is-invalid');
            nameInput.classList.add('is-valid');
            if (nameError) nameError.classList.add('d-none');
        }
    });

    // Real-time validation
    document.getElementById('roleName').addEventListener('input', function() {
        if (this.value.trim()) {
            this.classList.remove('is-invalid');
            this.classList.add('is-valid');
            document.getElementById('nameError').classList.add('d-none');
        } else {
            this.classList.remove('is-valid');
        }
    });
</script>

<style>
.is-valid {
    border-color: #198754 !important;
    background-color: #f6fff6 !important;
}
.is-invalid {
    border-color: #dc3545 !important;
    background-color: #fff6f6 !important;
}
.text-danger {
    font-size: 0.85rem;
}
</style>
@endpush

@endsection
