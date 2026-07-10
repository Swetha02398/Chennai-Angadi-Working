<?php
$directory = 'c:/xampp/htdocs/chennais/adminpanel/resources/views';
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));
$regex = new RegexIterator($iterator, '/^.+\.blade\.php$/i', RecursiveRegexIterator::GET_MATCH);

foreach ($regex as $file) {
    if (strpos($file[0], 'temp_restore') !== false) continue;
    $filePath = $file[0];
    $content = file_get_contents($filePath);
    
    $selectPattern = '/<select\s+[^>]*name=[\"\'](?:status|type|role|is_read|email_type|read)[\"\'][^>]*>/i';
    preg_match_all($selectPattern, $content, $matches);
    
    foreach ($matches[0] as $match) {
        if (stripos($match, 'onchange') === false && stripos($content, '<form') !== false) {
            // Echo missing onchange outside of explicit GET forms
            echo "Potential missing onchange in: $filePath | $match \n";
        }
    }
}
