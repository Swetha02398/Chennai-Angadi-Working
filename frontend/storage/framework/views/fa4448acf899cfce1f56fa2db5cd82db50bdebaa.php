
<?php $__env->startSection('content'); ?>
    <!--End header-->
    <main class="main pages">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="<?php echo e(route('index')); ?>" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                    <span></span> Return and Refund Policy
                </div>
            </div>
        </div>
        <div class="page-content pt-50">
            <div class="container">
                <div class="row">
                    <div class="col-xl-8 col-lg-10 m-auto">
                        <div class="row">
                            <div class="col-lg-12 m-auto">
                                <div class="single-page pr-30 mb-lg-0 mb-sm-5">
                                    <div class="single-header style-2 text-center">
                                        <h2>Return and Refund Policy</h2>
                                    </div>
                                    <div class="single-content mb-50">
                                        <h4 class="text-center">Welcome to Chennai Angadi Return and Refund Policy - <span
                                                style="font-size: 0.75em; font-weight: normal;">9 December 2025</span></h4>
                                        <div class="faq-container">
                                            <div class="faq-container">

                                                <!-- FAQ 1 -->
                                                <div class="faq-item">
                                                    <button class="faq-question">1. How to return an item?</button>
                                                    <div class="faq-answer">
                                                        <p>Contact us at <strong>care@chennaiangadi.com</strong> or WhatsApp
                                                            <strong>9094676665</strong> to initiate the return.
                                                        </p>
                                                        <ul>
                                                            <li>Include your order ID and reason.</li>
                                                            <li>Ship item to the provided address.</li>
                                                            <li>Return courier charges not covered.</li>
                                                            <li>Refund/exchange processed after item is received.</li>
                                                        </ul>
                                                    </div>
                                                </div>

                                                <!-- FAQ 2 -->
                                                <div class="faq-item">
                                                    <button class="faq-question">2. Damaged products during transit</button>
                                                    <div class="faq-answer">
                                                        <p>If your product arrives damaged, follow the steps:</p>
                                                        <ul>
                                                            <li>Record continuous unboxing video.</li>
                                                            <li>Send photos of the damage.</li>
                                                        </ul>
                                                        <p>After verification, refund will be issued.</p>
                                                    </div>
                                                </div>

                                                <!-- FAQ 3 -->
                                                <div class="faq-item">
                                                    <button class="faq-question">3. Wrong Product Received: How to Request a
                                                        Resolution?</button>
                                                    <div class="faq-answer">
                                                        <p>Email <strong>care@chennaiangadi.com</strong> or call
                                                            <strong>9094676665</strong> within 2 days.
                                                        </p>
                                                        <ul>
                                                            <li>Send photos of wrong item.</li>
                                                            <li>Return shipping covered if our mistake.</li>
                                                            <li>Replacement or refund if unavailable.</li>
                                                        </ul>
                                                    </div>
                                                </div>

                                                <!-- FAQ 4 -->
                                                <div class="faq-item">
                                                    <button class="faq-question">4. Order Cancellation Policy</button>
                                                    <div class="faq-answer">
                                                        <p>You can cancel order within 24 hours.</p>
                                                        <ul>
                                                            <li>Contact us with order ID.</li>
                                                            <li>Refund within 7–10 business days.</li>
                                                            <li>Shipped orders cannot be canceled.</li>
                                                        </ul>
                                                    </div>
                                                </div>

                                                <!-- FAQ 5 -->
                                                <div class="faq-item">
                                                    <button class="faq-question">5. Complaint Time Limit</button>
                                                    <div class="faq-answer">
                                                        <p>Complaints must be raised within <strong>24 hours</strong> of
                                                            delivery.</p>
                                                    </div>
                                                </div>

                                                <!-- FAQ 6 -->
                                                <div class="faq-item">
                                                    <button class="faq-question">6. Refunds</button>
                                                    <div class="faq-answer">
                                                        <p>Refund processed in 7–10 business days after inspection.</p>
                                                        <p>Shipping fees are non-refundable. Return shipping paid by
                                                            customer.</p>
                                                    </div>
                                                </div>

                                                <!-- FAQ 7 -->
                                                <div class="faq-item">
                                                    <button class="faq-question">7. Exchanges</button>
                                                    <div class="faq-answer">
                                                        <p>If defective/wrong item received, free exchange provided.</p>
                                                        <p>Other exchanges → return the item and order again.</p>
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
        .faq-container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            font-family: Arial, sans-serif;
        }

        .faq-item {
            border-bottom: 1px solid #ddd;
        }

        .faq-question {
            width: 100%;
            background: #f7f7f7;
            padding: 15px 20px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            border: none;
            text-align: left;
            outline: none;
            transition: 0.3s;
            position: relative;
            padding-right: 50px;
        }

        .faq-question::after {
            content: '\25BC';
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            transition: transform 0.3s;
            font-size: 14px;
        }

        .faq-question.active {
            background: #e2e2e2;
        }

        .faq-question.active::after {
            transform: translateY(-50%) rotate(180deg);
        }

        .faq-answer {
            display: none;
            padding: 15px 20px;
            background: #fff;
            font-size: 16px;
            line-height: 1.6;
        }
    </style>

    <script>
        // Close all other FAQ answers when one is opened
        const questions = document.querySelectorAll(".faq-question");

        questions.forEach(q => {
            q.addEventListener("click", () => {

                // Close all others
                questions.forEach(other => {
                    if (other !== q) {
                        other.classList.remove("active");
                        other.nextElementSibling.style.display = "none";
                    }
                });

                // Toggle the clicked one
                q.classList.toggle("active");
                const answer = q.nextElementSibling;
                answer.style.display = answer.style.display === "block" ? "none" : "block";
            });
        });
    </script>



<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\chennais\frontend\resources\views/pages/return-refund.blade.php ENDPATH**/ ?>