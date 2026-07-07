@extends('layouts.app')

@section('content')
    <section class="content-main">
        <div class="content-header">
            <div>
                <h2 class="content-title card-title">Edit Main Category</h2>
                <p>Update details for your main category.</p>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">


                <form id="mainCategoryForm" action="{{ route('maincategory.update', $main->id) }}" method="POST" enctype="multipart/form-data" novalidate>
                    @csrf
                    @method('PUT')

                    <div class="row mb-4">
                        <label class="col-lg-2 col-form-label">Category Name</label>
                        <div class="col-lg-6">
                            <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $main->name) }}" required>
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                            <small class="text-danger d-none" id="nameError">Category name is required.</small>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label class="col-lg-2 col-form-label">Slug Name</label>
                        <div class="col-lg-6">
                            <input type="text" id="slug" name="slug" class="form-control @error('slug') is-invalid @enderror"
                                value="{{ old('slug', $main->slug) }}" required>
                            @error('slug')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                            <small class="text-danger d-none" id="slugError">Slug name is required.</small>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Category Image</label>
                        <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror">
                        @error('image')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror

                        @if($main->image)
                            <div class="mt-2">
                                <img src="{{ asset($main->image) }}" alt="{{ $main->name }}" width="120" class="rounded">
                            </div>
                        @endif
                    </div>


                    <div class="row mb-4">
                        <label class="col-lg-2 col-form-label">Status</label>
                        <div class="col-lg-6">
                            <select name="status" class="form-select @error('status') is-invalid @enderror">
                                <option value="active" {{ old('status', $main->status) == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $main->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-4">
                        <label class="col-lg-2 col-form-label">Order By</label>
                        <div class="col-lg-6">
                            <input type="number" name="orderby" class="form-control"
                                value="{{ old('orderby', $main->orderby) }}" placeholder="Enter order number (1, 2, 3...)"
                                min="1">
                            @error('orderby')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                            <small class="text-muted d-block mt-1">Enter a number to set the display order.</small>
                        </div>
                    </div>

                    <div class="mb-4">
                        <button type="submit" class="btn btn-primary">Update Category</button>
                        <a href="{{ route('maincategory.index') }}" class="btn btn-secondary rounded ms-2">Cancel</a>
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

        document.getElementById('mainCategoryForm').addEventListener('submit', function (e) {
            let valid = true;
            const name = document.getElementById('name');
            const slug = document.getElementById('slug');

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
    </script>
@endsection