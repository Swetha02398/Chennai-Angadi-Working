@extends('layouts.app')
@section('content')
    <style>
        .addproduct-container {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin: 20px 0;
            padding: 25px;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            margin-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .page-header .back-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 18px;
            font-weight: 600;
            color: #333;
            text-decoration: none;
        }

        .page-header .back-btn:hover {
            color: #f9a825;
        }

        .order-info-badge {
            background: #f9a825;
            color: #000;
            padding: 8px 16px;
            border-radius: 5px;
            font-weight: 600;
        }

        .search-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .results-table {
            max-height: 400px;
            overflow-y: auto;
        }

        .results-table table {
            margin-bottom: 0;
        }

        .results-table thead {
            position: sticky;
            top: 0;
            background: #fff;
            z-index: 1;
        }

        .selected-section {
            background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%);
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
        }

        .qty-input {
            width: 80px !important;
        }
    </style>

    <div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header">
            <h2 class="mb-0">Add Products to Order</h2>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('orders.view', $order->id) }}" class="btn btn-secondary">
                    Back
                </a>
                <div class="order-info-badge">
                    <i class="bi bi-receipt me-1"></i> Order: {{ $order->order_number }}
                </div>
            </div>
        </div>

        <div class="addproduct-container">
            <!-- Search Section -->
            <div class="search-section">
                <label for="productSearch" class="form-label"><strong><i class="bi bi-search"></i> Search
                        Product</strong></label>
                <input type="text" class="form-control form-control-lg" id="productSearch"
                    placeholder="Type product name to search..." autocomplete="off">
            </div>

            <!-- Search Results -->
            <div id="searchResultsContainer" style="display: none;">
                <h5 class="mb-3"><i class="bi bi-list-ul"></i> Search Results</h5>
                <div class="results-table">
                    <table class="table table-bordered table-hover table-sm" id="productResultsTable">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 50px;"></th>
                                <th>Product Name</th>
                                <th>Variant (Gram)</th>
                                <th>Price (₹)</th>
                                <th style="width: 100px;">Quantity</th>
                            </tr>
                        </thead>
                        <tbody id="productResultsBody">
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- No Results Message -->
            <div id="noResultsMessage" class="text-center text-muted py-4" style="display: none;">
                <i class="bi bi-search" style="font-size: 2rem;"></i>
                <p class="mt-2">No products found. Try a different search term.</p>
            </div>

            <!-- Selected Products Section -->
            <div id="selectedProductsSection" class="selected-section" style="display: none;">
                <h5 class="mb-3">
                    <i class="bi bi-cart-check"></i> Selected Products
                    <span class="badge bg-success" id="selectedCount">0</span>
                </h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-sm bg-white" id="selectedProductsTable">
                        <thead class="table-success">
                            <tr>
                                <th>Product</th>
                                <th>Variant</th>
                                <th>Price (₹)</th>
                                <th>Qty</th>
                                <th>Total (₹)</th>
                                <th style="width: 50px;"></th>
                            </tr>
                        </thead>
                        <tbody id="selectedProductsBody">
                        </tbody>
                        <tfoot class="table-warning">
                            <tr>
                                <td colspan="4" class="text-end"><strong>Grand Total:</strong></td>
                                <td><strong id="grandTotal">₹ 0.00</strong></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-3">
                    <a href="{{ route('orders.view', $order->id) }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle me-1"></i> Cancel
                    </a>
                    <button type="button" class="btn btn-warning btn-lg" id="addProductsBtn" disabled>
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        <i class="bi bi-plus-circle me-1"></i> Add Products to Order
                    </button>
                </div>
            </div>

            <!-- Empty State -->
            <div id="emptyState" class="text-center py-5">
                <i class="bi bi-box-seam" style="font-size: 4rem; color: #ddd;"></i>
                <h5 class="text-muted mt-3">Search and select products to add to this order</h5>
                <p class="text-muted">Use the search box above to find products</p>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const productSearch = document.getElementById('productSearch');
            const searchResultsContainer = document.getElementById('searchResultsContainer');
            const productResultsBody = document.getElementById('productResultsBody');
            const noResultsMessage = document.getElementById('noResultsMessage');
            const selectedProductsSection = document.getElementById('selectedProductsSection');
            const selectedProductsBody = document.getElementById('selectedProductsBody');
            const selectedCount = document.getElementById('selectedCount');
            const grandTotal = document.getElementById('grandTotal');
            const addProductsBtn = document.getElementById('addProductsBtn');
            const emptyState = document.getElementById('emptyState');

            // Store selected products
            let selectedProducts = [];

            let searchTimeout;

            // Update selected products display
            function updateSelectedProductsDisplay() {
                selectedProductsBody.innerHTML = '';
                let total = 0;

                selectedProducts.forEach((item, index) => {
                    const itemTotal = item.price * item.quantity;
                    total += itemTotal;

                    const row = document.createElement('tr');
                    row.innerHTML = `
                                                        <td>${item.productName}</td>
                                                        <td>${item.variantName}</td>
                                                        <td>₹ ${parseFloat(item.price).toFixed(2)}</td>
                                                        <td>${item.quantity}</td>
                                                        <td>₹ ${parseFloat(itemTotal).toFixed(2)}</td>
                                                        <td class="text-center">
                                                            <button type="button" class="btn btn-sm btn-danger remove-item" data-index="${index}">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </td>
                                                `;
                               selectedProductsBody.appendChild(row);
                    });

                    selectedCount.textContent = selectedProducts.length;
                    grandTotal.textContent = '₹ ' + parseFloat(total).toFixed(2);

                    if (selectedProducts.length > 0) {
                        selectedProductsSection.style.display = 'block';
                        addProductsBtn.disabled = false;
                        emptyState.style.display = 'none';
                    } else {
                        selectedProductsSection.style.display = 'none';
                        addProductsBtn.disabled = true;
                        if (searchResultsContainer.style.display === 'none') {
                            emptyState.style.display = 'block';
                        }
                    }

                    // Add remove item handlers
                    document.querySelectorAll('.remove-item').forEach(btn => {
                        btn.addEventListener('click', function () {
                            const index = parseInt(this.dataset.index);
                            selectedProducts.splice(index, 1);
                            updateSelectedProductsDisplay();
                            updateCheckboxStates();
                        });
                    });
                }

                // Update checkbox states based on selected products
                function updateCheckboxStates() {
                    document.querySelectorAll('.product-checkbox').forEach(checkbox => {
                        const key = checkbox.dataset.productId + '-' + checkbox.dataset.variantId;
                        const isSelected = selectedProducts.some(p => (p.productId + '-' + p.variantId) === key);
                        checkbox.checked = isSelected;
                    });
                }

                // Add product to selection
                function addProductToSelection(productId, productName, variantId, variantName, price, quantity) {
                    const key = productId + '-' + variantId;
                    const existingIndex = selectedProducts.findIndex(p => (p.productId + '-' + p.variantId) === key);

                    if (existingIndex >= 0) {
                        selectedProducts[existingIndex].quantity = quantity;
                    } else {
                        selectedProducts.push({
                            productId,
                            productName,
                            variantId,
                            variantName,
                            price: parseFloat(price),
                            quantity: parseInt(quantity)
                        });
                    }
                    updateSelectedProductsDisplay();
                }

                // Remove product from selection
                function removeProductFromSelection(productId, variantId) {
                    const key = productId + '-' + variantId;
                    selectedProducts = selectedProducts.filter(p => (p.productId + '-' + p.variantId) !== key);
                    updateSelectedProductsDisplay();
                }

                // Search handler
                productSearch.addEventListener('input', function () {
                    const query = this.value.trim();

                    clearTimeout(searchTimeout);

                    if (query.length < 2) {
                        searchResultsContainer.style.display = 'none';
                        noResultsMessage.style.display = 'none';
                        if (selectedProducts.length === 0) {
                            emptyState.style.display = 'block';
                        }
                        return;
                    }

                    emptyState.style.display = 'none';
                    noResultsMessage.innerHTML = '<i class="bi bi-hourglass-split"></i> Searching...';
                    noResultsMessage.style.display = 'block';
                    searchResultsContainer.style.display = 'none';

                    searchTimeout = setTimeout(() => {
                        fetch(`{{ url('orders/search-products') }}?query=${encodeURIComponent(query)}`, {
                            method: 'GET',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        })
                            .then(response => response.json())
                            .then(data => {
                                productResultsBody.innerHTML = '';

                                if (data.success && data.products && data.products.length > 0) {
                                    noResultsMessage.style.display = 'none';
                                    searchResultsContainer.style.display = 'block';

                                    data.products.forEach(product => {
                                        if (product.variants && product.variants.length > 0) {
                                            product.variants.forEach(variant => {
                                                const isOutOfStock = variant.is_out_of_stock;
                                                const key = product.id + '-' + variant.id;
                                                const isSelected = selectedProducts.some(p => (p.productId + '-' + p.variantId) === key);

                                                const row = document.createElement('tr');
                                                if (isOutOfStock) {
                                                    row.style.opacity = '0.5';
                                                    row.style.backgroundColor = '#f8f8f8';
                                                }

                                                const stockCount = variant.stock || 0;
                                                const stockBadge = isOutOfStock
                                                    ? '<span class="badge bg-danger ms-2">Out of Stock</span>'
                                                    : `<span class="badge bg-success ms-2">${stockCount}</span>`;

                                                row.innerHTML = `
                                                                            <td class="text-center">
                                                                                <input type="checkbox" class="form-check-input product-checkbox"
                                                                                    data-product-id="${product.id}"
                                                                                    data-product-name="${product.productname}"
                                                                                    data-variant-id="${variant.id}"
                                                                                    data-variant-name="${variant.quantity_name || 'Default'}"
                                                                                    data-price="${variant.sell_price}"
                                                                                    ${isOutOfStock ? 'disabled' : ''}
                                                                                    ${isSelected ? 'checked' : ''}>
                                                                            </td>
                                                                            <td>${product.productname}</td>
                                                                            <td>${variant.quantity_name || 'Default'}${stockBadge}</td>
                                                                            <td>₹ ${parseFloat(variant.sell_price).toFixed(2)}</td>
                                                                            <td>
                                                                                <input type="number" class="form-control form-control-sm qty-input" 
                                                                                    value="1" min="1" max="${isOutOfStock ? 0 : stockCount}"
                                                                                    data-product-id="${product.id}"
                                                                                    data-variant-id="${variant.id}"
                                                                                    data-stock="${stockCount}"
                                                                                    ${isOutOfStock ? 'disabled' : ''}>
                                                                            </td>
                                                                        `;
                                                productResultsBody.appendChild(row);
                                            });
                                        } else {
                                            const row = document.createElement('tr');
                                            row.innerHTML = `
                                                                        <td class="text-center">
                                                                            <input type="checkbox" class="form-check-input product-checkbox"
                                                                                data-product-id="${product.id}"
                                                                                data-product-name="${product.productname}"
                                                                                data-variant-id=""
                                                                                data-variant-name="Default"
                                                                                data-price="${product.sell_price || 0}">
                                                                        </td>
                                                                        <td>${product.productname}</td>
                                                                        <td>Default</td>
                                                                        <td>₹ ${parseFloat(product.sell_price || 0).toFixed(2)}</td>
                                                                        <td>
                                                                            <input type="number" class="form-control form-control-sm qty-input" 
                                                                                value="1" min="1" max="999"
                                                                                data-product-id="${product.id}"
                                                                                data-variant-id="">
                                                                        </td>
                                                                    `;
                                            productResultsBody.appendChild(row);
                                        }
                                    });

                                    // Attach checkbox handlers
                                    document.querySelectorAll('.product-checkbox').forEach(checkbox => {
                                        checkbox.addEventListener('change', function () {
                                            const row = this.closest('tr');
                                            const qtyInput = row.querySelector('.qty-input');
                                            const productId = this.dataset.productId;
                                            const productName = this.dataset.productName;
                                            const variantId = this.dataset.variantId;
                                            const variantName = this.dataset.variantName;
                                            const price = this.dataset.price;
                                            const quantity = parseInt(qtyInput.value) || 1;

                                            if (this.checked) {
                                                addProductToSelection(productId, productName, variantId, variantName, price, quantity);
                                            } else {
                                                removeProductFromSelection(productId, variantId);
                                            }
                                        });
                                    });

                                    // Attach quantity handlers
                                    document.querySelectorAll('.qty-input').forEach(input => {
                                        // Handle quantity change when checkbox is already checked
                                        input.addEventListener('change', function () {
                                            const row = this.closest('tr');
                                            const checkbox = row.querySelector('.product-checkbox');
                                            if (checkbox.checked) {
                                                const productId = checkbox.dataset.productId;
                                                const productName = checkbox.dataset.productName;
                                                const variantId = checkbox.dataset.variantId;
                                                const variantName = checkbox.dataset.variantName;
                                                const price = checkbox.dataset.price;
                                                const quantity = parseInt(this.value) || 1;
                                                addProductToSelection(productId, productName, variantId, variantName, price, quantity);
                                            }
                                        });

                                        // Handle Enter key press - auto-check and add to selection
                                        input.addEventListener('keypress', function (e) {
                                            if (e.key === 'Enter') {
                                                e.preventDefault();
                                                const row = this.closest('tr');
                                                const checkbox = row.querySelector('.product-checkbox');
                                                const stock = parseInt(this.dataset.stock) || 0;
                                                let quantity = parseInt(this.value) || 1;

                                                // Validate stock
                                                if (stock <= 0) {
                                                    if (typeof toastr !== 'undefined') {
                                                        toastr.error('This product is out of stock');
                                                    } else {
                                                        alert('This product is out of stock');
                                                    }
                                                    return;
                                                }

                                                // Limit quantity to available stock
                                                if (quantity > stock) {
                                                    if (typeof toastr !== 'undefined') {
                                                        toastr.warning(`Only ${stock} available. Quantity adjusted to ${stock}`);
                                                    }
                                                    quantity = stock;
                                                    this.value = stock;
                                                }

                                                // Auto-check the checkbox
                                                checkbox.checked = true;

                                                // Add to selection
                                                const productId = checkbox.dataset.productId;
                                                const productName = checkbox.dataset.productName;
                                                const variantId = checkbox.dataset.variantId;
                                                const variantName = checkbox.dataset.variantName;
                                                const price = checkbox.dataset.price;
                                                addProductToSelection(productId, productName, variantId, variantName, price, quantity);

                                                // Show success feedback
                                                if (typeof toastr !== 'undefined') {
                                                    toastr.success(`${productName} (${variantName}) added to selection`);
                                                }
                                            }
                                        });
                                    });
                                } else {
                                    searchResultsContainer.style.display = 'none';
                                    noResultsMessage.innerHTML = '<i class="bi bi-search" style="font-size: 2rem;"></i><p class="mt-2">No products found. Try a different search term.</p>';
                                    noResultsMessage.style.display = 'block';
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                searchResultsContainer.style.display = 'none';
                                noResultsMessage.innerHTML = '<i class="bi bi-exclamation-triangle"></i> Error searching. Please try again.';
                                noResultsMessage.style.display = 'block';
                            });
                    }, 300);
                });

                // Add Products Button Handler
                addProductsBtn.addEventListener('click', function () {
                    if (selectedProducts.length === 0) {
                        alert('Please select at least one product.');
                        return;
                    }

                    const spinner = this.querySelector('.spinner-border');
                    this.disabled = true;
                    spinner.classList.remove('d-none');

                    fetch('{{ route('orders.add-products', $order->id) }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ products: selectedProducts })
                    })
                        .then(response => response.json())
                        .then(data => {
                            this.disabled = false;
                            spinner.classList.add('d-none');

                            if (data.success) {
                                // Check if there are warnings (stock issues)
                                if (data.warnings && data.warnings.length > 0) {
                                    // Show warnings
                                    if (typeof toastr !== 'undefined') {
                                        data.warnings.forEach(warning => {
                                            toastr.warning(warning);
                                        });
                                        toastr.info('Products added with stock limitations. You can add more products or go back to order.');
                                    } else {
                                        alert('Warnings:\n' + data.warnings.join('\n') + '\n\nProducts added with stock limitations. You can add more products.');
                                    }

                                    // Clear the selected products but stay on page
                                    selectedProducts = [];
                                    updateSelectedProductsDisplay();

                                    // Optionally reload search results to show updated stock
                                    if (productSearch.value.trim().length >= 2) {
                                        productSearch.dispatchEvent(new Event('input'));
                                    }
                                } else {
                                    // No warnings - everything added successfully, redirect
                                    if (typeof toastr !== 'undefined') {
                                        toastr.success(data.message || 'Products added successfully!');
                                    } else {
                                        alert(data.message || 'Products added successfully!');
                                    }

                                    // Redirect to order view page
                                    setTimeout(() => {
                                        window.location.href = '{{ route('orders.view', $order->id) }}';
                                    }, 1500);
                                }
                            } else {
                                if (typeof toastr !== 'undefined') {
                                    toastr.error(data.message || 'Failed to add products');
                                } else {
                                    alert('Error: ' + (data.message || 'Failed to add products'));
                                }
                            }
                        })
                        .catch(error => {
                            this.disabled = false;
                            spinner.classList.add('d-none');
                            console.error('Error:', error);
                            alert('An error occurred while adding products.');
                        });
                });

                // Focus on search input
                productSearch.focus();
            });
        </script>
@endpush