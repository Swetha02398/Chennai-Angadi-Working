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
                                                        href="{{ url('myAccount') }}?tab=orders">recent orders</a>,<br />
                                                    manage your <a href="{{ url('myAccount') }}?tab=account-detail">shipping and billing addresses</a> and <a
                                                        href="{{ url('myAccount') }}?tab=account-detail&edit=1">edit your password and account details.</a>
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
                                                                            @php
                                                                                $statusIcon = 'fi-rs-label';
                                                                                $statusLabel = ucfirst($order->status);
                                                                                $statusBg = 'bg-secondary';
                                                                                $normalizedStatus = strtolower($order->status);
                                                                                if($normalizedStatus == 'hold' || $normalizedStatus == 'pending') { $statusIcon = 'fi-rs-time-fast'; $statusLabel = 'Hold'; $statusBg = 'bg-warning text-dark'; }
                                                                                elseif($normalizedStatus == 'placed' || $normalizedStatus == 'confirmed') { $statusIcon = 'fi-rs-box'; $statusLabel = 'Confirmed'; $statusBg = 'bg-info'; }
                                                                                elseif($normalizedStatus == 'processing') { $statusIcon = 'fi-rs-settings-sliders'; $statusLabel = 'Processing'; $statusBg = 'bg-primary'; }
                                                                                elseif($normalizedStatus == 'shipped' || $normalizedStatus == 'shipping') { $statusIcon = 'fi-rs-paper-plane'; $statusLabel = 'Shipped'; $statusBg = 'bg-secondary'; }
                                                                                elseif($normalizedStatus == 'delivered') { $statusIcon = 'fi-rs-check'; $statusLabel = 'Delivered'; $statusBg = 'bg-success'; }
                                                                                elseif($normalizedStatus == 'cancelled') { $statusIcon = 'fi-rs-cross-circle'; $statusLabel = 'Cancelled'; $statusBg = 'bg-danger'; }
                                                                            @endphp
                                                                            <span class="badge order-status-badge {{ $statusBg }}">
                                                                                <i class="{{ $statusIcon }} me-1"></i> {{ $statusLabel }}
                                                                            </span>
                                                                        </td>
                                                                        <td>
                                                                            @php
                                                                                $payIcon = 'fi-rs-credit-card';
                                                                                $payLabel = ucfirst($order->payment_status ?? 'hold');
                                                                                $payBg = 'bg-secondary';
                                                                                $normalizedPay = strtolower($order->payment_status ?? 'hold');
                                                                                if($normalizedPay == 'paid') { $payIcon = 'fi-rs-check'; $payLabel = 'Paid'; $payBg = 'bg-success'; }
                                                                                elseif($normalizedPay == 'cod') { $payIcon = 'fi-rs-money'; $payLabel = 'COD'; $payBg = 'bg-warning text-dark'; }
                                                                                elseif($normalizedPay == 'hold' || $normalizedPay == 'pending') { $payIcon = 'fi-rs-time-fast'; $payLabel = 'Pending'; $payBg = 'bg-warning text-dark'; }
                                                                                elseif($normalizedPay == 'not_paid') { $payIcon = 'fi-rs-cross-circle'; $payLabel = 'Not Paid'; $payBg = 'bg-danger'; }
                                                                                elseif($normalizedPay == 'failed') { $payIcon = 'fi-rs-cross'; $payLabel = 'Failed'; $payBg = 'bg-danger'; }
                                                                                elseif($normalizedPay == 'refunded') { $payIcon = 'fi-rs-undo'; $payLabel = 'Refunded'; $payBg = 'bg-info'; }
                                                                            @endphp
                                                                            <span class="badge order-status-badge {{ $payBg }}">
                                                                                <i class="{{ $payIcon }} me-1"></i> {{ $payLabel }}
                                                                            </span>
                                                                        </td>
                                                                        <td>₹{{ number_format($order->final_amount, 2) }} for
                                                                            {{ $order->items->sum('qty') }} item(s)
                                                                        </td>
                                                                        <td>
                                                                            <button class="btn me-1 order-action-btn"
                                                                                onclick="viewOrder({{ $order->id }})">
                                                                                <i class="fi-rs-eye me-1"></i>View
                                                                            </button>
                                                                            <button class="btn order-action-btn"
                                                                                onclick="downloadInvoice({{ $order->id }})">
                                                                                <i class="fi-rs-download me-1"></i>Invoice
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
                                                                <h4 class="mb-10">Order Id</h4>
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
                                                                    <h4 class="mb-10">Order Id:</h4>
                                                                    <h4 id="result_order_number" class="text-brand">-</h4>
                                                                </div>
                                                                <div class="col-md-6 mb-15">
                                                                    <h4 class="mb-10">Order Status:</h4>
                                                                    <h4><span id="result_order_status"
                                                                            class="badge bg-primary">-</span></h4>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6 mb-15">
                                                                    <h4 class="mb-10">Order Date:</h4>
                                                                    <h4 id="result_order_date">-</h4>
                                                                </div>
                                                                <div class="col-md-6 mb-15">
                                                                    <h4 class="mb-10">Total Amount:</h4>
                                                                    <h4 id="result_order_total" class="text-brand fw-bold">-</h4>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <h4 class="mb-10">Tracking Notes:</h4>
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
                                                            
                                                            <div class="mb-4">
                                                                @if(!empty($customer->profile_image) && file_exists(public_path('uploads/profile/' . $customer->profile_image)))
                                                                    <img src="{{ asset('uploads/profile/' . $customer->profile_image) }}" class="profile-avatar" alt="Profile">
                                                                @else
                                                                    <div class="profile-avatar-default">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/></svg>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            
                                                            <div class="row">
                                                                <div class="col-md-6 mb-3">
                                                                    <input type="text" class="form-control" placeholder="Username" name="username" value="{{ $customer->username }}">                                                            
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <input type="email" class="form-control" placeholder="Email" name="email" value="{{ $customer->email }}">                                                            
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-6 mb-3">
                                                                    <input type="text" class="form-control" placeholder="Mobile Number" name="mobilenumber" value="{{ $customer->mobilenumber }}">
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <input type="text" class="form-control" placeholder="Address" name="address" value="{{ $customer->address }}">
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-6 mb-3">
                                                                    <input type="text" class="form-control" placeholder="City" name="city" value="{{ $customer->city }}">
                                                                </div>
                                                                <div class="col-md-6 mb-3">                                                                    
                                                                    <input type="text" class="form-control" placeholder="State" name="state" value="{{ $customer->state }}">
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-6 mb-3">
                                                                    <input type="text" class="form-control" placeholder="Country" name="country" value="{{ $customer->country }}">
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <input type="text" class="form-control" placeholder="Pincode" name="pin" value="{{ $customer->pin }}">
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-6 mb-3">
                                                                    <select class="form-control" name="gender">
                                                                        <option value="" disabled {{ empty($customer->gender) ? 'selected' : '' }}>Gender</option>
                                                                        <option value="Male" {{ $customer->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                                                        <option value="Female" {{ $customer->gender == 'Female' ? 'selected' : '' }}>Female</option>
                                                                        <option value="Other" {{ $customer->gender == 'Other' ? 'selected' : '' }}>Other</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                     <input type="text" onfocus="(this.type='date')" onblur="(this.type='text')" class="form-control" name="dob" value="{{ $customer->dob }}" placeholder="Date of Birth">
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-12 mb-3">
                                                                    <input type="file" class="form-control pt-2" name="profile_image" title="Profile Image">                                                                    
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
                <div class="modal-header custom-modal-header text-white" style="background-color: #00B5B8 !important;">
                    <h5 class="modal-title" id="viewOrderModalLabel">
                        <i class="fi-rs-receipt me-2"></i>Invoice
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-0" id="viewOrderContent">
                    <div class="text-center py-4">
                        <div class="spinner-border text-success" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="fi-rs-cross me-1"></i> Close</button>
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
        /* Standardized Button and Badge Sizes for Orders */
        .order-action-btn {
            width: 90px !important;
            height: 30px !important;
            border-radius: 4px !important;
            padding: 0 !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            font-size: 13px !important;
        }
        
        .order-status-badge {
            width: 90px !important;
            height: 30px !important;
            border-radius: 4px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            font-size: 12px !important;
            margin: 0 auto !important;
        }
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
                        
                        document.getElementById('viewOrderModalLabel').innerHTML = '<i class="fi-rs-receipt me-2"></i>Invoice - ' + (order.order_number || '');

                        const orderSubtotal = parseFloat(order.subtotal || 0);
                        const orderTaxAmount = parseFloat(order.tax_amount || 0);
                        const taxPercent = (orderSubtotal > 0) ? ((orderTaxAmount / orderSubtotal) * 100).toFixed(2) : '0.00';
                        const cgstPercent = (parseFloat(taxPercent) / 2).toFixed(2);
                        const sgstPercent = (parseFloat(taxPercent) / 2).toFixed(2);
                        
                        let totalGst = 0;
                        let totalSgst = 0;
                        let totalIgst = 0;
                        let giSubtotal = 0;

                        let itemsHtml = '';
                        let serialNo = 1;
                        if (order.items && order.items.length > 0) {
                            order.items.forEach((item) => {
                                const price = parseFloat(item.price || 0);
                                const qty = parseInt(item.qty || item.quantity || 1);
                                const lineTotal = parseFloat(item.total || (price * qty));
                                giSubtotal += lineTotal;

                                // Fallback logic (since frontend API might not give product GST, we'll try to estimate or show 0)
                                let productGst = 0; let productSgst = 0; let productIgst = 0;
                                // In admin API, product object might be available. The frontend order API returned just items:
                                // Let's check item.product or item.variant, if not present we just use 0%
                                if (item.product) {
                                    productGst = item.product.gst || 0;
                                    productSgst = item.product.sgst || 0;
                                    productIgst = item.product.igst || 0;
                                }

                                const gstAmount = (lineTotal * productGst) / 100;
                                const sgstAmount = (lineTotal * productSgst) / 100;
                                const igstAmount = (lineTotal * productIgst) / 100;
                                
                                totalGst += gstAmount;
                                totalSgst += sgstAmount;
                                totalIgst += igstAmount;

                                const productName = (item.product_productname || 'Product') + (item.variant_name ? ' - ' + item.variant_name : '');
                                itemsHtml += `
                                    <tr>
                                        <td>${serialNo}</td>
                                        <td class="product-name">${productName}</td>
                                        <td>${item.product && item.product.hsn ? item.product.hsn : 'N/A'}</td>
                                        <td>₹${price.toFixed(0)}</td>
                                        <td class="gst-highlight">${productGst}% (₹${gstAmount.toFixed(2)})</td>
                                        <td class="gst-highlight">${productSgst}% (₹${sgstAmount.toFixed(2)})</td>
                                        <td class="gst-highlight">${productIgst}% (₹${igstAmount.toFixed(2)})</td>
                                        <td>${qty}</td>
                                        <td>₹ ${lineTotal.toFixed(0)}</td>
                                    </tr>
                                `;
                                serialNo++;
                            });
                        }

                        const orderDate = new Date(order.created_at).toLocaleString('en-IN', {
                            day: '2-digit', month: '2-digit', year: 'numeric',
                            hour: '2-digit', minute: '2-digit', hour12: true
                        });

                        const customerName = shippingAddress.name || 'Customer';
                        const addressParts = [];
                        if (shippingAddress.address) addressParts.push(shippingAddress.address);
                        if (shippingAddress.city) addressParts.push(shippingAddress.city);
                        if (shippingAddress.state) addressParts.push(shippingAddress.state);
                        if (shippingAddress.pincode) addressParts.push(shippingAddress.pincode);
                        const addressLine = addressParts.join(', ') || 'N/A';
                        const mobile = shippingAddress.phone || 'N/A';
                        const state = shippingAddress.state || 'Tamil Nadu';

                        contentDiv.innerHTML = `
                            <div class="invoice-print-content" style="font-family: inherit; background: #fff; color: #000; padding: 5px;">
                                <style>
                                    .invoice-print-content * { margin: 0; padding: 0; box-sizing: border-box; }
                                    .gi-top-section { display: flex; justify-content: space-between; margin-bottom: 5px; font-size: 13px; }
                                    .gi-to-section { flex: 1; }
                                    .gi-to-label { color: #333; font-weight: bold; margin-bottom: 4px; font-size: 14px; }
                                    .gi-customer-name { font-weight: 600; font-size: 15px; margin-bottom: 2px; }
                                    .gi-address-line { color: #333; line-height: 1.5; font-size: 13px; }
                                    .gi-order-box { border-left: 1px dashed #999; padding-left: 15px; text-align: left; }
                                    .gi-order-id-label { font-size: 12px; color: #666; margin-bottom: 2px; }
                                    .gi-order-id { font-weight: bold; font-size: 16px; color: #000; margin-bottom: 4px; }
                                    .gi-state { font-size: 12px; color: #333; margin-top: 4px; }
                                    .gi-from-section { font-size: 13px; padding-bottom: 8px; border-bottom: 1px dashed #999; margin-bottom: 15px; line-height: 1.5; }
                                    .gi-from-label { font-weight: bold; font-size: 14px; }
                                    .gi-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
                                    .gi-logo img { height: 50px; width: auto; }
                                    .gi-title { text-align: center; flex: 1; }
                                    .gi-title h3 { font-size: 20px; font-weight: bold; margin: 0; text-transform: uppercase; letter-spacing: 1px; }
                                    .gi-company { text-align: right; font-size: 12px; line-height: 1.4; }
                                    .gi-company-name { font-weight: bold; font-size: 14px; }
                                    .gi-table { width: 100%; border-collapse: collapse; margin-bottom: 0; font-size: 12px; table-layout: fixed; }
                                    .gi-table th { background: #f0f0f0; border: 1px solid #999; padding: 8px 6px; font-size: 11px; font-weight: bold; text-align: center; text-transform: uppercase; }
                                    .gi-table td { border: 1px solid #999; padding: 8px 6px; font-size: 12px; text-align: center; }
                                    .gi-table td.product-name { text-align: left; white-space: normal; line-height: 1.4; }
                                    .gst-highlight { color: #0066cc; font-weight: bold; }
                                    .gi-footer { margin-top: 20px; text-align: center; font-size: 12px; color: #333; line-height: 1.6; border-top: 1px dashed #999; padding-top: 15px; }
                                    .gi-footer a { color: #dc3545; text-decoration: none; font-weight: bold; }
                                </style>
                                
                                <div class="gi-top-section">
                                    <div class="gi-to-section">
                                        <div class="gi-to-label">To,</div>
                                        <div class="gi-customer-name">${customerName}</div>
                                        <div class="gi-address-line">
                                            ${addressLine}<br>
                                            Mobile: ${mobile}
                                        </div>
                                    </div>
                                    <div class="gi-order-box">
                                        <div class="gi-order-id-label">Order ID</div>
                                        <div class="gi-order-id">${order.order_number || ''}</div>
                                        <div class="gi-state">${state}</div>
                                        <div class="gi-state">Order Date: ${orderDate}</div>
                                        <div class="gi-state">Status: <span class="badge bg-${getStatusColor(order.status)}">${order.status ? order.status.charAt(0).toUpperCase() + order.status.slice(1) : 'N/A'}</span></div>
                                        <div class="gi-state mt-1">Payment: <strong>${formatPaymentMethod(order.payment_method)}</strong></div>
                                    </div>
                                </div>

                                <div class="gi-from-section">
                                    <span class="gi-from-label">From,</span><br>
                                    Chennai Angadi, New #15/Old #8, Muthu Street, Mylapore, Chennai - 4, Mobile: +91 90946 76665
                                </div>

                                <div class="gi-header">
                                    <div class="gi-logo">
                                        <img src="{{ asset('assets/imgs/images/ChennaiAngadiLogo.png') }}" alt="Chennai Angadi" style="height: 50px; width: auto;">
                                    </div>
                                    <div class="gi-title">
                                        <h3 style="font-size: 20px; font-weight: bold; margin: 0; text-transform: uppercase; letter-spacing: 1px;">ESTIMATE INVOICE</h3>
                                    </div>
                                    <div class="gi-company">
                                        <div class="gi-company-name">Chennai Angadi</div>
                                        <div>15/8, Muthu St, Mylapore, Chennai 4</div>
                                        <div>Mobile: +91 90946 76665 | Email: care@chennaiangadi.com</div>
                                    </div>
                                </div>

                                <table class="gi-table">
                                    <thead>
                                        <tr>
                                            <th style="width: 6%;">S.NO.</th>
                                            <th style="width: 22%;">PRODUCTS</th>
                                            <th style="width: 8%;">Hsn Code</th>
                                            <th style="width: 8%;">PRICE</th>
                                            <th style="width: 12%;">GST%</th>
                                            <th style="width: 12%;">SGST%</th>
                                            <th style="width: 12%;">IGST%</th>
                                            <th style="width: 6%;">QTY</th>
                                            <th style="width: 14%;">SUB TOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ${itemsHtml}
                                    </tbody>
                                    <tfoot>
                                        ${totalGst > 0 ? `
                                        <tr>
                                            <td colspan="8" style="text-align: right; font-weight: 600; color: #dc3545; border: 1px solid #999;">GST</td>
                                            <td style="text-align: center; color: #dc3545; border: 1px solid #999;">₹ ${totalGst.toFixed(2)}</td>
                                        </tr>
                                        ` : ''}
                                        ${totalSgst > 0 ? `
                                        <tr>
                                            <td colspan="8" style="text-align: right; font-weight: 600; color: #dc3545; border: 1px solid #999;">SGST</td>
                                            <td style="text-align: center; color: #dc3545; border: 1px solid #999;">₹ ${totalSgst.toFixed(2)}</td>
                                        </tr>
                                        ` : ''}
                                        ${totalIgst > 0 ? `
                                        <tr>
                                            <td colspan="8" style="text-align: right; font-weight: 600; color: #dc3545; border: 1px solid #999;">IGST</td>
                                            <td style="text-align: center; color: #dc3545; border: 1px solid #999;">₹ ${totalIgst.toFixed(2)}</td>
                                        </tr>
                                        ` : ''}
                                        ${parseFloat(order.discount_amount || 0) > 0 ? `
                                        <tr>
                                            <td colspan="8" style="text-align: right; font-weight: 600; color: #28a745; border: 1px solid #999;">Coupon Applied ${order.coupon_code ? '('+order.coupon_code+')' : ''}</td>
                                            <td style="text-align: center; color: #28a745; border: 1px solid #999;">- ₹ ${parseFloat(order.discount_amount).toFixed(2)}</td>
                                        </tr>
                                        ` : ''}
                                        ${parseFloat(order.shipping_amount || 0) > 0 ? `
                                        <tr>
                                            <td colspan="8" style="text-align: right; font-weight: 600; color: #dc3545; border: 1px solid #999;">Shipping Charges</td>
                                            <td style="text-align: center; color: #dc3545; border: 1px solid #999;">₹ ${parseFloat(order.shipping_amount).toFixed(0)}</td>
                                        </tr>
                                        ` : ''}
                                        ${(order.payment_method === 'cash_on_delivery' || order.payment_method === 'cod') && parseFloat(order.cod_charge || 0) > 0 ? `
                                        <tr>
                                            <td colspan="8" style="text-align: right; font-weight: 600; color: #dc3545; border: 1px solid #999;">COD Charges</td>
                                            <td style="text-align: center; color: #dc3545; border: 1px solid #999;">₹ ${parseFloat(order.cod_charge).toFixed(0)}</td>
                                        </tr>
                                        ` : ''}
                                        <tr>
                                            <td colspan="8" style="text-align: right; font-weight: bold; font-size: 14px; color: #dc3545; border: 1px solid #999; background: #fff8f8;">TOTAL (Incl. GST)</td>
                                            <td style="text-align: center; font-weight: bold; font-size: 14px; color: #dc3545; border: 1px solid #999; background: #fff8f8;">₹ ${parseFloat(order.final_amount || order.total_amount || 0).toFixed(2)}</td>
                                        </tr>
                                    </tfoot>
                                </table>

                                <div class="gi-footer">
                                    <p>Thank you for shopping with us and we hope to serve you again in the future. Please feel free to write to us at <a href="mailto:care@chennaiangadi.com">care@chennaiangadi.com</a> for any queries, suggestions, complaints or anything else.</p>
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
                'hold': 'warning',
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
                $('#track_order_message').html('<h4 class="text-danger mt-10" style="font-size: 18px !important;">Please enter an order number</h4>');
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
                        if (status === 'hold') badgeClass = 'bg-warning';
                        else if (status === 'confirmed') badgeClass = 'bg-info';
                        else if (status === 'packed') badgeClass = 'bg-secondary';
                        else if (status === 'shipped') badgeClass = 'bg-primary';
                        else if (status === 'delivered') badgeClass = 'bg-success';
                        else if (status === 'cancelled') badgeClass = 'bg-danger';

                        $('#result_order_status').attr('class', 'badge ' + badgeClass);

                        // Show result box
                        $('#track_order_result').slideDown();
                        $('#track_order_message').html('<h4 class="text-brand mt-10">Order found!</h4>');
                        if (typeof toastr !== 'undefined') {
                            toastr.success('Order found!', 'Success');
                        }
                    } else {
                        $('#track_order_message').html('<h4 class="text-danger mt-10" style="font-size: 18px !important;">' + response.message + '</h4>');
                        $('#track_order_result').hide();
                    }
                    $('#track_order_btn').prop('disabled', false).text('Track');
                },
                error: function (xhr) {
                    const errorMsg = xhr.responseJSON ? xhr.responseJSON.message : 'Failed to track order';
                    $('#track_order_message').html('<h4 class="text-danger mt-10" style="font-size: 18px !important;">' + errorMsg + '</h4>');
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
