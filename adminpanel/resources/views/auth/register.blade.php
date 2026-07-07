@extends('layouts.auth')
@section('content')
@include('includes.alert')
            <section class="content-main mt-80 mb-80">
                <div class="card mx-auto card-login">
                    <div class="card-body">
                          <!-- Validation errors -->
                    @if($errors->any())
                     <div class="alert alert-danger">
                        <ul class="mb-0">
                          @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                          @endforeach
                        </ul>
                     </div>
                    @endif
                        <h4 class="card-title mb-4">Create an Account</h4>
                        <form method="POST" action="{{ route('register') }}"  enctype="multipart/form-data" class="needs-validation" novalidate>
                           @csrf

                            <div class="mb-3">
                                 <label class="form-label">Name</label>
                                 <input class="form-control" name="name"  value="{{ old('name') }}" placeholder="Your name" type="text" required />
                                  <div class="invalid-feedback">
                                     Please enter your name.
                                 </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" name="username" value="{{ old('username') }}" class="form-control" placeholder="Choose a username" required>
                                <div class="invalid-feedback">
                                    Please choose a username.
                                </div>
                            </div>

                            <div class="mb-3">
                                  <label class="form-label">Email Address</label>
                                  <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Enter your email" required>
                                  <div class="invalid-feedback">
                                      Please enter a valid email address.
                                  </div>
                            </div>

                           <div class="mb-3">
                                   <label class="form-label">Phone Number</label>
                                   <input type="text" name="phone" value="{{ old('phone') }}" class="form-control" placeholder="Enter your phone number" required>
                                   <div class="invalid-feedback">
                                       Please enter your phone number.
                                   </div>
                           </div>

                           <div class="mb-3">
                                   <label class="form-label">Password</label>
                                   <input type="password" name="password" class="form-control" placeholder="Enter password" required>
                                   <div class="invalid-feedback">
                                       Please enter a password.
                                   </div>
                            </div>

                            <div class="mb-3">
                                    <label class="form-label">Confirm Password</label>
                                    <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm password" required>
                                    <div class="invalid-feedback">
                                        Please confirm your password.
                                    </div>
                            </div>

                         <div class="mb-3">
                             <label class="form-label">Role Type</label>
                             <select name="role_type" class="form-control" required>
                                <option value="">-- Select Role Type --</option>
                                <option value="admin" {{ old('role_type') == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="superadmin" {{ old('role_type') == 'superadmin' ? 'selected' : '' }}>Super Admin</option>
                             </select>
                         </div>

                         <div class="mb-3">
                             <label class="form-label">Assign Role (Optional)</label>
                             <select name="role_id" class="form-control">
                                <option value="">-- No Role --</option>
                                @php $roles = \App\Models\Role::all(); @endphp
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                                @endforeach
                             </select>
                         </div>

                        <div class="mb-3">
                           <label class="form-label">Profile Image</label>
                           <input type="file" name="profile_image" class="form-control">
                              <div class="invalid-feedback">
                                 Please upload a profile image.
                              </div>
                        </div>
                            <!-- form-group// -->
                            <div class="mb-3">
                                <p class="small text-center text-muted">By signing up, you confirm that you’ve read and accepted our User Notice and Privacy Policy.</p>
                            </div>
                            <!-- form-group  .// -->
                            <div class="mb-4">
                                <button type="submit" class="btn btn-primary w-100">Register</button>
                            </div>
                            <!-- form-group// -->
                        </form>
                        <p class="text-center mb-2">Already have an account? <a href="{{ route('login') }}">Sign in now</a></p>
                    </div>
                </div>
            </section>
            @section('scripts')
       @endsection