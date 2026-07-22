@extends('layouts.app')

@section('content')
    <section class="content-main">
        <div class="content-header">
            <div>
                <h2 class="content-title card-title">Edit Child Category</h2>
                <p>Update details of your child category.</p>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">


                <form action="{{ route('childcategory.update', $child->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                        <label for="name" class="form-label">Child Category Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $child->name) }}" class="form-control @error('name') is-invalid @enderror"
                            placeholder="Enter child category name" required>
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <small class="text-danger d-none" id="nameError">Child category name is required.</small>
                    </div>

                        <label for="slug" class="form-label">Slug Name</label>
                        <input type="text" name="slug" id="slug" value="{{ old('slug', $child->slug) }}" class="form-control @error('slug') is-invalid @enderror"
                            placeholder="Enter slug name">
                        @error('slug')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <small class="text-danger d-none" id="slugError">Slug name is required.</small>
                    </div>

                    <div class="mb-3">
                        <label for="sub_category_id" class="form-label">Select Sub Category</label>
                         <select name="sub_category_id" id="sub_category_id" class="form-select @error('sub_category_id') is-invalid @enderror" required>
                             <option value="">-- Select Sub Category --</option>
                             @foreach($subcategories as $sub)
                                 <option value="{{ $sub->id }}" {{ old('sub_category_id', $child->sub_category_id) == $sub->id ? 'selected' : '' }}>
                                     {{ $sub->name }}
                                 </option>
                             @endforeach
                         </select>
                         @error('sub_category_id')
                             <small class="text-danger">{{ $message }}</small>
                         @enderror
                         <small class="text-danger d-none" id="subCategoryError">Sub category is required.</small>
                    </div>

                    <div class="mb-3">
                        <label for="orderby" class="form-label">Order By</label>
                        <input type="number" name="orderby" id="orderby" value="{{ old('orderby', $child->orderby) }}" class="form-control"
                            placeholder="Enter order number (1, 2, 3...)" min="1">
                        @error('orderby')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <small class="text-muted d-block mt-1">Enter a number to set the display order.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Category Image</label>
                        <input type="file" name="childimage" class="form-control @error('childimage') is-invalid @enderror">
                        @error('childimage')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror

                        @if($child->childimage)
                            <div class="mt-2">
                                <img src="{{ asset($child->childimage) }}" alt="{{ $child->name }}" width="120" class="rounded">
                            </div>
                        @endif
                    </div>


                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="active" {{ old('status', $child->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $child->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <button type="submit" class="btn btn-primary rounded"><i class="bi bi-save me-1"></i> Update</button>
                       <a href="{{ route('childcategory.index') }}" class="btn btn-secondary rounded ms-2"><i class="bi bi-x-circle me-1"></i> Cancel</a>
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
            // Clear validation errors when typing
            this.classList.remove('is-invalid');
            document.getElementById('nameError').classList.add('d-none');
            document.getElementById('slug').classList.remove('is-invalid');
            document.getElementById('slugError').classList.add('d-none');
        });

        document.getElementById('slug').addEventListener('input', function () {
            this.classList.remove('is-invalid');
            document.getElementById('slugError').classList.add('d-none');
        });

        document.getElementById('sub_category_id').addEventListener('change', function () {
            this.classList.remove('is-invalid');
            document.getElementById('subCategoryError').classList.add('d-none');
        });

        // Form validation
        document.querySelector('form').addEventListener('submit', function (e) {
            let valid = true;
            const name = document.getElementById('name');
            const slug = document.getElementById('slug');
            const subCategory = document.getElementById('sub_category_id');

            if (!name.value.trim()) {
                name.classList.add('is-invalid');
                document.getElementById('nameError').classList.remove('d-none');
                valid = false;
            }

            if (!slug.value.trim()) {
                slug.classList.add('is-invalid');
                document.getElementById('slugError').classList.remove('d-none');
                valid = false;
            }

            if (!subCategory.value) {
                subCategory.classList.add('is-invalid');
                document.getElementById('subCategoryError').classList.remove('d-none');
                valid = false;
            }

            if (!valid) e.preventDefault();
        });
    </script>
@endsection