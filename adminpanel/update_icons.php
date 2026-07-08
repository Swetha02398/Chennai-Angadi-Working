<?php
$dir = new RecursiveDirectoryIterator('c:\xampp\htdocs\chennais\adminpanel\resources\views');
$ite = new RecursiveIteratorIterator($dir);
$files = new RegexIterator($ite, '/.*\.blade\.php$/', RegexIterator::GET_MATCH);

$count = 0;
foreach($files as $file) {
    $path = $file[0];
    $content = file_get_contents($path);
    $orig = $content;

    // Fix Edit
    // Finds <i class="...bi-pencil-square..."> [Edit inside] </i> or no text
    // Replaces with <i class="..."></i> Edit
    $content = preg_replace('/<i\s+class="([^"]*bi-pencil-square[^"]*)"[^>]*>(?:\s*Edit\s*)?<\/i>(?!\s*Edit)/i', '<i class="$1"></i> Edit', $content);
    $content = preg_replace("/<i\s+class='([^']*bi-pencil-square[^']*)'[^>]*>(?:\s*Edit\s*)?<\/i>(?!\s*Edit)/i", "<i class='$1'></i> Edit", $content);

    // Fix Delete
    $content = preg_replace('/<i\s+class="([^"]*bi-trash[^"]*)"[^>]*>(?:\s*Delete\s*)?<\/i>(?!\s*Delete)/i', '<i class="$1"></i> Delete', $content);
    $content = preg_replace("/<i\s+class='([^']*bi-trash[^']*)'[^>]*>(?:\s*Delete\s*)?<\/i>(?!\s*Delete)/i", "<i class='$1'></i> Delete", $content);

    // Fix View
    $content = preg_replace('/<i\s+class="([^"]*bi-eye(?:-fill)?[^"]*)"[^>]*>(?:\s*View\s*)?<\/i>(?!\s*View)/i', '<i class="$1"></i> View', $content);
    $content = preg_replace("/<i\s+class='([^']*bi-eye(?:-fill)?[^']*)'[^>]*>(?:\s*View\s*)?<\/i>(?!\s*View)/i", "<i class='$1'></i> View", $content);

    if ($content !== $orig) {
        file_put_contents($path, $content);
        $count++;
        echo "Updated $path\n";
    }
}
echo "Total $count files updated.\n";
?>
