
<?php $__env->startSection('content'); ?>
    <!--End header-->
    <main class="main pages">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="<?php echo e(route('index')); ?>" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                    <span></span> Offers
                </div>
            </div>
        </div>
        <div class="page-content py-3">
            <div class="container">
                <div class="row">
                            <?php if($coupons->count() > 0): ?>
                                <?php $__currentLoopData = $coupons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $coupon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-lg-6 col-md-6 col-6 mb-30">
                                        <div class="coupon-card">
                                            <table class="table table-bordered coupon-table" style="margin-bottom: 0;border:2px solid #3BB77E;">
                                            <tbody>
                                                <tr>
                                                    <td style="width: 200px; font-weight: 600; background-color: #f8f9fa;">Coupon
                                                        No:</td>
                                                    <td><strong
                                                            style="color: #3BB77E; font-size: 16px;"><?php echo e($coupon->code); ?></strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-weight: 600; background-color: #f8f9fa;">Description:</td>
                                                    <td>
                                                        Use code <strong><?php echo e($coupon->code); ?></strong>
                                                        <?php if($coupon->type == 'percentage'): ?>
                                                            you will get <?php echo e(number_format($coupon->value, 0)); ?>% off
                                                        <?php else: ?>
                                                            you will get ₹<?php echo e(number_format($coupon->value, 0)); ?> off
                                                        <?php endif; ?>
                                                        on all products
                                                        <?php if($coupon->description): ?>
                                                            <br><small class="text-muted"><?php echo e($coupon->description); ?></small>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-weight: 600; background-color: #f8f9fa;">Discount (%):</td>
                                                    <td>
                                                        <?php if($coupon->type == 'percentage'): ?>
                                                            <?php echo e(number_format($coupon->value, 0)); ?> %
                                                        <?php else: ?>
                                                            ₹ <?php echo e(number_format($coupon->value, 0)); ?> (Fixed)
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-weight: 600; background-color: #f8f9fa;">Minimum Amount:</td>
                                                    <td>₹ <?php echo e(number_format($coupon->min_amount, 0)); ?></td>
                                                </tr>
                                                <tr>
                                                    <td style="font-weight: 600; background-color: #f8f9fa;">Expiry On:</td>
                                                    <td>
                                                        <?php echo e(\Carbon\Carbon::parse($coupon->end_date)->format('d-m-Y')); ?>

                                                        <?php if($coupon->end_time): ?>
                                                            <?php echo e(date('h:i A', strtotime($coupon->end_time))); ?>

                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-weight: 600; background-color: #f8f9fa;">Time Left:</td>
                                                    <td>
                                                        <?php
                                                            $endDateStr = \Carbon\Carbon::parse($coupon->end_date)->format('Y-m-d');
                                                            $endTimeStr = $coupon->end_time ? date('H:i:s', strtotime($coupon->end_time)) : '23:59:59';
                                                        ?>
                                                        <span class="coupon-countdown"
                                                            data-end="<?php echo e($endDateStr); ?>T<?php echo e($endTimeStr); ?>"
                                                            id="countdown-<?php echo e($coupon->id); ?>">
                                                            Calculating...
                                                        </span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            </table>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <div class="col-12 d-flex flex-column justify-content-center align-items-center" style="min-height: 40vh; padding: 40px 0;">
                                    <div class="text-center" style="max-width: 500px;">
                                        <i class="fi-rs-shopping-bag" style="font-size: 60px; color: #3BB77E; margin-bottom: 20px; display: block; opacity: 0.5;"></i>
                                        <h3 style="color: #253D4E; margin-bottom: 15px;">No active offers</h3>
                                        <p style="color: #7E7E7E; font-size: 16px; margin-bottom: 25px;">We currently don't have any active offers available at the moment. Please check back later for exciting deals!</p>
                                        <a href="<?php echo e(route('index')); ?>" class="btn btn-heading btn-block hover-up"><i class="fi-rs-home mr-10"></i>Return to Home</a>
                                    </div>
                                </div>
                            <?php endif; ?>
                        
                    
                </div>
            </div>
        </div>
    </main>

    <style>
        .coupon-card {
            border: 2px solid #3BB77E;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .coupon-card table {
            margin-bottom: 0;
        }

        .coupon-card td {
            padding: 12px 15px;
            vertical-align: middle;
        }

        .coupon-card tr:last-child td {
            border-bottom: none;
        }

        .coupon-countdown {
            font-weight: 600;
            font-size: 14px;
            color: #e74c3c;
        }

        .countdown-unit {
            display: inline-block;
            background: #fff3f3;
            border: 1px solid #fcd5d5;
            border-radius: 6px;
            padding: 4px 8px;
            margin: 0 2px;
            min-width: 40px;
            text-align: center;
        }

        .countdown-unit .count-num {
            font-size: 16px;
            font-weight: 700;
            color: #e74c3c;
            display: block;
            line-height: 1.2;
        }

        .countdown-unit .count-label {
            font-size: 10px;
            color: #999;
            font-weight: 500;
            text-transform: uppercase;
        }

        .countdown-expired {
            color: #dc3545;
            font-weight: 700;
        }

        /* Mobile responsive coupon card overrides */
        @media (max-width: 767.98px) {
            .page-content.pt-50.pb-50 {
                padding-top: 15px !important;
                padding-bottom: 15px !important;
            }

            .coupon-card {
                border-width: 1.5px;
                border-radius: 6px;
                margin-bottom: 10px !important;
            }

            .coupon-table,
            .coupon-table tbody,
            .coupon-table tr,
            .coupon-table td {
                display: block !important;
                width: 100% !important;
            }
            .coupon-table tr {
                border-bottom: 1px solid #eee;
            }
            .coupon-table tr:last-child {
                border-bottom: none;
            }
            .coupon-table td {
                padding: 4px 6px !important;
                font-size: 11px !important;
                text-align: center !important;
                border: none !important;
            }
            /* Style label rows */
            .coupon-table td[style*="font-weight: 600"] {
                padding-top: 6px !important;
                padding-bottom: 1px !important;
                font-size: 10.5px !important;
                color: #666;
            }
            /* Style value rows */
            .coupon-table td:not([style*="font-weight: 600"]) {
                padding-top: 1px !important;
                padding-bottom: 6px !important;
                font-size: 11px !important;
            }
            .coupon-table td strong {
                font-size: 13px !important;
            }
            .countdown-unit {
                padding: 2px 3px !important;
                min-width: 26px !important;
                margin: 0 1px !important;
                border-radius: 4px !important;
            }
            .countdown-unit .count-num {
                font-size: 11px !important;
            }
            .countdown-unit .count-label {
                font-size: 7.5px !important;
            }
        }
    </style>

    <?php $__env->startPush('scripts'); ?>
        <script>
            function startCouponCountdowns() {
                var countdowns = document.querySelectorAll('.coupon-countdown');

                countdowns.forEach(function (el) {
                    var endStr = el.getAttribute('data-end');
                    var endTime = new Date(endStr).getTime();

                    function updateCountdown() {
                        var now = new Date().getTime();
                        var diff = endTime - now;

                        if (diff <= 0) {
                            el.innerHTML = '<span class="countdown-expired">Expired</span>';
                            // Hide the coupon card after expiry
                            var couponCard = el.closest('.coupon-card');
                            if (couponCard) {
                                couponCard.style.transition = 'opacity 0.5s';
                                couponCard.style.opacity = '0';
                                setTimeout(function () { couponCard.style.display = 'none'; }, 500);
                            }
                            return;
                        }

                        var days = Math.floor(diff / (1000 * 60 * 60 * 24));
                        var hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        var minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                        var seconds = Math.floor((diff % (1000 * 60)) / 1000);

                        var html = '';
                        if (days > 0) {
                            html += '<span class="countdown-unit"><span class="count-num">' + days + '</span><span class="count-label">Days</span></span>';
                        }
                        html += '<span class="countdown-unit"><span class="count-num">' + String(hours).padStart(2, '0') + '</span><span class="count-label">Hrs</span></span>';
                        html += '<span class="countdown-unit"><span class="count-num">' + String(minutes).padStart(2, '0') + '</span><span class="count-label">Min</span></span>';
                        html += '<span class="countdown-unit"><span class="count-num">' + String(seconds).padStart(2, '0') + '</span><span class="count-label">Sec</span></span>';

                        el.innerHTML = html;

                        setTimeout(updateCountdown, 1000);
                    }

                    updateCountdown();
                });
            }

            document.addEventListener('DOMContentLoaded', startCouponCountdowns);
        </script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\chennais\frontend\resources\views/section/offer.blade.php ENDPATH**/ ?>