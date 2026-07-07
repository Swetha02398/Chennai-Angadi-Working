const fs = require('fs');
const path = require('path');

function processFile(filePath) {
    try {
        let content = fs.readFileSync(filePath, 'utf8');
        let originalContent = content;
        
        // Match ANY button/a inside a <td> with icon
        // For Edit:
        content = content.replace(/<(a|button)([^>]*?)class=(["'])([^"']*?)(\bbtn\b)([^"']*?)\2([^>]*?)>\s*<i\s+class=(["'])bi\s+bi-pencil(?:-square)?(?:\s+me-1)?\8><\/i>\s*(?:Edit\s*)?<\/\1>/gi,
            '<$1$2class=$3$4$5$6 btn-action-col d-inline-flex align-items-center justify-content-center$3$7><i class="bi bi-pencil-square me-1"></i> Edit</$1>');
            
        // For Delete:
        content = content.replace(/<(a|button)([^>]*?)class=(["'])([^"']*?)(\bbtn\b)([^"']*?)\3([^>]*?)>\s*<i\s+class=(["'])bi\s+bi-trash(?:\s+me-1)?\8><\/i>\s*(?:Delete\s*)?<\/\1>/gi,
            '<$1$2class=$3$4$5$6 btn-action-col d-inline-flex align-items-center justify-content-center$3$7><i class="bi bi-trash me-1"></i> Delete</$1>');
            
        // For View / Units:
        content = content.replace(/<(a|button)([^>]*?)class=(["'])([^"']*?)(\bbtn\b)([^"']*?)\3([^>]*?)>\s*<i\s+class=(["'])bi\s+(?:bi-speedometer2|bi-eye)(?:\s+me-1)?\8><\/i>\s*(?:Units|View\s*)?<\/\1>/gi,
            '<$1$2class=$3$4$5$6 btn-action-col d-inline-flex align-items-center justify-content-center$3$7><i class="bi bi-eye me-1"></i> View</$1>');

        // Make sure btn-action-col is not duplicated
        let duplicateFix = content.replace(/btn-action-col\s+d-inline-flex\s+align-items-center\s+justify-content-center(\s*btn-action-col\s+d-inline-flex\s+align-items-center\s+justify-content-center)+/g, 'btn-action-col d-inline-flex align-items-center justify-content-center');

        if (duplicateFix !== originalContent) {
            fs.writeFileSync(filePath, duplicateFix, 'utf8');
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
console.log("Universally processed.");
