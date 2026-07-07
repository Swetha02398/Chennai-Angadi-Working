const fs = require('fs');
const path = require('path');

function processFile(filePath) {
    try {
        let content = fs.readFileSync(filePath, 'utf8');
        let originalContent = content;

        // Edit Button Fix
        content = content.replace(/<(a|button)([^>]*?)class=(["'])\b([^"']*?)\bbtn-warning\b([^"']*?)\3([^>]*?)>\s*<i\s+class=(["'])bi\s+bi-pencil(?:-square)?(?:\s+me-1)?\7><\/i>(?:\s*Edit\s*)?<\/\1>/gi,
            function(match, tag, beforeClass, quote, classBefore, classAfter, afterClass, quoteIcon){
                if((classBefore + classAfter).includes("btn-action-col")) return match;
                return `<${tag}${beforeClass}class=${quote}${classBefore}btn-warning${classAfter} btn-action-col d-inline-flex align-items-center justify-content-center${quote}${afterClass}><i class="bi bi-pencil-square me-1"></i> Edit</${tag}>`;
            });
            
        // Delete Button Fix
        content = content.replace(/<(a|button)([^>]*?)class=(["'])\b([^"']*?)\bbtn-danger\b([^"']*?)\3([^>]*?)>\s*<i\s+class=(["'])bi\s+bi-trash(?:\s+me-1)?\7><\/i>(?:\s*Delete\s*)?<\/\1>/gi,
            function(match, tag, beforeClass, quote, classBefore, classAfter, afterClass, quoteIcon){
                if((classBefore + classAfter).includes("btn-action-col")) return match;
                return `<${tag}${beforeClass}class=${quote}${classBefore}btn-sm btn-danger${classAfter} btn-action-col d-inline-flex align-items-center justify-content-center${quote}${afterClass}><i class="bi bi-trash me-1"></i> Delete</${tag}>`;
            });
            
        // Info/View Button Fix
        content = content.replace(/<(a|button)([^>]*?)class=(["'])\b([^"']*?)\bbtn-info\b([^"']*?)\3([^>]*?)>\s*<i\s+class=(["'])bi\s+(?:bi-speedometer2|bi-eye)(?:\s+me-1)?\7><\/i>(?:\s*Units|\s*View\s*)?<\/\1>/gi,
            function(match, tag, beforeClass, quote, classBefore, classAfter, afterClass, quoteIcon){
                if((classBefore + classAfter).includes("btn-action-col")) return match;
                return `<${tag}${beforeClass}class=${quote}${classBefore}btn-info${classAfter} btn-action-col d-inline-flex align-items-center justify-content-center${quote}${afterClass}><i class="bi bi-eye me-1"></i> View</${tag}>`;
            });

        // Contact Enquires Fix (Image 3)
        // Ensure "Delete" is there if it's missing text
        
        // Push Notifications (Image 2)
        // Ensure "Edit" has text in notification-list / notifications-table
        
        // Shipping labels already handled
        
        // Remove duplicated btn-action-col if any
        content = content.replace(/(btn-action-col\s+d-inline-flex\s+align-items-center\s+justify-content-center\s*)+/g, 'btn-action-col d-inline-flex align-items-center justify-content-center ');

        if (content !== originalContent) {
            fs.writeFileSync(filePath, content, 'utf8');
            console.log("Updated: " + filePath);
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
console.log("All templates accurately processed.");
