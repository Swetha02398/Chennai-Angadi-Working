const fs = require('fs');
const path = require('path');

function processFile(filePath) {
    try {
        let content = fs.readFileSync(filePath, 'utf8');
        let originalContent = content;

        // JS Injection for app.blade.php
        if (filePath.endsWith('app.blade.php') && !content.includes('function updateTableBadges()') && !content.includes('unifyTableBadges()')) {
            const script = `
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
</body>`;
            content = content.replace('</body>', script);
        }

        // Action Buttons Regex Fixes
        content = content.replace(/<a([^>]*?)class=(["'])btn([^>]*?)btn-warning((?!btn-action-col)[^>]*?)\2([^>]*?)>\s*<i\s+class=(["'])bi bi-pencil(?:-square)?(\s+me-1)?\6><\/i>(?:\s*Edit\s*)?<\/a>/gi, 
            '<a$1class=$2btn$3btn-warning btn-action-col d-inline-flex align-items-center justify-content-center$4$2$5><i class="bi bi-pencil-square me-1"></i> Edit</a>');
            
        content = content.replace(/<button([^>]*?)class=(["'])(?:btn([^>]*?)btn-danger|btn-danger((?!btn-action-col)[^>]*?))(?!btn-action-col)([^>]*?)\2([^>]*?)>\s*<i\s+class=(["'])bi bi-trash(\s+me-1)?\7><\/i>(?:\s*Delete\s*)?<\/button>/gi,
            '<button$1class="btn btn-sm btn-danger btn-action-col d-inline-flex align-items-center justify-content-center"$6><i class="bi bi-trash me-1"></i> Delete</button>');
            
        // Info button standardizing
        content = content.replace(/<button([^>]*?)class=(["'])btn([^>]*?)btn-info((?!btn-action-col)[^>]*?)\2([^>]*?)>\s*<i\s+class=(["'])(?:bi bi-speedometer2|bi bi-eye|bi-eye)(\s+me-1)?\6><\/i>(?:\s*Units|\s*View)?<\/button>/gi,
            '<button$1class="btn$3btn-info btn-action-col d-inline-flex align-items-center justify-content-center$4"$5><i class="bi bi-eye me-1"></i> View</button>');
            
        content = content.replace(/<a([^>]*?)class=(["'])btn([^>]*?)btn-info((?!btn-action-col)[^>]*?)\2([^>]*?)>\s*<i\s+class=(["'])(?:bi bi-speedometer2|bi bi-eye|bi-eye)(\s+me-1)?\6><\/i>(?:\s*Units|\s*View)?<\/a>/gi,
            '<a$1class="btn$3btn-info btn-action-col d-inline-flex align-items-center justify-content-center$4"$5><i class="bi bi-eye me-1"></i> View</a>');
            

        if (content !== originalContent) {
            fs.writeFileSync(filePath, content, 'utf8');
        }
    } catch (e) {
        console.error("Error processing " + filePath, e);
    }
}

function processDirectory(dir) {
    fs.readdirSync(dir).forEach(file => {
        let fullPath = path.join(dir, file);
        if (fs.statSync(fullPath).isDirectory()) {
            processDirectory(fullPath);
        } else if (file.endsWith('.blade.php')) {
            processFile(fullPath);
        }
    });
}

processDirectory("c:\\xampp\\htdocs\\chennais\\adminpanel\\resources\\views");
console.log("All templates processed securely.");
