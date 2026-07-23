@extends('layouts.app')
@section('content')
  @include('includes.alert')
  <section class="content-main">

    <div class="content-header">
      <div>
        <h2 class="content-title card-title">Product List</h2>
      </div>
      <div>
        @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('products-create'))
        <a href="{{ route('product.create') }}" class="btn btn-primary btn-sm rounded">
<i class="bi bi-plus-circle me-1"></i> Add New</a>
        @endif
      </div>
    </div>
    <div class="card mb-4">
      <header class="card-header">
        <form method="GET" action="{{ route('product.table') }}" class="w-100">
          <div class="row gx-3 align-items-center">
            <div class="col-md-4 col-12">
              <input type="text" name="search" placeholder="Search..." class="form-control" value="{{ $search ?? '' }}" />
            </div>
            <div class="col-md-2 col-6">
              <select name="status" class="form-select" onchange="this.form.submit()">
                <option value="">Status - All</option>
                <option value="1" {{ (isset($status) && $status == '1') ? 'selected' : '' }}>Active</option>
                <option value="0" {{ (isset($status) && $status == '0') ? 'selected' : '' }}>Inactive</option>
              </select>
            </div>
            <div class="col-md-2 col-6">
              <button type="submit" class="btn btn-primary w-100">
<i class="bi bi-search me-1"></i> Search</button>
            </div>
            @if((isset($search) && $search) || (isset($status) && $status !== ''))
              <div class="col-md-2 col-6">
                <a href="{{ route('product.table') }}" class="btn btn-secondary w-100">
<i class="bi bi-eraser me-1"></i> Clear</a>
              </div>
            @endif
          </div>
        </form>
      </header>
      <div class="card-body">
        <table class="table table-hover align-middle">
          <thead class="table-light">
            <tr>
              <th>No.</th>
              <th>Product Image</th>
              <th>Product Name</th>
              <th>Sell Price</th>
              <th>Order By</th>
              <th>Last Update</th>
              <th>Product Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($products as $index => $product)
              <tr>
                <td>{{ ($products->currentPage() - 1) * $products->perPage() + $index + 1 }}</td>

                <!-- Product Image Column -->
                <td>
                  @if($product->first_image)
                    <img src="{{ asset($product->first_image) }}" alt="{{ $product->productname }}" width="40" height="40"
                      class="rounded-circle" style="object-fit: cover;">
                  @else
                    <span class="text-muted">No Image</span>
                  @endif
                </td>

                <td>
                  <a href="{{ route('product.view', $product->id) }}">
                    {{ $product->productname }}
                  </a>
                </td>
                <td class="text-end">₹{{ $product->sell_price ?? '0' }}</td>
                <td>{{ $product->orderby ?? '—' }}</td>
                {{-- Last Update Info --}}
                <td id="last-update-{{ $product->id }}">
                  @if($product->latestStockUpdate && $product->latestStockUpdate->stock_updated_at)
                  <div class="text-muted" style="font-size: 0.75rem;">
                      <div class="d-flex align-items-center mb-1">
                          <i class="material-icons md-person font-xs me-1"></i>
                          {{ $product->latestStockUpdate->stockUpdater->username ?? $product->latestStockUpdate->stockUpdater->name ?? 'Admin' }}
                      </div>
                      <div class="d-flex align-items-center">
                          <i class="material-icons md-access_time font-xs me-1"></i>
                          {{ \Carbon\Carbon::parse($product->latestStockUpdate->stock_updated_at)->format('d M, h:i A') }}
                      </div>
                  </div>
                  @else
                    <span class="text-muted small">N/A</span>
                  @endif
                </td>

                <td>
                  @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('products-edit'))
                  <form action="{{ route('product.toggle', $product->id) }}" method="POST" style="display:inline-block;"
                    onsubmit="return confirm('Are you sure you want to change the status of this product?');">
                    @csrf
                    @method('PATCH')

                    @if($product->status == 1)
                      <button type="submit" class="badge rounded-pill bg-success">
<i class="bi bi-check-circle me-1"></i> Active</button>
                    @else
                      <button type="submit" class="badge rounded-pill bg-danger">
<i class="bi bi-x-circle me-1"></i> Inactive</button>
                    @endif
                  </form>
                  @else
                    @if($product->status == 1)
                      <span class="badge rounded-pill bg-success">
<i class="bi bi-check-circle me-1"></i> Active</span>
                    @else
                      <span class="badge rounded-pill bg-danger">
<i class="bi bi-x-circle me-1"></i> Inactive</span>
                    @endif
                  @endif
                </td>

                <td>
                  <div class="d-inline-flex gap-1 align-items-center flex-wrap">
                    @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('products-edit'))
                    <a href="{{ route('product.edit', $product->id) }}" class="btn btn-sm btn-warning"> <i class="bi bi-pencil-square me-1"></i> Edit</a>
                    @endif
                    @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('products-delete'))
                    <form action="{{ route('product.destroy', $product->id) }}" method="POST" style="margin: 0;"
                      onsubmit="return confirm('Are you sure you want to delete this product? This action cannot be undone.');">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-danger btn-action-col d-inline-flex align-items-center justify-content-center "><i class="bi bi-trash me-1"></i> Delete</button>
                    </form>
                    @endif
                    <button class="btn btn-sm btn-info text-white view-units" data-product-id="{{ $product->id }}">
                      <i class="bi bi-speedometer2 me-1"></i> Units
                    </button>
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    </div>
    <div class="pagination-area mt-30 mb-50">
      <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-start">
          {{-- Previous Page Link --}}
          @if ($products->onFirstPage())
            <li class="page-item disabled">
              <span class="page-link">&laquo;</span>
            </li>
          @else
            <li class="page-item">
              <a class="page-link" href="{{ $products->appends(request()->query())->previousPageUrl() }}"
                aria-label="Previous">
                &laquo;
              </a>
            </li>
          @endif

          {{-- Pagination Elements --}}
          @foreach ($products->appends(request()->query())->getUrlRange(1, $products->lastPage()) as $page => $url)
            @if ($page == $products->currentPage())
              <li class="page-item active">
                <a class="page-link" href="#">{{ str_pad($page, 2, '0', STR_PAD_LEFT) }}</a>
              </li>
            @else
              @if ($page == 1 || $page == $products->lastPage() || abs($page - $products->currentPage()) <= 1)
                <li class="page-item">
                  <a class="page-link"
                    href="{{ $url }}">{{ str_pad($page, 2, '0', STR_PAD_LEFT) }}</a>
                </li>
              @elseif (abs($page - $products->currentPage()) == 2)
                <li class="page-item disabled">
                  <span class="page-link dot">...</span>
                </li>
              @endif
            @endif
          @endforeach

          {{-- Next Page Link --}}
          @if ($products->hasMorePages())
            <li class="page-item">
              <a class="page-link" href="{{ $products->appends(request()->query())->nextPageUrl() }}" aria-label="Next">
                &raquo;
              </a>
            </li>
          @else
            <li class="page-item disabled">
              <span class="page-link">&raquo;</span>
            </li>
          @endif
        </ul>
      </nav>
    </div>
  </section>
  <div class="modal fade" id="unitsModal" tabindex="-1" aria-labelledby="unitsModalLabel" aria-hidden="true"
    style="z-index: 1055 !important;">
    <div class="modal-dialog modal-lg" style="z-index: 1056 !important; position: relative;">
      <div class="modal-content" style="pointer-events: auto !important; z-index: 1057 !important;">
        <div class="modal-header" style="pointer-events: auto !important;">
          <h5 class="modal-title" id="unitsModalLabel">Product Variants (Weight Wise)</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeUnitsModal()"
            style="pointer-events: auto !important; z-index: 1060 !important; cursor: pointer;"></button>
        </div>

        <div class="modal-body" style="pointer-events: auto !important;">
          <table class="table table-bordered" style="pointer-events: auto !important;">
            <thead class="table-light">
              <tr>
                <th>Variant (Unit - Pieces/Weight)</th>
                <th>MRP</th>
                <th>Selling Price</th>
                <th>Stock</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody id="unitsTableBody">
              <tr>
                <td colspan="5" class="text-center">Loading...</td>
              </tr>
            </tbody>
          </table>
          <div class="d-flex justify-content-end">
            <button id="saveVariantBtn" class="btn btn-primary btn-sm d-none"
              style="pointer-events: auto !important; z-index: 1060 !important;"><i class="bi bi-save me-1"></i> Save</button>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@push('scripts')
  <style>
    /* Fix modal z-index and clickability - CRITICAL FIX */
    #unitsModal {
      z-index: 1055 !important;
    }

    #unitsModal.show {
      z-index: 1055 !important;
    }

    .modal-backdrop {
      z-index: 1050 !important;
    }

    #unitsModal .modal-dialog {
      z-index: 1056 !important;
      position: relative;
      pointer-events: auto !important;
    }

    #unitsModal .modal-content {
      position: relative;
      z-index: 1057 !important;
      pointer-events: auto !important;
    }

    #unitsModal .modal-header,
    #unitsModal .modal-body,
    #unitsModal .modal-footer {
      pointer-events: auto !important;
      position: relative;
      z-index: 1058 !important;
    }

    #unitsModal .btn-close,
    #unitsModal .btn-add-variant-row,
    #unitsModal .btn-delete-variant,
    #unitsModal .btn-save-variant,
    #unitsModal .btn-cancel-variant,
    #unitsModal .stock-spinner-up,
    #unitsModal .stock-spinner-down,
    #unitsModal #saveVariantBtn,
    #unitsModal .btn {
      cursor: pointer !important;
      pointer-events: auto !important;
      z-index: 1060 !important;
      position: relative;
    }

    #unitsModal .stock-spinner-buttons {
      pointer-events: auto !important;
    }

    #unitsModal input,
    #unitsModal select {
      pointer-events: auto !important;
      position: relative;
      z-index: 1059 !important;
    }

    #unitsModal table,
    #unitsModal tbody,
    #unitsModal tr,
    #unitsModal td {
      pointer-events: auto !important;
    }
  </style>
  <script>
    // Track current product to update main table row
    let currentOpeningProductId = null;

    // Close modal function
    function closeUnitsModal() {
      let modal = document.getElementById('unitsModal');
      let bsModal = bootstrap.Modal.getInstance(modal);
      if (bsModal) {
        bsModal.hide();
      }
    }

    // preload quantities for select options
    const quantityOptions = @json($quantities ?? []);
    const saveButton = document.getElementById('saveVariantBtn');

    // Open modal and load variants
    document.addEventListener('click', function (e) {
      if (e.target.classList.contains('view-units') || e.target.parentElement.classList.contains('view-units')) {
        let button = e.target.classList.contains('view-units') ? e.target : e.target.parentElement;
        let productId = button.dataset.productId;
        currentOpeningProductId = productId; // Store for sync
        let tbody = document.getElementById('unitsTableBody');

        tbody.innerHTML = `<tr><td colspan="5" class="text-center">Loading...</td></tr>`;
        new bootstrap.Modal(document.getElementById('unitsModal')).show();

        let unitsUrl = `{{ route('product.units', ':id') }}`.replace(':id', productId);

        fetch(unitsUrl)
          .then(res => {
            if (!res.ok) throw new Error(`HTTP error! status: ${res.status}`);
            return res.json();
          })
          .then(data => {
            tbody.innerHTML = '';
            if (!data || data.length === 0) {
              tbody.innerHTML = `<tr><td colspan="5" class="text-center">No units found</td></tr>`;
              return;
            }

            data.forEach(row => {
              let pkt = row.quantity && row.quantity.name ? row.quantity.name : '';
              let pcs = row.quantity && row.quantity.label ? row.quantity.label : '';
              let weight = pkt;
              if (pcs) weight = weight ? (weight + ' - ' + pcs) : pcs;
              if (!weight) weight = 'N/A';
              let mrp = row.price ? parseFloat(row.price).toFixed(2) : '0.00';
              let sellingPrice = row.sell_price ? parseFloat(row.sell_price).toFixed(2) : '0.00';
              let stock = row.stock || '0';

              tbody.innerHTML += `
                <tr data-variant-id="${row.id}">
                  <td>${weight}</td>
                  <td class="text-end">₹${mrp}</td>
                  <td class="text-end">₹${sellingPrice}</td>
                  <td>
                    <div class="stock-input-wrapper" style="position: relative; display: inline-block; width: 90px;">
                      <input type="number" class="form-control form-control-sm variant-stock-input" 
                             value="${stock}" min="0" 
                             data-variant-id="${row.id}"
                             style="padding-right: 22px; text-align: left;">
                      <div class="stock-spinner-buttons" style="position: absolute; right: 1px; top: 1px; bottom: 1px; width: 20px; display: flex; flex-direction: column; border-left: 1px solid #dee2e6; pointer-events: none;">
                        <button type="button" class="stock-spinner-up" data-variant-id="${row.id}" style="border: none; background: #f8f9fa; padding: 0; flex: 1; cursor: pointer; font-size: 9px; line-height: 1; color: #495057; pointer-events: auto; display: flex; align-items: center; justify-content: center; border-bottom: 1px solid #dee2e6;">▲</button>
                        <button type="button" class="stock-spinner-down" data-variant-id="${row.id}" style="border: none; background: #f8f9fa; padding: 0; flex: 1; cursor: pointer; font-size: 9px; line-height: 1; color: #495057; pointer-events: auto; display: flex; align-items: center; justify-content: center;">▼</button>
                      </div>
                    </div>
                  </td>
                  <td class="text-center">
                    <div class="d-flex justify-content-center align-items-center gap-2">
                      <button class="btn btn-sm btn-success btn-add-variant-row" data-product-id="${productId}" style="width: 95px !important; height: 34px !important; font-size: 14px !important; padding: 0 10px !important; font-weight: 500; border-radius: 6px; display: inline-flex; align-items: center; justify-content: center; gap: 4px;"><span>+</span> Add</button>
                      <button class="btn btn-sm btn-danger btn-delete-variant" data-variant-id="${row.id}" data-product-id="${productId}" style="width: 95px !important; height: 34px !important; font-size: 14px !important; padding: 0 10px !important; font-weight: 500; border-radius: 6px; display: inline-flex; align-items: center; justify-content: center; gap: 4px;"><span>−</span> Remove</button>
                    </div>
                  </td>
                </tr>
              `;
            });
            if (saveButton) saveButton.classList.add('d-none');
          })
          .catch(error => {
            console.error('Error fetching units:', error);
            tbody.innerHTML = `<tr><td colspan="5" class="text-center text-danger">Error loading data</td></tr>`;
          });
      }
    });

    // Add a blank editable row for new variant
    document.addEventListener('click', function (e) {
      if (e.target.classList.contains('btn-add-variant-row')) {
        let productId = e.target.dataset.productId;
        let tbody = document.getElementById('unitsTableBody');

        // remove any existing draft row
        let existingNewRow = tbody.querySelector('.new-variant-row');
        if (existingNewRow) existingNewRow.remove();

        let optionsHtml = quantityOptions.map(q => `<option value="${q.id}">${q.label || q.name}</option>`).join('');

        let newRow = document.createElement('tr');
        newRow.classList.add('new-variant-row');
        newRow.innerHTML = `
          <td><select class="form-select form-select-sm variant-quantity"><option value="">Select</option>${optionsHtml}</select></td>
          <td><input type="number" step="0.01" min="0" class="form-control form-control-sm variant-mrp" placeholder="MRP"></td>
          <td><input type="number" step="0.01" min="0" class="form-control form-control-sm variant-sell" placeholder="Selling Price"></td>
          <td><input type="number" step="1" min="0" class="form-control form-control-sm variant-stock" placeholder="Stock"></td>
          <td class="text-center">
            <div class="d-flex justify-content-center align-items-center gap-2">
              <button class="btn btn-sm btn-success btn-save-variant" data-product-id="${productId}" style="width: 95px !important; height: 34px !important; font-size: 14px !important; padding: 0 10px !important; font-weight: 500; border-radius: 6px; display: inline-flex; align-items: center; justify-content: center; gap: 4px;"><span>+</span> Add</button>
              <button class="btn btn-sm btn-danger btn-cancel-variant" style="width: 95px !important; height: 34px !important; font-size: 14px !important; padding: 0 10px !important; font-weight: 500; border-radius: 6px; display: inline-flex; align-items: center; justify-content: center; gap: 4px;"><span>−</span> Remove</button>
            </div>
          </td>
        `;

        tbody.appendChild(newRow);
        if (saveButton) saveButton.classList.remove('d-none');
      }
    });

    // Cancel new row (red minus in editable row)
    document.addEventListener('click', function (e) {
      if (e.target.classList.contains('btn-cancel-variant')) {
        let row = e.target.closest('tr.new-variant-row');
        if (row) row.remove();
        if (saveButton) saveButton.classList.add('d-none');
      }
    });

    // Save new variant (green plus in editable row)
    document.addEventListener('click', function (e) {
      if (e.target.classList.contains('btn-save-variant')) {
        saveDraftVariant();
      }
    });

    // Delete variant (red minus on existing row)
    document.addEventListener('click', function (e) {
      if (e.target.classList.contains('btn-delete-variant')) {
        if (!confirm('Delete this variant?')) return;

        let variantId = e.target.dataset.variantId;
        let productId = e.target.dataset.productId;
        let csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

        fetch(`{{ route('product.variant.delete', ':id') }}`.replace(':id', variantId), {
          method: 'DELETE',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrf
          },
          body: JSON.stringify({ product_id: productId })
        })
          .then(async res => {
            const json = await res.json();
            if (!res.ok || !json.success) throw new Error(json.message || 'Failed to delete variant');
            return json;
          })
          .then(() => {
            let row = e.target.closest('tr');
            if (row) row.remove();
            
            if (typeof toastr !== 'undefined') {
                toastr.success('Variant deleted successfully');
            }
          })
          .catch(err => {
            console.error('Error deleting variant:', err);
            alert(err.message || 'Failed to delete variant. Please try again.');
          });
      }
    });

    // Global Save button handler
    if (saveButton) {
      saveButton.addEventListener('click', function () {
        saveDraftVariant();
      });
    }

    function saveDraftVariant() {
      let row = document.querySelector('.new-variant-row');
      if (!row) return;
      let productId = row.querySelector('.btn-save-variant')?.dataset.productId;
      let csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

      let quantityId = row.querySelector('.variant-quantity').value;
      let mrp = row.querySelector('.variant-mrp').value;
      let sell = row.querySelector('.variant-sell').value;
      let stock = row.querySelector('.variant-stock').value;

      fetch(`{{ route('product.variant.store', ':id') }}`.replace(':id', productId), {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': csrf
        },
        body: JSON.stringify({
          quantity_id: quantityId,
          price: mrp,
          sell_price: sell,
          stock: stock
        })
      })
        .then(async res => {
          const json = await res.json();
          if (!res.ok || !json.success) throw new Error(json.message || 'Failed to add variant');
          return json.variant;
        })
        .then(variant => {
          let tbody = row.parentElement;
          row.remove();
          if (saveButton) saveButton.classList.add('d-none');

          let pkt = variant.quantity && variant.quantity.name ? variant.quantity.name : '';
          let pcs = variant.quantity && variant.quantity.label ? variant.quantity.label : '';
          let weight = pkt;
          if (pcs) weight = weight ? (weight + ' - ' + pcs) : pcs;
          if (!weight) weight = 'N/A';
          let mrpVal = variant.price ? parseFloat(variant.price).toFixed(2) : '0.00';
          let sellVal = variant.sell_price ? parseFloat(variant.sell_price).toFixed(2) : '0.00';
          let stockVal = variant.stock || '0';

          let newDisplayRow = document.createElement('tr');
          newDisplayRow.setAttribute('data-variant-id', variant.id);
          newDisplayRow.innerHTML = `
            <td>${weight}</td>
            <td>₹${mrpVal}</td>
            <td>₹${sellVal}</td>
            <td>
              <div class="stock-input-wrapper" style="position: relative; display: inline-block; width: 90px;">
                <input type="number" class="form-control form-control-sm variant-stock-input" 
                       value="${stockVal}" min="0" 
                       data-variant-id="${variant.id}"
                       style="padding-right: 22px; text-align: left;">
                <div class="stock-spinner-buttons" style="position: absolute; right: 1px; top: 1px; bottom: 1px; width: 20px; display: flex; flex-direction: column; border-left: 1px solid #dee2e6; pointer-events: none;">
                  <button type="button" class="stock-spinner-up" data-variant-id="${variant.id}" style="border: none; background: #f8f9fa; padding: 0; flex: 1; cursor: pointer; font-size: 9px; line-height: 1; color: #495057; pointer-events: auto; display: flex; align-items: center; justify-content: center; border-bottom: 1px solid #dee2e6;">▲</button>
                  <button type="button" class="stock-spinner-down" data-variant-id="${variant.id}" style="border: none; background: #f8f9fa; padding: 0; flex: 1; cursor: pointer; font-size: 9px; line-height: 1; color: #495057; pointer-events: auto; display: flex; align-items: center; justify-content: center;">▼</button>
                </div>
              </div>
            </td>
            <td class="text-center">
              <div class="d-flex justify-content-center align-items-center gap-2">
                <button class="btn btn-sm btn-success btn-add-variant-row" data-product-id="${productId}" style="width: 95px !important; height: 34px !important; font-size: 14px !important; padding: 0 10px !important; font-weight: 500; border-radius: 6px; display: inline-flex; align-items: center; justify-content: center; gap: 4px;"><span>+</span> Add</button>
                <button class="btn btn-sm btn-danger btn-delete-variant" data-variant-id="${variant.id}" data-product-id="${productId}" style="width: 95px !important; height: 34px !important; font-size: 14px !important; padding: 0 10px !important; font-weight: 500; border-radius: 6px; display: inline-flex; align-items: center; justify-content: center; gap: 4px;"><span>−</span> Remove</button>
              </div>
            </td>
          `;
          tbody.appendChild(newDisplayRow);
          
          if (typeof toastr !== 'undefined') {
              toastr.success('Variant added successfully');
          }
        })
        .catch(err => {
          console.error('Error saving variant:', err);
          alert(err.message || 'Failed to add variant. Please try again.');
        });
    }

    // Stock input change handler (when user types directly)
    document.addEventListener('change', function (e) {
      if (e.target.classList.contains('variant-stock-input')) {
        let variantId = e.target.dataset.variantId;
        let newStock = parseInt(e.target.value) || 0;
        if (newStock < 0) {
          newStock = 0;
          e.target.value = 0;
        }
        updateStock(variantId, newStock, e.target);
      }
    });

    // Stock input blur handler (when user leaves the field)
    document.addEventListener('blur', function (e) {
      if (e.target.classList.contains('variant-stock-input')) {
        let variantId = e.target.dataset.variantId;
        let newStock = parseInt(e.target.value) || 0;
        if (newStock < 0) {
          newStock = 0;
          e.target.value = 0;
        }
        updateStock(variantId, newStock, e.target);
      }
    }, true);

    // Increment stock handler (up arrow button)
    document.addEventListener('click', function (e) {
      if (e.target.classList.contains('stock-spinner-up')) {
        e.preventDefault();
        let variantId = e.target.dataset.variantId;
        let wrapper = e.target.closest('.stock-input-wrapper');
        let stockInput = wrapper.querySelector('.variant-stock-input');
        let currentStock = parseInt(stockInput.value) || 0;
        let newStock = currentStock + 1;
        stockInput.value = newStock;
        updateStock(variantId, newStock, stockInput);
      }
    });

    // Decrement stock handler (down arrow button)
    document.addEventListener('click', function (e) {
      if (e.target.classList.contains('stock-spinner-down')) {
        e.preventDefault();
        let variantId = e.target.dataset.variantId;
        let wrapper = e.target.closest('.stock-input-wrapper');
        let stockInput = wrapper.querySelector('.variant-stock-input');
        let currentStock = parseInt(stockInput.value) || 0;

        if (currentStock <= 0) {
          return;
        }

        let newStock = currentStock - 1;
        stockInput.value = newStock;
        updateStock(variantId, newStock, stockInput);
      }
    });

    function updateStock(variantId, newStock, stockInput) {
      let csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

      fetch(`{{ route('product.variant.stock.update', ':id') }}`.replace(':id', variantId), {
        method: 'PATCH',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': csrf
        },
        body: JSON.stringify({
          stock: newStock
        })
      })
        .then(async res => {
          const json = await res.json();
          if (!res.ok || !json.success) throw new Error(json.message || 'Failed to update stock');
          return json;
        })
        .then(data => {
          stockInput.value = data.stock;
          
          if (typeof toastr !== 'undefined') {
              toastr.options = {
                  "closeButton": true,
                  "progressBar": true,
                  "timeOut": "500",
                  "extendedTimeOut": "500",
                  "positionClass": "toast-top-right"
              };
              toastr.success('Product stock updated');
          }
          
          // Update main table row if we have the product ID
          if (currentOpeningProductId) {
              let updateCell = document.getElementById('last-update-' + currentOpeningProductId);
              if (updateCell) {
                  updateCell.innerHTML = `
                      <div class="text-muted" style="font-size: 0.75rem;">
                          <div class="d-flex align-items-center mb-1">
                              <i class="material-icons md-person font-xs me-1"></i>
                              ${data.updater}
                          </div>
                          <div class="d-flex align-items-center">
                              <i class="material-icons md-access_time font-xs me-1"></i>
                              ${data.updated_at}
                          </div>
                      </div>
                  `;
              }
          }
        })
        .catch(err => {
          console.error('Error updating stock:', err);
          alert(err.message || 'Failed to update stock. Please try again.');
          // Revert to previous value on error
          stockInput.value = stockInput.defaultValue || 0;
        });
    }
  </script>
@endpush
