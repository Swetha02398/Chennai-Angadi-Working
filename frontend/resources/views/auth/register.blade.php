 @extends('layouts.app')
 @section('content') 
 @include('includes.alert')  
    <main class="main pages">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="index.html" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                    <span></span> Pages <span></span> My Account
                </div>
            </div>
        </div>
        <div class="page-content pt-150 pb-150">
            <div class="container">
                <div class="row">
                    <div class="col-xl-8 col-lg-10 col-md-12 m-auto">
                        <div class="row">
                            <div class="col-lg-6 col-md-8">
                                <div class="login_wrap widget-taber-content background-white">
                                    <div class="p-4 bg-white">
                                        <div class="heading_s1">
                                            <h1 class="mb-2">Create an Account</h1>
                                            <p class="mb-10">Already have an account? <a href=" {{ route('login') }}">Login</a></p>
                                        </div>
                                        <form method="POST" action="{{ route('store') }}" id="register-form" novalidate>
    @csrf

    <!-- Username -->
    <div class="form-group mb-2">
        <input type="text" name="username" id="username" placeholder="Username" value="{{ old('username') }}" class="form-control @error('username') is-invalid @enderror" required />
        <small class="text-danger d-none" id="usernameError">Username is required</small>
        @error('username')
            <small class="text-danger font-sm">{{ $message }}</small>
        @enderror
    </div>

    <!-- Email -->
    <div class="form-group mb-2">
        <input type="email" name="email" id="email" placeholder="Email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required />
        <small class="text-danger d-none" id="emailError">Email is required</small>
        @error('email')
            <small class="text-danger font-sm">{{ $message }}</small>
        @enderror
    </div>

    <!-- Password -->
    <div class="form-group mb-2">
        <input type="password" name="password" id="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror" required />
        <small class="text-danger d-none" id="passwordError">Password is required</small>
        @error('password')
            <small class="text-danger font-sm">{{ $message }}</small>
        @enderror
    </div>

    <!-- Confirm Password -->
    <div class="form-group mb-2">
        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password" class="form-control @error('password_confirmation') is-invalid @enderror" required />
        <small class="text-danger d-none" id="password_confirmationError">Confirmation is required</small>
        @error('password_confirmation')
            <small class="text-danger font-sm">{{ $message }}</small>
        @enderror
    </div>

    <!-- Mobile -->
    <div class="form-group mb-2">
        <input type="tel" name="mobilenumber" id="mobilenumber" placeholder="Mobile Number" value="{{ old('mobilenumber') }}" class="form-control @error('mobilenumber') is-invalid @enderror" required maxlength="10" oninput="this.value=this.value.replace(/[^0-9]/g,'')" />
        <small class="text-danger d-none" id="mobilenumberError">Mobile number must be 10 digits</small>
        @error('mobilenumber')
            <small class="text-danger font-sm">{{ $message }}</small>
        @enderror
    </div>

    <!-- Terms -->
    <div class="login_footer form-group mb-20">
        <div class="chek-form">
            <div class="custome-checkbox">
                <input class="form-check-input" type="checkbox" name="agree" id="agree" required />
                <label class="form-check-label" for="agree">
                    <span>I agree to terms & <a href="#">Policy.</a></span>
                </label>
            </div>
        </div>
        <small class="text-danger d-none" id="agreeError">You must agree to the terms</small>
        @error('agree')
            <small class="text-danger font-sm">{{ $message }}</small>
        @enderror
    </div>

    <!-- Submit -->
    <div class="form-group mb-20">
        <button type="submit" class="btn btn-fill-out btn-block hover-up font-weight-bold">
             Register
        </button>
    </div>
</form>

<script>
    document.getElementById('register-form').addEventListener('submit', function (e) {
        let valid = true;
        
        function check(id, errorId, condition) {
            let input = document.getElementById(id);
            let error = document.getElementById(errorId);
            if (!input) return;
            
            let isInvalid = false;
            if (id === 'agree') {
                isInvalid = !input.checked;
            } else if (condition !== undefined) {
                isInvalid = condition;
            } else {
                isInvalid = !input.value.trim();
            }

            if (isInvalid) {
                error.classList.remove('d-none');
                input.classList.add('is-invalid');
                valid = false;
            } else {
                error.classList.add('d-none');
                input.classList.remove('is-invalid');
            }
        }

        check('username', 'usernameError');
        check('email', 'emailError');
        check('password', 'passwordError');
        check('password_confirmation', 'password_confirmationError', document.getElementById('password_confirmation').value !== document.getElementById('password').value);
        check('mobilenumber', 'mobilenumberError', document.getElementById('mobilenumber').value.length !== 10);
        check('agree', 'agreeError');

        if (!valid) {
            e.preventDefault();
        }
    });
</script>


                                    </div>
                                </div>
                            </div>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
