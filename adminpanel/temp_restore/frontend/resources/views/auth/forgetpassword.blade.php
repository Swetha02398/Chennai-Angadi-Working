@extends('layouts.app')
@section('content')

<div class="container mt-5">

    <h3>Forgot Password</h3>

    <!-- Step 1: Enter Email  -->
    @if(!session('otp_send') && !session('otp_verified'))
    <form method="POST" action="{{ route('sendotp') }}" id="fp-step1-form" novalidate>
        @csrf
        <div class="form-group mb-3">
            <label class="fw-bold mb-1">Enter Email</label>
            <input type="text" name="login_id" id="login_id_fp" class="form-control" required placeholder="Enter your email">
            <small class="text-danger d-none" id="login_id_fpError">Email is required</small>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Send OTP</button>
    </form>
    @endif


    <!-- Step 2: OTP Input -->
    @if(session('otp_send') && !session('otp_verified'))
    <form method="POST" action="{{ route('verifyotp') }}" class="mt-4" id="fp-step2-form" novalidate>
        @csrf
        <input type="hidden" name="login_id" value="{{ session('login_id') }}">
        
        <div class="form-group mb-3">
            <label class="fw-bold mb-1">Enter OTP</label>
            <input type="text" name="otp" id="otp" class="form-control" required placeholder="6-digit code">
            <small class="text-danger d-none" id="otpError">OTP is required</small>
        </div>

        <button type="submit" class="btn btn-success mt-3">Verify OTP</button>
    </form>
    @endif


    <!-- Step 3: New Password Form -->
    @if(session('otp_verified'))
    <form method="POST" action="{{ route('resetpassword') }}" class="mt-4" id="fp-step3-form" novalidate>
        @csrf
        <input type="hidden" name="login_id" value="{{ session('login_id') }}">

        <div class="form-group mb-3">
            <label class="fw-bold mb-1">New Password</label>
            <input type="password" name="password" id="password_fp" class="form-control" required>
            <small class="text-danger d-none" id="password_fpError">Password is required</small>
        </div>

        <div class="form-group mb-3">
            <label class="fw-bold mb-1">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation_fp" class="form-control" required>
            <small class="text-danger d-none" id="password_confirmation_fpError"></small>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Change Password</button>
    </form>
    @endif

    <script>
        function setupValidation(formId, fields) {
            let form = document.getElementById(formId);
            if (!form) return;
            form.addEventListener('submit', function (e) {
                let valid = true;
                fields.forEach(f => {
                    let input = document.getElementById(f.id);
                    let error = document.getElementById(f.errorId);
                    let isInvalid = false;
                    if (f.condition) {
                        isInvalid = f.condition();
                    } else {
                        isInvalid = !input.value.trim();
                    }

                    if (isInvalid) {
                        error.classList.remove('d-none');
                        if (f.message) error.textContent = f.message;
                        input.classList.add('is-invalid');
                        valid = false;
                    } else {
                        error.classList.add('d-none');
                        input.classList.remove('is-invalid');
                    }
                });
                if (!valid) e.preventDefault();
            });
        }

        setupValidation('fp-step1-form', [{ id: 'login_id_fp', errorId: 'login_id_fpError' }]);
        setupValidation('fp-step2-form', [{ id: 'otp', errorId: 'otpError' }]);
        setupValidation('fp-step3-form', [
            { id: 'password_fp', errorId: 'password_fpError' },
            { 
                id: 'password_confirmation_fp', 
                errorId: 'password_confirmation_fpError', 
                condition: () => document.getElementById('password_confirmation_fp').value !== document.getElementById('password_fp').value,
                message: 'Passwords do not match!'
            }
        ]);
    </script>


    <!-- SUCCESS / ERROR MESSAGES -->
    @if(session('message'))
        <div class="alert alert-success mt-3">{{ session('message') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger mt-3">{{ session('error') }}</div>
    @endif

</div>

@endsection
