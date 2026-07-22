@extends('layouts.app')
@section('content')
    <!--End header-->
    <main class="main pages">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="{{ route('index') }}" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                    <span></span> Order Track
                </div>
            </div>
        </div>
        <div class="page-content py-3">
            <div class="container">
                <div class="row">
                    <div class="col-xl-8 col-lg-10 m-auto">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Track Your Order</h5>
                            </div>
                            <div class="card-body contact-from-area p-10">
                                <p>Enter your Order ID below and click 'Track' to check your order status. <br/>You can find your Order ID in your receipt or confirmation email.</p>
                                <div class="row">
                                    <div class="col-lg-8">
                                        <form class="contact-form-style my-3" id="track_order_form"
                                            onsubmit="return trackOrder(event)">
                                            @csrf
                                            <div class="input-style mb-20">
                                                <h4 class="mb-10">Order Id</h4>
                                                <input name="order_number" id="track_order_number"
                                                    placeholder="e.g., CAXXXXXXXX-XXXXXXXX" type="text"
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
                                                    <h4 class="mb-10">Order Number:</h4>
                                                    <h4 id="result_order_number" class="text-brand">-</h4>
                                                </div>
                                                <div class="col-md-6 mb-15">
                                                    <h4 class="mb-10">Order Status:</h4>
                                                    <h4><span id="result_order_status"
                                                            class="badge bg-primary">-</span></h4>
                                                </div>
                                            </div>
{{-- 
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
--}}
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
                </div>
            </div>
        </div>
    </main>

    <style>
        /* Track Order Card Styling */
        .track-order-card {
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
            border: 1px solid #e9ecef;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            margin-top: 20px;
        }

        .order-header-track {
            border-bottom: 2px solid #3BB77E;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .order-header-track h5 {
            color: #253D4E;
            font-weight: 600;
            margin: 0;
        }

        .tracking-notes-box {
            background: #fff8e1;
            border-left: 4px solid #ffc107;
            padding: 15px;
            border-radius: 6px;
            font-size: 14px;
            color: #5a5a5a;
            line-height: 1.6;
            min-height: 60px;
        }

        .text-brand {
            color: #3BB77E !important;
        }

        .fw-bold {
            font-weight: 700 !important;
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

    <script>
        // Track Order function
        function trackOrder(event) {
            event.preventDefault();

            const orderNumber = document.getElementById('track_order_number').value.trim();

            if (!orderNumber) {
                document.getElementById('track_order_message').innerHTML = '<h4 class="text-danger mt-10" style="font-size: 18px !important;">Please enter an order number</h4>';
                return false;
            }

            const trackBtn = document.getElementById('track_order_btn');
            trackBtn.disabled = true;
            trackBtn.textContent = 'Tracking...';
            document.getElementById('track_order_result').style.display = 'none';

            fetch('{{ route("checkout.track-order") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    order_number: orderNumber
                })
            })
            .then(response => response.json())
            .then(response => {
                if (response.success) {
                    // Populate the result display
                    document.getElementById('result_order_number').textContent = response.order.order_number;
                    document.getElementById('result_order_status').textContent = response.order.status.charAt(0).toUpperCase() + response.order.status.slice(1);
                    if (document.getElementById('result_order_date')) document.getElementById('result_order_date').textContent = response.order.placed_at;
                    if (document.getElementById('result_order_total')) document.getElementById('result_order_total').textContent = '₹' + parseFloat(response.order.final_amount).toFixed(2);

                    // Display notes or show "No tracking notes available"
                    const notes = response.order.notes || 'No tracking notes available yet.';
                    document.getElementById('result_order_notes').innerHTML = notes.replace(/\n/g, '<br>');

                    // Set status badge color based on status
                    const status = response.order.status.toLowerCase();
                    let badgeClass = 'bg-primary';
                    if (status === 'hold') badgeClass = 'bg-warning';
                    else if (status === 'confirmed') badgeClass = 'bg-info';
                    else if (status === 'packed') badgeClass = 'bg-secondary';
                    else if (status === 'shipped') badgeClass = 'bg-primary';
                    else if (status === 'delivered') badgeClass = 'bg-success';
                    else if (status === 'cancelled') badgeClass = 'bg-danger';

                    document.getElementById('result_order_status').className = 'badge ' + badgeClass;

                    // Show result box
                    document.getElementById('track_order_result').style.display = 'block';
                    document.getElementById('track_order_message').innerHTML = '<h4 class="text-brand mt-10">Order found!</h4>';
                    
                    if (typeof toastr !== 'undefined') {
                        toastr.success('Order found!', 'Success');
                    }
                } else {
                    document.getElementById('track_order_message').innerHTML = '<h4 class="text-danger mt-10" style="font-size: 18px !important;">' + response.message + '</h4>';
                    document.getElementById('track_order_result').style.display = 'none';
                }
                trackBtn.disabled = false;
                trackBtn.textContent = 'Track';
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('track_order_message').innerHTML = '<h4 class="text-danger mt-10" style="font-size: 18px !important;">Failed to track order. Please try again.</h4>';
                document.getElementById('track_order_result').style.display = 'none';
                trackBtn.disabled = false;
                trackBtn.textContent = 'Track';
            });

            return false;
        }
    </script>
@endsection
