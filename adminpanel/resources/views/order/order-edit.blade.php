@extends('layouts.app')
@section('content')
    <style>
        .raise-invoice-container {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin: 20px 0;
            padding: 25px;
        }

        .raise-invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            margin-bottom: 15px;
        }

        .raise-invoice-header .back-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 18px;
            font-weight: 600;
            color: #333;
            text-decoration: none;
        }

        .raise-invoice-header .back-btn:hover {
            color: #00bcd4;
        }

        .raise-invoice-header .back-btn i {
            font-size: 20px;
        }

        .breadcrumb-nav {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .breadcrumb-nav a {
            text-decoration: none;
            color: #333;
            font-size: 14px;
            padding: 8px 16px;
            border-radius: 5px;
            border: 1px solid #ddd;
            background: #f5f5f5;
        }

        .breadcrumb-nav a:hover {
            background: #e0e0e0;
        }

        .breadcrumb-nav a i {
            margin-right: 5px;
        }

        .form-section {
            margin-bottom: 20px;
        }

        .form-section label {
            font-weight: 700;
            color: #333;
            margin-bottom: 10px;
            display: block;
            font-size: 16px;
        }

        .form-section .form-label-value {
            font-weight: 600;
            color: #333;
            font-size: 16px;
        }

        .status-radio-group {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .status-radio-group .form-check {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .status-radio-group .form-check-input {
            width: 18px;
            height: 18px;
            cursor: pointer;
            margin: 0 !important;
        }

        .status-radio-group .form-check-label {
            cursor: pointer;
            font-size: 14px;
            font-weight: 400;
            margin: 0 !important;
            line-height: 1;
            padding-top: 2px;
        }

        .btn-group-actions {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            margin-top: 20px;
        }

        .btn-save {
            background: #f44336;
            color: #fff;
            border: none;
            padding: 10px 30px;
            border-radius: 5px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-save:hover {
            background: #d32f2f;
            color: #fff;
        }

        .btn-cancel {
            background: #f5f5f5;
            color: #333;
            border: 1px solid #ddd;
            padding: 10px 30px;
            border-radius: 5px;
            font-weight: 500;
        }

        .btn-cancel:hover {
            background: #e0e0e0;
        }

        .order-history-section {
            margin-top: 30px;
            background: #f5f5f5;
            border-radius: 8px;
            overflow: hidden;
        }

        .order-history-header {
            background: #666;
            color: #fff;
            padding: 12px 20px;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 14px;
        }

        .order-history-table {
            width: 100%;
            background: #fff;
        }

        .order-history-table th {
            background: #e0e0e0;
            padding: 12px 20px;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 12px;
            color: #333;
            border-bottom: 1px solid #ddd;
        }

        .order-history-table td {
            padding: 12px 20px;
            font-size: 14px;
            border-bottom: 1px solid #eee;
            color: #555;
        }

        .order-history-table tbody tr:last-child td {
            border-bottom: none;
        }
    </style>

    <section class="content-main">
        <div class="container">


            <!-- Header with Back Button -->
            <div class="raise-invoice-header">
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('orders.view', $order->id) }}" class="back-btn">
                        <i class="bi bi-arrow-left-circle"></i>
                    </a>
                    <h2 class="mb-0">List - Raise Invoice</h2>
                </div>
                <div class="breadcrumb-nav">
                    <a href="{{ route('index') }}"><i class="bi bi-house-fill"></i> Home</a>
                    <a href="{{ route('orders.table') }}"><i class="bi bi-list-ul"></i> Shipping list</a>
                </div>
            </div>

            <!-- Main Content Card -->
            <div class="raise-invoice-container">
                <div class="card-header bg-transparent border-0 pb-3" style="border-bottom: 1px solid #eee !important;">
                    <h4 class="mb-0" style="font-size: 20px; font-weight: 600;">Raise Invoice</h4>
                </div>

                <form id="raiseInvoiceForm" action="{{ route('orders.notes.update', $order->id) }}" method="POST" novalidate>
                    @csrf

                    <div class="card-body pt-4">
                        <!-- Order Id -->
                        <div class="form-section">
                            <label>Order Id: <span class="form-label-value text-primary"
                                    style="font-size: 18px;">{{ $order->order_number }}</span></label>
                        </div>

                        <!-- Status Radio Buttons -->
                        <div class="form-section">
                            <label>Status</label>
                            @php
                                // Default to pending if status is not one of the 5 options
                                $currentStatus = in_array($order->status, ['pending', 'processing', 'shipped', 'delivered', 'cancelled']) ? $order->status : 'pending';
                            @endphp
                            <div class="status-radio-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="statusPending"
                                        value="pending" {{ $currentStatus == 'pending' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="statusPending">Hold</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="statusProcessing"
                                        value="processing" {{ $currentStatus == 'processing' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="statusProcessing">Processing</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="statusShipping"
                                        value="shipped" {{ $currentStatus == 'shipped' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="statusShipping">Shipped</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="statusDelivered"
                                        value="delivered" {{ $currentStatus == 'delivered' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="statusDelivered">Delivered</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="status" id="statusCancelled"
                                        value="cancelled" {{ $currentStatus == 'cancelled' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="statusCancelled">Cancelled</label>
                                </div>
                            </div>
                        </div>

                        <!-- Deliver Comments -->
                        <div class="form-section">
                            <label for="deliverComments">Deliver Comments:</label>
                            <textarea class="form-control" id="deliverComments" name="notes" rows="5"
                                placeholder="Enter delivery comments...">{{ $order->notes ?? '' }}</textarea>
                        </div>

                        <!-- Action Buttons -->
                        <div class="btn-group-actions">
                            <button type="submit" class="btn btn-save"><i class="bi bi-save me-1"></i> Save</button>
                            <a href="{{ route('orders.view', $order->id) }}" class="btn btn-cancel">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Order History Section -->
            <div class="order-history-section">
                <div class="order-history-header">
                    Order History
                </div>
                <table class="order-history-table" id="orderHistoryTable">
                    <thead>
                        <tr>
                            <th>SI.No</th>
                            <th>Status</th>
                            <th>Message</th>
                            <th>Update At</th>
                        </tr>
                    </thead>
                    <tbody id="orderHistoryBody">
                        {{-- Show Create Order as first entry --}}
                        <tr>
                            <td>1.</td>
                            <td>Create Order</td>
                            <td>-</td>
                            <td>{{ $order->created_at->format('d/m/y, H:i:s') }}</td>
                        </tr>
                        {{-- Show order histories --}}
                        @foreach($orderHistories as $index => $history)
                            <tr>
                                <td>{{ $index + 2 }}.</td>
                                <td>{{ ucfirst($history->status) == 'Pending' ? 'Hold' : ucfirst($history->status) }}</td>
                                <td>{!! $history->message !!}</td>
                                <td>{{ $history->created_at->format('d/m/y, H:i:s') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('raiseInvoiceForm');
            let rowCount = {{ count($orderHistories) + 1 }};

            form.addEventListener('submit', function (e) {
                e.preventDefault();

                const formData = new FormData(form);
                const submitBtn = form.querySelector('button[type="submit"]');
                const originalBtnText = submitBtn.innerHTML;
                const selectedStatus = formData.get('status');
                const notesValue = formData.get('notes');

                // Show loading state
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...';

                fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        notes: notesValue,
                        status: selectedStatus
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalBtnText;

                        if (data.success) {
                            // Add new row to the order history table
                            rowCount++;
                            const tbody = document.getElementById('orderHistoryBody');
                            const now = new Date();
                            const dateStr = now.toLocaleDateString('en-GB', {
                                day: '2-digit',
                                month: '2-digit',
                                year: '2-digit'
                            }).replace(/\//g, '/') + ', ' + now.toLocaleTimeString('en-GB', {
                                hour: '2-digit',
                                minute: '2-digit',
                                hour12: false
                            });

                            // Get display label for status
                            const statusLabel = selectedStatus === 'pending' ? 'Hold' :
                                (selectedStatus.charAt(0).toUpperCase() + selectedStatus.slice(1));

                            const notesDisplay = (notesValue && notesValue.trim() !== '') ? notesValue : statusLabel;

                            const newRow = document.createElement('tr');
                            newRow.innerHTML = `
                                            <td>${rowCount}.</td>
                                            <td>${statusLabel}</td>
                                            <td>${notesDisplay}</td>
                                            <td>${dateStr}</td>
                                        `;
                            tbody.appendChild(newRow);
                            document.getElementById('deliverComments').value = '';

                            if (typeof toastr !== 'undefined') {
                                toastr.success(data.message);
                            } else {
                                alert(data.message);
                            }
                            // Stay on the same page - no redirect
                        } else {
                            if (typeof toastr !== 'undefined') {
                                toastr.error(data.message || 'Failed to save changes');
                            } else {
                                alert('Error: ' + (data.message || 'Failed to save changes'));
                            }
                        }
                    })
                    .catch(error => {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalBtnText;
                        console.error('Error:', error);
                        if (typeof toastr !== 'undefined') {
                            toastr.error('An error occurred while saving.');
                        } else {
                            alert('An error occurred while saving.');
                        }
                    });
            });
        });
    </script>
@endpush