@extends('layouts.app')

@section('content')
<section class="content-main">
    <div class="content-header d-flex justify-content-between align-items-center">
        <h2 class="content-title">Edit Address</h2>
        <!-- <a href="{{ route('addressbook.table') }}" class="btn btn-secondary"><i class="bi bi-x-circle me-1"></i> Cancel</a> -->
    </div>

    <div class="card mt-3">
        <div class="card-body">
            <form id="addressForm" action="{{ route('addressbook.update', $address->id) }}" method="POST" novalidate>
                @csrf
                @method('PUT')
                <div class="row">
                    <!-- Customer -->
                    <div class="col-md-6 mb-3">
                        <label id="customerLabel">Customer *</label>
                        <select name="customer_id" class="form-control @error('customer_id') is-invalid @enderror">
                            @foreach($customers as $c)
                                <option value="{{ $c->id }}" {{ $c->id == old('customer_id', $address->customer_id) ? 'selected' : '' }}>
                                    {{ $c->username }}
                                </option>
                            @endforeach
                        </select>
                        <small id="customerError" class="text-danger d-none">Customer is required.</small>
                    </div>

                    <!-- Customer Type -->
                    <div class="col-md-6 mb-3">
                        <label>Customer Type</label>
                        <select name="customer_type" class="form-control">
                            <option value="1" {{ old('customer_type', $address->customer_type) == 1 ? 'selected' : '' }}>Customer</option>
                            <option value="0" {{ old('customer_type', $address->customer_type) == 0 ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>

                    <!-- Title -->
                    <div class="col-md-6 mb-3">
                        <label>Title</label>
                        <input type="text" name="title" value="{{ old('title', $address->title) }}" class="form-control" placeholder="Home / Office">
                    </div>

                    <!-- Phone -->
                    <div class="col-md-6 mb-3">
                        <label id="phoneLabel">Phone *</label>
                        <input type="text" name="phone" value="{{ old('phone', $address->phone) }}" class="form-control @error('phone') is-invalid @enderror">
                        <small id="phoneError" class="text-danger d-none">Phone is required.</small>
                    </div>

                    <!-- Landmark -->
                    <div class="col-md-6 mb-3">
                        <label>Landmark</label>
                        <input type="text" name="landmark" value="{{ old('landmark', $address->landmark) }}" class="form-control">
                    </div>

                    <!-- City -->
                    <div class="col-md-6 mb-3">
                        <label id="cityLabel">City *</label>
                        <input type="text" name="city" value="{{ old('city', $address->city) }}" class="form-control @error('city') is-invalid @enderror">
                        <small id="cityError" class="text-danger d-none">City is required.</small>
                    </div>

                    <!-- State -->
                    <div class="col-md-6 mb-3">
                        <label id="stateLabel">State *</label>
                        <input type="text" name="state" value="{{ old('state', $address->state) }}" class="form-control @error('state') is-invalid @enderror">
                        <small id="stateError" class="text-danger d-none">State is required.</small>
                    </div>

                    <!-- Pincode -->
                    <div class="col-md-6 mb-3">
                        <label id="pincodeLabel">Pincode *</label>
                        <input type="text" name="pincode" value="{{ old('pincode', $address->pincode) }}" class="form-control @error('pincode') is-invalid @enderror">
                        <small id="pincodeError" class="text-danger d-none">Pincode is required.</small>
                    </div>

                    <!-- Country -->
                    <div class="col-md-6 mb-3">
                        <label id="countryLabel">Country *</label>
                        <input type="text" name="country" value="{{ old('country', $address->country) }}" class="form-control @error('country') is-invalid @enderror">
                        <small id="countryError" class="text-danger d-none">Country is required.</small>
                    </div>

                    <!-- Latitude -->
                    <div class="col-md-6 mb-3">
                        <label>Latitude</label>
                        <input type="text" name="latitude" value="{{ old('latitude', $address->latitude) }}" class="form-control">
                    </div>

                    <!-- Longitude -->
                    <div class="col-md-6 mb-3">
                        <label>Longitude</label>
                        <input type="text" name="longitude" value="{{ old('longitude', $address->longitude) }}" class="form-control">
                    </div>

                    <!-- Default -->
                    <div class="col-md-6 mb-3">
                        <label>Default Address</label>
                        <select name="is_default" class="form-control">
                            <option value="0" {{ old('is_default', $address->is_default) == 0 ? 'selected' : '' }}>No</option>
                            <option value="1" {{ old('is_default', $address->is_default) == 1 ? 'selected' : '' }}>Yes</option>
                        </select>
                    </div>
                    
                     <!-- Address -->
                    <div class="col-md-12 mb-3">
                        <label id="addressLabel">Address *</label>
                        <textarea name="address" class="form-control @error('address') is-invalid @enderror" rows="3">{{ old('address', $address->address) }}</textarea>
                        <small id="addressError" class="text-danger d-none">Address is required.</small>
                    </div>
                    
                </div>

                <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> Update</button>
                <a href="{{ route('addressbook.table') }}" class="btn btn-secondary"><i class="bi bi-x-circle me-1"></i> Cancel</a>
            </form>
        </div>
    </div>
</section>

<script>
document.getElementById('addressForm').addEventListener('submit', function(e) {
    let valid = true;

    function validateField(name, errorId) {
        const el = document.querySelector(`[name="${name}"]`);
        if (!el.value.trim()) {
            document.getElementById(errorId).classList.remove('d-none');
            el.classList.add('is-invalid');
            valid = false;
        } else {
            document.getElementById(errorId).classList.add('d-none');
            el.classList.remove('is-invalid');
        }
    }

    validateField('customer_id', 'customerError');
    validateField('phone', 'phoneError');
    validateField('address', 'addressError');
    validateField('city', 'cityError');
    validateField('state', 'stateError');
    validateField('pincode', 'pincodeError');
    validateField('country', 'countryError');

    if (!valid) e.preventDefault();
});
</script>
@endsection
