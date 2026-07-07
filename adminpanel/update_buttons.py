import os
import re
import glob

def process_file(filepath):
    try:
        with open(filepath, "r", encoding="utf-8") as f:
            content = f.read()

        # Inject JavaScript into app.blade.php
        if "app.blade.php" in filepath and "function updateTableBadges()" not in content:
            script = """
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
</body>"""
            content = content.replace("</body>", script)

        # Regex modifications for action buttons
        # 1. Edit Button (icon to Edit text)
        content = re.sub(
            r"(?i)<a([^>]*?)class=[\"']btn([^>]*?)btn-warning((?!btn-action-col)[^>]*?)[\"']([^>]*?)>\s*<i\s+class=[\"']bi bi-pencil(?:-square)?(\s+me-1)?[\"']><\/i>(?:\s*Edit\s*)?<\/a>",
            r'<a\1class="btn\2btn-warning btn-action-col d-inline-flex align-items-center justify-content-center\3"\4><i class="bi bi-pencil-square me-1"></i> Edit</a>',
            content
        )
        
        # 2. Delete Button
        content = re.sub(
            r"(?i)<button([^>]*?)class=[\"'](?:btn([^>]*?)btn-danger|btn-danger((?!btn-action-col)[^>]*?))(?!btn-action-col)([^>]*?)[\"']([^>]*?)>\s*<i\s+class=[\"']bi bi-trash(\s+me-1)?[\"']><\/i>(?:\s*Delete\s*)?<\/button>",
            r'<button\1class="btn btn-sm btn-danger btn-action-col d-inline-flex align-items-center justify-content-center"\5><i class="bi bi-trash me-1"></i> Delete</button>',
            content
        )
        
        # 3. Info / View button
        content = re.sub(
            r"(?i)<button([^>]*?)class=[\"']btn([^>]*?)btn-info((?!btn-action-col)[^>]*?)[\"']([^>]*?)>\s*<i\s+class=[\"'](?:bi bi-speedometer2|bi bi-eye)(\s+me-1)?[\"']><\/i>(?:\s*Units|\s*View)?<\/button>",
            r'<button\1class="btn\2btn-info btn-action-col d-inline-flex align-items-center justify-content-center\3"\4><i class="bi bi-eye me-1"></i> View</button>',
            content
        )
        content = re.sub(
            r"(?i)<a([^>]*?)class=[\"']btn([^>]*?)btn-info((?!btn-action-col)[^>]*?)[\"']([^>]*?)>\s*<i\s+class=[\"'](?:bi bi-speedometer2|bi bi-eye)(\s+me-1)?[\"']><\/i>(?:\s*Units|\s*View)?<\/a>",
            r'<a\1class="btn\2btn-info btn-action-col d-inline-flex align-items-center justify-content-center\3"\4><i class="bi bi-eye me-1"></i> View</a>',
            content
        )
        
        with open(filepath, "w", encoding="utf-8") as f:
            f.write(content)
            
    except Exception as e:
        print(f"Error processing {filepath}: {e}")

# Process app.blade.php
process_file(r"c:\xampp\htdocs\chennais\adminpanel\resources\views\layouts\app.blade.php")

# Traverse all view templates
for root, dirs, files in os.walk(r"c:\xampp\htdocs\chennais\adminpanel\resources\views"):
    for file in files:
        if file.endswith(".blade.php"):
            process_file(os.path.join(root, file))

print("All blade templates safely processed.")
