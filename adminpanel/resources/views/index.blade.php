@extends('layouts.app')
@section('content')
@include('includes.alert')
            <section class="content-main">
                <div class="content-header">
                    <div>
                        <h2 class="content-title card-title">Dashboard</h2>
                        <p>Whole data about your business here</p>
                    </div>
                    <div>
                        <a href="{{route('reports.index')}}" class="btn btn-primary"><i class="text-muted material-icons md-post_add"></i> Report</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 d-flex">
                        <div class="card card-body mb-4 w-100">
                            <article class="icontext">
                                <span class="icon icon-sm rounded-circle bg-success-light"><i class="text-success material-icons md-local_shipping"></i></span>
                                <div class="text">
                                    <h6 class="mb-1 card-title">Today Orders</h6>
                                    <span>{{ $todayOrderCount }}</span>
                                    <span class="text-sm"> Orders placed today </span>
                                </div>
                            </article>
                        </div>
                    </div>
                    <div class="col-lg-4 d-flex">
                        <div class="card card-body mb-4 w-100">
                            <article class="icontext">
                                <span class="icon icon-sm rounded-circle bg-primary-light"><i class="text-primary material-icons md-list_alt"></i></span>
                                <div class="text">
                                    <h6 class="mb-1 card-title">Total Orders</h6>
                                    <span>{{ $totalOrderCount }}</span>
                                    <span class="text-sm"> All time orders </span>
                                </div>
                            </article>
                        </div>
                    </div>
                    <div class="col-lg-4 d-flex">
                        <div class="card card-body mb-4 w-100">
                            <article class="icontext">
                                <span class="icon icon-sm rounded-circle bg-warning-light"><i class="text-warning material-icons md-qr_code"></i></span>
                                <div class="text">
                                    <h6 class="mb-1 card-title">Total Products</h6>
                                    <span>{{ $totalProductCount }}</span>
                                    <span class="text-sm"> Available in catalog </span>
                                </div>
                            </article>
                        </div>
                    </div>
                </div>
              
                <div class="card mb-4">
                    <header class="card-header">
                        <h4 class="card-title">Latest orders</h4>
                        <div class="row align-items-center">
                            <div class="col-md-3 col-12 me-auto mb-md-0 mb-3">
                                <div class="custom_select">
                                    <select class="form-select select-nice" id="categoryFilter">
                                        <option value="" selected>All Categories</option>
                                        @foreach($mainCategories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 col-6">
                                <input type="date" value="" class="form-control" id="dateFilter" />
                            </div>
                            <div class="col-md-2 col-6">
                                <div class="custom_select">
                                    <select class="form-select select-nice" id="statusFilter">
                                        <option value="" selected>All Status</option>
                                        <option value="paid">Paid</option>
                                        <option value="cod">COD</option>
                                        <option value="not_paid">Not Paid</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </header>
                    <div class="card-body">
                        <div class="table-responsive">
                            <div class="table-responsive">
                                <table class="table align-middle table-nowrap mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="align-middle" scope="col">S.No</th>
                                            <th class="align-middle" scope="col">Order ID</th>
                                            <th class="align-middle" scope="col">Billing Name</th>
                                            <th class="align-middle" scope="col">Date</th>
                                            <th class="align-middle" scope="col">Total</th>
                                            <th class="align-middle text-center" scope="col">Payment Status</th>
                                            <th class="align-middle" scope="col">Payment Method</th>
                                            <th class="align-middle" scope="col">View Details</th>
                                        </tr>
                                    </thead>
                                    <tbody id="ordersTableBody">
                                        @forelse($recentOrders as $order)
                                        <tr>
                                            <td>{{ ($recentOrders->currentPage() - 1) * $recentOrders->perPage() + $loop->iteration }}</td>
                                            <td><a href="{{ ($order->order_type === 'billing') ? route('admin.billing.invoice', $order->id) : route('orders.view', $order->id) }}" class="fw-bold">#{{ $order->order_number }}</a></td>
                                            <td>
                                                @if($order->customer_type === 'registered' && $order->customer)
                                                    {{ $order->customer->username }}
                                                @elseif($order->customer_type === 'guest' && $order->guest_details)
                                                    {{ $order->guest_details['first_name'] ?? $order->guest_details['name'] ?? 'Guest' }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>{{ $order->created_at->format('d M, Y') }}</td>
                                            <td>₹{{ number_format($order->final_amount, 2) }}</td>
                                            <td class="text-center">
                                                @if(in_array($order->payment_method, ['cash_on_delivery', 'cod']))
                                                    <button type="button" class="btn btn-sm d-inline-flex justify-content-center align-items-center px-2" style="background-color:#ffc107;color:#000;border-radius:50px;height:24px;font-size:12px;border:none;padding:0;"><i class="bi bi-cash me-1"></i> COD</button>
                                                @elseif($order->payment_status === 'paid')
                                                    <button type="button" class="btn btn-sm d-inline-flex justify-content-center align-items-center px-2" style="background-color:#28a745;color:#fff;border-radius:50px;height:24px;font-size:12px;border:none;padding:0;"><i class="bi bi-check-circle me-1"></i> Paid</button>
                                                @else
                                                    <button type="button" class="btn btn-sm d-inline-flex justify-content-center align-items-center px-2" style="background-color:#dc3545;color:#fff;border-radius:50px;height:24px;font-size:12px;border:none;padding:0;"><i class="bi bi-x-circle me-1"></i> Not Paid</button>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <i class="material-icons md-payment font-xxl text-muted "></i>
                                                    @php
                                                        $method = $order->payment_method ?? 'cash';
                                                        $methodLabel = match(strtolower($method)) {
                                                            'online_gateway', 'online', 'razorpay', 'stripe', 'paytm' => 'Online',
                                                            'cash_on_delivery', 'cod' => 'Cash',
                                                            'cash' => 'Cash',
                                                            default => ucwords(str_replace('_', ' ', $method))
                                                        };
                                                    @endphp
                                                    <span>{{ $methodLabel }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-xs btn-primary view-invoice-btn d-inline-flex align-items-center justify-content-center" style="padding: 3px 7px; font-size: 11px;" data-order-id="{{ $order->id }}"><i class="bi bi-eye-fill me-1"></i> View </button>
                                            </td>
                                        </tr>
                                        @empty
                                            <td colspan="8" class="text-center text-muted py-4">No recent orders found</td>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- table-responsive end// -->
                    </div>
                </div>
              <!-- Pagination -->
<div class="pagination-area mt-30 mb-50">
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-start">
                {{-- Previous Page Link --}}
                @if ($recentOrders->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link">&laquo;</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $recentOrders->appends(request()->query())->previousPageUrl() }}" aria-label="Previous">
                            &laquo;
                        </a>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($recentOrders->appends(request()->query())->getUrlRange(1, $recentOrders->lastPage()) as $page => $url)
                    @if ($page == $recentOrders->currentPage())
                        <li class="page-item active">
                            <a class="page-link" href="#">{{ str_pad($page, 2, '0', STR_PAD_LEFT) }}</a>
                        </li>
                    @else
                        @if ($page == 1 || $page == $recentOrders->lastPage() || abs($page - $recentOrders->currentPage()) <= 1)
                            <li class="page-item">
                                <a class="page-link" href="{{ $url }}">{{ str_pad($page, 2, '0', STR_PAD_LEFT) }}</a>
                            </li>
                        @elseif (abs($page - $recentOrders->currentPage()) == 2)
                            <li class="page-item disabled">
                                <span class="page-link dot">...</span>
                            </li>
                        @endif
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($recentOrders->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $recentOrders->appends(request()->query())->nextPageUrl() }}" aria-label="Next">
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
            <!-- content-main end// -->

@push('scripts')
<script>
$(document).ready(function() {
    const $categoryFilter = $('#categoryFilter');
    const $dateFilter = $('#dateFilter');
    const $statusFilter = $('#statusFilter');
    const $tbody = $('#ordersTableBody');
    
    console.log('Dashboard filter script initialized');

    // Use jQuery for event listeners to handle Select2 properly
    $categoryFilter.on('change', filterOrders);
    $dateFilter.on('change', filterOrders);
    $statusFilter.on('change', filterOrders);
    
    function filterOrders() {
        console.log('Filter triggered!');
        const categoryId = $categoryFilter.val();
        const date = $dateFilter.val();
        const status = $statusFilter.val();
        
        console.log('Filter values:', { categoryId, date, status });
        
        // Build query string
        let params = new URLSearchParams();
        if (categoryId) params.append('category_id', categoryId);
        if (date) params.append('date', date);
        if (status) params.append('status', status);
        
        const url = "{{ route('dashboard.filter.orders') }}?" + params.toString();
        
        // Show loading state
        $tbody.html('<tr><td colspan="8" class="text-center py-4"><i class="material-icons md-autorenew spin"></i> Loading...</td></tr>');
        
        // Make AJAX request
        $.ajax({
            url: url,
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                console.log('AJAX Success:', data);
                if (data.success) {
                    $tbody.html(data.html);
                    // Re-attach event listeners to new detail buttons
                    attachViewDetailsListeners();
                } else {
                    $tbody.html('<tr><td colspan="8" class="text-center text-danger py-4">Error loading orders</td></tr>');
                }
            },
            error: function(xhr, status, error) {
                console.error('Filter AJAX error:', status, error);
                $tbody.html('<tr><td colspan="8" class="text-center text-danger py-4">Error loading orders</td></tr>');
            }
        });
    }

    function attachViewDetailsListeners() {
        $('.view-invoice-btn').off('click').on('click', function() {
            const orderId = $(this).data('order-id');
            openInvoiceModal(orderId);
        });
    }
    
    // Initial attachment
    attachViewDetailsListeners();

    // Invoice Modal initialization
    const modalElement = document.getElementById('invoiceModal');
    if (modalElement) {
        window.invoiceModal = new bootstrap.Modal(modalElement);
    }
});

function openInvoiceModal(orderId) {
    const modalBody = document.getElementById('invoiceModalBody');
    
    // Show loading
    modalBody.innerHTML = '<div class="text-center py-4"><i class="material-icons md-autorenew spin"></i> Loading...</div>';
    
    if (window.invoiceModal) {
        window.invoiceModal.show();
    }
    
    // Fetch invoice content
    fetch('{{ route("admin.billing.invoice.html", "") }}/' + orderId)
        .then(response => response.text())
        .then(html => {
            modalBody.innerHTML = html;
        })
        .catch(error => {
            console.error('Error loading invoice:', error);
            modalBody.innerHTML = '<div class="text-center text-danger py-4">Error loading invoice</div>';
        });
}

function closeInvoiceModal() {
    if (window.invoiceModal) {
        window.invoiceModal.hide();
    }
}

function printInvoice() {
    let printContent = document.getElementById('invoicePrintContent') || document.getElementById('billingInvoicePrintContent');
    let printArea = document.getElementById('dashboardInvoicePrintArea');
    if (!printContent || !printArea) {
        alert('Invoice content not loaded');
        return;
    }
    
    // Copy content to print wrapper at root body
    printArea.innerHTML = printContent.outerHTML;
    printArea.style.display = 'block';
    
    setTimeout(() => {
        window.print();
        
        // Hide print area after printing
        setTimeout(() => {
            printArea.style.display = 'none';
            printArea.innerHTML = '';
        }, 500);
    }, 100);
}
</script>
@endpush

<style>
.spin {
    animation: spin 1s linear infinite;
}
@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}
/* Small Modal Styles */
#invoiceModal .modal-content {
    border-radius: 8px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.2);
}
#invoiceModal .modal-header {
    border-bottom: 1px solid #eee;
}
#invoiceModal .modal-footer {
    border-top: 1px solid #eee;
}

@media print {
    @page { size: portrait; margin: 8mm; }
    
    body > *:not(#dashboardInvoicePrintArea):not(.main-wrap), 
    .main-wrap > *:not(#dashboardInvoicePrintArea), 
    .modal, .modal-backdrop {
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
    
    #dashboardInvoicePrintArea {
        display: block !important;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        margin: 0;
        padding: 0;
    }
}
</style>

<!-- Hidden print area for dashboard modal invoices -->
<div id="dashboardInvoicePrintArea" style="display: none;"></div>

<!-- Invoice Modal -->
<div class="modal fade" id="invoiceModal" tabindex="-1" aria-labelledby="invoiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header py-2" style="background: #f8f9fa;">
                <h6 class="modal-title" id="invoiceModalLabel">Invoice Details</h6>
                <button type="button" class="btn-close btn-close-sm" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-2" id="invoiceModalBody" style="max-height: 70vh; overflow-y: auto;">
                <div class="text-center py-4">
                    <i class="material-icons md-autorenew spin"></i> Loading...
                </div>
            </div>
<div class="modal-footer py-2 d-flex justify-content-end gap-2 w-100">
    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">
       <i class="bi bi-x-circle me-1"></i> Close
    </button>

    <button type="button" class="btn btn-sm btn-primary" onclick="printInvoice()">
        <i class="material-icons md-print" style="font-size:14px; vertical-align:middle;"></i>
        Print
    </button>
</div>
        </div>
    </div>
</div>

 @endsection

