@extends('layouts.app')
@section('content')
    @include('includes.alert')
<section class="content-main">
    <div class="content-header">
        <div>
            <h2 class="content-title card-title">Inventory</h2>
        </div>
        <div>
             @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('products-edit'))
             <button id="saveStock" class="btn btn-primary btn-sm rounded"><i class="bi bi-save me-1"></i> Save</button>
             @endif
            <a href="{{ route('product.inventory.table') }}" class="btn btn-secondary btn-sm rounded"><i class="bi bi-arrow-left me-1"></i> Back</a>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="card mb-4">
    <header class="card-header">
            <form method="GET" action="{{ route('product.inventory.table') }}" class="w-100">
                <div class="row gx-3 align-items-center">
                    <div class="col-md-4 col-12">
                        <input type="text" name="search" placeholder="Search..." class="form-control" value="{{ $search }}" />
                    </div>
                    <div class="col-md-2 col-6">
                        <select name="status" class="form-select" onchange="this.form.submit()">
                            <option value="">Status-All</option>
                            <option value="low" {{ request('status') == 'low' ? 'selected' : '' }}>Low Stock</option>
                        <option value="max" {{ request('status') == 'max' ? 'selected' : '' }}>Maximum Stock</option>
                        </select>
                    </div>
                    <div class="col-md-2 col-6">
                        <button type="submit" class="btn btn-primary w-100">
<i class="bi bi-search me-1"></i> Search</button>
                    </div>
                    @if($search || $status)
                    <div class="col-md-2 col-6">
                        <a href="{{ route('product.inventory.table') }}" class="btn btn-secondary w-100">
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
                <th>ID</th>
                <th>Product</th>
                <th>Weight</th>
                <th>MRP</th>
                <th>Selling Price</th>
                <th>Stock</th>
                <th>Last Update</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
           @foreach($variants as $variant)
      <tr data-id="{{ $variant->id }}" class="{{ $variant->stock < 10 ? 'low-stock' : '' }}">

    
    {{-- ID --}}
     <td>{{ ($variants->currentPage() - 1) * $variants->perPage() + $loop->iteration }}</td>

    {{-- product name from product_id --}}
    <td>{{ $variant->product->productname ?? '-' }}</td>

    {{-- Weight/Quantity --}}
    <td>{{ $variant->quantity->label ?? '-' }}</td>

    {{-- MRP Price --}}
    <td class="text-end">₹{{ number_format($variant->price, 2) }}</td>

    {{-- Selling Price --}}
    <td class="text-end">₹{{ number_format($variant->sell_price, 2) }}</td>

    {{-- STOCK - EDITABLE INPUT --}}
    <td>
        <div class="d-flex gap-2 align-items-center">
            <input type="number" class="form-control form-control-sm stock-input" 
                   value="{{ $variant->stock }}" min="0" style="width: 80px;" data-original="{{ $variant->stock }}">
            <span class="stock-status badge" style="display:none;"></span>
        </div>
    </td>
    
    {{-- LAST UPDATE --}}
    <td>
        @if($variant->stock_updated_at)
            <div class="small">
                <span class="text-muted d-inline-flex align-items-center gap-1" style="line-height:1;"><i class="material-icons md-person" style="font-size: 16px;"></i> {{ $variant->stockUpdater->username ?? $variant->stockUpdater->name ?? 'Admin' }}</span><br>
                <div style="height: 4px;"></div>
                <span class="text-muted d-inline-flex align-items-center gap-1" style="line-height:1;"><i class="material-icons md-access_time" style="font-size: 16px;"></i> {{ \Carbon\Carbon::parse($variant->stock_updated_at)->format('d M, h:i A') }}</span>
            </div>
        @else
            <span class="text-muted small">N/A</span>
        @endif
    </td>

    {{-- ACTION --}}
    <td>
        @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('products-edit'))
        <button type="button" class="btn btn-success btn-sm plus" title="Increase Stock" style="width: 95px !important; height: 34px !important; font-size: 14px !important; padding: 0 10px !important; font-weight: 500; border-radius: 6px; display: inline-flex; align-items: center; justify-content: center; gap: 4px;"><span>+</span> Add</button>
        <button type="button" class="btn btn-danger btn-sm minus" title="Decrease Stock" style="width: 95px !important; height: 34px !important; font-size: 14px !important; padding: 0 10px !important; font-weight: 500; border-radius: 6px; margin-left: 5px; display: inline-flex; align-items: center; justify-content: center; gap: 4px;"><span>−</span> Remove</button>
        @endif
    </td>
</tr>
@endforeach
    </tbody>
</thead>
</table>
</div>
</div>



<!-- Pagination -->
<div class="pagination-area mt-30 mb-50">
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-start">
                {{-- Previous Page Link --}}
                @if ($variants->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link">&laquo;</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $variants->appends(request()->query())->previousPageUrl() }}" aria-label="Previous">
                            &laquo;
                        </a>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($variants->appends(request()->query())->getUrlRange(1, $variants->lastPage()) as $page => $url)
                    @if ($page == $variants->currentPage())
                        <li class="page-item active">
                            <a class="page-link" href="#">{{ str_pad($page, 2, '0', STR_PAD_LEFT) }}</a>
                        </li>
                    @else
                        @if ($page == 1 || $page == $variants->lastPage() || abs($page - $variants->currentPage()) <= 1)
                            <li class="page-item">
                                <a class="page-link" href="{{ $url }}">{{ str_pad($page, 2, '0', STR_PAD_LEFT) }}</a>
                            </li>
                        @elseif (abs($page - $variants->currentPage()) == 2)
                            <li class="page-item disabled">
                                <span class="page-link dot">...</span>
                            </li>
                        @endif
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($variants->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $variants->appends(request()->query())->nextPageUrl() }}" aria-label="Next">
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

</div>
</section>
@endsection
<script>
// Check and display stock status (whether it will be removed after save)
function checkStockStatus(row) {
    let input = row.querySelector('.stock-input');
    let badge = row.querySelector('.stock-status');
    let val = parseInt(input.value) || 0;
    
    if (val >= 10) {
        badge.textContent = '✓ Will Remove';
        badge.className = 'stock-status badge bg-success';
        badge.style.display = 'inline-block';
        row.style.opacity = '0.6';
    } else {
        badge.style.display = 'none';
        row.style.opacity = '1';
    }
}

// Event delegation for Plus/Minus buttons - works even after page reload
document.addEventListener('click', function(e) {
    // Plus button
    if (e.target.classList.contains('plus')) {
        let row = e.target.closest('tr');
        let input = row.querySelector('.stock-input');
        let val = parseInt(input.value) || 0;
        val++;
        input.value = val;
        checkStockStatus(row);
    }
    
    // Minus button
    if (e.target.classList.contains('minus')) {
        let row = e.target.closest('tr');
        let input = row.querySelector('.stock-input');
        let val = parseInt(input.value) || 0;
        if (val > 0) val--;
        input.value = val;
        checkStockStatus(row);
    }
});

// Event delegation for Stock input change
document.addEventListener('change', function(e) {
    if (e.target.classList.contains('stock-input')) {
        let row = e.target.closest('tr');
        checkStockStatus(row);
    }
}, true);

document.addEventListener('input', function(e) {
    if (e.target.classList.contains('stock-input')) {
        let row = e.target.closest('tr');
        checkStockStatus(row);
    }
});

// Check all rows on page load
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('tr[data-id]').forEach(row => {
        checkStockStatus(row);
    });
});

// Also check immediately if DOM is already loaded
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            document.querySelectorAll('tr[data-id]').forEach(row => {
                checkStockStatus(row);
            });
        }, 100);
    });
} else {
    // DOM already loaded
    document.querySelectorAll('tr[data-id]').forEach(row => {
        checkStockStatus(row);
    });
}

// Save button - send all stock updates to database
document.addEventListener('click', function(e) {
    if (e.target.id === 'saveStock') {
        let data = [];
        let rowsToRemove = [];

        document.querySelectorAll('tr[data-id]').forEach(row => {
            let input = row.querySelector('.stock-input');
            let stock = parseInt(input.value) || 0;
            let originalStock = parseInt(input.dataset.original) || 0;
            let id = row.dataset.id;
            
            // Only add to data if the stock has actually changed
            if (stock !== originalStock) {
                data.push({
                    id: id,
                    stock: stock
                });
            }

            // Mark rows that will be removed (stock >= 10 and was low stock)
            if (stock >= 10) {
                rowsToRemove.push(row);
            }
        });

        if (data.length === 0) {
            alert('No changes detected in stock.');
            return;
        }

        console.log('Sending data:', data);

        fetch("{{ route('product.stock.update') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ stocks: data })
        })
        .then(res => res.json())
        .then(res => {
            console.log('Response:', res);
            if(res.status) {
                toastr.options = {
                    "closeButton": true,
                    "progressBar": true,
                    "timeOut": "1000",
                    "extendedTimeOut": "1000",
                    "positionClass": "toast-top-right"
                };
                toastr.success('Stock updated successfully!');
                
                // Remove rows where stock >= 10 before reloading
                rowsToRemove.forEach(row => {
                    row.style.transition = 'opacity 0.3s';
                    row.style.opacity = '0';
                    setTimeout(() => row.remove(), 300);
                });
                
                // Reload page after a short delay to sync with database
                setTimeout(() => {
                    location.reload();
                }, 800);
            } else {
                alert('❌ Error updating stock');
            }
        })
        .catch(err => {
            console.error('Error:', err);
            alert('❌ Error updating stock: ' + err.message);
        });
    }
});
</script>


