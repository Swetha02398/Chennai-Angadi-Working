@extends('layouts.app')
@section('content')
    <section class="content-main">

        <div class="content-header">
            <div>
                <h2 class="content-title card-title">Add Main Category</h2>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">



                <form id="mainCategoryForm" method="POST" action="{{ route('maincategory.store') }}"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label class="form-label">Main Category Name</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Enter category name" value="{{ old('name') }}">
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <small id="nameError" class="text-danger d-none">Please enter a category name.</small>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Slug Name</label>
                        <input type="text" id="slug" name="slug" class="form-control" placeholder="Enter category slug" value="{{ old('slug') }}">
                        @error('slug')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <small id="slugError" class="text-danger d-none">Slug cannot be empty.</small>
                    </div>

                    {{-- Image Field --}}
                    <div class="mb-4">
                        <label class="form-label">Category Image</label>
                        <input type="file" id="image" name="image" class="form-control">
                        @error('image')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <small id="imageError" class="text-danger d-none"></small>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <small id="statusError" class="text-danger d-none">Please select status.</small>
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

                    <div class="mb-4">
                        <button type="submit" class="btn btn-primary rounded">Save Category</button>
                        <a href="{{ route('maincategory.index') }}" class="btn btn-secondary rounded ms-2">Cancel</a>
                    </div>
                </form>

            </div>
        </div>

    </section>

    {{-- JAVASCRIPT VALIDATION --}}
    <script>

        // Auto-generate slug
        document.getElementById('name').addEventListener('input', function () {
            let slug = this.value.toLowerCase()
                .replace(/ /g, '-')
                .replace(/[^\w-]+/g, '');
            document.getElementById('slug').value = slug;

            // Remove error when typing
            document.getElementById('nameError').classList.add('d-none');
            document.getElementById('slugError').classList.add('d-none');
        });

        document.getElementById('slug').addEventListener('input', function () {
            document.getElementById('slugError').classList.add('d-none');
        });

        // Live image validation
        document.getElementById('image').addEventListener('change', function () {
            const allowedExtensions = /\.(jpg|jpeg|png|gif)$/i;
            if (!allowedExtensions.test(this.value)) {
                document.getElementById('imageError').innerHTML = "Only JPG, JPEG, PNG, GIF allowed.";
                document.getElementById('imageError').classList.remove('d-none');
            } else {
                document.getElementById('imageError').classList.add('d-none');
            }
        });

        // Form Validation and AJAX Submit
        document.getElementById('mainCategoryForm').addEventListener('submit', function (e) {
            e.preventDefault(); // Prevent standard page reload submit

            let isValid = true;

            // Clear previous errors
            document.querySelectorAll('.server-error').forEach(el => el.remove());
            document.querySelectorAll('small.text-danger:not([id])').forEach(el => el.remove());
            document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
            document.getElementById('nameError').classList.add('d-none');
            document.getElementById('slugError').classList.add('d-none');
            document.getElementById('imageError').classList.add('d-none');
            document.getElementById('statusError').classList.add('d-none');

            const nameValue = document.getElementById('name').value.trim();
            const slugValue = document.getElementById('slug').value.trim();
            const statusValue = document.getElementById('status').value.trim();

            // Name validation
            if (nameValue === "") {
                document.getElementById('nameError').classList.remove('d-none');
                document.getElementById('name').classList.add('is-invalid');
                isValid = false;
            }

            // Slug validation
            if (slugValue === "") {
                document.getElementById('slugError').classList.remove('d-none');
                document.getElementById('slug').classList.add('is-invalid');
                isValid = false;
            }

            // Image validation
            const imagePath = document.getElementById('image').value;
            const allowedExtensions = /\.(jpg|jpeg|png|gif)$/i;

            if (imagePath && !allowedExtensions.test(imagePath)) {
                document.getElementById('imageError').innerHTML = "Only JPG, JPEG, PNG, GIF allowed.";
                document.getElementById('imageError').classList.remove('d-none');
                document.getElementById('image').classList.add('is-invalid');
                isValid = false;
            }

            // Status validation
            if (statusValue === "") {
                document.getElementById('statusError').classList.remove('d-none');
                document.getElementById('status').classList.add('is-invalid');
                isValid = false;
            }

            if (!isValid) {
                return;
            }

            // Submit via AJAX
            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalBtnText = submitBtn.innerHTML;
            
            submitBtn.disabled = true;
            submitBtn.innerHTML = 'Saving Category...';

            fetch(this.action, {
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
                        window.location.href = "{{ route('maincategory.index') }}";
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
                    inputEl.classList.add('is-invalid');
                    
                    const errorEl = document.createElement('small');
                    errorEl.className = 'text-danger d-block mt-1 server-error';
                    errorEl.innerText = messages[0];
                    inputEl.parentNode.appendChild(errorEl);
                }
            }
        }
    </script>

@endsection