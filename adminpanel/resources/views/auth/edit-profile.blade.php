@extends('layouts.auth')
@section('content')
@include('includes.alert')
<section class="content-main mt-80 mb-80">
    <div class="card mx-auto card-login">
        <div class="card-body">
            @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <h4 class="card-title mb-4">Edit Profile</h4>
            <form id="profileForm" method="POST" action="{{ route('update-profile') }}" enctype="multipart/form-data" novalidate>
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input class="form-control" name="name" id="profileName" value="{{ $user->name }}" placeholder="Your name" type="text" required />
                    <div class="invalid-feedback" id="nameError">Please enter your name.</div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" id="profileUsername" value="{{ $user->username }}" class="form-control" placeholder="Choose a username" required>
                    <div class="invalid-feedback" id="usernameError">Please choose a username.</div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" id="profileEmail" value="{{ $user->email }}" class="form-control" placeholder="Enter your email" readonly style="background-color: #e9ecef;" required>
                    <div class="invalid-feedback" id="emailError">Please enter a valid email address.</div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Phone Number</label>
                    <input type="text" name="phone" id="profilePhone" value="{{ $user->phone }}" class="form-control" placeholder="Enter your phone number" readonly style="background-color: #e9ecef;" required>
                    <div class="invalid-feedback" id="phoneError">Please enter your phone number.</div>
                </div>


                <div class="mb-3">
                    <label class="form-label">Role</label>
                    <input type="text" class="form-control" disabled
                        value="{{ $user->isSuperAdmin() ? 'Super Admin' : ($user->role ? $user->role->name : 'Admin') }}">
                    <small class="text-muted">Role changes are managed via Admin & Roles section.</small>
                </div>

                <div class="mb-3">
                    <label class="form-label">Profile Image</label>
                    <input type="file" name="profile_image" class="form-control">
                    @if($user->profile_image)
                        <img src="{{ asset('assets/uploads/admin_profiles/'.$user->profile_image) }}" class="mt-2" width="100" alt="Profile Image">
                    @endif
                </div>

                <div class="mb-4 ">
                    <button type="submit" class="btn btn-primary   text-center">Update Profile</button>
                   <a href="{{ route('index') }}" class="btn btn-secondary text-center"> Back</a>
                </div>
            </form>
            <script>
                document.getElementById('profileForm').addEventListener('submit', function(e) {
                    let valid = true;
                    const fields = ['profileName', 'profileUsername', 'profileEmail', 'profilePhone'];
                    fields.forEach(id => {
                        const input = document.getElementById(id);
                        if (!input.value.trim()) {
                            input.classList.add('is-invalid');
                            valid = false;
                        } else {
                            input.classList.remove('is-invalid');
                        }
                    });

                    if (!valid) e.preventDefault();
                });
            </script>
        </div>
    </div>
</section>
@endsection
