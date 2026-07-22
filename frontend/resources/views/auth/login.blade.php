@extends('layouts.app')
@section('content')
    @include('includes.alert')
    <main class="main pages">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="{{ route('index') }}" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                    <span></span> Pages <span></span> My Account
                </div>
            </div>
        </div>
        <div class="page-content pt-150 pb-150">
            <div class="container">
                <div class="row">
                    <div class="col-xl-8 col-lg-10 col-md-12 m-auto">
                        <div class="row">
                            <div class="col-lg-6 pr-30 d-none d-lg-block">
                                <img class="border-radius-15" src="{{ asset('assets/imgs/page/login-1.png') }}" alt="" />
                            </div>
                            <div class="col-lg-6 col-md-8">
                                <div class="login_wrap widget-taber-content background-white">
                                    <div class="p-4 bg-white">
                                        <div class="heading_s1">
                                            <h1 class="mb-2">Login</h1>
                                            <p class="mb-10">Don't have an account? <a href="{{ route('register') }}">Create
                                                    here</a></p>
                                        </div>
                                        <form method="post" action="{{ route('insert') }}" id="login-form" novalidate>
                                            @csrf
                                            @if(request('redirect'))
                                                <input type="hidden" name="redirect" value="{{ request('redirect') }}">
                                            @endif
                                            <div class="form-group mb-2">
                                                <!-- Email / Username -->
                                                <input type="text" name="login_id" id="login_id" value="{{ old('login_id') }}"
                                                    placeholder="Username / Email" required class="form-control">
                                                <small class="text-danger d-none" id="login_idError">Login ID is required</small>
                                                @error('login_id')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="form-group mb-2">
                                                <input required="" type="password" name="password" id="password"
                                                    placeholder="Your password *" class="form-control" />
                                                <small class="text-danger d-none" id="passwordError">Password is required</small>
                                                @error('password')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                                <!-- Forgot Password link aligned right inside the same div -->
                                                <div class="text-end mt-1">
                                                    <a href="javascript:void(0);"
                                                        onclick="$('#forgotPasswordModal').modal('show');"
                                                        style="font-size: 0.85rem; color: #3BB77E;">
                                                        Forgot Password?
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="form-group mb-0">
                                                <button type="submit" class="btn btn-heading btn-block hover-up"
                                                    name="login">Log in</button>
                                            </div>
                                        </form>

                                        <script>
                                            document.getElementById('login-form').addEventListener('submit', function (e) {
                                                let valid = true;
                                                function check(id, errorId) {
                                                    let input = document.getElementById(id);
                                                    let error = document.getElementById(errorId);
                                                    if (!input.value.trim()) {
                                                        error.classList.remove('d-none');
                                                        input.classList.add('is-invalid');
                                                        valid = false;
                                                    } else {
                                                        error.classList.add('d-none');
                                                        input.classList.remove('is-invalid');
                                                    }
                                                }
                                                check('login_id', 'login_idError');
                                                check('password', 'passwordError');
                                                if (!valid) e.preventDefault();
                                            });
                                        </script>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </main>

    <!-- Forgot Password Modal -->
    <div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0" style="border-radius: 15px; box-shadow: 0 10px 40px rgba(0,0,0,0.1);">
                <div class="modal-header border-0 pb-0" style="padding: 15px 15px 0;">
                    <h5 class="modal-title fw-bold" id="forgotPasswordModalLabel">Forgot Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3 pt-2">

                    <!-- Feedback Messages inside Modal -->
                    @if(session('message'))
                        <div class="alert alert-success d-flex align-items-center mb-3" role="alert">
                            <i class="fi-rs-check mr-10"></i> {{ session('message') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger d-flex align-items-center mb-3" role="alert">
                            <i class="fi-rs-exclamation mr-10"></i> {{ session('error') }}
                        </div>
                    @endif


                    <!-- Step 1: Send OTP -->
                    @if(!session('otp_send') && !session('otp_verified'))
                        <p class="text-muted mb-2 font-sm">Enter your email to receive a verification code.</p>
                        <form method="POST" action="{{ route('sendotp') }}" id="fp-form" novalidate>
                            @csrf
                            <div class="form-group mb-2">
                                <input type="text" name="login_id" id="fp_login_id" class="form-control" placeholder="Enter email details" required
                                    style="height: 45px; border-radius: 8px;">
                                <small class="text-danger d-none" id="fp_login_idError">Email is required</small>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-heading btn-block hover-up"
                                    style="border-radius: 8px;">Send Verification Code</button>
                            </div>
                        </form>
                        <script>
                            document.getElementById('fp-form').addEventListener('submit', function (e) {
                                let input = document.getElementById('fp_login_id');
                                let error = document.getElementById('fp_login_idError');
                                if (!input.value.trim()) {
                                    error.classList.remove('d-none');
                                    input.classList.add('is-invalid');
                                    e.preventDefault();
                                } else {
                                    error.classList.add('d-none');
                                    input.classList.remove('is-invalid');
                                }
                            });
                        </script>
                    @endif

                    <!-- Step 2: Verify OTP -->
                    @if(session('otp_send') && !session('otp_verified'))
                        <p class="text-muted mb-2 font-sm">We've sent a Code to <strong>{{ session('login_id') }}</strong>.</p>
                        <form method="POST" action="{{ route('verifyotp') }}">
                            @csrf
                            <input type="hidden" name="login_id" value="{{ session('login_id') }}">
                            <div class="form-group mb-2">
                                <input type="text" name="otp" class="form-control" placeholder="6-digit code" required
                                    style="height: 45px; border-radius: 8px; letter-spacing: 2px; text-align: center; font-size: 1.2rem;">
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-heading btn-block hover-up"
                                    style="border-radius: 8px;">Verify Code</button>
                            </div>
                            <!-- <div class="text-center mt-3">
                                <a href="{{ route('login') }}" class="text-muted font-xs">Resend Code? (Reload)</a>
                            </div> -->
                        </form>
                    @endif

                    <!-- Step 3: Reset Password -->
                    @if(session('otp_verified'))
                        <p class="text-muted mb-2 font-sm">Set a new password for your account.</p>
                        <form method="POST" action="{{ route('resetpassword') }}" onsubmit="return validateResetForm()">
                            @csrf
                            <input type="hidden" name="login_id" value="{{ session('login_id') }}">
                            <div class="form-group mb-2">
                                <input type="password" name="password" id="new_password" class="form-control" placeholder="New Password" required
                                    style="height: 45px; border-radius: 8px;">
                            </div>
                            <div class="form-group mb-2">
                                <input type="password" name="password_confirmation" id="confirm_password" class="form-control"
                                    placeholder="Confirm Password" required style="height: 45px; border-radius: 8px;">
                                <span id="password_error" class="text-danger small mt-1 d-block"></span>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-heading btn-block hover-up"
                                    style="border-radius: 8px;">Reset Password</button>
                            </div>
                        </form>
                        <script>
                            function validateResetForm() {
                                var p1 = document.getElementById("new_password").value;
                                var p2 = document.getElementById("confirm_password").value;
                                var errorSpan = document.getElementById("password_error");

                                if (p1.length < 6) {
                                    errorSpan.textContent = "Password must be at least 6 characters.";
                                    return false;
                                }

                                if (p1 !== p2) {
                                    errorSpan.textContent = "Passwords do not match!";
                                    return false;
                                }
                                
                                errorSpan.textContent = "";
                                return true;
                            }
                        </script>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <!-- Auto-open Logic -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if(session('otp_send') || session('otp_verified') || session('error'))
                var myModal = new bootstrap.Modal(document.getElementById('forgotPasswordModal'));
                myModal.show();
            @endif
            });
    </script>
@endsection
