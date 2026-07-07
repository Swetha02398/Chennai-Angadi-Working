<!DOCTYPE html>
<html style="margin: 0; padding: 0;" lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Chennai Angadi Dashboard</title>
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
        <!-- Third-party Stylesheets (Loaded in head to prevent layout reflows/FOUC) -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
        <style>
.main-footer {
    position: relative !important;
}

main.main-wrap {
    padding-bottom: 0 !important;
}

/* Pagination Ellipsis Enhancement */
.page-link.dot {
    background: transparent !important;
    border: none !important;
    color: #3BB77E !important; /* Brand green color to make it pop */
    padding: 0.5rem 0.5rem !important;
    font-weight: 900 !important;
    font-size: 24px !important;
    letter-spacing: 3px !important;
    pointer-events: none;
    line-height: 1 !important;
    width: auto !important;
    min-width: 40px !important;
    text-align: center !important;
    display: inline-block !important;
}
.page-item.disabled .page-link.dot {
    background-color: transparent !important;
    border-color: transparent !important;
}
</style>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    </head>

    <body style="margin: 0; padding: 0;">
        <div class="screen-overlay"></div>
        @include('partials.header')
        <main class="main-wrap">   
            @yield('content')
            <!-- content-main end// --> 
              @include('partials.footer')    
        </main>
        
         
        <script src="{{ asset('assets/js/vendors/jquery-3.6.0.min.js') }}"></script>
        <script src="{{ asset('assets/js/vendors/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/js/vendors/select2.min.js') }}"></script>
        <script src="{{ asset('assets/js/vendors/perfect-scrollbar.js') }}"></script>
        <script src="{{ asset('assets/js/vendors/jquery.fullscreen.min.js') }}"></script>
        <script src="{{ asset('assets/js/vendors/chart.js') }}"></script>
        <!-- Third-party Plugins JS (bound to the same single jQuery instance) -->
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <!-- Main Script -->
        <script src="{{ asset('assets/js/main.js?v=6.0') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/js/custom-chart.js') }}" type="text/javascript"></script>
            <script>
                if (typeof toastr !== 'undefined') {
                    toastr.options = {
                        "closeButton": true,
                        "progressBar": true,
                        "timeOut": "500",
                        "extendedTimeOut": "500",
                        "positionClass": "toast-top-right"
                    };
                }
            </script>
            @stack('scripts')
    
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            function unifyTableBadges() {
                var $tables = $('.table');
                $tables.each(function() {
                    var $table = $(this);
                    
                    if ($table.attr("data-badges-unified") === "true") return;
                    
                    var $headerRow = $table.find("thead tr, .table-light tr");
                    if ($headerRow.length === 0) return;
                    
                    var $headers = $headerRow.find("th");
                    $headers.each(function(colIndex) {
                        var headerText = $(this).text().trim().toLowerCase();
                        if (headerText === "status") {
                            var $elements = $table.find("tbody tr").map(function() {
                                return $(this).children("td").eq(colIndex).find(".badge, .btn-sm").get();
                            });
                            
                            if ($elements.length > 0) {
                                var maxWidth = 0;
                                var targetRadius = "4px";
                                var hasPill = false;
                                
                                $elements.each(function() {
                                    var $el = $(this);
                                    $el.css({ "width": "auto", "min-width": "0" });
                                    var w = $el.outerWidth();
                                    if ($el.hasClass("rounded-pill")) {
                                        hasPill = true;
                                    }
                                    if (w > maxWidth) {
                                        maxWidth = w;
                                        if (!hasPill) {
                                            targetRadius = $el.css("border-radius");
                                        }
                                    }
                                });
                                
                                if (hasPill) {
                                    targetRadius = "50rem";
                                }
                                
                                if (maxWidth > 0) {
                                    $elements.each(function() {
                                        $(this).css({
                                            "width": (maxWidth + 10) + "px", 
                                            "display": "inline-block",
                                            "text-align": "center",
                                            "border-radius": targetRadius
                                        });
                                    });
                                }
                            }
                        }
                    });
                    
                    $table.attr("data-badges-unified", "true");
                });
            }
            
            unifyTableBadges();
            
            $(document).ajaxComplete(function(event, xhr, settings) {
                setTimeout(function() {
                    $('.table').attr("data-badges-unified", null);
                    unifyTableBadges();
                }, 100);
            });
        });
    </script>
</body>
</html>



