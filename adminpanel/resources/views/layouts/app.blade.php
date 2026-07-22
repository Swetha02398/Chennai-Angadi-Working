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
        <link href="{{ asset('assets/css/main.css') }}?v={{ file_exists(public_path('assets/css/main.css')) ? filemtime(public_path('assets/css/main.css')) : '6.0' }}" rel="stylesheet" type="text/css" />
        <!-- Third-party Stylesheets (Loaded in head to prevent layout reflows/FOUC) -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
        <style>
.main-footer {
    position: relative !important;
    margin-top: auto !important;
}

main.main-wrap {
    padding-bottom: 0 !important;
    min-height: 100vh !important;
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

/* Fix for Active/Inactive badge buttons black outline and enforce Pill radius */
table.table .badge,
table.table .btn-action-col, 
table.table form button.btn {
    outline: none !important;
    border: none !important;
    box-shadow: none !important;
}

/* Enforce mathematically absolute identical radius and size for ALL badges AND Action Buttons across the entire layout */
main.main-wrap .badge,
main.main-wrap .btn {
    border-radius: 4px !important;
    min-width: 100px !important;
    max-width: 100px !important;
    height: 32px !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    gap: 4px !important;
    font-size: 11.5px !important;
    font-weight: 500 !important;
    padding: 0 4px !important;
    line-height: normal !important;
    white-space: normal !important;
    text-align: center !important;
    vertical-align: middle !important;
    margin: 0 !important; /* Prevents auto margins from skewing shapes randomly */
}
main.main-wrap .badge i,
main.main-wrap .btn i {
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    margin: 0 !important; /* Overriden by gap */
    line-height: 1 !important;
    font-style: normal !important;
}

table.table .badge:focus, table.table .badge:active,
table.table form button.btn:focus, table.table form button.btn:active,
table.table .btn-action-col:focus, table.table .btn-action-col:active {
    outline: none !important;
    border: none !important;
    box-shadow: none !important;
}



/* Sidebar Width Optimization */
body:not(.aside-mini) .navbar-aside,
html body:not(.aside-mini) aside#offcanvas_aside.navbar-aside {
    max-width: 240px !important;
    width: 240px !important;
}
body:not(.aside-mini) .main-wrap,
body:not(.aside-mini) .main-header {
    margin-left: 240px !important;
}
@media (max-width: 1200px) {
    body:not(.aside-mini) .navbar-aside,
    html body:not(.aside-mini) aside#offcanvas_aside.navbar-aside {
        max-width: 210px !important;
        width: 210px !important;
    }
    body:not(.aside-mini) .main-wrap,
    body:not(.aside-mini) .main-header {
        margin-left: 210px !important;
    }
}
@media (max-width: 992px) {
    body:not(.aside-mini) .main-wrap,
    body:not(.aside-mini) .main-header {
        margin-left: 0 !important;
    }
}
  /* Admin Global Spacing Reduction (3mm - 5mm constraint) */
  html, body {
      margin: 0 !important;
      padding: 0 !important;
      overflow-x: hidden !important; /* Hide horizontal scroll */
  }
  html {
      overflow-y: scroll !important; /* Single native scrollbar */
  }
  body {
      display: flex !important;
      flex-direction: column !important;
      position: relative !important;
  }
  /* Allow mobile menu to lock scroll */
  body.offcanvas-active {
      overflow-y: hidden !important;
  }
  main.main-wrap {
      display: flex !important;
      flex-direction: column !important;
      flex-grow: 1 !important;
      min-height: calc(100vh - 60px) !important;
      width: auto !important;
      overflow-x: hidden !important; /* Trap inner horizontal scroll */
      box-sizing: border-box !important;
  }
  .content-main {
      padding: 12px 12px !important;
      max-width: 100% !important;
      width: 100% !important;
      margin: 0 !important; /* Overrides any auto margins causing side gaps */
      display: flex !important;
      flex-direction: column !important;
      flex-grow: 1 !important;
      box-sizing: border-box !important;
      overflow-x: hidden !important; /* Prevents 100% + padding overflow */
  }
.content-main > .container,
.content-main > .container-fluid {
    max-width: 100% !important;
    padding-left: 0 !important;
    padding-right: 0 !important;
    margin-top: 0 !important;
    margin-bottom: 0 !important;
    display: flex;
    flex-direction: column;
    
}
.content-main > .row,
.content-main > form > .row {
    margin-top: 0 !important;
}
.content-header {
    margin-bottom: 12px !important;
}
.main-header {
    min-height: 60px !important;
    padding: 0 12px !important;
}
.main-header .col-nav {
    padding: 0 !important;
}
.card {
    margin-bottom: 12px !important;
    display: flex;
    flex-direction: column;
}
.card-body {
    flex-grow: 0; 
}
.main-footer {
    padding: 0 !important;
    margin-top: auto !important; /* Forces footer to bottom of viewport on short pages */
    padding-bottom: 12px !important; 
}
.main-footer .row {
    padding-top: 12px !important;
    padding-bottom: 0 !important;
    margin: 0 !important;
}

/* Pagination Overrides */
.pagination-area {
    margin-top: 16px !important; /* ~4mm gap from card */
    margin-bottom: 0 !important;
}

/* Table Row Compression (Reduces the 2-line gap in products/categories lists) */
table.table td, 
table.table th {
    padding-top: 6px !important;
    padding-bottom: 6px !important;
    vertical-align: middle !important;
}

/* Global Constant Scrollbar (Prevents zooming/thickening on hover/click) */
::-webkit-scrollbar, *::-webkit-scrollbar {
    width: 6px !important;
    height: 6px !important;
}
::-webkit-scrollbar-track, *::-webkit-scrollbar-track {
    background: transparent !important; 
}
::-webkit-scrollbar-thumb, *::-webkit-scrollbar-thumb {
    background: #c1c1c1 !important; 
    border-radius: 10px !important;
}
::-webkit-scrollbar-thumb:hover, 
::-webkit-scrollbar-thumb:active,
*::-webkit-scrollbar-thumb:hover, 
*::-webkit-scrollbar-thumb:active {
    background: #999999 !important; 
}
/* Perfect Scrollbar Global Overrides */
.ps__rail-y:hover > .ps__thumb-y, 
.ps__rail-y:focus > .ps__thumb-y, 
.ps__rail-y.ps--clicking .ps__thumb-y {
    width: 6px !important;
    background-color: #999999 !important;
}
.ps__thumb-y {
    width: 6px !important;
}

/* Hide scrollbar completely on mini-sidebar to prevent double scrollbars */
body.aside-mini .navbar-aside::-webkit-scrollbar {
    display: none !important;
    width: 0 !important;
}
body.aside-mini .navbar-aside {
    -ms-overflow-style: none !important;  /* IE and Edge */
    scrollbar-width: none !important;  /* Firefox */
}
body.aside-mini .navbar-aside .ps__rail-y,
body.aside-mini .navbar-aside .ps__thumb-y,
.ps__rail-x {
    display: none !important;
}

/* Nuke ALL rogue horizontal WebKit scrollbars completely to permanently resolve bottom scrollbar overflow */
::-webkit-scrollbar:horizontal, *::-webkit-scrollbar:horizontal {
    display: none !important;
    height: 0 !important;
}

/* Background Gaps Masked Below */

/* Mask Background Gaps */
body {
    min-height: 100vh !important;
}
html:not(.dark),
html:not(.dark) body {
    background-color: #f8f9fa !important;
}
html.dark,
html.dark body {
    background-color: #222736 !important;
}

/* Fix massive gaps between Search and Clear buttons (Standard 3mm spacing) */
.card-header form .row > div:has(> .btn-primary:only-child),
.card-header form .row > div:has(> .btn-secondary:only-child) {
    width: auto !important;
    flex: 0 0 auto !important;
    padding-left: 4px !important;
    padding-right: 4px !important;
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
    <script>
        // Global Robust Real-time Auto-Search Implementation
        document.addEventListener("DOMContentLoaded", function() {
            // Find all inputs that function as search boxes across all modules
            const searchSelectors = 'input[name="search"], input[id*="Search"], input[id*="search"], input[placeholder*="Search"], input[placeholder*="search"]';
            const searchInputs = document.querySelectorAll(searchSelectors);
            let searchTimeout = null;
            
            searchInputs.forEach(function(input) {
                // Prevent targeting random non-text inputs (like checkboxes if wrongly named)
                if (input.type === 'checkbox' || input.type === 'radio' || input.type === 'hidden') return;

                // Auto-focus the search input if it has a populated value (indicating an active search state)
                // This ensures that when the page reloads after filtering, user focus is preserved 
                if (input.value && input.value.trim() !== '') {
                    // Slight timeout to ensure layout is fully rendered before focusing
                    setTimeout(() => {
                        input.focus();
                        // Move cursor to the end cleanly
                        const val = input.value;
                        input.value = '';
                        input.value = val;
                    }, 50);
                }

                input.addEventListener('keyup', function(e) {
                    // Ignore navigational & control keys
                    const ignoredKeys = [
                        'Tab', 'Enter', 'Escape', 
                        'ArrowLeft', 'ArrowRight', 'ArrowUp', 'ArrowDown', 
                        'Shift', 'Control', 'Alt', 'Meta', 'CapsLock',
                        'PageUp', 'PageDown', 'Home', 'End'
                    ];
                    
                    // Crucial: we ignore 'Enter' because we artificially trigger it later, 
                    // prevent infinite loop!
                    if (ignoredKeys.includes(e.key)) return;

                    clearTimeout(searchTimeout);
                    
                    // Trigger after 500ms debounce
                    searchTimeout = setTimeout(function() {
                        const form = input.closest('form');
                        if (form) {
                            form.submit();
                        } else {
                            // If no form, try known global filter functions
                            if (typeof filterTable === 'function') {
                                filterTable();
                            } else if (typeof filterOrders === 'function') {
                                filterOrders();
                            } else {
                                // Fallback: simulate an 'Enter' keypress on the input
                                // This natively triggers independent scripts waiting for Enter
                                const enterEvent = new KeyboardEvent('keyup', {
                                    key: 'Enter',
                                    code: 'Enter',
                                    keyCode: 13,
                                    which: 13,
                                    bubbles: true,
                                    cancelable: true
                                });
                                input.dispatchEvent(enterEvent);
                            }
                        }
                    }, 500);
                });
            });
        });
    </script>
</body>
</html>



