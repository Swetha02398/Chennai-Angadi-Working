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
                <!-- <div class="row">
                    <div class="col-xl-8 col-lg-12">
                        <div class="card mb-4">
                            <article class="card-body">
                                <h5 class="card-title">Sale statistics</h5>
                                <canvas id="myChart" height="120px"></canvas>
                            </article>
                        </div>
                        <div class="row">
                            <div class="col-lg-5">
                                <div class="card mb-4">
                                    <article class="card-body">
                                        <h5 class="card-title">New Members</h5>
                                        <div class="new-member-list">
                                            <div class="d-flex align-items-center justify-content-between mb-4">
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ asset('assets/imgs/people/avatar-4.png') }}" alt="" class="avatar" />
                                                    <div>
                                                        <h6>Patric Adams</h6>
                                                        <p class="text-muted font-xs">Sanfrancisco</p>
                                                    </div>
                                                </div>
                                                <a href="#" class="btn btn-xs"><i class="material-icons md-add"></i> Add</a>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mb-4">
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ asset('assets/imgs/people/avatar-2.png') }}" alt="" class="avatar" />
                                                    <div>
                                                        <h6>Dilan Specter</h6>
                                                        <p class="text-muted font-xs">Sanfrancisco</p>
                                                    </div>
                                                </div>
                                                <a href="#" class="btn btn-xs"><i class="material-icons md-add"></i> Add</a>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mb-4">
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ asset('assets/imgs/people/avatar-3.png') }}" alt="" class="avatar" />
                                                    <div>
                                                        <h6>Tomas Baker</h6>
                                                        <p class="text-muted font-xs">Sanfrancisco</p>
                                                    </div>
                                                </div>
                                                <a href="#" class="btn btn-xs"><i class="material-icons md-add"></i> Add</a>
                                            </div>
                                        </div>
                                    </article>
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="card mb-4">
                                    <article class="card-body">
                                        <h5 class="card-title">Recent activities</h5>
                                        <ul class="verti-timeline list-unstyled font-sm">
                                            <li class="event-list">
                                                <div class="event-timeline-dot">
                                                    <i class="material-icons md-play_circle_outline font-xxl"></i>
                                                </div>
                                                <div class="media">
                                                    <div class="me-3">
                                                        <h6><span>Today</span> <i class="material-icons md-trending_flat text-brand ml-15 d-inline-block"></i></h6>
                                                    </div>
                                                    <div class="media-body">
                                                        <div>Lorem ipsum dolor sit amet consectetur</div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="event-list active">
                                                <div class="event-timeline-dot">
                                                    <i class="material-icons md-play_circle_outline font-xxl animation-fade-right"></i>
                                                </div>
                                                <div class="media">
                                                    <div class="me-3">
                                                        <h6><span>17 May</span> <i class="material-icons md-trending_flat text-brand ml-15 d-inline-block"></i></h6>
                                                    </div>
                                                    <div class="media-body">
                                                        <div>Debitis nesciunt voluptatum dicta reprehenderit</div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="event-list">
                                                <div class="event-timeline-dot">
                                                    <i class="material-icons md-play_circle_outline font-xxl"></i>
                                                </div>
                                                <div class="media">
                                                    <div class="me-3">
                                                        <h6><span>13 May</span> <i class="material-icons md-trending_flat text-brand ml-15 d-inline-block"></i></h6>
                                                    </div>
                                                    <div class="media-body">
                                                        <div>Accusamus voluptatibus voluptas.</div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="event-list">
                                                <div class="event-timeline-dot">
                                                    <i class="material-icons md-play_circle_outline font-xxl"></i>
                                                </div>
                                                <div class="media">
                                                    <div class="me-3">
                                                        <h6><span>05 April</span> <i class="material-icons md-trending_flat text-brand ml-15 d-inline-block"></i></h6>
                                                    </div>
                                                    <div class="media-body">
                                                        <div>At vero eos et accusamus et iusto odio dignissi</div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="event-list">
                                                <div class="event-timeline-dot">
                                                    <i class="material-icons md-play_circle_outline font-xxl"></i>
                                                </div>
                                                <div class="media">
                                                    <div class="me-3">
                                                        <h6><span>26 Mar</span> <i class="material-icons md-trending_flat text-brand ml-15 d-inline-block"></i></h6>
                                                    </div>
                                                    <div class="media-body">
                                                        <div>Responded to need “Volunteer Activities</div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </article>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-12">
                        <div class="card mb-4">
                            <article class="card-body">
                                <h5 class="card-title">Revenue Base on Area</h5>
                                <canvas id="myChart2" height="217"></canvas>
                            </article>
                        </div>
                        <div class="card mb-4">
                            <article class="card-body">
                                <h5 class="card-title">Marketing Chanel</h5>
                                <span class="text-muted font-xs">Facebook</span>
                                <div class="progress mb-3">
                                    <div class="progress-bar" role="progressbar" style="width: 15%">15%</div>
                                </div>
                                <span class="text-muted font-xs">Instagram</span>
                                <div class="progress mb-3">
                                    <div class="progress-bar" role="progressbar" style="width: 65%">65%</div>
                                </div>
                                <span class="text-muted font-xs">Google</span>
                                <div class="progress mb-3">
                                    <div class="progress-bar" role="progressbar" style="width: 51%">51%</div>
                                </div>
                                <span class="text-muted font-xs">Twitter</span>
                                <div class="progress mb-3">
                                    <div class="progress-bar" role="progressbar" style="width: 80%">80%</div>
                                </div>
                                <span class="text-muted font-xs">Other</span>
                                <div class="progress mb-3">
                                    <div class="progress-bar" role="progressbar" style="width: 80%">80%</div>
                                </div>
                            </article>
                        </div>
                    </div>
                </div> -->
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
                                                    <button type="button" class="btn btn-sm d-inline-flex justify-content-center align-items-center" style="background-color:#ffc107;color:#000;border-radius:50px;width:80px;height:24px;font-size:12px;border:none;padding:0;">COD</button>
                                                @elseif($order->payment_status === 'paid')
                                                    <button type="button" class="btn btn-sm d-inline-flex justify-content-center align-items-center" style="background-color:#28a745;color:#fff;border-radius:50px;width:80px;height:24px;font-size:12px;border:none;padding:0;">Paid</button>
                                                @else
                                                    <button type="button" class="btn btn-sm d-inline-flex justify-content-center align-items-center" style="background-color:#dc3545;color:#fff;border-radius:50px;width:80px;height:24px;font-size:12px;border:none;padding:0;">Not Paid</button>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <i class="material-icons md-payment font-xxl text-muted me-2"></i>
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
                                                <button type="button" class="btn btn-xs btn-primary view-invoice-btn" data-order-id="{{ $order->id }}">View details</button>
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
    if (!printContent) {
        alert('Invoice content not loaded');
        return;
    }
    
    const printWindow = window.open('', '_blank');
    printWindow.document.write('<html><head><title>Print Invoice</title>');
    printWindow.document.write('<style>');
    printWindow.document.write(`
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Arial', sans-serif; font-size: 11px; background: #fff; color: #000; padding: 10mm; font-weight: bold; }
        .top-section { display: flex; justify-content: space-between; margin-bottom: 8px; }
        .to-section { flex: 1; }
        .to-label { color: #dc3545; font-weight: bold; margin-bottom: 2px; font-size: 12px; }
        .customer-name { font-weight: bold; margin-bottom: 1px; font-size: 13px; color: #000; }
        .address-line { line-height: 1.3; font-size: 11px; color: #000; }
        .order-info-box { border-left: 1px dashed #000; padding-left: 15px; text-align: left; min-width: 120px; }
        .order-info-box .order-id-label { font-size: 11px; color: #dc3545; font-weight: bold; }
        .order-info-box .order-id { font-weight: bold; font-size: 12px; color: #dc3545; }
        .order-info-box .state { font-size: 11px; margin-top: 3px; font-weight: bold; color: #000; }
        .from-section { margin-bottom: 8px; font-size: 11px; padding-bottom: 6px; border-bottom: 1px dashed #000; color: #000; font-weight: bold; line-height: 1.4; }
        .from-label { font-weight: bold; }
        .from-company { color: #000; font-weight: bold; }
        .header-section { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px; }
        .logo-section { display: flex; flex-direction: row; align-items: center; gap: 5px; }
        .logo-section img { height: 48px; width: auto; }
        .title-section { text-align: center; flex: 1; }
        .title-section .title { font-size: 18px; font-weight: bold; color: #000; text-transform: uppercase; }
        .company-details { text-align: right; font-size: 11px; line-height: 1.4; }
        .company-details .name { font-weight: bold; color: #000; font-size: 12px; }
        .company-details .contact { color: #000; font-weight: bold; }
        .items-table { width: 100%; border-collapse: collapse; margin-bottom: 0; border: 2px solid #000; }
        .items-table th { background: #e8e8e8; border: 2px solid #000; padding: 4px 8px; text-align: left; font-weight: bold; font-size: 12px; color: #000; }
        .items-table th.price-col, .items-table th.subtotal-col { text-align: right; }
        .items-table th.qty-col { text-align: center; }
        .items-table td { padding: 5px 8px; border: 1px solid #000; font-size: 12px; vertical-align: top; font-weight: bold; color: #000; }
        .items-table td.sno-col { text-align: left; width: 35px; }
        .items-table td.price-col { text-align: right; width: 75px; }
        .items-table td.qty-col { text-align: center; width: 45px; }
        .items-table td.subtotal-col { text-align: right; width: 90px; color: #000; }
        .items-table .product-name { color: #000; }
        .summary-container { display: flex; flex-direction: column; align-items: flex-end; margin-top: 0; width: 100%; }
        .summary-row { display: flex; justify-content: space-between; width: 100%; font-size: 13px; border: 1px solid #000; border-top: 1px solid #000; }
        .summary-row .label { text-align: left; font-weight: bold; color: #dc3545 !important; padding: 6px 10px; flex: 1; }
        .summary-row .amount { text-align: right; font-weight: bold; color: #dc3545 !important; padding: 6px 10px; width: 100px; border-left: 1px solid #000; }
        .summary-row.total { border: 2px solid #000; border-top: 2px solid #000; }
        .summary-row.total .label { font-size: 14px; text-transform: uppercase; color: #dc3545 !important; }
        .summary-row.total .amount { font-size: 16px; color: #dc3545 !important; border-left: 2px solid #000; }
        .footer { text-align: center; margin-top: 15px; font-size: 10px; color: #000; line-height: 1.4; font-weight: bold; border-top: 1px dashed #000; padding-top: 8px; }
        .footer a { color: #dc3545; text-decoration: none; font-weight: bold; }
        .hide-on-print { display: none !important; }
    `);
    printWindow.document.write('</style></head><body>');
    printWindow.document.write(printContent.innerHTML);
    printWindow.document.close();
    printWindow.onload = function() {
        printWindow.print();
        printWindow.close();
    };
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
</style>

<!-- Invoice Modal -->
<div class="modal fade" id="invoiceModal" tabindex="-1" aria-labelledby="invoiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 500px;">
        <div class="modal-content">
            <div class="modal-header py-2" style="background: #f8f9fa;">
                <h6 class="modal-title" id="invoiceModalLabel">Invoice Details</h6>
                <button type="button" class="btn-close btn-close-sm" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-2" id="invoiceModalBody" style="max-height: 60vh; overflow-y: auto;">
                <div class="text-center py-4">
                    <i class="material-icons md-autorenew spin"></i> Loading...
                </div>
            </div>
            <div class="modal-footer py-2">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-sm btn-primary" onclick="printInvoice()"><i class="material-icons md-print" style="font-size: 14px; vertical-align: middle;"></i> Print</button>
            </div>
        </div>
    </div>
</div>

 @endsection