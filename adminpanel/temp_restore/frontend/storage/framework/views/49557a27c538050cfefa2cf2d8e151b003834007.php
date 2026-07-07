<style>
    .toast-success {
        background-color: #28a745 !important;
        color: #fff !important;
    }

    .toast-error {
        background-color: #dc3545 !important;
        color: #fff !important;
    }

    .toast-message {
        color: #fff !important;
        font-weight: 500 !important;
    }
</style>


<?php if(session('success')): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "timeOut": "500",
                "extendedTimeOut": "500",
                "positionClass": "toast-top-right"
            };
            toastr.success("<?php echo e(session('success')); ?>");
        });
    </script>
<?php endif; ?>

<?php if(session('error')): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "timeOut": "500",
                "extendedTimeOut": "500",
                "positionClass": "toast-top-right"
            };
            toastr.error("<?php echo e(session('error')); ?>");
        });
    </script>
<?php endif; ?>

<?php if(session('message')): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "timeOut": "500",
                "extendedTimeOut": "500",
                "positionClass": "toast-top-right"
            };
            toastr.success("<?php echo e(session('message')); ?>");
        });
    </script>
<?php endif; ?><?php /**PATH /home/kidsmittaisbhask/public_html/chennaiangadi/frontend/resources/views/includes/alert.blade.php ENDPATH**/ ?>