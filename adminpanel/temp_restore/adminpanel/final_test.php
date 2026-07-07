<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;

$target = 'swethamary22022005@gmail.com';
echo "Starting Final Target Mail Test to $target...\n";

try {
    Mail::raw("Direct Test Mail from your Admin Panel. Please check if you receive this at $target", function ($message) use ($target) {
        $message->to($target)->subject("Admin Panel SMTP Test - " . now());
    });
    echo "SUCCESS: Mail dispatched to SMTP server for $target.\n";
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
