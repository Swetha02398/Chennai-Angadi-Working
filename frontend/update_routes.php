<?php
$dir = new RecursiveDirectoryIterator('c:/xampp/htdocs/chennais/frontend/resources/views');
$ite = new RecursiveIteratorIterator($dir);
foreach($ite as $val) {
    if(pathinfo($val, PATHINFO_EXTENSION) == 'php') {
        $c = file_get_contents($val);
        $nc = preg_replace('/route\(\'(category\.products|subcategory\.products|childcategory\.products)\'\s*,\s*([^)]+)\)/', 'url(\'/\' . $2)', $c);
        if ($c !== $nc) {
            file_put_contents($val, $nc);
            echo "Updated $val\n";
        }
    }
}
