<?php
$directory = 'c:/xampp/htdocs/chennais/adminpanel/resources/views';
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));
$regex = new RegexIterator($iterator, '/^.+\.blade\.php$/i', RecursiveRegexIterator::GET_MATCH);

foreach ($regex as $file) {
    if (strpos($file[0], 'temp_restore') !== false) continue;
    $filePath = $file[0];
    $content = file_get_contents($filePath);
    $modified = false;
    
    // Find <form method="GET"...> tags
    $pattern = '/(<form[^>]*method=[\"\']GET[\"\'][^>]*>)(.*?)(<\/form>)/is';
    $content = preg_replace_callback($pattern, function($matches) use (&$modified) {
        $formOpen = $matches[1];
        $innerHtml = $matches[2];
        $formClose = $matches[3];
        
        $selectPattern = '/(<select\s+[^>]*name=[\"\'](?:status|type|role|is_read|email_type|read)[\"\'][^>]*)(>)/i';
        $newInnerHtml = preg_replace_callback($selectPattern, function($selMatches) use (&$modified) {
            if (stripos($selMatches[1], 'onchange') === false) {
                $modified = true;
                return $selMatches[1] . ' onchange="this.form.submit()"' . $selMatches[2];
            }
            return $selMatches[0];
        }, $innerHtml);
        
        return $formOpen . $newInnerHtml . $formClose;
    }, $content);
    
    if ($modified) {
        file_put_contents($filePath, $content);
        echo "Updated: $filePath\n";
    }
}
