@extends('layouts.app')
@section('content')
@include('includes.alert')
           <section class="content-main">
                <div class="content-header">
                    <h2 class="content-title">Customer Registration</h2>
                </div>
                <div class="card">
                    <div class="card-body">
                        
                            <div class="col-lg-9">
                                <section class="content-body p-xl-4">
                                    <form id="customerForm" method="POST" action="{{ route('store') }}" novalidate>
                                       @csrf
                                        <div class="row gx-3">
                                            <div class="col-6 mb-3">
                                                <label class="form-label">User name</label>
                                                <input name="username" id="username" class="form-control" type="text" placeholder="User Name" pattern="[a-zA-Z0-9._@+-]+" title="Only letters, numbers, and . _ @ + - allowed" value="{{ old('username') }}">
                                                @error('username') <small class="text-danger">{{ $message }}</small> @enderror
                                                <small class="text-danger d-none" id="usernameError">Username is required.</small>
                                            </div>

                                            <div class="col-lg-6 mb-3">
                                               <label class="form-label">Email</label>
                                               <input name="email" id="email" class="form-control" type="email" placeholder="example@mail.com" value="{{ old('email') }}">
                                               @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                                               <small class="text-danger d-none" id="emailError">Enter a valid email</small>
                                            </div>

                                            <div class="col-lg-6 mb-3">
                                                <label class="form-label">Password</label>
                                                <input name="password" id="password" class="form-control" type="password" placeholder="password" value="{{ old('password') }}">
                                                @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                                                <small class="text-danger d-none" id="passwordError">Password must be at least 8 characters long</small>
                                            </div>
                                           
                                           
                                             <div class="col-lg-6 mb-3">
                                                <label class="form-label">Confirm Password</label>
                                                <input name="confirm_password" id="confirm_password" class="form-control" type="password" placeholder="password" value="{{ old('confirm_password') }}">
                                                @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                                                <small class="text-danger d-none" id="confirmPasswordError">Password must be at least 8 characters long</small>
                                            </div>
                                           
                                            

                                            

                                            <div class="col-lg-6 mb-3">
                                                <label class="form-label">Phone</label>
                                                <input name="mobilenumber" id="mobilenumber" class="form-control" type="tel" placeholder="+1234567890" value="{{ old('mobilenumber') }}">
                                                 @error('mobilenumber') <small class="text-danger">{{ $message }}</small> @enderror
                                                 <small class="text-danger d-none" id="mobileError">Mobile number must be 10 digits</small>
                                            </div> 
                                            
                                            <div class="col-lg-6 mb-3">
                                               <label class="form-label">Pin</label>
                                               <input name="pin" id="pin" class="form-control" type="text" placeholder="Pin no" value="{{ old('pin') }}">
                                               @error('pin') <small class="text-danger">{{ $message }}</small> @enderror
                                               <small class="text-danger d-none" id="pinError">PIN code must be 6 digits</small>
                                            </div>
                                            
                                            <div class="col-lg-12 mb-3">
                                               <label class="form-label">Address</label>
                                               <input name="address" id="address" class="form-control" type="text" placeholder="Address" value="{{ old('address') }}">
                                               @error('address') <small class="text-danger">{{ $message }}</small> @enderror
                                               <small class="text-danger d-none" id="addressError">Address is required.</small>
                                            </div>

                                        </div>

                                    <br>
                                       <button class="btn btn-primary" type="submit"><i class="bi bi-save me-1"></i> Save</button>
                                       <a href="{{ route('customer') }}" class="btn btn-secondary px-4"><i class="bi bi-arrow-left-circle me-1"></i> Back</a>
                                    </form>

                                    
                                    <!-- row.// -->
                                </section>
                                <!-- content-body .// -->
                            </div>
                            <!-- col.// -->
                        
                        <!-- row.// -->
                    </div>
                    <!-- card body end// -->
                </div>
                <!-- card end// -->
            </section>


<script>
document.addEventListener('DOMContentLoaded', function() {
    // Check if validation error exists only for confirm_password
    @if ($errors->has('confirm_password') && !$errors->has('password'))
        let pwd = "{{ old('password') }}";
        document.getElementById('password').value = pwd;
    @endif

    const form = document.getElementById('customerForm');
    const fields = [
        { id: 'username', errorId: 'usernameError' },
        { id: 'email', errorId: 'emailError' },
        { id: 'password', errorId: 'passwordError' },
        { id: 'confirm_password', errorId: 'confirmPasswordError' },
        { id: 'mobilenumber', errorId: 'mobileError' },
        { id: 'pin', errorId: 'pinError' },
        { id: 'address', errorId: 'addressError' }
    ];

    const uniqueChecks = {};

    async function checkUniqueness(field, value, errorId, inputId) {
        const input = document.getElementById(inputId);
        const error = document.getElementById(errorId);
        if (!value.trim()) return;

        try {
            const response = await fetch('{{ route("check.uniqueness") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ field, value })
            });
            const data = await response.json();
            uniqueChecks[field] = data.exists;

            if (data.exists) {
                input.classList.add('is-invalid');
                input.classList.remove('is-valid');
                error.textContent = (field === 'email' ? 'Email already exists' : 'Mobile number already registered');
                error.classList.remove('d-none');
            }
        } catch (e) {
            console.error('Uniqueness check failed', e);
        }
    }

    form.addEventListener('submit', async function(e) {
        let valid = true;
        
        for (const field of fields) {
            const input = document.getElementById(field.id);
            const error = document.getElementById(field.errorId);
            let fieldValid = true;

            if (!input.value.trim()) {
                fieldValid = false;
                error.textContent = field.id.charAt(0).toUpperCase() + field.id.slice(1) + " is required.";
            } else {
                // Specific checks
                if (field.id === 'email') {
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(input.value.trim())) {
                        fieldValid = false;
                        error.textContent = "Enter a valid email";
                    }
                } else if (field.id === 'password' || field.id === 'confirm_password') {
                    const strongPasswordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,}$/;
                    if (!strongPasswordRegex.test(input.value)) {
                        fieldValid = false;
                        error.textContent = "Password must contain a strong password (uppercase, lowercase, number, special character)";
                    } else if (field.id === 'confirm_password' && input.value !== document.getElementById('password').value) {
                        fieldValid = false;
                        error.textContent = "Passwords do not match";
                    }
                } else if (field.id === 'mobilenumber') {
                    const phoneRegex = /^\d{10}$/;
                    if (!phoneRegex.test(input.value.trim())) {
                        fieldValid = false;
                        error.textContent = "Mobile number must be 10 digits";
                    }
                } else if (field.id === 'pin') {
                    const pinRegex = /^\d{6}$/;
                    if (!pinRegex.test(input.value.trim())) {
                        fieldValid = false;
                        error.textContent = "PIN code must be 6 digits";
                    }
                }
            }

            if (!fieldValid) {
                input.classList.add('is-invalid');
                input.classList.remove('is-valid');
                error.classList.remove('d-none');
                valid = false;
            } else {
                // Final check for uniqueness before allowing submit
                if (uniqueChecks[field.id]) {
                     input.classList.add('is-invalid');
                     input.classList.remove('is-valid');
                     error.textContent = (field.id === 'email' ? 'Email already exists' : 'Mobile number already registered');
                     error.classList.remove('d-none');
                     valid = false;
                } else {
                    input.classList.remove('is-invalid');
                    input.classList.add('is-valid');
                    error.classList.add('d-none');
                }
            }
        }

        if (!valid) {
            e.preventDefault();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    });

    fields.forEach(field => {
        const input = document.getElementById(field.id);
        input.addEventListener('input', function() {
            this.classList.remove('is-invalid');
            this.classList.remove('is-valid');
            document.getElementById(field.errorId).classList.add('d-none');
            if (field.id === 'email' || field.id === 'mobilenumber') {
                uniqueChecks[field.id] = false; // Reset on change
            }
        });

        if (field.id === 'email' || field.id === 'mobilenumber') {
            input.addEventListener('blur', function() {
                checkUniqueness(field.id, this.value, field.errorId, field.id);
            });
        }
    });
});
</script>

         @endsection   