@extends('layouts.app')
@section('content')
    <section class="content-main">
        <div class="content-header">
            <div>
                <h2 class="content-title card-title">Edit Sub Category</h2>
                <p>Update the details of your sub category.</p>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">

                {{-- Validation Errors --}}


                {{-- Edit Form --}}
                <form id="subCategoryForm" action="{{ route('subcategory.update', $sub->id) }}" method="POST" enctype="multipart/form-data" novalidate>
                    @csrf
                    @method('PUT')

                    <div class=" mb-4">
                        <label class="form-label">Sub Category Name</label>
                        <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $sub->name) }}"
                            required>
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <small class="text-danger d-none" id="nameError">Sub category name is required.</small>
                    </div>

                    <div class=" mb-4">
                        <label class="form-label">Slug Name</label>
                        <input type="text" id="slug" name="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug', $sub->slug) }}"
                            required>
                        @error('slug')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <small class="text-danger d-none" id="slugError">Slug name is required.</small>
                    </div>

                    <div class=" mb-4">
                        <label class="form-label">Parent Category</label>
                        <select name="main_category_id" id="main_category_id" class="form-select @error('main_category_id') is-invalid @enderror" required>
                            <option value="">-- Select Parent Main Category --</option>
                            @foreach($maincategories as $main)
                                <option value="{{ $main->id }}" {{ old('main_category_id', $sub->main_category_id) == $main->id ? 'selected' : '' }}>
                                    {{ $main->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('main_category_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <small class="text-danger d-none" id="mainCategoryError">Parent category is required.</small>
                    </div>

                    <div class=" mb-4">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="active" {{ old('status', $sub->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $sub->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Subcategory Image Field --}}
                    <div class="mb-3">
                        <label class="form-label">Category Image</label>
                        <input type="file" name="subimage" class="form-control @error('subimage') is-invalid @enderror">
                        @error('subimage')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror

                        @if($sub->subimage)
                            <div class="mt-2">
                                <img src="{{ asset($sub->subimage) }}" alt="{{ $sub->name }}" width="120" class="rounded">
                            </div>
                        @endif
                    </div>

                    {{-- Order By --}}
                    <div class="mb-4">
                        <label class="form-label">Order By</label>
                        <input type="number" name="orderby" class="form-control" value="{{ old('orderby', $sub->orderby) }}"
                            placeholder="Enter order number (1, 2, 3...)" min="1">
                        @error('orderby')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <small class="text-muted d-block mt-1">Enter a number to set the display order.</small>
                    </div>


                    <div class="mb-4">
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save me-1"></i> Update</button>
                        <a href="{{ route('subcategory.index') }}" class="btn btn-secondary rounded ms-2"><i class="bi bi-x-circle me-1"></i> Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <script>
        // Auto-generate slug when typing name
        document.getElementById('name').addEventListener('input', function () {
            let slug = this.value.toLowerCase().replace(/ /g, '-').replace(/[^\w-]+/g, '');
            document.getElementById('slug').value = slug;
        });

        document.getElementById('subCategoryForm').addEventListener('submit', function (e) {
            let valid = true;
            const name = document.getElementById('name');
            const slug = document.getElementById('slug');
            const main_category_id = document.getElementById('main_category_id');

            if (!name.value.trim()) {
                name.classList.add('is-invalid');
                document.getElementById('nameError').classList.remove('d-none');
                valid = false;
            } else {
                name.classList.remove('is-invalid');
                document.getElementById('nameError').classList.add('d-none');
            }

            if (!slug.value.trim()) {
                slug.classList.add('is-invalid');
                document.getElementById('slugError').classList.remove('d-none');
                valid = false;
            } else {
                slug.classList.remove('is-invalid');
                document.getElementById('slugError').classList.add('d-none');
            }

            if (!main_category_id.value) {
                main_category_id.classList.add('is-invalid');
                document.getElementById('mainCategoryError').classList.remove('d-none');
                valid = false;
            } else {
                main_category_id.classList.remove('is-invalid');
                document.getElementById('mainCategoryError').classList.add('d-none');
            }

            if (!valid) e.preventDefault();
        });

        // Clear validation errors when typing
        document.getElementById('name').addEventListener('input', function () {
            this.classList.remove('is-invalid');
            document.getElementById('nameError').classList.add('d-none');
        });

        document.getElementById('slug').addEventListener('input', function () {
            this.classList.remove('is-invalid');
            document.getElementById('slugError').classList.add('d-none');
        });

        document.getElementById('main_category_id').addEventListener('change', function () {
            this.classList.remove('is-invalid');
            document.getElementById('mainCategoryError').classList.add('d-none');
        });
    </script>
@endsection