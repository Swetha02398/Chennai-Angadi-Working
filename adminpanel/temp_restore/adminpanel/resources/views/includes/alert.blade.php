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


@if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "timeOut": "500",
                "extendedTimeOut": "500",
                "positionClass": "toast-top-right"
            };
            toastr.success("{{ session('success') }}");
        });
    </script>
@endif

@if (session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "timeOut": "500",
                "extendedTimeOut": "500",
                "positionClass": "toast-top-right"
            };
            toastr.error("{{ session('error') }}");
        });
    </script>
@endif