<?php
require "vendor/autoload.php";
$app = require_once "bootstrap/app.php";
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$type = DB::select("SHOW COLUMNS FROM orders LIKE 'status'")[0]->Type;
echo "TYPE: " . $type . "\n";
if (strpos($type, "enum") !== false && strpos($type, "hold") === false) {
    echo "Need to alter ENUM\n";
    DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending', 'hold', 'processing', 'shipped', 'delivered', 'cancelled', 'failed', 'returned', 'refunded', 'on-hold', 'confirmed', 'packed', 'cod') DEFAULT 'hold'");
    echo "ALTERED\n";
} else {
    echo "NO ALTER NEEDED (already contains hold or is varchar)\n";
}

