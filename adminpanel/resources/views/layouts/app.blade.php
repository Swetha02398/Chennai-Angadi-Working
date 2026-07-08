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

/* Fix for Active/Inactive badge buttons black outline and enforce Pill radius */
table.table .badge,
table.table .btn-action-col, 
table.table form button.btn {
    outline: none !important;
    border: none !important;
    box-shadow: none !important;
}

/* Enforce Pill radius ONLY for status badges, not action buttons */
table.table .badge {
    border-radius: 50px !important;
    min-width: 85px !important;
    height: 28px !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    font-size: 12px !important;
    font-weight: 600 !important;
    padding: 0 10px !important;
    line-height: 1 !important;
}

/* Enforce identical size, radius, and alignment for Action Buttons (Edit / Delete / View) */
table.table td .btn-sm {
    border-radius: 6px !important;
    min-width: 80px !important;
    height: 30px !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    padding: 0 10px !important;
    line-height: 1 !important;
    font-size: 13px !important;
    white-space: nowrap !important;
}

/* Enforce exactly identical physical size for all Filter/Search and Clear buttons in table headers globally */
.card-header .btn,
.card-header form .btn {
    width: 145px !important;
    height: 36px !important;
    border-radius: 6px !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    text-align: center !important;
    padding: 0 !important;
    font-size: 13px !important;
    font-weight: 500 !important;
    margin: 0 auto !important; /* Centers within w-100 grid columns */
    vertical-align: top !important;
    white-space: nowrap !important;
}

/* Enforce the identical aesthetic for top "Add" buttons, but use min-width to accommodate slightly longer names like "Add Main Category" */
.content-header .btn,
.content-header a.btn {
    min-width: 145px !important;
    height: 36px !important;
    border-radius: 6px !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    text-align: center !important;
    padding: 0 15px !important;
    font-size: 13px !important;
    font-weight: 500 !important;
    vertical-align: top !important;
    white-space: nowrap !important;
}

table.table td .btn-sm i {
    display: inline-block;
    font-style: normal;
    margin-right: 4px !important;
}

table.table .badge:focus, table.table .badge:active,
table.table form button.btn:focus, table.table form button.btn:active,
table.table .btn-action-col:focus, table.table .btn-action-col:active {
    outline: none !important;
    border: none !important;
    box-shadow: none !important;
}

/* Standardize All Form Action Buttons (Save/Cancel/Update/Add/Edit/Back) across Create/Edit/View pages globally */
.content-main form .btn:not(.btn-sm):not(.search-btn):not([name="search"]), 
.content-main .btn-group-actions .btn,
.order-view-header .action-buttons .btn,
.btn-save,
.btn-cancel,
.btn-update,
button[type="submit"]:not(.btn-sm):not(.btn-action-col):not(.search-btn):not(.btn-primary:has(.bi-search)):not(.badge),
.content-main form a.btn-secondary:not(.btn-sm),
.content-main form a.btn-light:not(.btn-sm),
.content-main form a.btn-dark:not(.btn-sm) {
    min-width: 145px !important;
    height: 40px !important;
    border-radius: 6px !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    font-size: 14px !important;
    font-weight: 500 !important;
    padding: 0 15px !important;
    letter-spacing: 0.3px !important;
    white-space: nowrap !important;
    gap: 6px !important;
    margin: 0 !important;
}

/* Assure consistency on secondary/light links acting as form buttons */
.content-main form a.btn-secondary:not(.btn-sm),
.content-main form a.btn-light:not(.btn-sm),
.content-main form a.btn-dark:not(.btn-sm) {
    min-width: 145px !important;
    height: 40px !important;
    border-radius: 6px !important;
}

.content-main form .btn:not(.btn-sm) i,
.btn-save i,
.btn-cancel i,
.action-buttons .btn i {
    flex-shrink: 0;
    margin-right: 0 !important; /* using flex gap instead */
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



