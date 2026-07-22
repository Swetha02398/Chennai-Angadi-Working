@extends('layouts.app')

@section('content')
<section class="content-main">

    <div class="content-header">
        <h2 class="content-title">Edit Customer Profile</h2>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            @push('scripts')
                <script>
                    @if(session('success'))
                        toastr.success("{{ session('success') }}");
                    @endif
                    @if(session('error'))
                        toastr.error("{{ session('error') }}");
                    @endif
                </script>
            @endpush

            <form action="{{ route('customer.update', $customer->id ?? 0) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-lg-9">
                        <div class="row gx-3">
                            <div class="col-12 mb-3">
                                <h5 class="mb-2">Customer Information</h5>
                                <hr>
                            </div>

                            <div class="col-sm-6 mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" class="form-control" name="username" value="{{ old('username', $customer->username ?? '') }}" required>
                            </div>

                            <div class="col-sm-6 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" value="{{ old('email', $customer->email ?? '') }}" required>
                            </div>

                            <div class="col-sm-6 mb-3">
                                <label class="form-label">Mobile Number</label>
                                <input type="text" class="form-control" name="mobilenumber" value="{{ old('mobilenumber', $customer->mobilenumber ?? '') }}" required>
                            </div>

                            <div class="col-sm-6 mb-3">
                                <label class="form-label">Gender</label>
                                <select class="form-select" name="gender">
                                    <option value="">Select Gender</option>
                                    <option value="Male" {{ (old('gender', $customer->gender ?? '') == 'Male') ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ (old('gender', $customer->gender ?? '') == 'Female') ? 'selected' : '' }}>Female</option>
                                    <option value="Other" {{ (old('gender', $customer->gender ?? '') == 'Other') ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>

                            <div class="col-sm-6 mb-3">
                                <label class="form-label">Date of Birth</label>
                                <input type="date" class="form-control" name="dob" value="{{ old('dob', $customer->dob ?? '') }}">
                            </div>
                            
                            <div class="col-sm-6 mb-3">
                                <label class="form-label">Address</label>
                                <textarea class="form-control" name="address" rows="2">{{ old('address', $customer->address ?? '') }}</textarea>
                            </div>

                            <div class="col-sm-6 mb-3">
                                <label class="form-label">City</label>
                                <input type="text" class="form-control" name="city" value="{{ old('city', $customer->city ?? '') }}">
                            </div>

                            <div class="col-sm-6 mb-3">
                                <label class="form-label">State</label>
                                <input type="text" class="form-control" name="state" value="{{ old('state', $customer->state ?? '') }}">
                            </div>

                            <div class="col-sm-6 mb-3">
                                <label class="form-label">Country</label>
                                <input type="text" class="form-control" name="country" value="{{ old('country', $customer->country ?? 'India') }}">
                            </div>

                            <div class="col-sm-6 mb-3">
                                <label class="form-label">Pin Code</label>
                                <input type="text" class="form-control" name="pin" value="{{ old('pin', $customer->pin ?? '') }}">
                            </div>

                        </div>
                    </div>

                    <!-- RIGHT SIDE IMAGE UPLOAD -->
                    <div class="col-lg-3 text-center">
                        <label class="form-label mb-2 d-block text-start">Profile Image</label>
                        <div class="mb-3">
                            @if(!empty($customer->profile_image) && file_exists(public_path('uploads/profile/' . $customer->profile_image)))
                                <img src="{{ asset('uploads/profile/' . $customer->profile_image) }}" id="profilePreview" width="150" height="150" class="rounded-circle mb-3" style="object-fit:cover;border:3px solid #ddd;" alt="Customer Profile">
                            @else
                                <img src="{{ asset('assets/imgs/people/avatar.jpg') }}" id="profilePreview" width="150" height="150" class="rounded-circle mb-3" style="object-fit:cover;border:3px solid #ddd;" alt="No Profile Image">
                            @endif
                        </div>
                        <input type="file" class="form-control" name="profile_image" accept="image/*" onchange="previewImage(event)">
                        <small class="text-muted d-block mt-2">Recommended size: 300x300px</small>
                    </div>

                </div>
                
                <hr>
                
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> Update</button>
                    <a href="{{ route('customer') }}" class="btn btn-secondary ms-2"><i class="bi bi-arrow-left-circle me-1"></i> Cancel</a>
                </div>
            </form>
        </div>
    </div>

</section>

@push('scripts')
<script>
function previewImage(event) {
    var reader = new FileReader();
    reader.onload = function(){
        var output = document.getElementById('profilePreview');
        output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
}
</script>
@endpush
@endsection
