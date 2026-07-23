@extends('layouts.app')

@section('content')
@include('includes.alert')

<section class="content-main">
    <div class="container mt-4">

        {{-- HEADER --}}
        <div class="content-header d-flex justify-content-between align-items-center mb-3">
            <h2>Billing Orders</h2>
            @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('billing-create'))
            <a href="{{ route('admin.billing.create') }}?new=1" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i> Add New
            </a>
            @endif
        </div>

        {{-- CARD --}}
        <div class="card mb-4">

            {{-- SEARCH & FILTER (Real-time without page refresh) --}}
            <header class="card-header">
                <div class="row gx-3 align-items-center">

                    <div class="col-md-3 col-12">
                        <input
                            type="text"
                            id="billingSearchName"
                            class="form-control"
                            placeholder="Search by ID or Number..."
                            value="{{ request('search') }}"
                        >
                    </div>

                    <div class="col-md-2 col-6">
                        <input
                            type="date"
                            id="billingSearchDate"
                            class="form-control"
                            placeholder="Filter by Date"
                            value="{{ request('date') }}"
                        >
                    </div>


                    <div class="col-md-2 col-6">
                        <select id="billingFilterOrderStatus" class="form-select">
                            <option value="">All Status</option>
                            <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Hold</option>
                        </select>
                    </div>

                    <div class="col-md-2 col-6">
                        <select id="billingFilterStatus" class="form-select">
                            <option value="">Payment Status</option>
                            <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="cod" {{ request('payment_status') == 'cod' ? 'selected' : '' }}>COD</option>
                            <option value="not_paid" {{ request('payment_status') == 'not_paid' ? 'selected' : '' }}>Not Paid</option>
                        </select>
                    </div>

                    <div class="col-md-3 col-12">
                        <div class="d-flex gap-2">
                            <button type="button" id="billingSearchBtn" class="btn btn-primary w-100">
                                <i class="bi bi-search me-1"></i> Search
                            </button>
                            <button type="button" id="billingClearFilters" class="btn btn-secondary w-100">
                                <i class="bi bi-eraser me-1"></i> Clear
                            </button>
                        </div>
                    </div>

                </div>
            </header>

            {{-- TABLE --}}
            <div class="card-body">
                <div class="table-responsive table-centered">

                    <table class="table mb-0" id="billingTable">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Order Id</th>
                                <th>Order Date</th>
                                <th>Customer</th>
                                <th>Amount</th>
                                <th>Payment</th>
                                <th>Customer Type</th>
                                <th>Payment Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($orders as $order)
                              
                                     
                              
                                @php
                                    if (in_array($order->payment_method, ['cash_on_delivery', 'cod'])) {
                                        $paymentFilterStatus = 'cod';
                                    } elseif ($order->payment_status === 'paid') {
                                        $paymentFilterStatus = 'paid';
                                    } else {
                                        $paymentFilterStatus = 'not_paid';
                                    }
                                @endphp
                                <tr data-order-id="{{ strtolower($order->order_number) }}"
                                    data-date="{{ $order->created_at->format('Y-m-d') }}"
                                    data-payment-status="{{ $paymentFilterStatus }}"
                                    data-order-status="{{ strtolower($order->status) }}">
                                    <td>{{ ($orders->currentPage() - 1) * $orders->perPage() + $loop->iteration }}</td>
                                    <td><strong>{{ $order->order_number }}</strong></td>

                                    <td>
                                        {{ $order->created_at->format('d-m-Y') }}<br>
                                        <small class="text-muted">{{ $order->created_at->format('h:i A') }}</small>
                                    </td>

                                    <td>
                                        @if($order->customer_type === 'registered')
                                            {{ $order->customer->username ?? 'N/A' }}
                                        @else
                                            {{ $order->guest_details['first_name']
                                                ?? $order->guest_details['name']
                                                ?? 'Guest' }}
                                        @endif
                                    </td>

                                    <td class="text-end"><strong>₹{{ number_format($order->final_amount, 2) }}</strong></td>

                                    <td>
                                        @php
                                            $methodName = '';
                                            if (!empty($order->payment_provider) && in_array(strtolower($order->payment_provider), ['gpay', 'google pay', 'google_pay'])) {
                                                $methodName = 'GPay';
                                            } elseif (!empty($order->payment_provider) && strtolower($order->payment_provider) !== 'cash') {
                                                $methodName = \Illuminate\Support\Str::headline($order->payment_provider);
                                            } else {
                                                $methodName = \Illuminate\Support\Str::headline($order->payment_method);
                                            }

                                            if (stripos($methodName, 'Online') !== false) {
                                                $methodName = 'Online';
                                            } elseif (stripos($methodName, 'Cash') !== false || strtolower($order->payment_method) == 'cod') {
                                                $methodName = 'COD';
                                            }
                                        @endphp
                                        {{ $methodName }}
                                    </td>

                                    <td>
                                        <span class="badge {{ $order->customer_type === 'registered' ? 'bg-info' : 'bg-secondary' }}">
                                            <i class="bi bi-{{ $order->customer_type === 'registered' ? 'person-check' : 'person' }} me-1"></i> {{ ucfirst($order->customer_type) }}
                                        </span>
                                    </td>

                                    <td>
                                        @if(in_array($order->payment_method, ['cash_on_delivery', 'cod']))
                                            @php
                                                $paymentClass = 'bg-warning text-dark';
                                                $paymentLabel = 'COD';
                                                $paymentIcon = '<i class="bi bi-cash me-1"></i>';
                                            @endphp
                                        @elseif($order->payment_status === 'paid')
                                            @php
                                                $paymentClass = 'bg-success text-white';
                                                $paymentLabel = 'Paid';
                                                $paymentIcon = '<i class="bi bi-check-circle me-1"></i>';
                                            @endphp
                                        @else
                                            @php
                                                $paymentClass = 'bg-danger text-white';
                                                $paymentLabel = 'Not Paid';
                                                $paymentIcon = '<i class="bi bi-x-circle me-1"></i>';
                                            @endphp
                                        @endif
                                        <button class="btn btn-sm badge {{ $paymentClass }} payment-status-toggle" type="button" 
                                            id="paymentStatusBtn{{ $order->id }}" 
                                            data-order-id="{{ $order->id }}" 
                                            data-current-status="{{ $paymentLabel }}">
                                            {!! $paymentIcon !!} {{ $paymentLabel }}
                                        </button>
                                    </td>



                                    <td>
                                        <div class="d-flex gap-2">
                                            @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('billing-edit'))
                                            <a href="{{ route('admin.billing.edit', $order->id) }}" class="btn btn-sm btn-warning d-inline-flex align-items-center justify-content-center" title="Edit Order">
                                                <i class="bi bi-pencil-square me-1"></i> Edit
                                            </a>
                                            @endif
                                            
                                            <button type="button" 
                                                class="btn btn-sm btn-info text-white view-billing-invoice-btn"
                                                data-order-id="{{ $order->id }}"
                                                data-order-number="{{ $order->order_number }}"
                                                title="View Invoice">
                                                <i class="bi bi-printer-fill me-1"></i> Print
                                            </button>

                                            @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('billing-delete'))
                                            <form
                                                action="{{ route('admin.billing.delete', $order->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Delete this order?');"
                                            >
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger btn-action-col d-inline-flex align-items-center justify-content-center "><i class="bi bi-trash me-1"></i> Delete</button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center">
                                        No billing orders found
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
                        <a class="page-link" href="{{ $orders->previousPageUrl() }}" aria-label="Previous">
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
                                <a class="page-link" href="{{ $url }}">{{ str_pad($page, 2, '0', STR_PAD_LEFT) }}</a>
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
                        <a class="page-link" href="{{ $orders->nextPageUrl() }}" aria-label="Next">
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

<!-- Billing Invoice Modal -->
<div class="modal fade" id="billingInvoiceModal" tabindex="-1" aria-labelledby="billingInvoiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header text-white" style="background-color: #00bcd4;">
                <h5 class="modal-title" id="billingInvoiceModalLabel">
                    <i class="bi bi-receipt me-2"></i>Invoice - <span id="billingInvoiceOrderNumber"></span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="billingInvoiceModalBody">
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Loading invoice...</p>
                </div>
            </div>
            <div class="modal-footer gap-3">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg me-1"></i>Close
                </button>
                <button type="button" class="btn btn-danger" id="billingPrintInvoiceBtn">
                    <i class="bi bi-printer-fill me-1"></i>Print Invoice
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Billing Print Options Modal -->
<div class="modal fade" id="billingPrintOptionsModal" tabindex="-1" aria-labelledby="billingPrintOptionsModalLabel" aria-hidden="true" style="z-index: 10060 !important;">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 360px; z-index: 10061 !important;">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 12px; overflow: hidden;">
            <div class="modal-body p-0">
                <!-- Header Section -->
                <div class="text-center py-3" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <div class="mb-2">
                        <i class="bi bi-printer-fill text-white" style="font-size: 32px;"></i>
                    </div>
                    <h5 class="text-white mb-0 fw-semibold">Print Invoice</h5>
                    <small class="text-white-50">Select invoice type</small>
                </div>
                
                <!-- Options Section -->
                <div class="d-flex flex-row justify-content-center align-items-center" style="padding: 12px; gap: 10px;">
                    <button type="button" class="btn w-50 py-3 d-flex align-items-center justify-content-center" id="billingPrintGstIncluded" 
                        style="background: #f0fdf4; border: 2px solid #22c55e; border-radius: 10px; color: #166534; font-weight: 600; transition: all 0.2s;">
                        <i class="bi bi-receipt-cutoff me-2" style="font-size: 20px;"></i>
                        GST Included
                    </button>
                    <button type="button" class="btn w-50 py-3 d-flex align-items-center justify-content-center" id="billingPrintGstNotIncluded"
                        style="background: #fefce8; border: 2px solid #eab308; border-radius: 10px; color: #854d0e; font-weight: 600; transition: all 0.2s;">
                        <i class="bi bi-receipt me-2" style="font-size: 20px;"></i>
                        GST Not Included
                    </button>
                </div>
                
                <!-- Cancel Link -->
                <div class="text-center" style="padding-bottom: 12px;">
                    <button type="button" class="btn btn-link text-muted text-decoration-none" data-bs-dismiss="modal"><i class="bi bi-x-circle me-1"></i> Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Print Styles - Hide tax columns and rows when printing -->
<style>
/* Make Billing Invoice Modal backdrop brighter */
#billingInvoiceModal + .modal-backdrop,
.modal-backdrop.show {
    opacity: 0.3 !important;
}

/* Ensure Billing Invoice Modal is on top */
#billingInvoiceModal {
    z-index: 10050 !important;
}
#billingInvoiceModal .modal-dialog {
    z-index: 10051 !important;
}

/* Ensure Billing Print Options Modal is on top of invoice modal */
#billingPrintOptionsModal {
    z-index: 10060 !important;
}
#billingPrintOptionsModal .modal-dialog {
    z-index: 10061 !important;
}

/* Make modal content brighter with white background */
#billingInvoiceModal .modal-content {
    background-color: #fff !important;
    box-shadow: 0 10px 50px rgba(0,0,0,0.3);
}

#billingInvoiceModal .modal-body {
    background-color: #fff !important;
}

@media print {
    @page { size: A4 portrait; margin: 10mm; }
    
    html, body { 
        height: auto !important; 
        margin: 0 !important; 
        padding: 0 !important; 
        overflow: visible !important;
        background: #fff !important;
    }
    
    * {
        box-sizing: border-box !important;
    }

    /* Hide everything except print area */
    body > *:not(.main-wrap):not(#billingInvoicePrintArea),
    .main-wrap > *:not(#billingInvoicePrintArea),
    .screen-overlay, .modal, .modal-backdrop {
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

    #billingInvoicePrintArea {
        display: block !important;
        visibility: visible !important;
        position: absolute !important;
        top: 0 !important;
        left: 0 !important;
        width: 100% !important;
        background: #fff !important;
    }
    
    #billingInvoicePrintArea, #billingInvoicePrintArea * {
        visibility: visible !important;
    }

    /* GST type selection: hide/show correct invoice inside print area */
    body.print-gst-included #billingInvoicePrintArea #billingGstNotIncludedInvoice {
        display: none !important;
    }
    body.print-gst-included #billingInvoicePrintArea #billingGstIncludedInvoice {
        display: block !important;
    }
    body.print-gst-not-included #billingInvoicePrintArea #billingGstIncludedInvoice {
        display: none !important;
    }
    body.print-gst-not-included #billingInvoicePrintArea #billingGstNotIncludedInvoice {
        display: block !important;
    }

    .hide-on-print { display: none !important; }
}
</style>

<!-- Hidden print area for billing invoice -->
<div id="billingInvoicePrintArea" style="display: none;"></div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('billingSearchName');
    const searchDate = document.getElementById('billingSearchDate');
    const filterOrderStatus = document.getElementById('billingFilterOrderStatus');
    const filterPaymentStatus = document.getElementById('billingFilterStatus');
    const searchBtn = document.getElementById('billingSearchBtn');
    const clearBtn = document.getElementById('billingClearFilters');
    const tableBody = document.querySelector('#billingTable tbody');

    // Check if all elements exist
    if (!searchInput || !searchDate || !filterOrderStatus || !filterPaymentStatus || !tableBody) {
        console.error('Billing filter elements not found');
        return;
    }

    console.log('Billing filter initialized successfully');

    function filterTable() {
        console.log('Billing filterTable called');
        const searchValue = searchInput ? searchInput.value.trim() : '';
        const dateValue = searchDate ? searchDate.value : '';
        const orderStatusValue = filterOrderStatus ? filterOrderStatus.value : '';
        const paymentStatusValue = filterPaymentStatus ? filterPaymentStatus.value : '';
        
        let url = new URL(window.location.href);
        
        if (searchValue) url.searchParams.set('search', searchValue);
        else url.searchParams.delete('search');
        
        if (dateValue) url.searchParams.set('date', dateValue);
        else url.searchParams.delete('date');
        
        if (orderStatusValue) url.searchParams.set('status', orderStatusValue);
        else url.searchParams.delete('status');
        
        if (paymentStatusValue) url.searchParams.set('payment_status', paymentStatusValue);
        else url.searchParams.delete('payment_status');
        
        // Reset to page 1 on search
        url.searchParams.delete('page');
        
        window.location.href = url.toString();
    }

    // Event listeners - real-time filtering
    searchInput.addEventListener('keyup', function(e) {
        if (e.key === 'Enter') {
            filterTable();
        }
    });
    // We stop automatic filtering for date/status/payment to avoid multiple reloads
    // User must click Search or press Enter

    // Search button click
    if (searchBtn) {
        searchBtn.addEventListener('click', function(e) {
            e.preventDefault();
            filterTable();
        });
    }

    // Clear filters
    if (clearBtn) {
        clearBtn.addEventListener('click', function() {
            window.location.href = "{{ route('billing.table') }}";
        });
    }

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
                btn.innerHTML = (newStatus === 'Paid' ? '<i class="bi bi-check-circle me-1"></i> ' : (newStatus === 'COD' ? '<i class="bi bi-cash me-1"></i> ' : '<i class="bi bi-x-circle me-1"></i> ')) + newStatus;
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

    // ===== BILLING INVOICE MODAL FUNCTIONALITY =====
    const billingInvoiceModal = new bootstrap.Modal(document.getElementById('billingInvoiceModal'));
    const billingInvoiceModalBody = document.getElementById('billingInvoiceModalBody');
    const billingInvoiceOrderNumberSpan = document.getElementById('billingInvoiceOrderNumber');
    const billingPrintInvoiceBtn = document.getElementById('billingPrintInvoiceBtn');
    const billingInvoicePrintArea = document.getElementById('billingInvoicePrintArea');

    // Handle View Invoice button click
    document.querySelectorAll('.view-billing-invoice-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const orderId = this.dataset.orderId;
            const orderNumber = this.dataset.orderNumber;

            // Set order number in modal title
            billingInvoiceOrderNumberSpan.textContent = orderNumber;

            // Show loading spinner
            billingInvoiceModalBody.innerHTML = `
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Loading invoice...</p>
                </div>
            `;

            // Show modal
            billingInvoiceModal.show();

            // Fetch invoice HTML via AJAX
            fetch(`{{ url('billing/invoice-html') }}/${orderId}`, {
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
                billingInvoiceModalBody.innerHTML = html;
            })
            .catch(error => {
                console.error('Error:', error);
                billingInvoiceModalBody.innerHTML = `
                    <div class="alert alert-danger text-center">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        Failed to load invoice. Please try again.
                    </div>
                `;
            });
        });
    });

    const billingPrintOptionsModalEl = document.getElementById('billingPrintOptionsModal');
    const billingPrintOptionsModal = bootstrap.Modal.getInstance(billingPrintOptionsModalEl) || new bootstrap.Modal(billingPrintOptionsModalEl);
    const billingPrintGstIncludedBtn = document.getElementById('billingPrintGstIncluded');
    const billingPrintGstNotIncludedBtn = document.getElementById('billingPrintGstNotIncluded');

    // Handle Print Invoice button click:
    // Hide invoice modal first, then show GST selection modal (avoids Bootstrap nested modal conflicts)
    billingPrintInvoiceBtn.addEventListener('click', function() {
        billingInvoiceModal.hide();
        setTimeout(() => {
            billingPrintOptionsModal.show();
        }, 400);
    });

    function printBillingInvoice(gstType) {
        // Get the invoice content from modal body
        const invoiceContent = billingInvoiceModalBody.innerHTML;
        
        // Copy content to print area
        billingInvoicePrintArea.innerHTML = invoiceContent;
        billingInvoicePrintArea.style.display = 'block';

        // Remove any existing print classes
        document.body.classList.remove('print-gst-included', 'print-gst-not-included');
        
        // Add the appropriate GST class
        if (gstType === 'included') {
            document.body.classList.add('print-gst-included');
        } else {
            document.body.classList.add('print-gst-not-included');
        }

        // Close options modal
        billingPrintOptionsModal.hide();
        
        // Trigger print after modal closes
        setTimeout(() => {
            window.print();
            
            // Hide print area and clean up classes after printing
            setTimeout(() => {
                billingInvoicePrintArea.style.display = 'none';
                document.body.classList.remove('print-gst-included', 'print-gst-not-included');
            }, 1000);
        }, 500);
    }

    if (billingPrintGstIncludedBtn) {
        billingPrintGstIncludedBtn.addEventListener('click', function() {
            printBillingInvoice('included');
        });
    }

    if (billingPrintGstNotIncludedBtn) {
        billingPrintGstNotIncludedBtn.addEventListener('click', function() {
            printBillingInvoice('not_included');
        });
    }
});
</script>
@endpush

