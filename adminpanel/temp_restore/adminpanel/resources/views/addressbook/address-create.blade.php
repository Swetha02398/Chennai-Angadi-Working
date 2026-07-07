@extends('layouts.app')

@section('content')
<section class="content-main">
    <div class="content-header">
        <h2 class="content-title">Add Address</h2>
    </div>

    <div class="card">
        <div class="card-body">
            <form id="addressForm" action="{{ route('addressbook.store') }}" method="POST" novalidate>
                @csrf
                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label id="customerLabel">Customer *</label>
                        <select name="customer_id" class="form-control">
                            <option value="">Select Customer</option>
                            @foreach($customers as $c)
                                <option value="{{ $c->id }}">{{ $c->username }}</option>
                            @endforeach
                        </select>
                        <small id="customerError" class="text-danger d-none">Customer is required.</small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Customer Type</label>
                        <select name="customer_type" class="form-control">
                            <option value="1" selected>Customer</option>
                            <option value="0">Other</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control" placeholder="Home / Office">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label id="phoneLabel">Phone *</label>
                        <input type="text" name="phone" class="form-control">
                        <small id="phoneError" class="text-danger d-none">Phone is required.</small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Landmark</label>
                        <input type="text" name="landmark" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label id="cityLabel">City *</label>
                        <input type="text" name="city" class="form-control">
                        <small id="cityError" class="text-danger d-none">City is required.</small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label id="stateLabel">State *</label>
                        <input type="text" name="state" class="form-control">
                        <small id="stateError" class="text-danger d-none">State is required.</small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label id="pincodeLabel">Pincode *</label>
                        <input type="text" name="pincode" class="form-control">
                        <small id="pincodeError" class="text-danger d-none">Pincode is required.</small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label id="countryLabel">Country *</label>
                        <input type="text" name="country" class="form-control">
                        <small id="countryError" class="text-danger d-none">Country is required.</small>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Latitude</label>
                        <input type="text" name="latitude" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Longitude</label>
                        <input type="text" name="longitude" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Default Address</label>
                        <select name="is_default" class="form-control">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label id="addressLabel">Address *</label>
                        <textarea name="address" class="form-control" rows="3"></textarea>
                        <small id="addressError" class="text-danger d-none">Address is required.</small>
                    </div>

                </div>

                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ route('addressbook.table') }}" class="btn btn-secondary">Cancel</a>
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

    // Only these 7 fields validated
    validateField('customer_id', 'customerError');
    validateField('phone', 'phoneError');
    validateField('address', 'addressError');
    validateField('city', 'cityError');
    validateField('state', 'stateError');
    validateField('pincode', 'pincodeError');
    validateField('country', 'countryError');

     // Latitude / Longitude validation (added)
    const latEl = document.querySelector('[name="latitude"]');
    const lonEl = document.querySelector('[name="longitude"]');

    // Decimal(10,7) regex
    const decimalRegex = /^-?\d{1,3}(\.\d{1,7})?$/; // max 3 digits before dot, up to 7 after

    if (latEl.value.trim() && !decimalRegex.test(latEl.value.trim())) {
        alert('Latitude must be a number with up to 7 decimal places.');
        valid = false;
    }

    if (lonEl.value.trim() && !decimalRegex.test(lonEl.value.trim())) {
        alert('Longitude must be a number with up to 7 decimal places.');
        valid = false;
    }

    if (!valid) e.preventDefault();
});
</script>

@endsection
