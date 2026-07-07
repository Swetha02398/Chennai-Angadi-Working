@extends('layouts.app')

@section('content')
<section class="content-main">

    <div class="content-header">
        <h2 class="content-title">Profile View</h2>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <div class="col-lg-9">
              <div class="row">
                <div class="col-lg-8">
                 <div class="row gx-3">

                <!-- RIGHT SIDE DETAILS -->
                

                     <div class="nav-link active">
                        <h5 class="mb-3">Customer Information</h5>
                     </div>


                    <div class="col-6 mb-3">
                        <label class="text-muted">Username</label>
                        <p class="fw-bold">{{ $customer->username ?? '--' }}</p>
                    </div>

                    <div class="col-6 mb-3">
                        <label class="text-muted">Email</label>
                        <p class="fw-bold">{{ $customer->email ?? '--' }}</p>
                    </div>

                    <div class="col-6 mb-3">
                        <label class="text-muted">Mobile Number</label>
                        <p class="fw-bold">{{ $customer->mobilenumber ?? '--' }}</p>
                    </div>

                    <div class="col-6 mb-3">
                        <label class="text-muted">Address</label>
                        <p class="fw-bold">{{ $customer->address ?? '--' }}</p>
                    </div>

                    <div class="col-6 mb-3">
                        <label class="text-muted">Pin Code</label>
                        <p class="fw-bold">{{ $customer->pin ?? '--' }}</p>
                    </div>

                    <div class="col-6 mb-3">
                        <label class="text-muted">Gender</label>
                        <p class="fw-bold">{{ $customer->gender ?? 'Not Provided' }}</p>
                    </div>

                    <div class="col-6 mb-3">
                        <label class="text-muted">Date of Birth</label>
                        <p class="fw-bold">{{ $customer->dob ?? 'Not Provided' }}</p>
                    </div>

                    <div class="col-6 mb-3">
                        <label class="text-muted">City</label>
                        <p class="fw-bold">{{ $customer->city ?? '--' }}</p>
                    </div>

                    <div class="col-6 mb-3">
                        <label class="text-muted">State</label>
                        <p class="fw-bold">{{ $customer->state ?? '--' }}</p>
                    </div>

                    <div class="col-6 mb-3">
                        <label class="text-muted">Country</label>
                        <p class="fw-bold">{{ $customer->country ?? '--' }}</p>
                    </div>

                   
                
                </div>
              </div>

                <!-- RIGHT SIDE IMAGE -->
                 <div class="col-md-3 text-center">
                   @if($customer->profile_image)
                   <img src="{{ env('ADMIN_ASSET_URL') }}/profile/{{ $customer->profile_image }}"
               width="150" height="150" class="rounded-circle" style="object-fit:cover;border:3px solid #ddd;" alt="Customer Profile">
                   @else
                   <img src="{{ asset('assets/imgs/people/avatar.jpg') }}"
               width="150" height="150" class="rounded-circle" style="object-fit:cover;border:3px solid #ddd;" alt="No Profile Image">
                   @endif

                    <p class="fw-bold mt-2">{{ $customer->username }}</p>
                </div>

            </div>
 <a href="{{ route('customer') }}" class="btn btn-primary">Back</a>
        </div>
        </div>
    </div>

</section>
@endsection
