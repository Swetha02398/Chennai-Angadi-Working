@extends('layouts.app')
@section('content')
    <section class="content-main">

        <div class="content-header">
            <div>
                <h2 class="content-title card-title">Add Sub Category</h2>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">



                {{-- Create Subcategory Form --}}
                <form id="subcategoryForm" action="{{ route('subcategory.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    {{-- Subcategory Name --}}
                    <div class="mb-4">
                        <label class="form-label">Sub Category Name</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Enter subcategory name" value="{{ old('name') }}">
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <small id="nameError" class="text-danger d-none">Please enter a Subcategory name.</small>
                    </div>

                    {{-- Slug --}}
                    <div class="mb-4">
                        <label class="form-label">Slug</label>
                        <input type="text" id="slug" name="slug" class="form-control" placeholder="Enter slug" value="{{ old('slug') }}">
                        @error('slug')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <small id="slugError" class="text-danger d-none">Please enter a slug.</small>
                    </div>

                    {{-- Parent Category --}}
                    <div class="mb-4">
                        <label class="form-label">Parent Category</label>
                        <select id="parentCategory" name="main_category_id" class="form-select">
                            <option value="">-- Select Parent Main Category --</option>
                            @foreach($maincategories as $main)
                                <option value="{{ $main->id }}" {{ old('main_category_id') == $main->id ? 'selected' : '' }}>
                                    {{ $main->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('main_category_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <small id="parentCategoryError" class="text-danger d-none">Please select a parent category.</small>
                    </div>

                    {{-- Status --}}
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Image Upload --}}
                    <div class="mb-4">
                        <label class="form-label">Subcategory Image</label>
                        <input type="file" id="subimage" name="subimage" class="form-control">
                        @error('subimage')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <small class="text-muted d-block mt-1">Optional. JPG, JPEG, PNG, GIF only.</small>
                    </div>

                    {{-- Order By --}}
                    <div class="mb-4">
                        <label class="form-label">Order By</label>
                        <input type="number" id="orderby" name="orderby" class="form-control"
                            placeholder="Enter order number (1, 2, 3...)" min="1" value="{{ old('orderby') }}">
                        @error('orderby')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <small class="text-muted d-block mt-1">Enter a number to set the display order.</small>
                    </div>

                    {{-- Submit --}}
                    <div class="mb-4">
                        <button type="submit" class="btn btn-primary rounded">Save Category</button>
                        <a href="{{ route('subcategory.index') }}" class="btn btn-secondary rounded ms-2">Cancel</a>
                    </div>

                </form>

            </div>
        </div>

    </section>

    {{-- Full Frontend Validation --}}
    <script>
        document.addEventListener("DOMContentLoaded", function () {

            const nameInput = document.getElementById('name');
            const slugInput = document.getElementById('slug');
            const parentSelect = document.getElementById('parentCategory');
            const statusSelect = document.getElementById('status');
            const imageInput = document.getElementById('subimage');
            const form = document.getElementById('subcategoryForm');

            // Create Error Text
            function createError(input, message) {
                let err = input.parentNode.querySelector("small.error-text");
                if (!err) {
                    err = document.createElement("small");
                    err.classList.add("text-danger", "error-text");
                    input.parentNode.appendChild(err);
                }
                err.innerText = message;
                input.classList.add("is-invalid");
                input.classList.remove("is-valid");
            }

            function clearError(input) {
                let err = input.parentNode.querySelector("small.error-text");
                if (err) err.remove();
                input.classList.remove("is-invalid");
            }

            // Auto Slug
            nameInput.addEventListener('input', function () {
                let slug = this.value.toLowerCase().replace(/ /g, '-').replace(/[^\w-]+/g, '');
                slugInput.value = slug;
                clearError(nameInput);
                clearError(slugInput);
            });

            slugInput.addEventListener('input', () => clearError(slugInput));
            parentSelect.addEventListener('change', () => clearError(parentSelect));
            statusSelect.addEventListener('change', () => clearError(statusSelect));

            // Image validation
            imageInput.addEventListener('change', function () {
                const allowed = /\.(jpg|jpeg|png|gif)$/i;
                if (this.value && !allowed.test(this.value)) {
                    createError(imageInput, "Only JPG, JPEG, PNG, GIF allowed.");
                } else {
                    clearError(imageInput);
                }
            });

            // On Submit Validation
            form.addEventListener('submit', function (e) {
                e.preventDefault(); // Prevent standard page reload submit

                let valid = true;

                // Clear previous client-side errors
                form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
                form.querySelectorAll('.error-text').forEach(el => el.remove());
                // Clear server-side Laravel errors
                form.querySelectorAll('small.text-danger:not(.error-text)').forEach(el => el.remove());

                if (nameInput.value.trim() === "") {
                    createError(nameInput, "Please enter subcategory name.");
                    valid = false;
                }

                if (slugInput.value.trim() === "") {
                    createError(slugInput, "Slug cannot be empty.");
                    valid = false;
                }

                if (parentSelect.value === "") {
                    createError(parentSelect, "Please select a parent category.");
                    valid = false;
                }

                const allowed = /\.(jpg|jpeg|png|gif)$/i;
                if (imageInput.value && !allowed.test(imageInput.value)) {
                    createError(imageInput, "Only JPG, JPEG, PNG, GIF allowed.");
                    valid = false;
                }

                if (statusSelect.value === "") {
                    createError(statusSelect, "Please select status.");
                    valid = false;
                }

                if (!valid) return;

                // Submit via AJAX
                const formData = new FormData(form);
                const submitBtn = form.querySelector('button[type="submit"]');
                const originalBtnText = submitBtn.innerHTML;

                submitBtn.disabled = true;
                submitBtn.innerHTML = 'Saving Category...';

                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (response.redirected) {
                        window.location.href = response.url;
                        return;
                    }
                    
                    return response.json().then(data => {
                        if (!response.ok) {
                            if (response.status === 422 && data.errors) {
                                displayServerErrors(data.errors);
                            } else {
                                alert(data.message || 'Something went wrong. Please try again.');
                            }
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = originalBtnText;
                        } else {
                            window.location.href = "{{ route('subcategory.index') }}";
                        }
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Something went wrong. Please try again.');
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnText;
                });
            });

            function displayServerErrors(errors) {
                for (const key in errors) {
                    const messages = errors[key];
                    const inputEl = document.getElementById(key) || document.getElementsByName(key)[0];
                    if (inputEl) {
                        createError(inputEl, messages[0]);
                    }
                }
            }

        });
    </script>

@endsection