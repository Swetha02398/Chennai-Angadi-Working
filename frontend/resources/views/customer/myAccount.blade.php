@extends('layouts.app')
@section('content')
    @include('includes.alert')
    <main class="main pages">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="{{ route('index') }}" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                    <span></span> My Account
                </div>
            </div>
        </div>
        <div class="page-content py-3">           
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 m-auto">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="dashboard-menu">
                                    <ul class="nav flex-column" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="dashboard-tab" data-bs-toggle="tab"
                                                href="#dashboard" role="tab" aria-controls="dashboard"
                                                aria-selected="false"><i
                                                    class="fi-rs-settings-sliders mr-10"></i>Dashboard</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="orders-tab" data-bs-toggle="tab" href="#orders"
                                                role="tab" aria-controls="orders" aria-selected="false"><i
                                                    class="fi-rs-shopping-bag mr-10"></i>Orders </a>
                                        </li>

                                        <!-- <li class="nav-item">
                                                                                                        <a class="nav-link" id="address-tab" data-bs-toggle="tab" href="#address"
                                                                                                            role="tab" aria-controls="address" aria-selected="true"><i
                                                                                                                class="fi-rs-marker mr-10"></i>My Address</a>
                                                                                                    </li> -->
                                        @if($customer)
                                            <li class="nav-item">
                                                <a class="nav-link" id="account-detail-tab" data-bs-toggle="tab"
                                                    href="#account-detail" role="tab" aria-controls="account-detail"
                                                    aria-selected="true"><i class="fi-rs-user mr-10"></i>Account details</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{ route('logout') }}"><i
                                                        class="fi-rs-sign-out mr-10"></i>Logout</a>
                                            </li>
                                        @else
                                            <li class="nav-item">
                                                <a class="nav-link" href="javascript:void(0);" onclick="openLoginModal()"><i
                                                        class="fi-rs-sign-in mr-10"></i>Login</a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="tab-content account dashboard-content">
                                    <div class="tab-pane fade active show" id="dashboard" role="tabpanel"
                                        aria-labelledby="dashboard-tab">
                                        <h4 class="mb-0">Hello {{ $customer->username ?? 'Guest' }}!</h4>
                                        <p>From your account dashboard. you can easily check &amp; view your <a
                                                        href="#">recent orders</a>,<br />
                                                    manage your <a href="#">shipping and billing addresses</a> and <a
                                                        href="#">edit your password and account details.</a>
                                                </p>                                        
                                    </div>
                                    <div class="tab-pane fade" id="orders" role="tabpanel" aria-labelledby="orders-tab">
                                        <div class="card">
                                                <h4 class="mb-0">Your Orders</h4>
                                            <div class="card-body p-0 pt-3">
                                                @if($orders->isEmpty())
                                                    <div class="text-center py-5">
                                                        <i class="fi-rs-shopping-bag" style="font-size: 48px; color: #ccc;"></i>
                                                        <p class="mt-3 text-muted">You haven't placed any orders yet.</p>
                                                        <a href="{{ route('shop') }}" class="btn btn-fill-out">Start
                                                            Shopping</a>
                                                    </div>
                                                @else
                                                    <div class="table-responsive">
                                                        <table class="table tableStyles">
                                                            <thead>
                                                                <tr>
                                                                    <th>Order</th>
                                                                    <th>Date</th>
                                                                    <th>Status</th>
                                                                    <th>Payment</th>
                                                                    <th>Total</th>
                                                                    <th>Actions</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($orders as $index => $order)
                                                                    <tr>
                                                                        <td>#{{ $order->order_number }}</td>
                                                                        <td>{{ \Carbon\Carbon::parse($order->created_at)->format('M d, Y') }}
                                                                        </td>
                                                                        <td>
                                                                            <span
                                                                                class="badge 
                                                                                    @if($order->status == 'pending') bg-warning
                                                                                    @elseif($order->status == 'placed') bg-info
                                                                                    @elseif($order->status == 'processing') bg-primary
                                                                                    @elseif($order->status == 'shipped') bg-secondary
                                                                                    @elseif($order->status == 'delivered') bg-success
                                                                                    @elseif($order->status == 'cancelled') bg-danger
                                                                                    @else bg-secondary
                                                                                    @endif">
                                                                                {{ ucfirst($order->status) }}
                                                                            </span>
                                                                        </td>
                                                                        <td>
                                                                            <span class="badge 
                                                                                    @if($order->payment_status == 'paid') bg-success
                                                                                    @elseif($order->payment_status == 'cod') bg-warning
                                                                                    @elseif($order->payment_status == 'pending') bg-warning
                                                                                    @elseif($order->payment_status == 'not_paid') bg-danger
                                                                                    @elseif($order->payment_status == 'failed') bg-danger
                                                                                    @elseif($order->payment_status == 'refunded') bg-info
                                                                                    @else bg-secondary
                                                                                    @endif">
                                                                                {{ $order->payment_status === 'cod' ? 'COD' : ($order->payment_status === 'not_paid' ? 'Not Paid' : ucfirst($order->payment_status ?? 'Pending')) }}
                                                                            </span>
                                                                        </td>
                                                                        <td>₹{{ number_format($order->final_amount, 2) }} for
                                                                            {{ $order->items->sum('qty') }} item(s)
                                                                        </td>
                                                                        <td>
                                                                            <button class="btn me-2 px-3 py-1"
                                                                                onclick="viewOrder({{ $order->id }})">View</button>
                                                                            <button class="btn px-3 py-1"
                                                                                onclick="downloadInvoice({{ $order->id }})">
                                                                                <i class="fi-rs-download"></i> Invoice
                                                                            </button>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="track-orders" role="tabpanel"
                                        aria-labelledby="track-orders-tab">
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="mb-0">Orders tracking</h3>
                                            </div>
                                            <div class="card-body contact-from-area">
                                                <p>To track your order please enter your Order Id in the box below and
                                                    press
                                                    "Track" button. This was given to you on your receipt and in the
                                                    confirmation email you should have received.</p>
                                                <div class="row">
                                                    <div class="col-lg-8">
                                                        <form class="contact-form-style mt-30 mb-30" id="track_order_form"
                                                            onsubmit="return trackOrder(event)">
                                                            @csrf
                                                            <div class="input-style mb-20">
                                                                <label>Order Id</label>
                                                                <input name="order_number" id="track_order_number"
                                                                    placeholder="e.g., ORD-XXXXXXXX-XXXXXXXX" type="text"
                                                                    required />
                                                            </div>
                                                            <button class="submit submit-auto-width" id="track_order_btn"
                                                                type="submit">Track</button>
                                                            <div id="track_order_message" class="mt-15"></div>
                                                        </form>
                                                    </div>
                                                </div>

                                                {{-- Track Order Result --}}
                                                <div id="track_order_result" style="display: none;">
                                                    <div class="track-order-card">
                                                        <div class="order-header-track">
                                                            <h5><i class="fi-rs-box mr-10"></i>Order Details</h5>
                                                        </div>
                                                        <div class="order-info-track">
                                                            <div class="row">
                                                                <div class="col-md-6 mb-15">
                                                                    <p class="mb-5"><strong>Order Id:</strong></p>
                                                                    <p id="result_order_number" class="text-brand">-</p>
                                                                </div>
                                                                <div class="col-md-6 mb-15">
                                                                    <p class="mb-5"><strong>Order Status:</strong></p>
                                                                    <p><span id="result_order_status"
                                                                            class="badge bg-primary">-</span></p>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6 mb-15">
                                                                    <p class="mb-5"><strong>Order Date:</strong></p>
                                                                    <p id="result_order_date">-</p>
                                                                </div>
                                                                <div class="col-md-6 mb-15">
                                                                    <p class="mb-5"><strong>Total Amount:</strong></p>
                                                                    <p id="result_order_total" class="text-brand fw-bold">-
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <p class="mb-10"><strong>Tracking Notes:</strong></p>
                                                                    <div id="result_order_notes" class="tracking-notes-box">
                                                                        -</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="address" role="tabpanel" aria-labelledby="address-tab">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="card mb-3 mb-lg-0">
                                                    <div class="card-header">
                                                        <h3 class="mb-0">Billing Address</h3>
                                                    </div>
                                                    <div class="card-body">
                                                        <address>
                                                            3522 Interstate<br />
                                                            75 Business Spur,<br />
                                                            Sault Ste. <br />Marie, MI 49783
                                                        </address>
                                                        <p>New York</p>
                                                        <a href="#" class="btn-small">Edit</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5 class="mb-0">Delivery Address</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <address>
                                                            4299 Express Lane<br />
                                                            Sarasota, <br />FL 34249 USA <br />Phone: 1.941.227.4444
                                                        </address>
                                                        <p>Sarasota</p>
                                                        <a href="#" class="btn-small">Edit</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="account-detail" role="tabpanel"
                                        aria-labelledby="account-detail-tab">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>Account Details</h5>
                                            </div>
                                            <div class="card-body">
                                                @if($customer)
                                                    <!-- 1️⃣ Display profile details -->
                                                    <div class="profile-box">
                                                        <style>
                                                            .profile-avatar {
                                                                width: 120px;
                                                                height: 120px;
                                                                border-radius: 50%;
                                                                object-fit: cover;
                                                                border: 3px solid #e0e0e0;
                                                                margin-bottom: 15px;
                                                                display: block;
                                                            }
                                                            .profile-avatar-default {
                                                                width: 120px;
                                                                height: 120px;
                                                                border-radius: 50%;
                                                                background-color: #c0c0c0;
                                                                display: flex;
                                                                align-items: center;
                                                                justify-content: center;
                                                                margin-bottom: 15px;
                                                                border: 3px solid #e0e0e0;
                                                            }
                                                            .profile-avatar-default svg {
                                                                width: 70px;
                                                                height: 70px;
                                                                fill: #fff;
                                                            }
                                                        </style>

                                                        @if(!empty($customer->profile_image) && file_exists(public_path('uploads/profile/' . $customer->profile_image)))
                                                            <img src="{{ asset('uploads/profile/' . $customer->profile_image) }}" class="profile-avatar" alt="Profile">
                                                        @else
                                                            <div class="profile-avatar-default">
                                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/></svg>
                                                            </div>
                                                        @endif

                                                        <p><strong>Username:</strong> {{ $customer->username }}</p>
                                                        <p><strong>Email:</strong> {{ $customer->email }}</p>
                                                        @if(!empty($customer->mobilenumber))
                                                            <p><strong>Mobile:</strong> {{ $customer->mobilenumber }}</p>
                                                        @endif
                                                        @if(!empty($customer->address))
                                                            <p><strong>Address:</strong> {{ $customer->address }}</p>
                                                        @endif
                                                        @if(!empty($customer->pin))
                                                            <p><strong>Pin:</strong> {{ $customer->pin }}</p>
                                                        @endif
                                                        @if(!empty($customer->gender))
                                                            <p><strong>Gender:</strong> {{ $customer->gender }}</p>
                                                        @endif
                                                        @if(!empty($customer->dob))
                                                            <p><strong>DOB:</strong> {{ $customer->dob }}</p>
                                                        @endif
                                                        @if(!empty($customer->city))
                                                            <p><strong>City:</strong> {{ $customer->city }}</p>
                                                        @endif
                                                        @if(!empty($customer->state))
                                                            <p><strong>State:</strong> {{ $customer->state }}</p>
                                                        @endif
                                                        @if(!empty($customer->country))
                                                            <p><strong>Country:</strong> {{ $customer->country }}</p>
                                                        @endif

                                                        <!-- Edit button -->
                                                        @php
                                                            $isEmpty =
                                                                empty($customer->gender) &&
                                                                empty($customer->dob) &&
                                                                empty($customer->address) &&
                                                                empty($customer->city) &&
                                                                empty($customer->state) &&
                                                                empty($customer->country);
                                                        @endphp

                                                        <button class="btn btn-fill-out btn-block hover-up font-weight-bold"
                                                            onclick="showEditForm()">
                                                            {{ $isEmpty ? 'Add Your Details' : 'Edit Your Details' }}
                                                        </button>

                                                    </div>

                                                    <!-- 2️⃣ Profile edit form (hidden initially) -->
                                                    <div id="editForm" style="display:none;">
                                                        <form method="POST" action="{{ route('update') }}"
                                                            enctype="multipart/form-data">
                                                            @csrf
                                                            
                                                            <div class="row">
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="form-label font-weight-bold">Username</label>
                                                                    <input type="text" class="form-control" placeholder="Username" name="username" value="{{ $customer->username }}">                                                            
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="form-label font-weight-bold">Email</label>
                                                                    <input type="email" class="form-control" placeholder="Email" name="email" value="{{ $customer->email }}">                                                            
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="form-label font-weight-bold">Mobile Number</label>
                                                                    <input type="text" class="form-control" placeholder="Mobile Number" name="mobilenumber" value="{{ $customer->mobilenumber }}">
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="form-label font-weight-bold">Address</label>
                                                                    <input type="text" class="form-control" placeholder="Address" name="address" value="{{ $customer->address }}">
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="form-label font-weight-bold">City</label>
                                                                    <input type="text" class="form-control" placeholder="City" name="city" value="{{ $customer->city }}">
                                                                </div>
                                                                <div class="col-md-6 mb-3">                                                                    
                                                                    <label class="form-label font-weight-bold">State</label>
                                                                    <input type="text" class="form-control" placeholder="State" name="state" value="{{ $customer->state }}">
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="form-label font-weight-bold">Country</label>
                                                                    <input type="text" class="form-control" placeholder="Country" name="country" value="{{ $customer->country }}">
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="form-label font-weight-bold">Pincode</label>
                                                                    <input type="text" class="form-control" placeholder="Pincode" name="pin" value="{{ $customer->pin }}">
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="form-label font-weight-bold">Gender</label>
                                                                    <select class="form-control" name="gender">
                                                                        <option value="">Select Gender</option>
                                                                        <option value="Male" {{ $customer->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                                                        <option value="Female" {{ $customer->gender == 'Female' ? 'selected' : '' }}>Female</option>
                                                                        <option value="Other" {{ $customer->gender == 'Other' ? 'selected' : '' }}>Other</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                     <label class="form-label font-weight-bold">Date of Birth</label>
                                                                     <input type="date" class="form-control" name="dob" value="{{ $customer->dob }}">
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-12 mb-3">
                                                                    <label class="form-label font-weight-bold">Profile Image</label>
                                                                    <input type="file" class="form-control pt-2" name="profile_image">                                                                    
                                                                </div>
                                                            </div>

                                                            <div class="row mt-20 justify-content-center">
                                                                <div class="col-md-6">
                                                                    <button type="submit" class="btn btn-fill-out btn-block hover-up font-weight-bold">Update Profile</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>

                                                    <script>
                                                        function showEditForm() {
                                                            document.querySelector('.profile-box').style.display = "none";
                                                            document.getElementById('editForm').style.display = "block";
                                                        }

                                                        // Auto-activate Account Details tab when redirected back after save
                                                        document.addEventListener('DOMContentLoaded', function() {
                                                            @if(session('success'))
                                                                // Activate the account-detail tab
                                                                var accountTab = document.getElementById('account-detail-tab');
                                                                if (accountTab) {
                                                                    var tab = new bootstrap.Tab(accountTab);
                                                                    tab.show();
                                                                }
                                                            @endif
                                                        });
                                                    </script>
                                                @else
                                                    <div class="text-center py-4">
                                                        <i class="fi-rs-user" style="font-size: 48px; color: #ccc;"></i>
                                                        <p class="mt-3 text-muted">Please login to view your account details.
                                                        </p>
                                                        <a href="javascript:void(0);" onclick="openLoginModal()"
                                                            class="btn btn-fill-out">Login</a>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>
    <!-- View Order Modal -->
    <div class="modal fade" id="viewOrderModal" tabindex="-1" aria-labelledby="viewOrderModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background: #3BB77E; color: white;">
                    <h5 class="modal-title" id="viewOrderModalLabel">Order Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body" id="viewOrderContent">
                    <div class="text-center py-4">
                        <div class="spinner-border text-success" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Invoice Modal -->
    <div class="modal fade" id="invoiceModal" tabindex="-1" aria-labelledby="invoiceModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div id="invoiceContent">
                        <!-- Invoice content will be loaded here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Invoice Styles */
        .invoice-wrapper {
            background: #ddd;
            padding: 0;
        }

        .invoice-header {
            background: linear-gradient(135deg, #f5f5f5 0%, #e8e8e8 100%);
            padding: 20px 30px;
            position: relative;
        }

        .print-btn {
            position: absolute;
            right: 30px;
            top: 20px;
            background: #d9534f;
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .print-btn:hover {
            background: #c9302c;
        }

        .invoice-title {
            text-align: center;
            font-size: 28px;
            font-weight: 700;
            color: #333;
            margin: 0;
        }

        .company-info {
            text-align: right;
            font-size: 12px;
            color: #666;
        }

        .company-name {
            font-weight: 700;
            color: #333;
            font-size: 14px;
        }

        .invoice-body {
            padding: 30px;
        }

        .address-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        .address-box {
            width: 45%;
        }

        .address-box h4 {
            color: #d9534f;
            font-weight: 700;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .address-box p {
            margin: 2px 0;
            font-size: 13px;
            color: #333;
        }

        .order-info {
            text-align: right;
        }

        .order-info p {
            margin: 5px 0;
            font-size: 13px;
        }

        .order-info strong {
            color: #333;
        }

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .invoice-table thead {
            background: #f8f8f8;
            border-top: 2px solid #ddd;
            border-bottom: 2px solid #ddd;
        }

        .invoice-table th {
            padding: 12px 10px;
            text-align: left;
            font-size: 12px;
            font-weight: 700;
            color: #333;
        }

        .invoice-table td {
            padding: 12px 10px;
            font-size: 13px;
            border-bottom: 1px solid #eee;
        }

        .invoice-table .product-name {
            color: #3BB77E;
        }

        .invoice-totals {
            width: 100%;
            margin-top: 20px;
        }

        .invoice-totals td {
            padding: 8px 10px;
            font-size: 13px;
            text-align: right;
        }

        .invoice-totals .total-label {
            text-align: right;
            color: #666;
        }

        .invoice-totals .total-value {
            color: #3BB77E;
            font-weight: 700;
        }

        .invoice-totals .grand-total {
            font-size: 16px;
            color: #d9534f;
        }

        .invoice-footer {
            background: #f5f5f5;
            padding: 20px 30px;
            text-align: center;
            border-top: 1px solid #ddd;
        }

        .invoice-footer p {
            margin: 5px 0;
            font-size: 12px;
            color: #666;
        }

        .invoice-footer a {
            color: #3BB77E;
        }

        .logo-section {
            display: flex;
            align-items: center;
        }

        .logo-section img {
            max-height: 50px;
        }

        /* Print Styles - A4 Optimized */
        @media print {
            @page {
                size: A4;
                margin: 10mm;
            }

            body * {
                visibility: hidden;
            }

            #invoiceContent,
            #invoiceContent *,
            #invoice-pdf-container,
            #invoice-pdf-container * {
                visibility: visible;
            }

            #invoiceContent,
            #invoice-pdf-container {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                background: #fff !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                color-adjust: exact !important;
            }

            .print-btn,
            .no-print {
                display: none !important;
            }

            .modal {
                position: absolute !important;
                overflow: visible !important;
            }

            .modal-dialog {
                max-width: 100% !important;
                margin: 0 !important;
            }

            .modal-content {
                border: none !important;
                box-shadow: none !important;
            }

            /* Ensure yellow backgrounds print correctly */
            [style*="background:#f5d742"],
            [style*="background: #f5d742"] {
                background-color: #f5d742 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }

        /* Order Status Badge Colors */
        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .bg-warning {
            background-color: #ffc107 !important;
            color: #000;
        }

        .bg-info {
            background-color: #17a2b8 !important;
            color: #fff;
        }

        .bg-primary {
            background-color: #007bff !important;
            color: #fff;
        }

        .bg-secondary {
            background-color: #6c757d !important;
            color: #fff;
        }

        .bg-success {
            background-color: #28a745 !important;
            color: #fff;
        }

        .bg-danger {
            background-color: #dc3545 !important;
            color: #fff;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script>
        // Safe address parser
        function parseAddress(addressData) {
            if (!addressData) return {};
            if (typeof addressData === 'string') {
                try {
                    return JSON.parse(addressData) || {};
                } catch (e) {
                    return {};
                }
            }
            return addressData || {};
        }

        // View Order Modal
        function viewOrder(orderId) {
            const modal = new bootstrap.Modal(document.getElementById('viewOrderModal'));
            const contentDiv = document.getElementById('viewOrderContent');

            // Show loading
            contentDiv.innerHTML = `
                                                                                                                <div class="text-center py-4">
                                                                                                                    <div class="spinner-border text-success" role="status">
                                                                                                                        <span class="visually-hidden">Loading...</span>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            `;
            modal.show();

            // Fetch order details
            fetch(`{{ url('/order') }}/${orderId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const order = data.order;
                        const shippingAddress = parseAddress(order.shipping_address);

                        let itemsHtml = '';
                        if (order.items && order.items.length > 0) {
                            order.items.forEach((item, index) => {
                                const productImage = item.product_image || '{{ asset("assets/imgs/shop/product-1-1.jpg") }}';
                                itemsHtml += `
                                                                                                                                    <tr>
                                                                                                                                        <td style="width: 80px;">
                                                                                                                                            <img src="${productImage}" alt="${item.product_productname}" 
                                                                                                                                                 style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                                                                                                                                        </td>
                                                                                                                                        <td>
                                                                                                                                            <strong>${item.product_productname || 'Product'}</strong>
                                                                                                                                            ${item.variant_name ? '<br><small class="text-muted">' + item.variant_name + '</small>' : ''}
                                                                                                                                        </td>
                                                                                                                                        <td>₹${parseFloat(item.price || 0).toFixed(2)}</td>
                                                                                                                                        <td>${item.qty || 1}</td>
                                                                                                                                        <td>₹${parseFloat(item.total || 0).toFixed(2)}</td>
                                                                                                                                    </tr>
                                                                                                                                `;
                            });
                        }

                        contentDiv.innerHTML = `
                                                                                                                            <div class="row mb-4">
                                                                                                                                <div class="col-md-6">
                                                                                                                                    <h6 class="text-muted">Order Id</h6>
                                                                                                                                    <p class="fw-bold">#${order.order_number || 'N/A'}</p>
                                                                                                                                </div>
                                                                                                                                <div class="col-md-6 text-end">
                                                                                                                                    <h6 class="text-muted">Order Date</h6>
                                                                                                                                    <p class="fw-bold">${order.created_at ? new Date(order.created_at).toLocaleDateString('en-IN', { day: '2-digit', month: 'short', year: 'numeric' }) : 'N/A'}</p>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                            <div class="row mb-4">
                                                                                                                                <div class="col-md-6">
                                                                                                                                    <h6 class="text-muted">Status</h6>
                                                                                                                                    <span class="badge bg-${getStatusColor(order.status)}">${order.status ? order.status.charAt(0).toUpperCase() + order.status.slice(1) : 'N/A'}</span>
                                                                                                                                </div>
                                                                                                                                <div class="col-md-6 text-end">
                                                                                                                                    <h6 class="text-muted">Payment Method</h6>
                                                                                                                                    <p class="fw-bold">${formatPaymentMethod(order.payment_method)}</p>
                                                                                                                                </div>

                                                                                                                            </div>
                                                                                                                            <div class="mb-4">
                                                                                                                                <h6 class="text-muted">Delivery Address</h6>
                                                                                                                                <p class="mb-0">${shippingAddress.name || 'N/A'}</p>
                                                                                                                                <p class="mb-0">${shippingAddress.address || ''}</p>
                                                                                                                                <p class="mb-0">${shippingAddress.city || ''}, ${shippingAddress.state || ''} - ${shippingAddress.pincode || ''}</p>
                                                                                                                                <p class="mb-0">Phone: ${shippingAddress.phone || 'N/A'}</p>
                                                                                                                            </div>
                                                                                                                            <h6 class="text-muted mb-3">Order Items</h6>
                                                                                                                            <div class="table-responsive">
                                                                                                                                <table class="table table-bordered">
                                                                                                                                    <thead class="table-light">
                                                                                                                                        <tr>
                                                                                                                                            <th>Image</th>
                                                                                                                                            <th>Product</th>
                                                                                                                                            <th>Price</th>
                                                                                                                                            <th>Qty</th>
                                                                                                                                            <th>Total</th>
                                                                                                                                        </tr>
                                                                                                                                    </thead>
                                                                                                                                    <tbody>
                                                                                                                                        ${itemsHtml}
                                                                                                                                    </tbody>
                                                                                                                                </table>
                                                                                                                            </div>
                                                                                                                            <div class="row mt-3">
                                                                                                                                <div class="col-md-6"></div>
                                                                                                                                <div class="col-md-6">
                                                                                                                                    <table class="table table-sm">
                                                                                                                                        <tr>
                                                                                                                                            <td class="text-end">Subtotal:</td>
                                                                                                                                            <td class="text-end fw-bold">₹${parseFloat(order.subtotal || 0).toFixed(2)}</td>
                                                                                                                                        </tr>
                                                                                                                                        <tr>
                                                                                                                                            <td class="text-end">Shipping Charges:</td>
                                                                                                                                            <td class="text-end fw-bold">${parseFloat(order.shipping_amount || 0) > 0 ? '₹' + parseFloat(order.shipping_amount).toFixed(2) : 'Free'}</td>
                                                                                                                                        </tr>
                                                                                                                                        ${parseFloat(order.cod_charge || 0) > 0 ? `
                                                                                                                                        <tr>
                                                                                                                                            <td class="text-end">COD Charge:</td>
                                                                                                                                            <td class="text-end fw-bold">₹${parseFloat(order.cod_charge).toFixed(2)}</td>
                                                                                                                                        </tr>
                                                                                                                                        ` : ''}
                                                                                                                                        ${parseFloat(order.discount_amount || 0) > 0 ? `
                                                                                                                                        <tr>
                                                                                                                                            <td class="text-end">Discount:</td>
                                                                                                                                            <td class="text-end fw-bold text-danger">-₹${parseFloat(order.discount_amount).toFixed(2)}</td>
                                                                                                                                        </tr>
                                                                                                                                        ` : ''}
                                                                                                                                        <tr class="table-success">
                                                                                                                                            <td class="text-end"><strong>Total:</strong></td>
                                                                                                                                            <td class="text-end"><strong style="color: #3BB77E; font-size: 18px;">₹${parseFloat(order.final_amount || 0).toFixed(2)}</strong></td>
                                                                                                                                        </tr>
                                                                                                                                    </table>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                        `;
                    } else {
                        contentDiv.innerHTML = `<div class="alert alert-danger">Failed to load order details: ${data.message || 'Unknown error'}</div>`;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    contentDiv.innerHTML = `<div class="alert alert-danger">Error loading order details. Please try again.</div>`;
                });
        }

        function downloadInvoice(orderId) {
            if (typeof toastr !== 'undefined') {
                toastr.info('Generating invoice PDF...');
            }

            fetch(`{{ url('/order') }}/${orderId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const order = data.order;
                        const billingAddress = parseAddress(order.billing_address);
                        const shippingAddress = parseAddress(order.shipping_address);

                        const customerName = shippingAddress.name || billingAddress.name || 'Customer';
                        const customerAddressLine1 = shippingAddress.address || billingAddress.address || '';
                        const customerCity = shippingAddress.city || billingAddress.city || '';
                        const customerState = shippingAddress.state || billingAddress.state || '';
                        const customerPincode = shippingAddress.pincode || shippingAddress.postal_code || billingAddress.pincode || billingAddress.postal_code || '';
                        const customerPhone = shippingAddress.phone || billingAddress.phone || 'N/A';

                        // Calculate tax percentages
                        const orderSubtotal = parseFloat(order.subtotal || 0);
                        const orderTaxAmount = parseFloat(order.tax_amount || 0);
                        const taxPercent = (orderSubtotal > 0) ? ((orderTaxAmount / orderSubtotal) * 100).toFixed(2) : '0.00';
                        const cgstPercent = (parseFloat(taxPercent) / 2).toFixed(2);
                        const sgstPercent = (parseFloat(taxPercent) / 2).toFixed(2);

                        // Build items HTML with GST columns
                        let itemsHtml = '';
                        let serialNo = 1;
                        if (order.items && order.items.length > 0) {
                            order.items.forEach((item) => {
                                const price = parseFloat(item.price || 0);
                                const qty = parseInt(item.qty || item.quantity || 1);
                                const subtotal = parseFloat(item.total || (price * qty));
                                const productName = (item.product_productname || 'Product') + (item.variant_name ? ' - ' + item.variant_name : '');
                                itemsHtml += `
                                                                                                    <td style="padding:10px;border:1px solid #000;font-size:11px;text-align:center;width:50px;">${serialNo}</td>
                                                                                                        <td style="padding:10px;border:1px solid #000;font-size:11px;color:#2e7d32;">${productName}</td>
                                                                                                        <td style="padding:10px;border:1px solid #000;font-size:11px;text-align:center;width:70px;">₹ ${price.toFixed(0)}</td>
                                                                                                        <td style="padding:10px;border:1px solid #000;font-size:11px;text-align:center;width:50px;">${qty}</td>
                                                                                                        <td style="padding:10px;border:1px solid #000;font-size:11px;text-align:right;width:90px;">₹ ${subtotal.toFixed(0)}</td>
                                                                                                    </tr>`;
                                serialNo++;
                            });
                        }

                        const hiddenContainer = document.createElement('div');
                        hiddenContainer.id = 'invoice-pdf-container';
                        hiddenContainer.style.cssText = 'position:fixed;left:-9999px;top:0;width:794px;background:#fff;';

                        hiddenContainer.innerHTML = `
                                                                                            <div style="max-width:750px;margin:0 auto;padding:30px 40px;background:#fff;border:2px solid #000;font-family:Arial,sans-serif;font-size:12px;color:#333;">

                                                                                                <!-- Top Section: To Address and Order Info -->
                                                                                                <div style="display:flex;justify-content:space-between;margin-bottom:15px;">
                                                                                                    <div style="flex:1;">
                                                                                                        <div style="color:#d32f2f;font-weight:bold;margin-bottom:5px;">To,</div>
                                                                                                        <div style="font-weight:bold;margin-bottom:3px;">${customerName}</div>
                                                                                                        <div style="line-height:1.7;font-size:11px;">
                                                                                                            ${customerAddressLine1}<br>
                                                                                                            ${customerCity}, ${customerState} - ${customerPincode}<br>
                                                                                                            Mobile: ${customerPhone}
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <!-- Order Info with dotted left border -->
                                                                                                    <div style="border-left:1px dashed #333;padding-left:20px;text-align:left;min-width:120px;">
                                                                                                        <div style="font-size:11px;color:#666;">Order ID</div>
                                                                                                        <div style="font-weight:bold;font-size:12px;color:#d32f2f;">${order.order_number || 'N/A'}</div>
                                                                                                        <div style="font-size:11px;margin-top:8px;font-weight:bold;">${customerState}</div>
                                                                                                    </div>
                                                                                                </div>

                                                                                                <!-- From Section with dotted bottom border -->
                                                                                                <div style="margin-bottom:15px;font-size:11px;padding-bottom:15px;border-bottom:1px dashed #333;">
                                                                                                    <span style="font-weight:bold;">From,</span><br>
                                                                                                    <span style="color:#000;font-weight:bold;">CHENNAI ANGADI, NEW #15/OLD #8, MUTHU STREET, MYLAPORE, CHENNAI - 4, MOBILE: +91 90946 76665</span>
                                                                                                </div>

                                                                                                <!-- Header: Logo + Title + Company Details -->
                                                                                                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
                                                                                                    <div style="width:200px;">
                                                                                                        <img src="{{ asset('assets/imgs/images/ChennaiAngadiLogo.png') }}" alt="Chennai Angadi" style="height:60px;width:auto;" crossorigin="anonymous">
                                                                                                    </div>
                                                                                                    <div style="text-align:center;flex:1;">
                                                                                                        <span style="font-size:18px;font-weight:bold;color:#333;">Estimate Invoice</span>
                                                                                                    </div>
                                                                                                    <div style="text-align:right;font-size:10px;line-height:1.6;">
                                                                                                        <div style="font-weight:bold;color:#d32f2f;">Chennai Angadi</div>
                                                                                                        <div style="color:#666;">15/8, Muthu St, Mylapore, Chennai 4</div>
                                                                                                        <div style="color:#666;">Mobile: +91 90946 76665 | Email: care@chennaiangadi.com</div>
                                                                                                    </div>
                                                                                                </div>

                                                                                                <!-- Items Table with ash header and black borders -->
                                                                                                <table style="width:100%;border-collapse:collapse;margin-bottom:0;border:1px solid #000;">
                                                                                                    <thead>
                                                                                                        <tr>
                                                                                                            <th style="background:#e8e8e8;border:1px solid #000;padding:8px 10px;text-align:left;font-weight:bold;font-size:11px;color:#333;width:40px;">S.NO.</th>
                                                                                                            <th style="background:#e8e8e8;border:1px solid #000;padding:8px 10px;text-align:left;font-weight:bold;font-size:11px;color:#333;">PRODUCTS</th>
                                                                                                            <th style="background:#e8e8e8;border:1px solid #000;padding:8px 10px;text-align:right;font-weight:bold;font-size:11px;color:#333;width:70px;">PRICE</th>
                                                                                                            <th style="background:#e8e8e8;border:1px solid #000;padding:8px 10px;text-align:center;font-weight:bold;font-size:11px;color:#333;width:50px;">QTY</th>
                                                                                                            <th style="background:#e8e8e8;border:1px solid #000;padding:8px 10px;text-align:right;font-weight:bold;font-size:11px;color:#333;width:90px;">SUB TOTAL</th>
                                                                                                        </tr>
                                                                                                    </thead>
                                                                                                    <tbody>
                                                                                                        ${itemsHtml}
                                                                                                        <!-- Delivery Row -->
                                                                                                        <tr>
                                                                                                            <td colspan="4" style="padding:8px 10px;border:1px solid #000;text-align:right;font-weight:500;color:#ff9800;border-bottom:1px solid #333;">Shipping Charges</td>
                                                                                                            <td style="padding:8px 10px;border:1px solid #000;text-align:right;color:#ff9800;border-bottom:1px solid #333;">${parseFloat(order.shipping_amount || 0) > 0 ? '₹ ' + parseFloat(order.shipping_amount).toFixed(0) : 'Free'}</td>
                                                                                                        </tr>
                                                                                                        <!-- COD Charge Row -->
                                                                                                        ${parseFloat(order.cod_charge || 0) > 0 ? `
                                                                                                        <tr>
                                                                                                            <td colspan="4" style="padding:8px 10px;border:1px solid #000;text-align:right;font-weight:500;color:#ff9800;border-bottom:1px solid #333;">COD Charge</td>
                                                                                                            <td style="padding:8px 10px;border:1px solid #000;text-align:right;color:#ff9800;border-bottom:1px solid #333;">₹ ${parseFloat(order.cod_charge).toFixed(2)}</td>
                                                                                                        </tr>
                                                                                                        ` : ''}
                                                                                                        <!-- Coupon Discount Row -->
                                                                                                         ${parseFloat(order.discount_amount || 0) > 0 ? `
                                                                                                         <tr>
                                                                                                             <td colspan="4" style="padding:8px 10px;border:1px solid #000;text-align:right;font-weight:500;color:#28a745;border-bottom:1px solid #333;">Coupon Discount ${order.coupon_code ? '(' + order.coupon_code + ')' : ''}</td>
                                                                                                             <td style="padding:8px 10px;border:1px solid #000;text-align:right;color:#28a745;border-bottom:1px solid #333;">- ₹ ${parseFloat(order.discount_amount).toFixed(2)}</td>
                                                                                                         </tr>
                                                                                                         ` : ''}
                                                                                                         <!-- Total Row -->
                                                                                                         <tr>
                                                                                                            <td colspan="4" style="padding:8px 10px;border:1px solid #000;text-align:right;font-weight:bold;font-size:13px;">Total</td>
                                                                                                            <td style="padding:8px 10px;border:1px solid #000;text-align:right;font-weight:bold;font-size:15px;color:#ff9800;">₹ ${parseFloat(order.final_amount || 0).toFixed(2)}</td>
                                                                                                        </tr>
                                                                                                    </tbody>
                                                                                                </table>

                                                                                                <!-- Footer -->
                                                                                                <div style="text-align:center;margin-top:25px;font-size:10px;color:#666;line-height:1.8;">
                                                                                                    <p style="margin:0 0 5px 0;">Thank you for shopping with us and we hope to serve you again in the future</p>
                                                                                                    <p style="margin:0;">Please feel free to write to us at <span style="color:#d32f2f;font-weight:bold;">care@chennaiangadi.com</span> for any queries, suggestions, complaints or anything else.</p>
                                                                                                </div>
                                                                                            </div>
                                                                                        `;

                        document.body.appendChild(hiddenContainer);

                        setTimeout(() => {
                            generatePDF(hiddenContainer, order.order_number || 'invoice');
                        }, 500);

                    } else {
                        if (typeof toastr !== 'undefined') {
                            toastr.error('Failed to generate invoice: ' + (data.message || 'Unknown error'));
                        } else {
                            alert('Failed to generate invoice');
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    if (typeof toastr !== 'undefined') {
                        toastr.error('Error generating invoice. Please try again.');
                    } else {
                        alert('Error generating invoice. Please try again.');
                    }
                });
        }

        function generatePDF(container, orderNumber) {
            const { jsPDF } = window.jspdf;
            html2canvas(container, {
                scale: 2,
                useCORS: true,
                logging: false,
                backgroundColor: '#ffffff',
                allowTaint: true
            }).then(canvas => {
                const imgData = canvas.toDataURL('image/png');
                const pdf = new jsPDF('p', 'mm', 'a4');
                const imgWidth = 210;
                const pageHeight = 297;
                const imgHeight = (canvas.height * imgWidth) / canvas.width;
                let heightLeft = imgHeight;
                let position = 0;
                pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
                heightLeft -= pageHeight;
                while (heightLeft >= 0) {
                    position = heightLeft - imgHeight;
                    pdf.addPage();
                    pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
                    heightLeft -= pageHeight;
                }
                pdf.save(`Invoice-${orderNumber}.pdf`);
                document.body.removeChild(container);
                if (typeof toastr !== 'undefined') {
                    toastr.success('Invoice downloaded successfully!');
                }
            }).catch(error => {
                console.error('PDF generation error:', error);
                document.body.removeChild(container);
                if (typeof toastr !== 'undefined') {
                    toastr.error('Failed to generate PDF. Please try again.');
                } else {
                    alert('Failed to generate PDF. Please try again.');
                }
            });
        }
        // Helper: Get status color
        function getStatusColor(status) {
            const colors = {
                'pending': 'warning',
                'placed': 'info',
                'processing': 'primary',
                'shipped': 'secondary',
                'delivered': 'success',
                'cancelled': 'danger'
            };
            return colors[status] || 'secondary';
        }

        // Helper: Format payment method
        function formatPaymentMethod(method) {
            const methods = {
                'bank_transfer': 'Bank Transfer',
                'cash_on_delivery': 'Cash on Delivery',
                'online_gateway': 'Online Payment'
            };
            return methods[method] || method || 'N/A';
        }
        // Track Order function
        function trackOrder(event) {
            event.preventDefault();

            const orderNumber = $('#track_order_number').val().trim();

            if (!orderNumber) {
                $('#track_order_message').html('<span class="text-danger">Please enter an order number</span>');
                return false;
            }

            $('#track_order_btn').prop('disabled', true).text('Tracking...');
            $('#track_order_result').hide();

            $.ajax({
                url: '{{ route("checkout.track-order") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    order_number: orderNumber
                },
                success: function (response) {
                    if (response.success) {
                        // Populate the result display
                        $('#result_order_number').text(response.order.order_number);
                        $('#result_order_status').text(response.order.status.charAt(0).toUpperCase() + response.order.status.slice(1));
                        $('#result_order_date').text(response.order.placed_at);
                        $('#result_order_total').text('₹' + parseFloat(response.order.final_amount).toFixed(2));

                        // Display notes or show "No tracking notes available"
                        const notes = response.order.notes || 'No tracking notes available yet.';
                        $('#result_order_notes').html(notes.replace(/\n/g, '<br>'));

                        // Set status badge color based on status
                        const status = response.order.status.toLowerCase();
                        let badgeClass = 'bg-primary';
                        if (status === 'pending') badgeClass = 'bg-warning';
                        else if (status === 'confirmed') badgeClass = 'bg-info';
                        else if (status === 'packed') badgeClass = 'bg-secondary';
                        else if (status === 'shipped') badgeClass = 'bg-primary';
                        else if (status === 'delivered') badgeClass = 'bg-success';
                        else if (status === 'cancelled') badgeClass = 'bg-danger';

                        $('#result_order_status').attr('class', 'badge ' + badgeClass);

                        // Show result box
                        $('#track_order_result').slideDown();
                        $('#track_order_message').html('<span class="text-success">Order found!</span>');
                        if (typeof toastr !== 'undefined') {
                            toastr.success('Order found!', 'Success');
                        }
                    } else {
                        $('#track_order_message').html('<span class="text-danger">' + response.message + '</span>');
                        $('#track_order_result').hide();
                    }
                    $('#track_order_btn').prop('disabled', false).text('Track');
                },
                error: function (xhr) {
                    const errorMsg = xhr.responseJSON ? xhr.responseJSON.message : 'Failed to track order';
                    $('#track_order_message').html('<span class="text-danger">' + errorMsg + '</span>');
                    $('#track_order_result').hide();
                    $('#track_order_btn').prop('disabled', false).text('Track');
                }
            });

            return false;
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const urlParams = new URLSearchParams(window.location.search);
            const tab = urlParams.get('tab');
            const edit = urlParams.get('edit');

            if (tab) {
                const tabEl = document.getElementById(tab + '-tab');
                if (tabEl) {
                    // Use Bootstrap's tab show method
                    const tabTrigger = new bootstrap.Tab(tabEl);
                    tabTrigger.show();

                    // If it's the account-detail tab and edit=1 is present, show the form
                    if (tab === 'account-detail' && edit === '1') {
                        // Small delay to ensure tab is fully shown before manipulating its content
                        setTimeout(() => {
                            if (typeof showEditForm === 'function') {
                                showEditForm();
                            }
                        }, 100);
                    }
                }
            }
        });
    </script>

@endsection