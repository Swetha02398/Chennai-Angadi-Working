@extends('layouts.app')
@section('content')
@include('includes.alert')

<section class="content-main">
    <h2 class="content-title mb-4">{{ isset($offer) ? 'Edit Offer' : 'Add Offer' }}</h2>

    {{-- Laravel backend errors --}}


    <div class="card p-4">
        <form class="offerForm"
            action="{{ isset($offer) ? route('offer.update', $offer->id) : route('offer.store') }}"
            method="POST"
            enctype="multipart/form-data" novalidate>
            @csrf

            <div class="row g-3">
                <!-- Title -->
                <div class="col-md-6">
                    <label class="form-label">Title <span class="text-danger"></span></label>
                    <input type="text" name="title" id="title" class="form-control"
                           value="{{ old('title', $offer->title ?? '') }}">
                    @error('title') <small class="text-danger">{{ $message }}</small> @enderror
                    <small id="titleError" class="text-danger d-none">Title is required.</small>
                </div>

                <!-- Discount Type -->
                <div class="col-md-6">
                    <label class="form-label">Discount Type <span class="text-danger"></span></label>
                    <select name="discount_type" id="discount_type" class="form-select">
                        <option value="">Select Type</option>
                        <option value="percentage" 
                            {{ old('discount_type', $offer->discount_type ?? '') == 'percentage' ? 'selected' : '' }}>Percentage</option>
                        <option value="fixed" 
                            {{ old('discount_type', $offer->discount_type ?? '') == 'fixed' ? 'selected' : '' }}>Fixed</option>
                    </select>
                    @error('discount_type') <small class="text-danger">{{ $message }}</small> @enderror
                    <small id="discountTypeError" class="text-danger d-none">Discount type is required.</small>
                </div>

                <!-- Discount Value -->
                <div class="col-md-6">
                    <label class="form-label">Discount Value <span class="text-danger"></span></label>
                    <input type="number" step="0.01" name="discount_value" id="discount_value" class="form-control"
                           value="{{ old('discount_value', $offer->discount_value ?? '') }}">
                    @error('discount_value') <small class="text-danger">{{ $message }}</small> @enderror
                    <small id="discountValueError" class="text-danger d-none">Discount value is required.</small>
                </div>

                <!-- Priority -->
                <div class="col-md-6">
                    <label class="form-label">Priority <span class="text-danger"></span></label>
                    <input type="number" name="priority" id="priority" class="form-control"
                           value="{{ old('priority', $offer->priority ?? 0) }}">
                    @error('priority') <small class="text-danger">{{ $message }}</small> @enderror
                    <small id="priorityError" class="text-danger d-none">Priority is required.</small>
                </div>

                <!-- Start Date -->
                <div class="col-md-6">
                    <label class="form-label">Start Date <span class="text-danger"></span></label>
                    <input type="date" name="start_date" id="start_date" class="form-control"
                           value="{{ old('start_date', $offer->start_date ?? '') }}">
                    @error('start_date') <small class="text-danger">{{ $message }}</small> @enderror
                    <small id="startDateError" class="text-danger d-none">Start date is required.</small>
                </div>

                <!-- End Date -->
                <div class="col-md-6">
                    <label class="form-label">End Date <span class="text-danger"></span></label>
                    <input type="date" name="end_date" id="end_date" class="form-control"
                           value="{{ old('end_date', $offer->end_date ?? '') }}">
                    @error('end_date') <small class="text-danger">{{ $message }}</small> @enderror
                    <small id="endDateError" class="text-danger d-none">End date is required.</small>
                </div>

                <!-- Banner Image -->
                <div class="col-md-6">
                    <label class="form-label">Banner Image <span class="text-danger"></span></label>
                    <input type="file" name="banner_image" id="banner_image" class="form-control" accept="image/*" 
                           {{ isset($offer) ? '' : 'required' }}>
                    @error('banner_image') <small class="text-danger">{{ $message }}</small> @enderror
                    @if(isset($offer) && $offer->banner_image)
                        <img src="{{ asset('uploads/offers/'.$offer->banner_image) }}" 
                             alt="Banner" width="150" class="mt-2 rounded">
                    @endif
                    <small id="bannerError" class="text-danger d-none">Banner image is required.</small>
                </div>

                <!-- Product Multi Select -->
                <!-- <div class="col-md-6">
                    <label class="form-label">Products <span class="text-danger">*</span></label>
                    <select name="product_ids[]" class="form-control" multiple>
                   @foreach($products as $product)
                      <option value="{{ $product->id }}"
                              {{ isset($productIds) && in_array($product->id, $productIds) ? 'selected' : '' }}>
                          {{ $product->productname }}
                        </option>
                        @endforeach
                         </select>
                    <small id="productError" class="text-danger d-none">Select at least one product.</small>
                </div> -->
                <!-- Users Multi-Select -->
    <div class="col-md-6">
    <label class="form-label">Select Products <span class="text-danger"></span></label>
    <select name="product_ids[]" id="productSelect" class="form-control" multiple required size="8" style="min-height: 180px;">
        @php
            // safely convert to array (works for both string & array)
            if (isset($offer)) {
                $productData = $offer->product_ids;
                if (is_string($productData)) {
                    $selectedProducts = json_decode($productData, true) ?? [];
                } elseif (is_array($productData)) {
                    $selectedProducts = $productData;
                } else {
                    $selectedProducts = [];
                }
            } else {
                $selectedProducts = [];
            }

            // merge old input if validation fails
            $selectedProducts = old('product_ids', $selectedProducts);
        @endphp

        @foreach($products as $product)
            <option value="{{ $product->id }}"
                {{ in_array($product->id, $selectedProducts ?? []) ? 'selected' : '' }}>
                {{ $product->productname }}
            </option>
        @endforeach
    </select>
    @error('product_ids') <small class="text-danger">{{ $message }}</small> @enderror
    @error('product_ids.*') <small class="text-danger">{{ $message }}</small> @enderror
    <small id="productError" class="text-danger d-none">Select at least one product.</small>
</div>




                <!-- Description -->
                <div class="col-md-12">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description', $offer->description ?? '') }}</textarea>
                </div>

                <!-- Buttons -->
                <div class="col-md-12 mt-4">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> {{ isset($offer) ? 'Update Offer' : 'Save Offer' }}</button>
                    <a href="{{ route('offer.table') }}" class="btn btn-secondary"><i class="bi bi-x-circle me-1"></i> Cancel</a>
                </div>
            </div>
        </form>
    </div>
</section>

<script>
document.querySelector('.offerForm').addEventListener('submit', function(e) {
    e.preventDefault();
    let valid = true;
    const fields = [
        { id: 'title', errorId: 'titleError', defaultMsg: 'Title is required.' },
        { id: 'discount_type', errorId: 'discountTypeError', defaultMsg: 'Discount type is required.' },
        { id: 'discount_value', errorId: 'discountValueError', defaultMsg: 'Discount value is required.' },
        { id: 'priority', errorId: 'priorityError', defaultMsg: 'Priority is required.' },
        { id: 'start_date', errorId: 'startDateError', defaultMsg: 'Start date is required.' },
        { id: 'end_date', errorId: 'endDateError', defaultMsg: 'End date is required.' }
    ];

    fields.forEach(field => {
        const input = document.getElementById(field.id);
        const error = document.getElementById(field.errorId);
        if (input && !input.value.trim()) {
            input.classList.add('is-invalid');
            input.classList.remove('is-valid');
            error.textContent = field.defaultMsg;
            error.classList.remove('d-none');
            valid = false;
        } else if (input) {
            input.classList.remove('is-invalid');
            input.classList.add('is-valid');
            error.classList.add('d-none');
        }
    });

    const productSelect = document.getElementById('productSelect');
    const productError = document.getElementById('productError') || { classList: { add: () => {}, remove: () => {} } }; // Fallback
    if (productSelect && productSelect.selectedOptions.length === 0) {
        productSelect.classList.add('is-invalid');
        productSelect.classList.remove('is-valid');
        if (document.getElementById('productError')) document.getElementById('productError').classList.remove('d-none');
        valid = false;
    } else if (productSelect) {
        productSelect.classList.remove('is-invalid');
        productSelect.classList.add('is-valid');
        if (document.getElementById('productError')) document.getElementById('productError').classList.add('d-none');
    }

    const bannerInput = document.getElementById('banner_image');
    @if(!isset($offer))
        if (bannerInput && bannerInput.files.length === 0) {
            document.getElementById("bannerError").classList.remove("d-none");
            bannerInput.classList.add("is-invalid");
            bannerInput.classList.remove("is-valid");
            valid = false;
        } else if (bannerInput) {
            document.getElementById("bannerError").classList.add("d-none");
            bannerInput.classList.remove("is-invalid");
            bannerInput.classList.add("is-valid");
        }
    @endif

    if (!valid) {
        window.scrollTo({ top: 0, behavior: "smooth" });
        return false;
    }

    // AJAX priority uniqueness check
    const priorityInput = document.getElementById('priority');
    const priorityValue = priorityInput.value.trim();
    const offerId = "{{ $offer->id ?? '' }}";

    $.ajax({
        url: "{{ route('offer.check-priority') }}",
        method: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            priority: priorityValue,
            id: offerId
        },
        success: function(response) {
            if (response.unique) {
                // Submit form programmatically (bypassing the event listener)
                document.querySelector('.offerForm').submit();
            } else {
                const priorityError = document.getElementById('priorityError');
                priorityInput.classList.add('is-invalid');
                priorityInput.classList.remove('is-valid');
                priorityError.textContent = 'Priority has already been taken.';
                priorityError.classList.remove('d-none');
                window.scrollTo({ top: 0, behavior: "smooth" });
            }
        },
        error: function() {
            // Fallback to regular submit if check fails
            document.querySelector('.offerForm').submit();
        }
    });
});

// Clear errors and valid status as user types/changes
const allFieldIds = ['title', 'discount_type', 'discount_value', 'priority', 'start_date', 'end_date', 'banner_image', 'productSelect'];
const allFieldErrors = ['titleError', 'discountTypeError', 'discountValueError', 'priorityError', 'startDateError', 'endDateError', 'bannerError', 'productError'];

allFieldIds.forEach((id, index) => {
    const el = document.getElementById(id);
    if (el) {
        const eventType = el.tagName === 'SELECT' || el.type === 'file' || el.type === 'date' ? 'change' : 'input';
        el.addEventListener(eventType, function() {
            if (this.value.trim() || (this.type === 'file' && this.files.length > 0)) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            } else {
                this.classList.remove('is-valid');
            }
            const errorEl = document.getElementById(allFieldErrors[index]);
            if (errorEl) errorEl.classList.add('d-none');
        });
    }
});

// On-the-fly priority check on change
const priorityEl = document.getElementById('priority');
if (priorityEl) {
    priorityEl.addEventListener('change', function() {
        const priorityValue = this.value.trim();
        if (!priorityValue) return;
        
        const offerId = "{{ $offer->id ?? '' }}";
        $.ajax({
            url: "{{ route('offer.check-priority') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                priority: priorityValue,
                id: offerId
            },
            success: function(response) {
                const priorityError = document.getElementById('priorityError');
                if (response.unique) {
                    priorityEl.classList.remove('is-invalid');
                    priorityEl.classList.add('is-valid');
                    priorityError.classList.add('d-none');
                } else {
                    priorityEl.classList.add('is-invalid');
                    priorityEl.classList.remove('is-valid');
                    priorityError.textContent = 'Priority has already been taken.';
                    priorityError.classList.remove('d-none');
                }
            }
        });
    });
}

// Select2 specific listener
$('#productSelect').on('change', function() {
    if ($(this).val() && $(this).val().length > 0) {
        $(this).removeClass('is-invalid').addClass('is-valid');
    } else {
        $(this).removeClass('is-valid');
    }
    if (document.getElementById('productError')) document.getElementById('productError').classList.add('d-none');
});
</script>

<style>
.is-valid {
    border-color: #198754 !important;
    background-color: #f6fff6 !important;
}
.is-invalid {
    border-color: #dc3545 !important;
    background-color: #fff6f6 !important;
}
/* Select2 validation support */
.is-valid + .select2-container .select2-selection {
    border-color: #198754 !important;
    background-color: #f6fff6 !important;
}
.is-invalid + .select2-container .select2-selection {
    border-color: #dc3545 !important;
    background-color: #fff6f6 !important;
}
.text-danger {
    font-size: 0.85rem;
}
</style>

<script>
    $(document).ready(function() {
        $('#productSelect').select2({
            placeholder: "Select Products",
            allowClear: true,
            width: '100%',
            closeOnSelect: false
        });
    });
</script>
@endsection