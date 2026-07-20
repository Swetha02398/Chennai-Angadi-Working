<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Chennai Angadi </title>
        <meta http-equiv="x-ua-compatible" content="ie=edge" />
        <meta name="description" content="" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta property="og:title" content="" />
        <meta property="og:type" content="" />
        <meta property="og:url" content="" />
        <meta property="og:image" content="" />
        <!-- Favicon -->
         <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/imgs/theme/chennaiangadifavicon.png') }}" />
         <!-- Template CSS -->
        <script src="{{ asset('assets/js/vendors/color-modes.js') }}"></script>
        <link href="{{ asset('assets/css/main.css?v=6.0') }}" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    </head>

    <body>
        <main>
            @yield('content')
        </main>
        <script src="{{ asset('assets/js/vendors/jquery-3.6.0.min.js') }}"></script>
        <script src="{{ asset('assets/js/vendors/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/js/vendors/jquery.fullscreen.min.js') }}"></script>
        <!-- Main Script -->
        <script src="{{ asset('assets/js/main.js?v=6.0') }}" type="text/javascript"></script>
          <!-- alert message  -->
            <!-- jQuery -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
            <!-- Toastr JS -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
            <!-- Toastr CSS -->
            <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
        <script>
// Example starter JavaScript for disabling form submissions if there are invalid fields
(function () {
  'use strict'
  var forms = document.querySelectorAll('.needs-validation')

  Array.prototype.slice.call(forms)
    .forEach(function (form) {
      form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
          event.preventDefault()
          event.stopPropagation()
        }
        form.classList.add('was-validated')
      }, false)
    })
})()
</script>

    </body>
</html>
