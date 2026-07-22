@extends('layouts.auth')

@section('content')
    @include('includes.alert')
    <section class="content-main">
        <div class="card mx-auto card-login">
            <div class="card-body" style="padding: 15px;">
                <h4 class="card-title mb-4 text-center">Reset Password</h4>
                <form method="POST" action="{{ route('password.update') }}" id="resetPasswordForm">
                    @csrf
                    <input type="hidden" name="email" value="{{ $email }}">
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <input name="password" id="password" class="form-control" placeholder="New Password" type="password"
                            required />
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirm Password</label>
                        <input name="password_confirmation" id="password_confirmation" class="form-control"
                            placeholder="Confirm Password" type="password" required />
                        <span class="text-danger" id="passwordError" style="display: none;">Password does not match.</span>
                    </div>
                    <div class="mb-0">
                        <button type="submit" class="btn btn-primary w-100">Reset Password</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <script>
        document.getElementById('resetPasswordForm').addEventListener('submit', function (e) {
            var password = document.getElementById('password').value;
            var confirmPassword = document.getElementById('password_confirmation').value;
            var errorSpan = document.getElementById('passwordError');

            if (password !== confirmPassword) {
                e.preventDefault();
                errorSpan.style.display = 'block';
                document.getElementById('password_confirmation').classList.add('is-invalid');
            } else {
                errorSpan.style.display = 'none';
                document.getElementById('password_confirmation').classList.remove('is-invalid');
            }
        });

        // Hide error when user starts typing in confirm password field
        document.getElementById('password_confirmation').addEventListener('input', function () {
            var password = document.getElementById('password').value;
            var confirmPassword = this.value;
            var errorSpan = document.getElementById('passwordError');

            if (password === confirmPassword) {
                errorSpan.style.display = 'none';
                this.classList.remove('is-invalid');
            }
        });
    </script>
@endsection