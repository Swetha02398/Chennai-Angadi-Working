@extends('layouts.app')
@section('content')
    @include('includes.alert')
    <style>
        /* Fix modal z-index to appear above screen-overlay */
        #editNotesModal {
            z-index: 9999 !important;
        }

        .modal-backdrop {
            z-index: 9998 !important;
        }
    </style>
    <section class="content-main">
        <div class="container mt-4">
            <div class="content-header">
                <div>
                    <h2 class="content-title card-title">Orders</h2>
                </div>
            </div>

            <!-- Search & Filters (Real-time without page refresh) -->
            <div class="card mb-4">

                <header class="card-header">
                    <div class="row g-3 align-items-center">
                        <div class="col-md-3">
                            <input type="text" id="ordersSearchNumber" class="form-control"
                                placeholder="Search by Order ID or Mobile Number" value="{{ $search ?? '' }}">
                        </div>
                        <div class="col-md-2">
                            <input type="date" id="ordersSearchDate" class="form-control" placeholder="Filter by Date" value="{{ $date ?? request('date') }}">
                        </div>
                        <div class="col-md-2">
                            <select id="ordersFilterStatus" class="form-select">
                                <option value="">All Status</option>
                                <option value="pending" {{ ($status ?? '') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ ($status ?? '') == 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="shipped" {{ ($status ?? '') == 'shipped' ? 'selected' : '' }}>Shipping</option>
                                <option value="delivered" {{ ($status ?? '') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="cancelled" {{ ($status ?? '') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select id="ordersFilterPayment" class="form-select">
                                <option value="">Payment Status</option>
                                <option value="paid" {{ ($payment_status ?? '') == 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="not_paid" {{ ($payment_status ?? '') == 'not_paid' ? 'selected' : '' }}>Not Paid</option>
                                <option value="cod" {{ ($payment_status ?? '') == 'cod' ? 'selected' : '' }}>COD</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex gap-2">
                                <button type="button" id="ordersSearchBtn" class="btn btn-primary flex-fill">
                                    Search
                                </button>
                                <button type="button" id="ordersClearFilters" class="btn btn-secondary flex-fill">
                                    Clear
                                </button>
                            </div>
                        </div>
                    </div>
                </header>


                <!-- Orders Table -->

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="ordersTable">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Order Id</th>
                                    <th>Order Date</th>
                                    <th>Billing Name/Address</th>
                                    <th>Order Source</th>
                                    <th>Amount</th>
                                    <th>Payment Status</th>
                                    <th>Delivery Status</th>
                                    <th class="text-start">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                    @php
                                        $address = $order->billing_address ?? $order->shipping_address ?? null;
                                        $billingPhone = $address['phone'] ?? '';
                                        if (empty($billingPhone)) {
                                            if ($order->customer_type === 'registered' && $order->customer) {
                                                $billingPhone = $order->customer->mobile ?? $order->customer->phone ?? '';
                                            } elseif ($order->customer_type === 'guest' && $order->guest_details) {
                                                $billingPhone = $order->guest_details['mobile'] ?? $order->guest_details['phone'] ?? '';
                                            }
                                        }
                                        $billingName = $address['name'] ?? '';
                                        if (empty($billingName)) {
                                            if ($order->customer_type === 'registered' && $order->customer) {
                                                $billingName = $order->customer->username ?? $order->customer->name ?? 'N/A';
                                            } elseif ($order->customer_type === 'guest' && $order->guest_details) {
                                                $billingName = $order->guest_details['name'] ?? $order->guest_details['first_name'] ?? 'Guest';
                                            } else {
                                                $billingName = 'N/A';
                                            }
                                        }
                                    @endphp
                                    @php
                                        // Determine payment display status
                                        if (in_array($order->payment_method, ['cash_on_delivery', 'cod'])) {
                                            $paymentFilterStatus = 'cod';
                                        } elseif ($order->payment_status === 'paid') {
                                            $paymentFilterStatus = 'paid';
                                        } else {
                                            $paymentFilterStatus = 'not_paid';
                                        }
                                    @endphp
                                    <tr data-order-number="{{ strtolower($order->order_number) }}"
                                        data-mobile="{{ strtolower($billingPhone) }}"
                                        data-date="{{ $order->created_at->format('Y-m-d') }}"
                                        data-payment-status="{{ $paymentFilterStatus }}"
                                        data-status="{{ strtolower($order->status) }}"
                                        data-source="{{ strtolower($order->order_source ?? 'web') }}">
                                        <td>{{ ($orders->currentPage() - 1) * $orders->perPage() + $loop->iteration }}</td>
                                        <td>
                                            <strong>{{ $order->order_number }}</strong>
                                        </td>
                                        <td>
                                            {{ $order->created_at->format('d-m-Y') }}<br>
                                            <small class="text-muted">{{ $order->created_at->format('h:i A') }}</small>
                                        </td>
                                        <td>
                                            <strong>{{ $billingName }}</strong><br>
                                            @if($address)
                                                <small>
                                                    {{ $address['address'] ?? '' }}{{ !empty($address['address2']) ? ', ' . $address['address2'] : '' }}{{ !empty($address['landmark']) ? ', ' . $address['landmark'] : '' }}
                                                    , {{ $address['city'] ?? '' }}
                                                    {{ !empty($address['state']) ? $address['state'] : '' }}
                                                    @if(!empty($address['pincode']))
                                                        - {{ $address['pincode'] }}
                                                    @endif
                                                </small>
                                            @endif
                                            @if(!empty($billingPhone))
                                                <br><small><strong>Mobile:</strong> {{ $billingPhone }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $source = $order->order_source ?? 'web';
                                                $sourceClass = match ($source) {
                                                    'web' => 'bg-info text-white',
                                                    'app' => 'bg-primary text-white',
                                                    'admin_panel' => 'bg-secondary text-white',
                                                    default => 'bg-light text-dark'
                                                };
                                            @endphp
                                            <span class="badge {{ $sourceClass }}">
                                                {{ ucfirst(str_replace('_', ' ', $source)) }}
                                            </span>
                                        </td>
                                        <td><strong>₹{{ number_format($order->final_amount ?? $order->total_amount, 2) }}</strong>
                                        </td>
                                        <td>
                                            @php
                                                if (in_array($order->payment_method, ['cash_on_delivery', 'cod'])) {
                                                    $paymentClass = 'bg-warning text-dark';
                                                    $paymentLabel = 'COD';
                                                } elseif ($order->payment_status === 'paid') {
                                                    $paymentClass = 'bg-success text-white';
                                                    $paymentLabel = 'Paid';
                                                } else {
                                                    $paymentClass = 'bg-danger text-white';
                                                    $paymentLabel = 'Not Paid';
                                                }
                                            @endphp
                                            <button class="btn btn-sm badge {{ $paymentClass }} payment-status-toggle" type="button" 
                                                id="paymentStatusBtn{{ $order->id }}" 
                                                data-order-id="{{ $order->id }}" 
                                                data-current-status="{{ $paymentLabel }}">
                                                {{ $paymentLabel }}
                                            </button>
                                        </td>
                                        <td>
                                            @php
                                                // Map status to support pending, processing, shipped, delivered, cancelled
                                                $displayStatus = match ($order->status) {
                                                    'pending' => 'pending',
                                                    'processing' => 'processing',
                                                    'shipped' => 'shipped',
                                                    'delivered' => 'delivered',
                                                    'cancelled' => 'cancelled',
                                                    default => 'processing'
                                                };
                                                $statusClass = match ($displayStatus) {
                                                    'pending' => 'bg-warning text-dark',
                                                    'processing' => 'bg-info',
                                                    'shipped' => 'bg-primary',
                                                    'delivered' => 'bg-success',
                                                    'cancelled' => 'bg-danger',
                                                    default => 'bg-info'
                                                };
                                                $statusLabel = match ($displayStatus) {
                                                    'pending' => 'Pending',
                                                    'shipped' => 'Shipping',
                                                    default => ucfirst($displayStatus)
                                                };
                                            @endphp
                                            <span class="badge {{ $statusClass }}">
                                                {{ $statusLabel }}
                                            </span>
                                        </td>
                                        <td class="text-start">
                                            <div class="d-flex gap-1 justify-content-end">
                                                <a href="{{ route('orders.view', $order->id) }}" class="btn btn-sm"
                                                    style="background-color: #00ccffff; color: #000; padding: 3px 7px; font-size: 11px;"
                                                    title="View Order">
                                                    <i class="bi bi-eye-fill"></i> View
                                                </a>
                                                @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('orders-delete'))
                                                <form action="{{ route('orders.delete', $order->id) }}" method="POST" style="display:inline-block;"
                                                    onsubmit="return confirm('Are you sure you want to delete this order? This action cannot be undone.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger btn-action-col d-inline-flex align-items-center justify-content-center "
                                                        style="padding: 3px 7px; font-size: 11px;"
                                                        title="Delete Order"><i class="bi bi-trash me-1"></i> Delete</button>
                                                </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="material-icons md-shopping_cart" style="font-size: 48px;"></i>
                                                <p class="mt-2">No frontend orders found</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {{-- PAGINATION --}}
            <div class="pagination-area mt-30 mb-50">
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-start">
                        {{-- Previous Page Link --}}
                        @if ($orders->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">&laquo;</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $orders->previousPageUrl() }}"
                                    aria-label="Previous">
                                    &laquo;
                                </a>
                            </li>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach ($orders->getUrlRange(1, $orders->lastPage()) as $page => $url)
                            @if ($page == $orders->currentPage())
                                <li class="page-item active">
                                    <a class="page-link" href="#">{{ str_pad($page, 2, '0', STR_PAD_LEFT) }}</a>
                                </li>
                            @else
                                @if ($page == 1 || $page == $orders->lastPage() || abs($page - $orders->currentPage()) <= 1)
                                    <li class="page-item">
                                        <a class="page-link"
                                            href="{{ $url }}">{{ str_pad($page, 2, '0', STR_PAD_LEFT) }}</a>
                                    </li>
                                @elseif (abs($page - $orders->currentPage()) == 2)
                                    <li class="page-item disabled">
                                        <span class="page-link dot">...</span>
                                    </li>
                                @endif
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($orders->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $orders->nextPageUrl() }}"
                                    aria-label="Next">
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
        </div>

    </section>

    <!-- Edit Order Notes Modal -->
    <div class="modal fade" id="editNotesModal" tabindex="-1" aria-labelledby="editNotesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title" id="editNotesModalLabel">
                        <i class="bi bi-pencil-square me-1"></i> Edit<span id="modalOrderNumber"></span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editNotesForm">
                    <div class="modal-body">
                        <input type="hidden" id="editOrderId" name="order_id">
                        <div class="mb-3">
                            <label for="editStatus" class="form-label"><strong>Status</strong></label>
                            <select class="form-select" id="editStatus" name="status">
                                <option value="pending">Pending</option>
                                <option value="confirmed">Confirmed</option>
                                <option value="packed">Packed</option>
                                <option value="shipped">Shipped</option>
                                <option value="delivered">Delivered</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editNotes" class="form-label"><strong>Notes</strong></label>
                            <textarea class="form-control" id="editNotes" name="notes" rows="10" required></textarea>
                            <div class="invalid-feedback">Notes cannot be empty.</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="saveNotesBtn">
                            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                            Save Notes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Invoice Modal -->
    <div class="modal fade" id="invoiceModal" tabindex="-1" aria-labelledby="invoiceModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header text-white" style="background-color: #00bcd4;">
                    <h5 class="modal-title" id="invoiceModalLabel">
                        <i class="bi bi-receipt me-2"></i>Invoice - <span id="invoiceOrderNumber"></span>
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body" id="invoiceModalBody">
                    <div class="text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2">Loading invoice...</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-lg me-1"></i>Close
                    </button>
                    <button type="button" class="btn btn-danger" id="printInvoiceBtn">
                        <i class="bi bi-printer-fill me-1"></i>Print Invoice
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Print Styles - Hide tax columns and rows when printing -->
    <style>
        /* Make Invoice Modal backdrop brighter */
        #invoiceModal+.modal-backdrop,
        .modal-backdrop.show {
            opacity: 0.3 !important;
        }

        /* Ensure Invoice Modal is on top */
        #invoiceModal {
            z-index: 10050 !important;
        }

        #invoiceModal .modal-dialog {
            z-index: 10051 !important;
        }

        /* Make modal content brighter with white background */
        #invoiceModal .modal-content {
            background-color: #fff !important;
            box-shadow: 0 10px 50px rgba(0, 0, 0, 0.3);
        }

        #invoiceModal .modal-body {
            background-color: #fff !important;
        }

        @media print {
            @page {
                size: A4 portrait;
                margin: 0;
            }

            html,
            body {
                height: auto !important;
                margin: 0 !important;
                padding: 0 !important;
                overflow: visible !important;
                background: #fff !important;
            }

            /* Improved Surgical Isolation */
            body>*:not(.main-wrap):not(#invoicePrintArea),
            .main-wrap>*:not(#invoicePrintArea),
            .screen-overlay,
            .modal,
            .modal-backdrop {
                display: none !important;
            }

            .main-wrap {
                display: block !important;
                position: relative !important;
                width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
                height: auto !important;
            }

            #invoicePrintArea {
                display: block !important;
                visibility: visible !important;
                position: absolute !important;
                top: 0 !important;
                left: 0 !important;
                width: 100% !important;
                background: #fff !important;
            }

            #invoicePrintArea,
            #invoicePrintArea * {
                visibility: visible !important;
            }

            .hide-on-print {
                display: none !important;
            }
        }
    </style>

    <!-- Hidden print area -->
    <div id="invoicePrintArea" style="display: none;"></div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchNumber = document.getElementById('ordersSearchNumber');
            const searchDate = document.getElementById('ordersSearchDate');
            const filterStatus = document.getElementById('ordersFilterStatus');
            const filterPayment = document.getElementById('ordersFilterPayment');
            const searchBtn = document.getElementById('ordersSearchBtn');
            const clearBtn = document.getElementById('ordersClearFilters');
            const tableBody = document.querySelector('#ordersTable tbody');

            // Check if all elements exist
            if(!searchNumber || !searchDate || !filterStatus || !filterPayment || !tableBody) {
            console.error('Orders filter elements not found');
            return;
        }

        console.log('Orders filter initialized successfully');

        function filterTable() {
            const searchValue = searchNumber ? searchNumber.value.trim() : '';
            const dateValue = searchDate ? searchDate.value : '';
            const statusValue = filterStatus ? filterStatus.value : '';
            const paymentValue = filterPayment ? filterPayment.value : '';

            let url = new URL(window.location.href);
            
            if (searchValue) url.searchParams.set('search', searchValue);
            else url.searchParams.delete('search');
            
            if (dateValue) url.searchParams.set('date', dateValue);
            else url.searchParams.delete('date');
            
            if (statusValue) url.searchParams.set('status', statusValue);
            else url.searchParams.delete('status');
            
            if (paymentValue) url.searchParams.set('payment_status', paymentValue);
            else url.searchParams.delete('payment_status');
            
            // Always reset to page 1 on search
            url.searchParams.delete('page');
            
            window.location.href = url.toString();
        }

        // Event listeners - server-side filtering
        searchNumber.addEventListener('keyup', function (e) {
            if (e.key === 'Enter') {
                filterTable();
            }
        });
        // We stop automatic filtering for date/status/payment to avoid multiple reloads, 
        // User must click Search or press Enter

        // Search button click
        if (searchBtn) {
            searchBtn.addEventListener('click', function (e) {
                e.preventDefault();
                filterTable();
            });
        }

        // Clear filters
        if (clearBtn) {
            clearBtn.addEventListener('click', function () {
                window.location.href = "{{ route('orders.table') }}";
            });
        }

        // Default notes template
        const defaultNotesTemplate = `Your order has been Shipped<br/>
                                                <strong>Courier Details:</strong><br/>
                                                Courier Name: Professional Courier<br/>
                                                Tracking Status:
                                                <a href="https://www.tpcindia.com/Default.aspx" target="_blank">Click Here</a><br/>
                                                Tracking ID: 13214646`;

        // Edit Notes Modal
        const editNotesModal = new bootstrap.Modal(document.getElementById('editNotesModal'));
        const editNotesForm = document.getElementById('editNotesForm');
        const editOrderIdInput = document.getElementById('editOrderId');
        const editNotesTextarea = document.getElementById('editNotes');
        const editStatusSelect = document.getElementById('editStatus');
        const saveNotesBtn = document.getElementById('saveNotesBtn');

        // Handle Edit button click
        document.querySelectorAll('.edit-notes-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                const orderId = this.dataset.orderId;
                const orderNumber = this.dataset.orderNumber;
                const existingNotes = this.dataset.notes;
                const existingStatus = this.dataset.status;

                editOrderIdInput.value = orderId;

                // Set order number in modal title
                document.getElementById('modalOrderNumber').textContent = orderNumber;

                // Prefill with existing notes only (no default template)
                editNotesTextarea.value = existingNotes || '';

                // Set current status in dropdown
                editStatusSelect.value = existingStatus || 'pending';

                // Clear validation state
                editNotesTextarea.classList.remove('is-invalid');

                editNotesModal.show();
            });
        });

        // Handle form submission
        editNotesForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const orderId = editOrderIdInput.value;
            const notes = editNotesTextarea.value.trim();
            const status = editStatusSelect.value;

            // Validation: notes cannot be empty
            if (!notes) {
                editNotesTextarea.classList.add('is-invalid');
                return;
            }

            editNotesTextarea.classList.remove('is-invalid');

            // Show loading spinner
            saveNotesBtn.disabled = true;
            saveNotesBtn.querySelector('.spinner-border').classList.remove('d-none');

            // AJAX request
            fetch(`{{ url('orders/update-notes') }}/${orderId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ notes: notes, status: status })
            })
                .then(response => response.json())
                .then(data => {
                    // Hide loading spinner
                    saveNotesBtn.disabled = false;
                    saveNotesBtn.querySelector('.spinner-border').classList.add('d-none');

                    if (data.success) {
                        // Update the button's data attributes for future edits
                        const editBtn = document.querySelector(`.edit-notes-btn[data-order-id="${orderId}"]`);
                        if (editBtn) {
                            editBtn.dataset.notes = data.notes;
                            editBtn.dataset.status = data.status;
                        }

                        // Update the status badge in the table row
                        const row = editBtn.closest('tr');
                        if (row) {
                            const statusCell = row.cells[7]; // Delivery Status is column index 7 (8th column)
                            if (statusCell) {
                                const statusClass = {
                                    'confirmed': 'bg-success',
                                    'pending': 'bg-warning text-dark',
                                    'processing': 'bg-info',
                                    'packed': 'bg-info',
                                    'shipped': 'bg-primary',
                                    'delivered': 'bg-success',
                                    'cancelled': 'bg-danger'
                                }[data.status] || 'bg-secondary';
                                const displayStatusLabel = data.status === 'shipped' ? 'Shipping' : (data.status.charAt(0).toUpperCase() + data.status.slice(1));
                                statusCell.innerHTML = `<span class="badge ${statusClass}">${displayStatusLabel}</span>`;
                            }
                        }

                        // Close modal
                        editNotesModal.hide();

                        // Show success message (using toastr if available, otherwise alert)
                        if (typeof toastr !== 'undefined') {
                            toastr.success(data.message);
                        } else {
                            alert(data.message);
                        }
                    } else {
                        if (typeof toastr !== 'undefined') {
                            toastr.error(data.message);
                        } else {
                            alert('Error: ' + data.message);
                        }
                    }
                })
                .catch(error => {
                    // Hide loading spinner
                    saveNotesBtn.disabled = false;
                    saveNotesBtn.querySelector('.spinner-border').classList.add('d-none');

                    console.error('Error:', error);
                    if (typeof toastr !== 'undefined') {
                        toastr.error('An error occurred while saving notes.');
                    } else {
                        alert('An error occurred while saving notes.');
                    }
                });
        });

        // ===== PAYMENT STATUS TOGGLE FUNCTIONALITY (Event Delegation) =====
        document.addEventListener('click', function(e) {
            const target = e.target.closest('.payment-status-toggle');
            if (!target) return;
            
            e.preventDefault();
            const orderId = target.dataset.orderId;
            const currentStatus = target.dataset.currentStatus;
            
            // Toggle Logic: 
            // - If Paid -> change to Not Paid
            // - If COD or Not Paid -> change to Paid
            let newStatus = 'Paid';
            if (currentStatus === 'Paid') {
                newStatus = 'Not Paid';
            }
            
            const btn = target;
            
            console.log('Payment status toggle triggered:', { orderId, currentStatus, newStatus });
            
            // Show loading state
            const originalText = btn.textContent;
            const originalClass = btn.className;
            
            btn.textContent = 'Updating...';
            btn.disabled = true;

            const url = "{{ route('orders.payment-status.update', ['id' => ':id']) }}".replace(':id', orderId);

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ payment_status: newStatus })
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => { throw err; }).catch(() => {
                        throw new Error('Network response was not ok: ' + response.status);
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Update button content and state
                    btn.textContent = newStatus;
                    btn.dataset.currentStatus = newStatus;
                    
                    // Update classes
                    btn.classList.remove('bg-success', 'bg-warning', 'bg-danger', 'text-dark', 'text-white');
                    if (newStatus === 'Paid') {
                        btn.classList.add('bg-success', 'text-white');
                    } else if (newStatus === 'COD') {
                        btn.classList.add('bg-warning', 'text-dark');
                    } else {
                        btn.classList.add('bg-danger', 'text-white');
                    }
                    
                    if (typeof toastr !== 'undefined') toastr.success(data.message);
                    else console.log('Update success:', data.message);
                } else {
                    alert('Error: ' + data.message);
                    btn.textContent = originalText;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Update failed: ' + (error.message || error));
                btn.textContent = originalText;
                btn.className = originalClass;
            })
            .finally(() => {
                btn.disabled = false;
            });
        });

        // ===== INVOICE MODAL FUNCTIONALITY =====
        const invoiceModal = new bootstrap.Modal(document.getElementById('invoiceModal'));
        const invoiceModalBody = document.getElementById('invoiceModalBody');
        const invoiceOrderNumberSpan = document.getElementById('invoiceOrderNumber');
        const printInvoiceBtn = document.getElementById('printInvoiceBtn');
        const invoicePrintArea = document.getElementById('invoicePrintArea');

        // Handle View Invoice button click
        document.querySelectorAll('.view-invoice-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                const orderId = this.dataset.orderId;
                const orderNumber = this.dataset.orderNumber;

                // Set order number in modal title
                invoiceOrderNumberSpan.textContent = orderNumber;

                // Show loading spinner
                invoiceModalBody.innerHTML = `
                                                                <div class="text-center py-5">
                                                                    <div class="spinner-border text-primary" role="status">
                                                                        <span class="visually-hidden">Loading...</span>
                                                                    </div>
                                                                    <p class="mt-2">Loading invoice...</p>
                                                                </div>
                                                            `;

                // Show modal
                invoiceModal.show();

                // Fetch invoice HTML via AJAX
                fetch(`{{ url('orders/invoice-html') }}/${orderId}`, {
                    method: 'GET',
                    headers: {
                        'Accept': 'text/html',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Failed to load invoice');
                        }
                        return response.text();
                    })
                    .then(html => {
                        invoiceModalBody.innerHTML = html;
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        invoiceModalBody.innerHTML = `
                                                                    <div class="alert alert-danger text-center">
                                                                        <i class="bi bi-exclamation-triangle me-2"></i>
                                                                        Failed to load invoice. Please try again.
                                                                    </div>
                                                                `;
                    });
            });
        });

        // Handle Print Invoice button click
        printInvoiceBtn.addEventListener('click', function () {
            // Get the invoice content
            const invoiceContent = invoiceModalBody.innerHTML;

            // Copy content to print area
            invoicePrintArea.innerHTML = invoiceContent;
            invoicePrintArea.style.display = 'block';

            // Trigger print
            window.print();

            // Hide print area after printing
            setTimeout(() => {
                invoicePrintArea.style.display = 'none';
            }, 1000);
        });
                                    });
    </script>
@endpush