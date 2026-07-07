@extends('layouts.app')

@section('content')
    @include('includes.alert')

    <section class="content-main">
        <div class="content-header d-flex justify-content-between align-items-center">
            <div>
                <h2 class="content-title card-title">Email History</h2>
            </div>
        </div>

        <div class="card mb-4">
            <header class="card-header">
                <form method="GET" action="{{ route('email-history.table') }}" class="w-100">
                    <div class="row gx-3 align-items-center">
                        <div class="col-md-3 col-12">
                            <input type="text" name="search" placeholder="Search by Order ID, Email..." class="form-control"
                                value="{{ $search ?? '' }}" />
                        </div>
                        <div class="col-md-2 col-6">
                            <select name="type" class="form-select">
                                <option value="">Email Type - All</option>
                                <option value="order_confirmation" {{ ($type ?? '') == 'order_confirmation' ? 'selected' : '' }}>Order Confirmation</option>
                                <option value="status_update" {{ ($type ?? '') == 'status_update' ? 'selected' : '' }}>Status
                                    Update</option>
                                <option value="billing_invoice" {{ ($type ?? '') == 'billing_invoice' ? 'selected' : '' }}>
                                    Billing Invoice</option>
                            </select>
                        </div>
                        <div class="col-md-2 col-6">
                            <select name="status" class="form-select">
                                <option value="">Status - All</option>
                                <option value="sent" {{ ($status ?? '') == 'sent' ? 'selected' : '' }}>Sent</option>
                                <option value="failed" {{ ($status ?? '') == 'failed' ? 'selected' : '' }}>Failed</option>
                            </select>
                        </div>
                        <div class="col-md-2 col-6">
                            <button type="submit" class="btn btn-primary w-100">Search</button>
                        </div>
                        @if(($search ?? '') || ($type ?? '') || ($status ?? ''))
                            <div class="col-md-2 col-6">
                                <a href="{{ route('email-history.table') }}" class="btn btn-secondary w-100">Clear</a>
                            </div>
                        @endif
                    </div>
                </form>
            </header>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>No.</th>
                                <th>Order ID</th>
                                <th>Email Type</th>
                                <th>Recipient</th>
                                <th>Subject</th>
                                <th>Sent At</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($emails as $index => $email)
                                <tr>
                                    <td>{{ ($emails->currentPage() - 1) * $emails->perPage() + $index + 1 }}</td>
                                    <td>
                                        @if($email->order_number && $email->order_id)
                                            <a href="javascript:void(0)" class="text-primary fw-bold order-link"
                                                data-order-id="{{ $email->order_id }}" data-bs-toggle="modal"
                                                data-bs-target="#orderDetailsModal">
                                                {{ $email->order_number }}
                                            </a>
                                        @elseif($email->order_number)
                                            <strong>{{ $email->order_number }}</strong>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $typeClass = match ($email->email_type) {
                                                'order_confirmation' => 'bg-info',
                                                'status_update' => 'bg-warning text-dark',
                                                'billing_invoice' => 'bg-primary',
                                                default => 'bg-secondary'
                                            };
                                        @endphp
                                        <span class="badge {{ $typeClass }}">{{ $email->email_type_label }}</span>
                                    </td>
                                    <td>
                                        <div>{{ $email->recipient_name ?? '-' }}</div>
                                        <small class="text-muted">{{ $email->recipient_email }}</small>
                                    </td>
                                    <td>{{ Str::limit($email->subject, 40) }}</td>
                                    <td>
                                        @if($email->sent_at)
                                            {{ $email->sent_at->format('d M Y, h:i A') }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge {{ $email->status_badge_class }}">
                                            {{ ucfirst($email->status) }}
                                        </span>
                                        @if($email->status == 'failed' && $email->error_message)
                                            <i class="bi bi-info-circle text-danger" data-bs-toggle="tooltip"
                                                title="{{ $email->error_message }}"></i>
                                        @endif
                                    </td>
                                    <td>
                                        @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('email-history-delete'))
                                        <form action="{{ route('email-history.delete', $email->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm btn-action-col d-inline-flex align-items-center justify-content-center "
                                                onclick="return confirm('Are you sure to delete this record?')"><i class="bi bi-trash me-1"></i> Delete</button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">
                                        <i class="bi bi-envelope" style="font-size: 48px;"></i>
                                        <p class="mt-2">No email history found.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- PAGINATION --}}
        @if($emails->hasPages())
            <div class="pagination-area mt-30 mb-50">
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-start">
                        {{-- Previous Page Link --}}
                        @if ($emails->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">&laquo;</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $emails->previousPageUrl() }}" aria-label="Previous">
                                    &laquo;
                                </a>
                            </li>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach ($emails->getUrlRange(1, $emails->lastPage()) as $page => $url)
                            @if ($page == $emails->currentPage())
                                <li class="page-item active">
                                    <a class="page-link" href="#">{{ str_pad($page, 2, '0', STR_PAD_LEFT) }}</a>
                                </li>
                            @else
                                @if ($page == 1 || $page == $emails->lastPage() || abs($page - $emails->currentPage()) <= 1)
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $url }}">{{ str_pad($page, 2, '0', STR_PAD_LEFT) }}</a>
                                    </li>
                                @elseif (abs($page - $emails->currentPage()) == 2)
                                    <li class="page-item disabled">
                                        <span class="page-link dot">...</span>
                                    </li>
                                @endif
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($emails->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $emails->nextPageUrl() }}" aria-label="Next">
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
        @endif

    </section>

    <!-- Order Details Modal -->
    <div class="modal fade" id="orderDetailsModal" tabindex="-1" aria-labelledby="orderDetailsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header custom-modal-header text-white">
                    <h5 class="modal-title" id="orderDetailsModalLabel">
                        <i class="bi bi-receipt me-2"></i>Invoice Details
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="orderDetailsContent">
                    <div class="text-center py-5">
                        <div class="spinner-border text-info" role="status"></div>
                        <p class="mt-2 text-muted">Loading...</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });

            // Order Details Modal Close Fix
            // The main.js has a global .btn-close handler that interferes with Bootstrap modals
            document.addEventListener('DOMContentLoaded', function() {
                const orderModal = document.getElementById('orderDetailsModal');
                if (orderModal) {
                    // Get Bootstrap modal instance
                    const bsModal = new bootstrap.Modal(orderModal);
                    
                    // Handle X button click
                    const closeBtn = orderModal.querySelector('.btn-close');
                    if (closeBtn) {
                        closeBtn.addEventListener('click', function(e) {
                            e.preventDefault();
                            e.stopPropagation();
                            bsModal.hide();
                        });
                    }
                    
                    // Handle footer Close button click
                    const footerCloseBtn = orderModal.querySelector('.modal-footer .btn-secondary');
                    if (footerCloseBtn) {
                        footerCloseBtn.addEventListener('click', function(e) {
                            e.preventDefault();
                            e.stopPropagation();
                            bsModal.hide();
                        });
                    }
                }
            });

            // Order Details Popup
            document.querySelectorAll('.order-link').forEach(link => {
                link.addEventListener('click', function () {
                    const orderId = this.dataset.orderId;
                    const orderNumber = this.innerText; // Get order number from link text
                    const contentDiv = document.getElementById('orderDetailsContent');
                    
                    // Update Modal Title
                    document.getElementById('orderDetailsModalLabel').innerHTML = `<i class="bi bi-receipt me-2"></i>Invoice - ${orderNumber}`;

                    // Show loading
                    contentDiv.innerHTML = `
                                <div class="text-center py-5">
                                    <div class="spinner-border text-info" role="status"></div>
                                    <p class="mt-2">Loading invoice...</p>
                                </div>
                            `;

                    // Fetch order details
                    fetch(`{{ url('orders/invoice-html') }}/${orderId}`)
                        .then(response => {
                            if (!response.ok) {
                                // Try billing invoice if orders fails
                                return fetch(`{{ url('billing/invoice-html') }}/${orderId}`);
                            }
                            return response;
                        })
                        .then(response => response.text())
                        .then(html => {
                            contentDiv.innerHTML = html;
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            contentDiv.innerHTML = `
                                        <div class="alert alert-danger">
                                            <i class="bi bi-exclamation-triangle me-2"></i>
                                            Failed to load invoice details. Please try again.
                                        </div>
                                    `;
                        });
                });
            });
        </script>
        <style>
            .custom-modal-header {
                background-color: #00B5B8 !important; /* Custom Teal Color */
            }
            .modal-backdrop {
                background-color: rgba(0, 0, 0, 0.5) !important; /* Standard dark overlay */
            }
            /* Fix modal z-index */
            #orderDetailsModal {
                z-index: 9999 !important;
            }
            #orderDetailsModal .modal-dialog {
                z-index: 10000 !important;
            }
        </style>
    @endpush
@endsection