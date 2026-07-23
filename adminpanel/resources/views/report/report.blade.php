@extends('layouts.app')

@section('content')
    <section class="content-main">
        <div class="content-header">
            <div>
                <h2 class="content-title card-title">Sales Reports</h2>
                <p>View and download your sales reports</p>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <!-- Order Type Tabs with Download Button -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <ul class="nav nav-tabs nav-tabs-custom mb-0" id="reportTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="frontend-tab" data-bs-toggle="tab"
                                data-bs-target="#frontend-orders" type="button" role="tab" data-order-type="frontend">
                                <i class="material-icons md-shopping_cart me-1"></i> Orders
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="billing-tab" data-bs-toggle="tab" data-bs-target="#billing-orders"
                                type="button" role="tab" data-order-type="billing">
                                <i class="material-icons md-payment me-1"></i> Billing Orders
                            </button>
                        </li>
                    </ul>
                    <button type="button" id="downloadExcelBtn" class="btn btn-secondary btn-sm">
                        <i class="bi bi-download me-1" style="font-size: 16px; vertical-align: middle;"></i> Download 
                    </button>
                </div>

                <!-- Filters -->
                <div class="card mb-3">
                    <div class="card-body py-2">
                        <div class="row g-2 align-items-center">
                            <div class="col-md-2">
                                <label class="form-label mb-0 small">Day</label>
                                <select id="reportFilterDay" class="form-select form-select-sm">
                                    <option value="">All Days</option>
                                    @for($i = 1; $i <= 31; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label mb-0 small">Month</label>
                                <select id="reportFilterMonth" class="form-select form-select-sm">
                                    <option value="">All Months</option>
                                    <option value="1">January</option>
                                    <option value="2">February</option>
                                    <option value="3">March</option>
                                    <option value="4">April</option>
                                    <option value="5">May</option>
                                    <option value="6">June</option>
                                    <option value="7">July</option>
                                    <option value="8">August</option>
                                    <option value="9">September</option>
                                    <option value="10">October</option>
                                    <option value="11">November</option>
                                    <option value="12">December</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label mb-0 small">Year</label>
                                <select id="reportFilterYear" class="form-select form-select-sm">
                                    <option value="">All Years</option>
                                    @for($year = date('Y'); $year >= 2020; $year--)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label mb-0 small">Order Type</label>
                                <select id="reportFilterOrderType" class="form-select form-select-sm">
                                    <option value="">Both</option>
                                    <option value="frontend">Orders</option>
                                    <option value="billing">Billing</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label mb-0 small">&nbsp;</label>
                                <div class="d-flex" style="gap: 8px;">
                                    <button type="button" id="reportApplyFilter" class="btn btn-primary btn-sm">
                                        <i class="material-icons md-filter_alt"></i> Filter
                                    </button>
                                    <button type="button" id="reportClearFilter" class="btn btn-secondary btn-sm">
<i class="bi bi-eraser me-1"></i> Clear</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Summary Cards -->
                <div class="row mb-3" id="reportSummary">
                    <div class="col-md-3">
                        <div class="card bg-light">
                            <div class="card-body py-2 text-center">
                                <h6 class="mb-0">Total Orders</h6>
                                <h4 class="text-primary mb-0" id="summaryTotalOrders">0</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-light">
                            <div class="card-body py-2 text-center">
                                <h6 class="mb-0">Total Amount</h6>
                                <h4 class="text-success mb-0">₹<span id="summaryTotalAmount">0.00</span></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-light">
                            <div class="card-body py-2 text-center">
                                <h6 class="mb-0">Paid Orders</h6>
                                <h4 class="text-info mb-0" id="summaryPaidOrders">0</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-light">
                            <div class="card-body py-2 text-center">
                                <h6 class="mb-0">Pending Orders</h6>
                                <h4 class="text-warning mb-0" id="summaryPendingOrders">0</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Results Table -->
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="reportTable">
                        <thead class="table-light">
                            <tr>
                                <th>S.No</th>
                                <th>Order Id</th>
                                <th>Date</th>
                                <th>Customer</th>
                                <th>Amount</th>
                                <th>Payment</th>
                                <th>Order source</th>
                                <th>Payment Status</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="reportTableBody">
                            <tr>
                                <td colspan="11" class="text-center text-muted">
                                    Click "Filter" to load orders
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Pagination Area (Outside Card) -->
        <div class="pagination-area mt-4 mb-50">
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-start" id="reportPaginationList"></ul>
            </nav>
        </div>
    </section>

    <style>
        .nav-tabs-custom .nav-link {
            border: 2px solid transparent;
            border-radius: 8px 8px 0 0;
            font-weight: 500;
            color: #6c757d;
            transition: all 0.3s ease;
            min-width: 170px;
            height: 45px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0;
        }

        .nav-tabs-custom .nav-link:hover {
            border-color: #e9ecef #e9ecef #dee2e6;
            background-color: #f8f9fa;
        }

        .nav-tabs-custom .nav-link.active {
            color: #fff;
            background-color: #5897fb;
            border-color: #5897fb;
        }

        .nav-tabs-custom .nav-link i {
            font-size: 16px;
            vertical-align: middle;
        }

        #reportTable th {
            font-size: 13px;
            font-weight: 600;
        }

        #reportTable td {
            font-size: 13px;
            vertical-align: middle;
        }

        #reportTable .report-row:hover {
            background-color: #e8f4ff;
            transition: background-color 0.2s ease;
        }



        /* Enforce exactly identical physical size for Download Excel, Filter, and Clear buttons */
        #downloadExcelBtn, #reportClearFilter, #reportApplyFilter {
            width: 145px !important;
            height: 36px !important;
            border-radius: 6px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            text-align: center !important;
            padding: 0 !important;
            font-size: 13px !important;
            font-weight: 500 !important;
            margin: 0 !important;
            vertical-align: top !important;
        }

    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const filterDay = document.getElementById('reportFilterDay');
            const filterMonth = document.getElementById('reportFilterMonth');
            const filterYear = document.getElementById('reportFilterYear');
            const filterOrderType = document.getElementById('reportFilterOrderType');
            const applyFilterBtn = document.getElementById('reportApplyFilter');
            const clearFilterBtn = document.getElementById('reportClearFilter');
            const tableBody = document.getElementById('reportTableBody');

            let currentTab = 'frontend';

            // Global references for pagination onclick
            window.fetchReportData = function(page = 1) {
                const orderType = filterOrderType.value || currentTab;
                const day = filterDay.value;
                const month = filterMonth.value;
                const year = filterYear.value;

                // Show loading
                tableBody.innerHTML = '<tr><td colspan="10" class="text-center"><div class="spinner-border spinner-border-sm text-primary" role="status"></div> Loading...</td></tr>';
                const pagList = document.getElementById('reportPaginationList');
                if (pagList) pagList.innerHTML = '';

                const params = new URLSearchParams({
                    order_type: orderType,
                    day: day,
                    month: month,
                    year: year,
                    page: page
                });

                fetch(`{{ route('reports.filter') }}?${params.toString()}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update summary
                            document.getElementById('summaryTotalOrders').textContent = data.summary.total_orders;
                            document.getElementById('summaryTotalAmount').textContent = data.summary.total_amount;
                            document.getElementById('summaryPaidOrders').textContent = data.summary.paid_orders;
                            document.getElementById('summaryPendingOrders').textContent = data.summary.pending_orders;

                            // Update table
                            if (data.orders.length === 0) {
                                tableBody.innerHTML = '<tr><td colspan="11" class="text-center text-muted">No orders found</td></tr>';
                            } else {
                                const billingInvoiceBase = '{{ url("billing/invoice") }}';
                                const ordersInvoiceBase = '{{ url("orders/invoice") }}';

                                tableBody.innerHTML = data.orders.map((order, index) => {
                                    const invoiceUrl = order.order_type === 'Billing'
                                        ? `${billingInvoiceBase}/${order.id}`
                                        : `${ordersInvoiceBase}/${order.id}`;
                                    
                                    // Sequential S.No logic
                                    const sNo = (data.pagination.current_page - 1) * data.pagination.per_page + (index + 1);

                                    return `
                                <tr class="report-row" style="cursor: pointer;" onclick="window.open('${invoiceUrl}', '_blank')">
                                    <td>${sNo}</td>
                                    <td><strong>${order.order_number}</strong></td>
                                    <td>${order.date}</td>
                                    <td>${order.customer}</td>
                                    <td class="text-end"><strong>₹${order.amount}</strong></td>
                                    <td>${(order.payment_method || '').toLowerCase().includes('cash') || (order.payment_method || '').toLowerCase().includes('cod') ? 'COD' : 'Online'}</td>
                                    <td>
                                        <span class="badge ${order.order_source === 'app' ? 'bg-success' : (order.order_source === 'web' ? 'bg-primary' : 'bg-warning')}">
                                            ${order.order_source === 'app' ? '<i class="bi bi-phone me-1"></i>' : (order.order_source === 'web' ? '<i class="bi bi-globe me-1"></i>' : '<i class="bi bi-display me-1"></i>')} ${order.order_source ? order.order_source.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase()) : 'N/A'}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge ${
                                            (order.payment_status === 'Paid') 
                                                ? 'bg-success text-white' 
                                                : ((order.payment_status && order.payment_status.toLowerCase() === 'cod') ? 'bg-warning text-dark' : 'bg-danger text-white')
                                        }">
                                            ${(order.payment_status === 'Paid') ? '<i class="bi bi-check-circle me-1"></i> Paid' : ((order.payment_status && order.payment_status.toLowerCase() === 'cod') ? '<i class="bi bi-cash me-1"></i> COD' : '<i class="bi bi-x-circle me-1"></i> Not Paid')}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge ${
                                            {'confirmed':'bg-success text-white',
                                             'hold':'bg-warning text-dark', 'pending':'bg-warning text-dark',
                                             'processing':'bg-info text-white',
                                             'shipped':'bg-primary text-white',
                                             'delivered':'bg-success text-white',
                                             'cancelled':'bg-danger text-white'}[(order.status || '').toLowerCase()] || 'bg-info text-dark' 
                                        }">
                                        ${
                                            {'hold':'<i class="bi bi-clock me-1"></i> Hold', 'pending':'<i class="bi bi-clock me-1"></i> Hold',
                                             'confirmed':'<i class="bi bi-check2-circle me-1"></i> Confirmed',
                                             'processing':'<i class="bi bi-arrow-repeat me-1"></i> Processing',
                                             'shipped':'<i class="bi bi-truck me-1"></i> Shipped',
                                             'delivered':'<i class="bi bi-box-seam me-1"></i> Delivered',
                                             'cancelled':'<i class="bi bi-x-octagon me-1"></i> Cancelled'}[(order.status || '').toLowerCase()] || '<i class="bi bi-arrow-repeat me-1"></i> ' + order.status
                                        }
                                        </span>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-info text-white" onclick="event.stopPropagation(); window.open('${invoiceUrl}', '_blank');" title="View Invoice">
                                            <i class="bi bi-printer-fill me-1"></i> Print
                                        </button>
                                    </td>
                                </tr>
                            `}).join('');

                                // Render Pagination
                                renderPagination(data.pagination);
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        tableBody.innerHTML = '<tr><td colspan="11" class="text-center text-danger">Error loading data</td></tr>';
                    });
            };

            window.renderPagination = function(pagination) {
                const list = document.getElementById('reportPaginationList');
                if (!pagination || pagination.last_page <= 1) {
                    list.innerHTML = '';
                    return;
                }

                let html = '';
                const pad = (num) => num.toString().padStart(2, '0');

                // Previous button
                if (pagination.current_page > 1) {
                    html += `
                        <li class="page-item">
                            <a class="page-link" href="#" onclick="event.preventDefault(); fetchReportData(${pagination.current_page - 1})">
                                &laquo;
                            </a>
                        </li>
                    `;
                } else {
                    html += `
                        <li class="page-item disabled">
                            <span class="page-link">&laquo;</span>
                        </li>
                    `;
                }

                // Page numbers
                const start = Math.max(1, pagination.current_page - 2);
                const end = Math.min(pagination.last_page, pagination.current_page + 2);

                if (start > 1) {
                    html += `<li class="page-item"><a class="page-link" href="#" onclick="event.preventDefault(); fetchReportData(1)">01</a></li>`;
                    if (start > 2) html += `<li class="page-item disabled"><span class="page-link dot">...</span></li>`;
                }

                for (let i = start; i <= end; i++) {
                    html += `
                        <li class="page-item ${i === pagination.current_page ? 'active' : ''}">
                            <a class="page-link" href="#" onclick="event.preventDefault(); fetchReportData(${i})">${pad(i)}</a>
                        </li>
                    `;
                }

                if (end < pagination.last_page) {
                    if (end < pagination.last_page - 1) html += `<li class="page-item disabled"><span class="page-link dot">...</span></li>`;
                    html += `<li class="page-item"><a class="page-link" href="#" onclick="event.preventDefault(); fetchReportData(${pagination.last_page})">${pad(pagination.last_page)}</a></li>`;
                }

                // Next button
                if (pagination.current_page < pagination.last_page) {
                    html += `
                        <li class="page-item">
                            <a class="page-link" href="#" onclick="event.preventDefault(); fetchReportData(${pagination.current_page + 1})">
                                &raquo;
                            </a>
                        </li>
                    `;
                } else {
                    html += `
                        <li class="page-item disabled">
                            <span class="page-link">&raquo;</span>
                        </li>
                    `;
                }

                list.innerHTML = html;
            };

            // Tab change handler
            document.querySelectorAll('#reportTabs button').forEach(tab => {
                tab.addEventListener('click', function () {
                    currentTab = this.dataset.orderType;
                    // Update active class
                    document.querySelectorAll('#reportTabs button').forEach(t => t.classList.remove('active'));
                    this.classList.add('active');
                    fetchReportData();
                });
            });

            // Apply filter
            if (applyFilterBtn) {
                applyFilterBtn.addEventListener('click', () => fetchReportData(1));
            }

            // Clear filter
            if (clearFilterBtn) {
                clearFilterBtn.addEventListener('click', function () {
                    filterDay.value = '';
                    filterMonth.value = '';
                    filterYear.value = '';
                    filterOrderType.value = '';
                    fetchReportData(1);
                });
            }

            // Download Excel button handler
            const downloadExcelBtn = document.getElementById('downloadExcelBtn');
            if (downloadExcelBtn) {
                downloadExcelBtn.addEventListener('click', function () {
                    const orderType = filterOrderType.value || currentTab;
                    const day = filterDay.value;
                    const month = filterMonth.value;
                    const year = filterYear.value;

                    const params = new URLSearchParams({
                        order_type: orderType,
                        day: day,
                        month: month,
                        year: year
                    });

                    // Redirect to download URL
                    window.location.href = `{{ route('reports.export.excel') }}?${params.toString()}`;
                });
            }

            // Load data on page load
            fetchReportData(1);

        });
    </script>
@endsection
