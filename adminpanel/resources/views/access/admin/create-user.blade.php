@extends('layouts.app')
@section('content')
@include('includes.alert')

<section class="content-main">
    <div class="content-header">
        <div>
            <h2 class="content-title card-title">Add Admin User</h2>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form id="adminUserForm" action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf

                {{-- Name & Username --}}
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label">Name <span class="text-danger"></span></label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required placeholder="Enter full name">
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        <small id="nameError" class="text-danger d-none">Name is required.</small>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Username <span class="text-danger"></span></label>
                        <input type="text" name="username" id="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}" required placeholder="Enter username">
                        @error('username') <small class="text-danger">{{ $message }}</small> @enderror
                        <small id="usernameError" class="text-danger d-none">Username is required.</small>
                    </div>
                </div>

                {{-- Email & Phone --}}
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label">Email <span class="text-danger"></span></label>
                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required placeholder="Enter email address">
                        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                        <small id="emailError" class="text-danger d-none">Email is required.</small>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Phone Number <span class="text-danger"></span></label>
                        <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" required placeholder="Enter phone number">
                        @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                        <small id="phoneError" class="text-danger d-none">Phone number is required.</small>
                    </div>
                </div>

                {{-- Password & Confirm Password --}}
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label">Password <span class="text-danger"></span></label>
                        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required placeholder="Enter password (min 6 characters)">
                        @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                        <small id="passwordError" class="text-danger d-none">Password is required.</small>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Confirm Password <span class="text-danger"></span></label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required placeholder="Re-enter password">
                        <small id="passwordConfirmationError" class="text-danger d-none">Please confirm your password.</small>
                    </div>
                </div>

                <hr>

                {{-- Role Type & Assigned Role --}}
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label">Role Type <span class="text-danger"></span></label>
                        <select name="role_type" id="role_type" class="form-control @error('role_type') is-invalid @enderror" required>
                            <option value="admin" {{ old('role_type') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="superadmin" {{ old('role_type') == 'superadmin' ? 'selected' : '' }}>Super Admin</option>
                        </select>
                        @error('role_type') <small class="text-danger">{{ $message }}</small> @enderror
                        <small id="roleTypeError" class="text-danger d-none">Role type is required.</small>
                        <small class="text-muted">Super Admin has access to everything regardless of role/permissions.</small>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Assigned Role</label>
                        <select name="role_id" class="form-control">
                            <option value="">-- No Role --</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">Role provides a base set of permissions.</small>
                    </div>
                </div>

                <hr>

                {{-- Profile Image --}}
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label">Profile Image</label>
                        <input type="file" name="profile_image" class="form-control" accept="image/jpeg,image/png,image/jpg">
                        <small class="text-muted">Accepted formats: JPG, JPEG, PNG. Max size: 2MB.</small>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> Create</button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary"><i class="bi bi-x-circle me-1"></i> Cancel</a>
                </div>
            </form>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    document.getElementById('adminUserForm').addEventListener('submit', function(e) {
        let valid = true;
        const fields = [
            { name: 'name', errorId: 'nameError' },
            { name: 'username', errorId: 'usernameError' },
            { name: 'email', errorId: 'emailError' },
            { name: 'phone', errorId: 'phoneError' },
            { name: 'password', errorId: 'passwordError' },
            { name: 'password_confirmation', errorId: 'passwordConfirmationError' },
            { name: 'role_type', errorId: 'roleTypeError' }
        ];
        
        fields.forEach(field => {
            const input = this.querySelector(`[name="${field.name}"]`);
            const error = document.getElementById(field.errorId);
            if (input && !input.value.trim()) {
                input.classList.add('is-invalid');
                input.classList.remove('is-valid');
                if (error) error.classList.remove('d-none');
                valid = false;
            } else if (input) {
                input.classList.remove('is-invalid');
                input.classList.add('is-valid');
                if (error) error.classList.add('d-none');
            }
        });

        if (!valid) {
            e.preventDefault();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    });

    // Real-time validation as user types
    const inputFields = ['name', 'username', 'email', 'phone', 'password', 'password_confirmation', 'role_type'];
    const errorIds = ['nameError', 'usernameError', 'emailError', 'phoneError', 'passwordError', 'passwordConfirmationError', 'roleTypeError'];

    inputFields.forEach((name, index) => {
        const el = document.querySelector(`[name="${name}"]`);
        if (el) {
            const eventType = el.tagName === 'SELECT' ? 'change' : 'input';
            el.addEventListener(eventType, function() {
                if (this.value.trim()) {
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                    const errorEl = document.getElementById(errorIds[index]);
                    if (errorEl) errorEl.classList.add('d-none');
                } else {
                    this.classList.remove('is-valid');
                }
            });
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
