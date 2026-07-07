<?php
echo "=== PORT CONNECTIVITY TESTS ===\n\n";

// Test Port 587
$c = @fsockopen('mail.doxainfotech.com', 587, $e, $s, 10);
echo "Port 587 (TLS): " . ($c ? "OPEN" : "BLOCKED: $s ($e)") . "\n";
if ($c) {
    $banner = fgets($c, 512);
    echo "  Banner: " . trim($banner) . "\n";
    fclose($c);
}

// Test Port 465
$c2 = @fsockopen('ssl://mail.doxainfotech.com', 465, $e2, $s2, 10);
echo "Port 465 (SSL): " . ($c2 ? "OPEN" : "BLOCKED: $s2 ($e2)") . "\n";
if ($c2) {
    $banner2 = fgets($c2, 512);
    echo "  Banner: " . trim($banner2) . "\n";
    fclose($c2);
}

echo "\nDone.\n";
