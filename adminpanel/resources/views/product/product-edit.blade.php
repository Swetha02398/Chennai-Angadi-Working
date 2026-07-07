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
            background-color: #f5f7fa;
            border: 1px solid #e3e6ea;
            padding: 10px 12px;
            font-size: 0.9rem;
        }
        .order-view-header .action-buttons .btn {
            padding: 8px 16px;
            font-size: 14px;
            border-radius: 5px;
        }

        /* Individual image edit styles */
        .existing-image-item {
            position: relative;
            display: inline-block;
            cursor: pointer;
        }
        .existing-image-item img {
            width: 70px;
            height: 70px;
            border-radius: 6px;
            object-fit: cover;
            border: 2px solid #e3e6ea;
            transition: border-color 0.2s;
        }
        .existing-image-item:hover img {
            border-color: #4caf50;
        }
        .existing-image-item .delete-btn {
            position: absolute;
            top: -8px;
            left: -8px;
            background: #f44336;
            color: #fff;
            border-radius: 50%;
            width: 22px;
            height: 22px;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 10;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
            transition: transform 0.2s;
        }
        .existing-image-item .delete-btn:hover {
            transform: scale(1.1);
            background: #d32f2f;
        }
        .existing-image-item .edit-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0,0,0,0.6);
            color: #fff;
            text-align: center;
            font-size: 10px;
            padding: 2px 0;
            border-radius: 0 0 6px 6px;
            opacity: 0;
            transition: opacity 0.2s;
        }
        .existing-image-item:hover .edit-overlay {
            opacity: 1;
        }
        .existing-image-item .replace-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #4caf50;
            color: #fff;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 11px;
            display: none;
            align-items: center;
            justify-content: center;
        }
        .existing-image-item.replaced .replace-badge {
            display: flex;
        }
        .form-control:focus,
        .form-select:focus {
            background-color: #fff;
            border-color: #4caf50;
            box-shadow: none;
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

        html.dark .existing-image-item img {
            border-color: #374151;
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

            <h2 class="mb-4">Edit Product</h2>
            <div class="form-card">
                <form id="productForm" method="POST" action="{{ route('product.update', $product->id) }}" enctype="multipart/form-data" novalidate>
                    @csrf
                    @method('PUT')



                    {{-- ================= BASIC DETAILS ================= --}}
                    <div class="section-title">Basic Details</div>
                    <div class="row g-4">

                        <div class="col-lg-4">
                            <label class="form-label">Product Name *</label>
                            <input type="text" name="productname" id="productname" class="form-control @error('productname') is-invalid @enderror"
                                value="{{ old('productname', $product->productname) }}" required>
                            @error('productname')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                            <small class="text-danger d-none" id="productnameError">Product name is required.</small>
                        </div>

                        <div class="col-lg-4">
                            <label class="form-label">SKU *</label>
                            <input type="text" name="sku" id="sku" class="form-control @error('sku') is-invalid @enderror" value="{{ old('sku', $product->sku) }}"
                                required>
                            @error('sku')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                            <small class="text-danger d-none" id="skuError">SKU is required.</small>
                        </div>


                        <input type="hidden" name="slug" id="slug" value="{{ old('slug', $product->slug) }}">
                    </div>

                    {{-- ================= GST ================= --}}
                    <div class="section-title">GST Details</div>
                    <div class="row g-3">

                        <div class="col-lg-4">
                            <label class="form-label">HSN Code</label>
                            <input type="text" name="hsn" class="form-control" value="{{ old('hsn', $product->hsn) }}">
                            @error('hsn')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-lg-4">
                            <label class="form-label">GST %</label>
                            <input type="number" step="0.01" name="gst" class="form-control"
                                value="{{ old('gst', $product->gst) }}">
                            @error('gst')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-lg-4">
                            <label class="form-label">IGST %</label>
                            <input type="number" step="0.01" name="igst" class="form-control"
                                value="{{ old('igst', $product->igst) }}">
                            @error('igst')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-lg-4">
                            <label class="form-label">SGST %</label>
                            <input type="number" step="0.01" name="sgst" class="form-control"
                                value="{{ old('sgst', $product->sgst) }}">
                            @error('sgst')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    {{-- ================= CATEGORY ================= --}}
                    <div class="section-title">Category</div>
                    <div class="row g-4">

                        <div class="col-lg-4">
                            <label class="form-label">Category *</label>
                            <select name="category_id" class="form-select" required>
                                <option value="">Select</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-lg-4">
                            <label class="form-label">Sub Category</label>
                            <select name="subcategory_id" class="form-select">
                                <option value="">Select</option>
                                @foreach($subcategories as $sub)
                                    <option value="{{ $sub->id }}" {{ old('subcategory_id', $product->subcategory_id) == $sub->id ? 'selected' : '' }}>
                                        {{ $sub->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('subcategory_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-lg-4">
                            <label class="form-label">Child Category</label>
                            <select name="childcategory_id" class="form-select">
                                <option value="">Select</option>
                                @foreach($childcategories as $child)
                                    <option value="{{ $child->id }}" {{ old('childcategory_id', $product->childcategory_id) == $child->id ? 'selected' : '' }}>
                                        {{ $child->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('childcategory_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    {{-- ================= DESCRIPTION ================= --}}
                    <div class="section-title">Description</div>
                    <div class="row g-4">

                        <div class="col-lg-4">
                            <label class="form-label">Short Description</label>
                            <textarea name="short_description"
                                class="form-control">{{ old('short_description', $product->short_description) }}</textarea>
                            @error('short_description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-lg-4">
                            <label class="form-label">Full Description</label>
                            <textarea name="description"
                                class="form-control">{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-lg-4">
                            <label class="form-label">Featured</label>
                            <select name="featured" class="form-select">
                                <option value="0" {{ old('featured', $product->featured) == 0 ? 'selected' : '' }}>No</option>
                                <option value="1" {{ old('featured', $product->featured) == 1 ? 'selected' : '' }}>Yes</option>
                            </select>
                            @error('featured')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-lg-4">
                            <label class="form-label">Product Status</label>
                            <select name="status" class="form-select">
                                <option value="1" {{ old('status', $product->status) == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('status', $product->status) == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    {{-- ================= HOME PAGE SECTIONS ================= --}}
                    <div class="section-title">Home Page Sections</div>
                    <div class="row g-4">
                        <div class="col-lg-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="top_selling" value="1" id="topSelling" {{ old('top_selling', $product->top_selling) ? 'checked' : '' }}>
                                <label class="form-check-label" for="topSelling">Top Selling</label>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="trending_product" value="1" id="trendingProduct" {{ old('trending_product', $product->trending_product) ? 'checked' : '' }}>
                                <label class="form-check-label" for="trendingProduct">Trending Product</label>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="hot_deal" value="1" id="hotDeal" {{ old('hot_deal', $product->hot_deal) ? 'checked' : '' }}>
                                <label class="form-check-label" for="hotDeal">Hot Deal</label>
                            </div>
                        </div>
                    </div>

                    {{-- ================= IMAGES ================= --}}
                    <div class="section-title">Images</div>
                    <div class="row g-4">

                        <div class="col-lg-4">
                            <label class="form-label">Add New Images</label>
                            <input type="file" id="productimage" name="productimage[]" class="form-control" multiple>
                            <small class="text-danger d-none" id="imageError"></small>
                            @error('productimage')
                                <small class="text-danger d-block">{{ $message }}</small>
                            @enderror
                            @error('productimage.*')
                                <small class="text-danger d-block">{{ $message }}</small>
                            @enderror
                            @error('replace_image.*')
                                <small class="text-danger d-block">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-lg-8">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <label class="form-label mb-0">Existing Images <small class="text-muted">(click image to replace)</small></label>
                                @if($product->productimage && count($product->productimage) > 0)
                                <div class="d-flex gap-2">
                                    <button type="button" id="toggleSelectMode" class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-check2-square me-1"></i> Select to Delete
                                    </button>
                                    <button type="button" id="deleteSelectedBtn" class="btn btn-sm btn-danger d-none" onclick="deleteSelectedImages({{ $product->id }})">
                                        <i class="bi bi-trash me-1"></i> Delete Selected (<span id="selectedCount">0</span>)
                                    </button>
                                </div>
                                @endif
                            </div>
                            <div class="d-flex gap-3 flex-wrap" id="imageContainer">
                                @if($product->productimage)
                                    @foreach($product->productimage as $imgIndex => $img)
                                        <div class="existing-image-item" id="imgWrapper{{ $imgIndex }}" onclick="handleImageClick(event, {{ $imgIndex }}, '{{ $img }}')" data-img-path="{{ $img }}">
                                            <div class="delete-btn single-delete-btn" onclick="deleteProductImage(event, {{ $product->id }}, '{{ $img }}', this)" title="Remove image"><i class="bi bi-x"></i></div>
                                            <div class="select-checkbox d-none" style="position:absolute;top:4px;right:4px;z-index:11;">
                                                <input type="checkbox" class="img-select-cb form-check-input" data-img-path="{{ $img }}" style="width:18px;height:18px;cursor:pointer;" onclick="event.stopPropagation();updateSelectedCount();">
                                            </div>
                                            <img src="{{ asset($img) }}" id="previewImage{{ $imgIndex }}">
                                            <div class="edit-overlay"><i class="bi bi-pencil-fill"></i> Edit</div>
                                            <div class="replace-badge"><i class="bi bi-check"></i></div>
                                            <input type="file"
                                                   name="replace_image[{{ $imgIndex }}]"
                                                   id="replaceImage{{ $imgIndex }}"
                                                   accept="image/*"
                                                   style="display:none"
                                                   onchange="previewReplaceImage(this, {{ $imgIndex }})">
                                        </div>
                                    @endforeach
                                @else
                                    <p class="text-muted">No images yet</p>
                                @endif
                            </div>
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
                                @if(count($product->specifications) > 0)
                                    @foreach($product->specifications as $sIndex => $spec)
                                        <tr>
                                            <td><input type="text" name="specifications[{{ $sIndex }}][key]" class="form-control" value="{{ $spec->spec_key }}"></td>
                                            <td><input type="text" name="specifications[{{ $sIndex }}][value]" class="form-control" value="{{ $spec->spec_value }}"></td>
                                            <td>
                                                @if($loop->first)
                                                    <button type="button" class="btn btn-success addSpecRow">+</button>
                                                @else
                                                    <button type="button" class="btn btn-danger removeSpecRow">-</button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td><input type="text" name="specifications[0][key]" class="form-control" placeholder="e.g. Height"></td>
                                        <td><input type="text" name="specifications[0][value]" class="form-control" placeholder="e.g. 10cm"></td>
                                        <td><button type="button" class="btn btn-success addSpecRow">+</button></td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    {{-- ================= ROW 5: Variants ================= --}}
                    <div class="section-title">Product Variants (Weight Wise)</div>
                    <div class="row g-4">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-hover variant-table" id="variantTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 15%;">Variant (Unit - Pieces/Weight)</th>
                                            <th style="width: 12%;">MRP</th>
                                            <th style="width: 12%;">Selling Price</th>
                                            <th style="width: 10%;">Stock</th>
                                            <th style="width: 15%;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(old('variants'))
                                            @foreach(old('variants') as $index => $variant)
                                                <tr>
                                                    <td>
                                                        <select name="variants[{{ $index }}][quantity_id]"
                                                            class="form-select form-select-sm" required>
                                                            <option value="">Select</option>
                                                            @foreach($quantities as $q)
                                                                <option value="{{ $q->id }}" {{ $variant['quantity_id'] == $q->id ? 'selected' : '' }}>{{ $q->name }}{{ $q->label ? ' – ' . $q->label : '' }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error("variants.$index.quantity_id") <small class="text-danger">{{ $message }}</small> @enderror
                                                    </td>
                                                    <td>
                                                        <input type="number" step="0.01" name="variants[{{ $index }}][price]"
                                                            class="form-control form-control-sm" value="{{ $variant['price'] }}"
                                                            required>
                                                        @error("variants.$index.price") <small class="text-danger">{{ $message }}</small> @enderror
                                                    </td>
                                                    <td>
                                                        <input type="number" step="0.01" name="variants[{{ $index }}][sell_price]"
                                                            class="form-control form-control-sm" value="{{ $variant['sell_price'] }}"
                                                            required>
                                                        @error("variants.$index.sell_price") <small class="text-danger">{{ $message }}</small> @enderror
                                                    </td>
                                                    <td>
                                                        <input type="number" name="variants[{{ $index }}][stock]"
                                                            class="form-control form-control-sm" value="{{ $variant['stock'] }}"
                                                            required>
                                                        @error("variants.$index.stock") <small class="text-danger">{{ $message }}</small> @enderror
                                                    </td>
                                                    <td>
                                                        @if($index == 0)
                                                            <button type="button"
                                                                class="btn btn-success btn-sm-custom addRow">+</button>
                                                        @else
                                                            <button type="button"
                                                                class="btn btn-danger btn-sm-custom removeRow">-</button>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            @foreach($product->variants as $index => $variant)
                                                <tr>
                                                    <td>
                                                        <select name="variants[{{ $index }}][quantity_id]"
                                                            class="form-select form-select-sm" required>
                                                            <option value="">Select</option>
                                                            @foreach($quantities as $q)
                                                                <option value="{{ $q->id }}" {{ $variant->quantity_id == $q->id ? 'selected' : '' }}>{{ $q->name }}{{ $q->label ? ' – ' . $q->label : '' }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="number" step="0.01" name="variants[{{ $index }}][price]"
                                                            class="form-control form-control-sm" value="{{ $variant->price }}"
                                                            required>
                                                    </td>
                                                    <td>
                                                        <input type="number" step="0.01" name="variants[{{ $index }}][sell_price]"
                                                            class="form-control form-control-sm" value="{{ $variant->sell_price }}"
                                                            required>
                                                    </td>
                                                    <td>
                                                        <input type="number" name="variants[{{ $index }}][stock]"
                                                            class="form-control form-control-sm" value="{{ $variant->stock }}"
                                                            required>
                                                    </td>
                                                    <td>
                                                        @if($index == 0)
                                                            <button type="button"
                                                                class="btn btn-success btn-sm-custom addRow">+</button>
                                                        @else
                                                            <button type="button"
                                                                class="btn btn-danger btn-sm-custom removeRow">-</button>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>



                    {{-- ================= SEO ================= --}}
                    <div class="section-title">SEO</div>
                    <div class="row g-4">
                        <div class="col-lg-4">
                            <label class="form-label">SEO Title</label>
                            <input type="text" name="seo_title" class="form-control"
                                value="{{ old('seo_title', $product->seo_title) }}">
                        </div>

                        <div class="col-lg-4">
                            <label class="form-label">SEO Keywords</label>
                            <input type="text" name="seo_keywords" class="form-control"
                                value="{{ old('seo_keywords', $product->seo_keywords) }}">
                        </div>

                        <div class="col-lg-4">
                            <label class="form-label">SEO Description</label>
                            <input type="text" name="seo_description" class="form-control"
                                value="{{ old('seo_description', $product->seo_description) }}">
                        </div>


                    </div>

                    {{-- ================= ORDER BY ================= --}}
                    <div class="section-title">Display Order</div>
                    <div class="row g-4">
                        <div class="col-lg-4">
                            <label class="form-label">Order By</label>
                            <input type="number" name="orderby" class="form-control"
                                value="{{ old('orderby', $product->orderby) }}" placeholder="Enter order number (1, 2, 3...)" min="1">
                            <small class="text-muted d-block mt-1">Controls display order <strong>within the same category</strong>. Lower numbers appear first. Must be unique per category.</small>
                            @error('orderby') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>

                    <div class="mt-4">
                        <button class="btn btn-primary px-4">Update Product</button>
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
        let rowIndex = {{ count($product->variants) }};
        let specIndex = {{ count($product->specifications) }};
        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('addRow')) {
                e.preventDefault();
                let tr = e.target.closest('tr');
                let clone = tr.cloneNode(true);

                clone.querySelectorAll('input, select').forEach(el => {
                    el.name = el.name.replace(/\d+/, rowIndex);
                    el.value = '';
                });

                clone.querySelector('.addRow').outerHTML = '<button type="button" class="btn btn-danger btn-sm-custom removeRow">-</button>';

                document.querySelector('#variantTable tbody').appendChild(clone);
                rowIndex++;
            }

            if (e.target.classList.contains('removeRow')) {
                e.preventDefault();
                e.target.closest('tr').remove();
            }

            if (e.target.classList.contains('addSpecRow')) {
                e.preventDefault();
                let tr = e.target.closest('tr');
                let clone = tr.cloneNode(true);

                clone.querySelectorAll('input').forEach(el => {
                    el.name = el.name.replace(/\d+/, specIndex);
                    el.value = '';
                });

                let btn = clone.querySelector('.addSpecRow');
                if(btn){
                     btn.className = 'btn btn-danger btn-sm-custom removeSpecRow';
                     btn.innerText = '-';
                }

                document.querySelector('#specTable tbody').appendChild(clone);
                specIndex++;
            }

            if (e.target.classList.contains('removeSpecRow')) {
                e.preventDefault();
                e.target.closest('tr').remove();
            }
        });
        // Preview replacement image
        function previewReplaceImage(input, index) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('previewImage' + index).src = e.target.result;
                    input.closest('.existing-image-item').classList.add('replaced');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        
        // ─── Single image delete via AJAX ───────────────────────────
        function deleteProductImage(event, productId, imagePath, btnElement) {
            event.stopPropagation();
            if (!confirm('Are you sure you want to delete this image?')) return;
            
            let csrf = document.querySelector('input[name="_token"]')?.value;
            
            fetch(`{{ url('product') }}/${productId}/image`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf || '{{ csrf_token() }}'
                },
                body: JSON.stringify({ image_path: imagePath })
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    btnElement.closest('.existing-image-item').remove();
                    if (typeof toastr !== 'undefined') toastr.success(data.message);
                } else {
                    alert(data.message || 'Error deleting image');
                }
            })
            .catch(err => {
                console.error(err);
                alert('Failed to delete image');
            });
        }

        // ─── Multi-select image delete ────────────────────────────────
        let selectModeActive = false;

        document.getElementById('toggleSelectMode')?.addEventListener('click', function() {
            selectModeActive = !selectModeActive;
            const checkboxes = document.querySelectorAll('.select-checkbox');
            const singleDeleteBtns = document.querySelectorAll('.single-delete-btn');
            const deleteSelectedBtn = document.getElementById('deleteSelectedBtn');

            checkboxes.forEach(cb => {
                cb.classList.toggle('d-none', !selectModeActive);
                // Uncheck when deactivating
                if (!selectModeActive) cb.querySelector('input').checked = false;
            });
            singleDeleteBtns.forEach(btn => btn.classList.toggle('d-none', selectModeActive));

            this.innerHTML = selectModeActive
                ? '<i class="bi bi-x-circle me-1"></i> Cancel'
                : '<i class="bi bi-check2-square me-1"></i> Select to Delete';
            this.classList.toggle('btn-outline-secondary', !selectModeActive);
            this.classList.toggle('btn-outline-warning', selectModeActive);

            if (!selectModeActive) {
                deleteSelectedBtn?.classList.add('d-none');
                document.getElementById('selectedCount').textContent = '0';
            }
            updateSelectedCount();
        });

        function updateSelectedCount() {
            const checked = document.querySelectorAll('.img-select-cb:checked').length;
            document.getElementById('selectedCount').textContent = checked;
            const deleteBtn = document.getElementById('deleteSelectedBtn');
            if (deleteBtn) {
                deleteBtn.classList.toggle('d-none', checked === 0);
            }
        }

        function handleImageClick(event, index, imgPath) {
            if (selectModeActive) {
                // In select mode, toggle checkbox
                event.stopPropagation();
                const cb = document.querySelector(`#imgWrapper${index} .img-select-cb`);
                if (cb) { cb.checked = !cb.checked; updateSelectedCount(); }
            } else {
                // Normal mode: click to replace
                document.getElementById('replaceImage' + index)?.click();
            }
        }

        function deleteSelectedImages(productId) {
            const checked = document.querySelectorAll('.img-select-cb:checked');
            if (checked.length === 0) return;
            if (!confirm(`Delete ${checked.length} selected image(s)? This cannot be undone.`)) return;

            const imagePaths = Array.from(checked).map(cb => cb.getAttribute('data-img-path'));
            const csrf = document.querySelector('input[name="_token"]')?.value;

            fetch(`{{ url('product') }}/${productId}/images`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf || '{{ csrf_token() }}'
                },
                body: JSON.stringify({ image_paths: imagePaths })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    checked.forEach(cb => cb.closest('.existing-image-item').remove());
                    if (typeof toastr !== 'undefined') toastr.success(data.message);
                    else alert(data.message);
                    // Reset select mode
                    selectModeActive = false;
                    document.getElementById('toggleSelectMode').click();
                } else {
                    alert(data.message || 'Error deleting images');
                }
            })
            .catch(err => {
                console.error(err);
                alert('Failed to delete images');
            });
        }
        document.getElementById('productForm').addEventListener('submit', function (e) {
            let valid = true;
            const name = document.getElementById('productname');
            const sku = document.getElementById('sku');

            if (!name.value.trim()) {
                name.classList.add('is-invalid');
                document.getElementById('productnameError').classList.remove('d-none');
                valid = false;
            } else {
                name.classList.remove('is-invalid');
                document.getElementById('productnameError').classList.add('d-none');
            }

            if (!sku.value.trim()) {
                sku.classList.add('is-invalid');
                document.getElementById('skuError').classList.remove('d-none');
                valid = false;
            } else {
                sku.classList.remove('is-invalid');
                document.getElementById('skuError').classList.add('d-none');
            }

            const imageInput = document.getElementById('productimage');
            const imageError = document.getElementById('imageError');
            if (imageInput) {
                const existingCount = document.querySelectorAll('#imageContainer .existing-image-item').length;
                const newCount = imageInput.files.length;
                if (existingCount + newCount > 5) {
                    imageError.textContent = `You can only add up to ${5 - existingCount} more image(s). (Max 5 total images)`;
                    imageError.classList.remove('d-none');
                    imageInput.classList.add('is-invalid');
                    valid = false;
                } else {
                    imageError.classList.add('d-none');
                    imageInput.classList.remove('is-invalid');
                }
            }

            if (!valid) {
                e.preventDefault();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        });

        // Clear validation errors when typing
        document.getElementById('productname').addEventListener('input', function () {
            this.classList.remove('is-invalid');
            document.getElementById('productnameError').classList.add('d-none');
        });

        document.getElementById('sku').addEventListener('input', function () {
            this.classList.remove('is-invalid');
            document.getElementById('skuError').classList.add('d-none');
        });

        const imageInput = document.getElementById('productimage');
        const imageError = document.getElementById('imageError');
        if (imageInput) {
            imageInput.addEventListener('change', function () {
                const existingCount = document.querySelectorAll('#imageContainer .existing-image-item').length;
                const newCount = this.files.length;
                if (existingCount + newCount > 5) {
                    const maxAllowed = 5 - existingCount;
                    if (maxAllowed <= 0) {
                        imageError.textContent = 'You already have 5 images. Please delete some existing images first before adding new ones.';
                    } else {
                        imageError.textContent = `You can only add up to ${maxAllowed} more image(s). (Max 5 total images)`;
                    }
                    imageError.classList.remove('d-none');
                    this.classList.add('is-invalid');
                    this.value = ''; // Clear selected files
                } else {
                    imageError.classList.add('d-none');
                    this.classList.remove('is-invalid');
                }
            });
        }
    </script>


@endsection