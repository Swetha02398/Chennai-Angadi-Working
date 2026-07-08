@extends('layouts.app')
@section('content')
    @include('includes.alert')

    <style>
        .form-card {
            background: #fff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .form-label {
            font-weight: 500;
            color: #444;
            font-size: 0.9rem;
            margin-bottom: 6px;
        }

        .form-control,
        .form-select {
            background: #f5f7fa;
            border: 1px solid #e3e6ea;
            padding: 10px 12px;
            font-size: 0.9rem;
        }

        input[type="number"] {
            padding-right: 30px;
        }

        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: inner-spin-button !important;
            opacity: 1;
        }

        .form-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 16px 12px;
            padding-right: 2.5rem;
            cursor: pointer;
        }

        .section-title {
            font-size: 1rem;
            font-weight: 600;
            margin: 25px 0 15px;
            color: #333;
        }

        /* Dark mode support */
        html.dark .form-card {
            background: #1e293b;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        html.dark .form-label {
            color: #cbd5e1;
        }

        html.dark .section-title {
            color: #f1f5f9;
        }

        html.dark .form-control,
        html.dark .form-select {
            background-color: #111827;
            border-color: #374151;
            color: #f9fafb;
        }

        html.dark .form-control:focus,
        html.dark .form-select:focus {
            background-color: #111827;
            border-color: #3bb77e;
            color: #f9fafb;
        }

        html.dark .table {
            color: #cbd5e1;
        }

        html.dark .table thead th {
            background-color: #374151;
            color: #f9fafb;
            border-color: #4b5563;
        }

        html.dark .table td {
            border-color: #374151;
        }

        html.dark .text-muted {
            color: #9ca3af !important;
        }
    </style>

    <section class="content-main">
        <div class="container">

            <h2 class="mb-4">Add Product</h2>

            <div class="form-card">
                <form id="productForm" method="POST" action="{{ route('product.store') }}" enctype="multipart/form-data"
                    novalidate>
                    @csrf



                    {{-- ================= BASIC DETAILS ================= --}}
                    <div class="section-title">Basic Details</div>
                    <div class="row g-4">
                        <div class="col-lg-4">
                            <label class="form-label">Product Name *</label>
                            <input type="text" name="productname" id="productname" class="form-control"value="{{ old('productname') }}">
                                <small class="text-danger d-none" id="productnameError">Product name is required</small>
                                @error('productname') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-lg-4">
                                <label class="form-label">SKU *</label>
                                <input type="text" name="sku" class="form-control" value="{{ old('sku') }}">
                                <small class="text-danger d-none" id="skuError">SKU is required</small>
                                @error('sku') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <input type="hidden" name="slug" id="slug" value="{{ old('slug') }}">
                        </div>

                        {{-- ================= GST ================= --}}
                        <div class="section-title">GST Details</div>
                        <div class="row g-3">
                            <div class="col-lg-4">
                                <label class="form-label">HSN Code</label>
                                <input type="text" name="hsn" class="form-control" value="{{ old('hsn') }}">
                                @error('hsn') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">GST %</label>
                                <input type="number" step="0.01" name="gst" class="form-control" value="{{ old('gst') }}">
                                @error('gst') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">IGST %</label>
                                <input type="number" step="0.01" name="igst" class="form-control" value="{{ old('igst') }}">
                                @error('igst') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">SGST %</label>
                                <input type="number" step="0.01" name="sgst" class="form-control" value="{{ old('sgst') }}">
                                @error('sgst') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        {{-- ================= CATEGORY ================= --}}
                        <div class="section-title">Category</div>
                        <div class="row g-4">
                            <div class="col-lg-4">
                                <label class="form-label">Category *</label>
                                <select name="category_id" class="form-select">
                                    <option value="">Select</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                                <small class="text-danger d-none" id="categoryError">Category is required</small>
                                @error('category_id') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-lg-4">
                                <label class="form-label">Sub Category</label>
                                <select name="subcategory_id" class="form-select">
                                    <option value="">Select</option>
                                    @foreach($subcategories as $sub)
                                        <option value="{{ $sub->id }}" {{ old('subcategory_id') == $sub->id ? 'selected' : '' }}>{{ $sub->name }}</option>
                                    @endforeach
                                </select>
                                @error('subcategory_id') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-lg-4">
                                <label class="form-label">Child Category</label>
                                <select name="childcategory_id" class="form-select">
                                    <option value="">Select</option>
                                    @foreach($childcategories as $child)
                                        <option value="{{ $child->id }}" {{ old('childcategory_id') == $child->id ? 'selected' : '' }}>{{ $child->name }}</option>
                                    @endforeach
                                </select>
                                @error('childcategory_id') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        {{-- ================= DESCRIPTION ================= --}}
                        <div class="section-title">Description</div>
                        <div class="row g-4">
                            <div class="col-lg-4">
                                <label class="form-label">Short Description</label>
                                <textarea name="short_description" class="form-control">{{ old('short_description') }}</textarea>
                                @error('short_description') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-lg-4">
                                <label class="form-label">Full Description</label>
                                <textarea name="description" class="form-control">{{ old('description') }}</textarea>
                                @error('description') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-lg-4">
                                <label class="form-label">Featured</label>
                                <select name="featured" class="form-select">
                                    <option value="0" {{ old('featured') == '0' ? 'selected' : '' }}>No</option>
                                    <option value="1" {{ old('featured') == '1' ? 'selected' : '' }}>Yes</option>
                                </select>
                                @error('featured') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-lg-4">
                                <label class="form-label">Product Status</label>
                                <select name="status" class="form-select">
                                    <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        {{-- ================= HOME PAGE SECTIONS ================= --}}
                        <div class="section-title">Home Page Sections</div>
                        <div class="row g-4">
                            <div class="col-lg-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="top_selling" value="1" id="topSelling" {{ old('top_selling') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="topSelling">Top Selling</label>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="trending_product" value="1" id="trendingProduct" {{ old('trending_product') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="trendingProduct">Trending Product</label>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="hot_deal" value="1" id="hotDeal" {{ old('hot_deal') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="hotDeal">Hot Deal</label>
                                </div>
                            </div>
                        </div>

                        {{-- ================= IMAGES ================= --}}
                        <div class="section-title">Images</div>
                        <div class="row g-4">
                            <div class="col-lg-4">
                                <label class="form-label">Product Images</label>
                                <input type="file" id="productimage" name="productimage[]" class="form-control" multiple>
                                <small class="text-danger d-none" id="imageError">You can only select up to 5 images.</small>
                                @error('productimage') 
                                    <small class="text-danger d-block">{{ $message }}</small> 
                                @enderror
                                @error('productimage.*') 
                                    <small class="text-danger d-block">{{ $message }}</small> 
                                @enderror
                            </div>
                        </div>

                        {{-- ================= ADDITIONAL INFORMATION ================= --}}
                        <div class="section-title">Additional Information</div>
                        <div class="table-responsive">
                            <table class="table" id="specTable">
                                <thead>
                                    <tr>
                                        <th>Specification Name (e.g. Height)</th>
                                        <th>Value (e.g. 10cm)</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><input type="text" name="specifications[0][key]" class="form-control" placeholder="e.g. Height"></td>
                                        <td><input type="text" name="specifications[0][value]" class="form-control" placeholder="e.g. 10cm"></td>
                                        <td><button type="button" class="btn btn-success addSpecRow" style="width: 95px; height: 34px; border-radius: 6px; padding: 0; font-size: 13px;">+ Add</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        {{-- ================= VARIANTS ================= --}}
                        <div class="section-title">Product Variants (Weight Wise)</div>
                        @if($errors->has('variants'))
                            <div class="alert alert-danger">{{ $errors->first('variants') }}</div>
                        @endif
                        <div class="table-responsive">
                            <table class="table" id="variantTable">
                                <thead>
                                    <tr>
                                        <th>Weight *</th>
                                        <th>MRP *</th>
                                        <th>Selling Price *</th>
                                        <th>Stock *</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(old('variants'))
                                        @foreach(old('variants') as $index => $variant)
                                            <tr>
                                                <td>
                                                    <select name="variants[{{ $index }}][quantity_id]" class="form-select">
                                                        <option value="">Select</option>
                                                        @foreach($quantities as $q)
                                                            <option value="{{ $q->id }}" {{ $variant['quantity_id'] == $q->id ? 'selected' : '' }}>{{ $q->name }}{{ $q->label ? ' – ' . $q->label : '' }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error("variants.$index.quantity_id") <small class="text-danger">{{ $message }}</small> @enderror
                                                </td>
                                                <td>
                                                    <input type="number" step="0.01" name="variants[{{ $index }}][price]" class="form-control" value="{{ $variant['price'] }}">
                                                    @error("variants.$index.price") <small class="text-danger">{{ $message }}</small> @enderror
                                                </td>
                                                <td>
                                                    <input type="number" step="0.01" name="variants[{{ $index }}][sell_price]" class="form-control" value="{{ $variant['sell_price'] }}">
                                                    @error("variants.$index.sell_price") <small class="text-danger">{{ $message }}</small> @enderror
                                                </td>
                                                <td>
                                                    <input type="number" name="variants[{{ $index }}][stock]" class="form-control" value="{{ $variant['stock'] }}">
                                                    @error("variants.$index.stock") <small class="text-danger">{{ $message }}</small> @enderror
                                                </td>
                                                <td>
                                                    @if($index == 0)
                                                        <button type="button" class="btn btn-success addRow" style="width: 95px; height: 34px; border-radius: 6px; padding: 0; font-size: 13px;">+ Add</button>
                                                    @else
                                                        <button type="button" class="btn btn-danger removeRow" style="width: 95px; height: 34px; border-radius: 6px; padding: 0; font-size: 13px;">- Remove</button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td>
                                                <select name="variants[0][quantity_id]" class="form-select">
                                                    <option value="">Select</option>
                                                    @foreach($quantities as $q)
                                                        <option value="{{ $q->id }}">{{ $q->name }}{{ $q->label ? ' – ' . $q->label : '' }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td><input type="number" step="0.01" name="variants[0][price]" class="form-control">
                                            </td>
                                            <td><input type="number" step="0.01" name="variants[0][sell_price]"
                                                    class="form-control"></td>
                                            <td><input type="number" name="variants[0][stock]" class="form-control"></td>
                                            <td><button type="button" class="btn btn-success addRow" style="width: 95px; height: 34px; border-radius: 6px; padding: 0; font-size: 13px;">+ Add</button></td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            <small class="text-danger d-none variantError" id="variantError">All variant fields are required</small>
                        </div>

                        {{-- ================= SEO ================= --}}
                        <div class="section-title">SEO</div>
                        <div class="row g-4">
                            <div class="col-lg-4">
                                <label class="form-label">SEO Title</label>
                                <input type="text" name="seo_title" class="form-control" value="{{ old('seo_title') }}">
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">SEO Keywords</label>
                                <input type="text" name="seo_keywords" class="form-control" value="{{ old('seo_keywords') }}">
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label">SEO Description</label>
                                <input type="text" name="seo_description" class="form-control" value="{{ old('seo_description') }}">
                            </div>
                        </div>

                        {{-- ================= ORDER BY ================= --}}
                        <div class="section-title">Display Order</div>
                        <div class="row g-4">
                            <div class="col-lg-4">
                                <label class="form-label">Order By</label>
                                <input type="number" name="orderby" class="form-control"
                                    placeholder="Enter order number (1, 2, 3...)" min="1" value="{{ old('orderby') }}">
                                <small class="text-muted d-block mt-1">Enter a number to set the display order.</small>
                                @error('orderby') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="mt-4">
                            <button class="btn btn-primary px-4">Save Product</button>
                            <a href="{{ route('product.table') }}" class="btn btn-secondary px-4">Cancel</a>
                        </div>

                    </form>
                </div>
            </div>
        </section>

        <script>
            document.getElementById('productname').addEventListener('keyup', function () {
                document.getElementById('slug').value =
                    this.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
            });

            // Initialize rowIndex based on existing rows (in case of validation error)
            let rowIndex = {{ old('variants') ? count(old('variants')) : 1 }};
            let specIndex = {{ old('specifications') ? count(old('specifications')) : 1 }};

            document.addEventListener('click', function (e) {
                if (e.target.classList.contains('addRow')) {
                    let tr = e.target.closest('tr');
                    let clone = tr.cloneNode(true);

                    clone.querySelectorAll('input,select').forEach(el => {
                        // Update the index in the name attribute
                        el.name = el.name.replace(/\[\d+\]/, '[' + rowIndex + ']');
                        el.value = '';
                        el.classList.remove('is-invalid'); // Remove error classes if any
                    });

                    // Remove error messages in clone
                    clone.querySelectorAll('.text-danger').forEach(el => el.remove());

                    // Ensure the button is a remove button on the clone
                    let btn = clone.querySelector('.addRow') || clone.querySelector('.removeRow');
                    if(btn){
                         btn.className = 'btn btn-danger removeRow';
                         btn.style.cssText = 'width: 95px; height: 34px; border-radius: 6px; padding: 0; font-size: 13px;';
                         btn.innerText = '- Remove';
                    }

                    document.querySelector('#variantTable tbody').appendChild(clone);
                    rowIndex++;
                }

                if (e.target.classList.contains('removeRow')) {
                    e.target.closest('tr').remove();
                }

                if (e.target.classList.contains('addSpecRow')) {
                    let tr = e.target.closest('tr');
                    let clone = tr.cloneNode(true);

                    clone.querySelectorAll('input').forEach(el => {
                        el.name = el.name.replace(/\[\d+\]/, '[' + specIndex + ']');
                        el.value = '';
                    });

                    let btn = clone.querySelector('.addSpecRow');
                    if(btn){
                         btn.className = 'btn btn-danger removeSpecRow';
                         btn.style.cssText = 'width: 95px; height: 34px; border-radius: 6px; padding: 0; font-size: 13px;';
                         btn.innerText = '- Remove';
                    }

                    document.querySelector('#specTable tbody').appendChild(clone);
                    specIndex++;
                }

                if (e.target.classList.contains('removeSpecRow')) {
                    e.target.closest('tr').remove();
                }
            });

            // Hide variant error message when user interacts with variant fields
            document.getElementById('variantTable').addEventListener('input', function(e) {
                if (e.target.matches('input, select')) {
                    document.querySelector('.variantError').classList.add('d-none');
                }
            });            document.getElementById('productForm').addEventListener('submit', function (e) {
                e.preventDefault(); // Prevent standard page reload submit

                let valid = true;

                // Clear previous server-side errors
                document.querySelectorAll('.server-error').forEach(el => el.remove());
                document.querySelectorAll('small.text-danger:not([id])').forEach(el => el.remove());
                document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));

                function check(input, errorId) {
                    if (!input.value.trim()) {
                        document.getElementById(errorId).classList.remove('d-none');
                        input.classList.add('is-invalid');
                        valid = false;
                    } else {
                        document.getElementById(errorId).classList.add('d-none');
                        input.classList.remove('is-invalid');
                    }
                }

                check(document.getElementById('productname'), 'productnameError');
                check(document.querySelector('input[name="sku"]'), 'skuError');

                let imageInput = document.getElementById('productimage');
                if (imageInput && imageInput.files.length > 5) {
                    document.getElementById('imageError').classList.remove('d-none');
                    imageInput.classList.add('is-invalid');
                    valid = false;
                } else if (imageInput) {
                    document.getElementById('imageError').classList.add('d-none');
                    imageInput.classList.remove('is-invalid');
                }

                let category = document.querySelector('select[name="category_id"]');
                if (!category.value) {
                    document.getElementById('categoryError').classList.remove('d-none');
                    category.classList.add('is-invalid');
                    valid = false;
                } else {
                    document.getElementById('categoryError').classList.add('d-none');
                    category.classList.remove('is-invalid');
                }

                // Simple check for variants - just check if any inputs are empty
                let variantRows = document.querySelectorAll('#variantTable tbody tr');
                let hasVariantError = false;

                variantRows.forEach(tr => {
                    let inputs = tr.querySelectorAll('input,select');
                    inputs.forEach(i => { 
                        if (!i.value.trim()) {
                            i.classList.add('is-invalid');
                            hasVariantError = true;
                        } else {
                            i.classList.remove('is-invalid');
                        }
                    });
                });

                if(hasVariantError) {
                    document.querySelector('.variantError').classList.remove('d-none');
                    valid = false;
                } else {
                    document.querySelector('.variantError').classList.add('d-none');
                }

                if (!valid) {
                    const firstInvalid = document.querySelector('.is-invalid');
                    if (firstInvalid) {
                        firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        firstInvalid.focus();
                    } else {
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    }
                    return;
                }

                // Submit via AJAX
                const formData = new FormData(this);
                const submitBtn = this.querySelector('button[type="submit"]') || this.querySelector('.btn-primary');
                const originalBtnText = submitBtn.innerHTML;

                submitBtn.disabled = true;
                submitBtn.innerHTML = 'Saving Product...';

                fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    return response.json().then(data => {
                        if (response.ok && data.success) {
                            // Success - redirect to product table
                            window.location.href = data.redirect || "{{ route('product.table') }}";
                        } else if (response.status === 422 && data.errors) {
                            // Validation errors
                            displayServerErrors(data.errors);
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = originalBtnText;
                        } else {
                            // Other server error
                            alert(data.message || 'Something went wrong. Please try again.');
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = originalBtnText;
                        }
                    }).catch(() => {
                        // Response was not JSON (e.g., a redirect to HTML page)
                        if (response.redirected || response.ok) {
                            window.location.href = "{{ route('product.table') }}";
                        } else {
                            alert('Something went wrong. Please try again.');
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = originalBtnText;
                        }
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Network error. Please check your connection and try again.');
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnText;
                });
            });

            function displayServerErrors(errors) {
                for (const key in errors) {
                    const messages = errors[key];
                    
                    // Handle array fields (like "variants.0.price" -> name="variants[0][price]")
                    let fieldKey = key;
                    if (key.includes('.')) {
                        const parts = key.split('.');
                        fieldKey = parts[0];
                        for (let i = 1; i < parts.length; i++) {
                            fieldKey += '[' + parts[i] + ']';
                        }
                    }
                    
                    const inputEl = document.getElementById(fieldKey) || document.getElementsByName(fieldKey)[0];
                    if (inputEl) {
                        inputEl.classList.add('is-invalid');
                        
                        const errorEl = document.createElement('small');
                        errorEl.className = 'text-danger d-block mt-1 server-error';
                        errorEl.innerText = messages[0];
                        inputEl.parentNode.appendChild(errorEl);
                    } else {
                        // General fallback
                        alert(messages[0]);
                    }
                }
            } 
            
            const imageInput = document.getElementById('productimage');
            if (imageInput) {
                imageInput.addEventListener('change', function () {
                    if (this.files.length > 5) {
                        document.getElementById('imageError').classList.remove('d-none');
                        this.classList.add('is-invalid');
                        this.value = ''; // Clear selected files
                    } else {
                        document.getElementById('imageError').classList.add('d-none');
                        this.classList.remove('is-invalid');
                    }
                });
            }
        </script>

@endsection
