<?php
require 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

echo "=== SMTP CONNECTIVITY TEST ===\n";
echo "Host: " . $_ENV['MAIL_HOST'] . "\n";
echo "Port: " . $_ENV['MAIL_PORT'] . "\n";
echo "User: " . $_ENV['MAIL_USERNAME'] . "\n\n";

// Test 1: DNS
$ip = gethostbyname($_ENV['MAIL_HOST']);
echo "1. DNS Resolution: " . $ip . "\n";

// Test 2: Port 587
$conn = @fsockopen($_ENV['MAIL_HOST'], 587, $errno, $errstr, 15);
if ($conn) {
    $banner = fgets($conn, 512);
    echo "2. Port 587: OPEN - Banner: " . trim($banner) . "\n";
    fputs($conn, "EHLO test\r\n");
    $ehlo = '';
    while ($line = fgets($conn, 512)) {
        $ehlo .= $line;
        if (substr($line, 3, 1) == ' ') break;
    }
    echo "   EHLO Response: " . trim($ehlo) . "\n";
    fclose($conn);
} else {
    echo "2. Port 587: BLOCKED - Error: $errstr ($errno)\n";
}

// Test 3: Port 465
$conn2 = @fsockopen('ssl://' . $_ENV['MAIL_HOST'], 465, $errno2, $errstr2, 15);
echo "3. Port 465 SSL: " . ($conn2 ? "OPEN" : "BLOCKED - $errstr2") . "\n";
if ($conn2) {
    $banner2 = fgets($conn2, 512);
    echo "   Banner: " . trim($banner2) . "\n";
    fclose($conn2);
}

// Test 4: Auth test via Symfony Mailer using PORT 465 (since 587 is blocked)
echo "\n=== AUTHENTICATION TEST (Port 465 SSL) ===\n";
try {
    $dsn = "smtps://" . urlencode($_ENV['MAIL_USERNAME']) . ":" . urlencode($_ENV['MAIL_PASSWORD']) . "@" . $_ENV['MAIL_HOST'] . ":465";
    echo "DSN: smtps://***:***@" . $_ENV['MAIL_HOST'] . ":465\n";
    $transport = Symfony\Component\Mailer\Transport::fromDsn($dsn);
    $mailer = new Symfony\Component\Mailer\Mailer($transport);
    $email = (new Symfony\Component\Mime\Email())
        ->from($_ENV['MAIL_FROM_ADDRESS'])
        ->to('swethamary22022005@gmail.com')
        ->subject('SMTP Auth Debug Test ' . date('Y-m-d H:i:s'))
        ->text('Test email sent at ' . date('Y-m-d H:i:s') . ' - if you receive this, SMTP is working via port 465 SSL.');
    $mailer->send($email);
    echo "AUTH + SEND: SUCCESS - Email accepted by SMTP server\n";
    echo "Check: swethamary22022005@gmail.com inbox AND spam folder\n";
} catch (Exception $e) {
    echo "AUTH/SEND FAILED:\n";
    echo "Error: " . $e->getMessage() . "\n";
    echo "Class: " . get_class($e) . "\n";
}

// Test 5: Also test with port 587 to confirm it fails
echo "\n=== AUTHENTICATION TEST (Port 587 TLS - current config) ===\n";
try {
    $dsn587 = "smtp://" . urlencode($_ENV['MAIL_USERNAME']) . ":" . urlencode($_ENV['MAIL_PASSWORD']) . "@" . $_ENV['MAIL_HOST'] . ":587";
    $transport587 = Symfony\Component\Mailer\Transport::fromDsn($dsn587);
    $mailer587 = new Symfony\Component\Mailer\Mailer($transport587);
    $email587 = (new Symfony\Component\Mime\Email())
        ->from($_ENV['MAIL_FROM_ADDRESS'])
        ->to('swethamary22022005@gmail.com')
        ->subject('SMTP Test Port 587 ' . date('Y-m-d H:i:s'))
        ->text('Test email sent at ' . date('Y-m-d H:i:s') . ' - port 587 test.');
    $mailer587->send($email587);
    echo "AUTH + SEND: SUCCESS on port 587\n";
} catch (Exception $e) {
    echo "FAILED on port 587 (confirms our diagnosis):\n";
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\n=== DONE ===\n";
