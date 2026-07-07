@extends('layouts.auth')

@section('content')
@include('includes.alert')
<section class="content-main">
    <div class="card mx-auto card-login">
        <div class="card-body">
            <h4 class="card-title mb-4 text-center">Verify OTP</h4>
            <p class="text-muted text-center mb-4">Please enter the 6-digit OTP sent to <strong>{{ $email }}</strong></p>
            <form method="POST" action="{{ route('password.verify.otp') }}">
                @csrf
                <input type="hidden" name="email" value="{{ $email }}">
                <div class="mb-3">
                    <input name="otp" class="form-control text-center" placeholder="Enter 6-digit OTP" type="text" maxlength="6" required style="letter-spacing: 5px; font-size: 1.2rem;" />
                    @error('otp')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-4">
                    <button type="submit" class="btn btn-primary w-100">Verify OTP</button>
                </div>
                <div class="text-center">
                    <p class="mb-0"><a href="{{ route('password.request') }}">Resend OTP</a></p>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
