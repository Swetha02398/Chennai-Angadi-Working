@extends('layouts.app')
@section('content')
<section class="content-main">
<div class="container mt-4">
    <div class="row">
        <div class="col-md-8">
            <h2>Create Notification</h2>

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="notificationForm" action="{{ route('notifications.store') }}" method="POST" novalidate>
                @csrf

                <!-- Type -->
                <div class="mb-3">
                    <label for="type" class="form-label fw-bold">Notification Type *</label>
                    <select name="type" id="type" class="form-control" required>
                        <option value="">-- Select Type --</option>
                        <option value="normal" {{ old('type') == 'normal' ? 'selected' : '' }}>Normal</option>
                        <option value="high" {{ old('type') == 'high' ? 'selected' : '' }}>High Priority</option>
                        <option value="admin" {{ old('type') == 'admin' ? 'selected' : '' }}>Admin Only</option>
                    </select>
                    <small id="typeError" class="text-danger d-none">Notification type is required.</small>
                </div>

                <!-- Title -->
                <div class="mb-3">
                    <label for="title" class="form-label fw-bold">Notification Title *</label>
                    <input type="text" id="title" name="title" class="form-control" value="{{ old('title') }}" required>
                    <small id="titleError" class="text-danger d-none">Title is required.</small>
                </div>

                <!-- Message -->
                <div class="mb-3">
                    <label for="message" class="form-label fw-bold">Message *</label>
                    <textarea id="message" name="message" class="form-control" rows="4" required>{{ old('message') }}</textarea>
                    <small id="messageError" class="text-danger d-none">Message is required.</small>
                </div>

                 <!--From role-->
                  <div class="mb-3">
                    <label for="from_role" class="form-label fw-bold">From Role *</label>
                    <select name="from_role" id="from_role" class="form-control" required>
                        <option value="">-- Select Type --</option>
                        <option value="customer" {{ old('from_role') == 'customer' ? 'selected' : '' }}>Customer</option>
                        <option value="admin" {{ old('from_role') == 'admin' ? 'selected' : '' }}>Admin </option>
                    </select>
                    <small id="fromRoleError" class="text-danger d-none">From role is required.</small>
                </div>

                <!-- Send To Role -->
                <div class="mb-3">
                    <label for="role" class="form-label fw-bold">Send To Role *</label>
                    <select name="role" id="role" class="form-control" onchange="loadUsers()" required>
                        <option value="">-- Select Role --</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admins</option>
                        <option value="customer" {{ old('role') == 'customer' ? 'selected' : '' }}>Registered Customers</option>
                        <option value="guest" {{ old('role') == 'guest' ? 'selected' : '' }}>Guest Customers</option>
                        <option value="all_customers" {{ old('role') == 'all_customers' ? 'selected' : '' }}>All Customers (Registered & Guest)</option>
                    </select>
                    <small id="roleError" class="text-danger d-none">Send to role is required.</small>
                </div>

                <!-- Select Users -->
                <div class="mb-3" id="usersSection" style="display:none;">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <label class="form-label fw-bold">Select Users *</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="selectAllUsers">
                            <label class="form-check-label fw-bold" for="selectAllUsers">
                                Select All
                            </label>
                        </div>
                    </div>
                    <div class="border p-3 rounded" style="max-height: 400px; overflow-y: auto; background-color: #f9f9f9;">
                        <div id="usersList"></div>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Send Notification</button>
                    <a href="{{ route('notifications.table') }}" class="btn btn-secondary btn-lg">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
</section>

<script>
// Convert Laravel collections to JavaScript arrays
const admins = @json($admins);
const customers = @json($customers);
const guests = @json($guests ?? []);

console.log('Admins:', admins);
console.log('Customers:', customers);
console.log('Guests:', guests);

document.getElementById('selectAllUsers').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.user-checkbox');
    checkboxes.forEach(cb => cb.checked = this.checked);
});

function loadUsers() {
    const role = document.getElementById('role').value;
    const usersSection = document.getElementById('usersSection');
    const usersList = document.getElementById('usersList');

    usersSection.style.display = 'block';

    let users = [];
    if (role === 'customer') {
        users = customers;
    } else if (role === 'admin') {
        users = admins;
    } else if (role === 'guest') {
        users = guests;
    } else if (role === 'all_customers') {
        users = [...customers, ...guests];
    }
    
    // Reset select all checkbox
    document.getElementById('selectAllUsers').checked = false;

    let html = '';

    if (!users || users.length === 0) {
        html = '<p class="text-muted">No users available for this role</p>';
    } else {
        users.forEach(user => {
            html += `
                <div class="form-check mb-2">
                    <input class="form-check-input user-checkbox" type="checkbox" 
                           name="user_id[]" value="${user.id}" id="user_${user.id}">
                    <label class="form-check-label" for="user_${user.id}">
                        <strong>${user.name}</strong> 
                        <span class="text-muted">${user.email}</span>
                    </label>
                </div>
            `;
        });
    }

    usersList.innerHTML = html;
}


// Load users if role is already selected (on page load)
window.addEventListener('load', function() {
    const role = document.getElementById('role').value;
    if (role) {
        loadUsers();
    }
});

document.getElementById('notificationForm').addEventListener('submit', function(e) {
    let isValid = true;
    const fields = [
        { id: 'type', errorId: 'typeError' },
        { id: 'title', errorId: 'titleError' },
        { id: 'message', errorId: 'messageError' },
        { id: 'from_role', errorId: 'fromRoleError' },
        { id: 'role', errorId: 'roleError' }
    ];

    fields.forEach(field => {
        const input = document.getElementById(field.id);
        const error = document.getElementById(field.errorId);
        if (input && !input.value.trim()) {
            input.classList.add('is-invalid');
            input.classList.remove('is-valid');
            error.classList.remove('d-none');
            isValid = false;
        } else if (input) {
            input.classList.remove('is-invalid');
            input.classList.add('is-valid');
            error.classList.add('d-none');
        }
    });

    const selectedUsers = Array.from(document.querySelectorAll('input.user-checkbox:checked')).length;
    if (selectedUsers === 0) {
        alert('❌ Please select at least one user');
        isValid = false;
    }

    if (!isValid) {
        e.preventDefault();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
});

// Clear errors and valid status as user types/changes
const allFieldIds = ['type', 'title', 'message', 'from_role', 'role'];
const allFieldErrors = ['typeError', 'titleError', 'messageError', 'fromRoleError', 'roleError'];

allFieldIds.forEach((id, index) => {
    const el = document.getElementById(id);
    if (el) {
        const eventType = el.tagName === 'SELECT' ? 'change' : 'input';
        el.addEventListener(eventType, function() {
            if (this.value.trim()) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            } else {
                this.classList.remove('is-valid');
            }
            const errorEl = document.getElementById(allFieldErrors[index]);
            if (errorEl) errorEl.classList.add('d-none');
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
@endsection
