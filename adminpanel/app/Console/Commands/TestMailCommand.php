<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class TestMailCommand extends Command
{
    protected $signature = 'mail:test {email? : The email address to send test mail to}';
    protected $description = 'Send a test email to verify SMTP configuration';

    public function handle()
    {
        $email = $this->argument('email') ?? config('mail.from.address');

        $this->info("=== MAIL CONFIGURATION ===");
        $this->info("MAIL_MAILER:       " . config('mail.default'));
        $this->info("MAIL_HOST:         " . config('mail.mailers.smtp.host'));
        $this->info("MAIL_PORT:         " . config('mail.mailers.smtp.port'));
        $this->info("MAIL_ENCRYPTION:   " . config('mail.mailers.smtp.encryption'));
        $this->info("MAIL_USERNAME:     " . config('mail.mailers.smtp.username'));
        $this->info("MAIL_PASSWORD:     " . (config('mail.mailers.smtp.password') ? '***SET***' : 'NOT SET'));
        $this->info("MAIL_FROM_ADDRESS: " . config('mail.from.address'));
        $this->info("MAIL_FROM_NAME:    " . config('mail.from.name'));
        $this->info("========================");
        $this->info("");
        $this->info("Sending test email to: {$email}");

        try {
            // Check Symfony transport type
            $transport = Mail::mailer('smtp')->getSymfonyTransport();
            $this->info("Transport class: " . get_class($transport));

            if ($transport instanceof \Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport) {
                $stream = $transport->getStream();
                $this->info("Stream class: " . get_class($stream));
            }

            // Try sending
            Mail::raw('This is a test email from Chennai Angadi Admin Panel. If you received this, your SMTP configuration is working correctly! Time: ' . now()->format('Y-m-d H:i:s'), function ($message) use ($email) {
                $message->to($email)
                    ->subject('Test Email - Chennai Angadi Admin Panel')
                    ->from(config('mail.from.address'), config('mail.from.name'));
            });

            $this->info("✅ Email sent successfully to {$email}!");
            $this->info("Check your inbox (and spam folder) for the test email.");
            Log::info('Test email sent successfully', ['to' => $email]);

        } catch (\Exception $e) {
            $this->error("❌ Email sending FAILED!");
            $this->error("Error: " . $e->getMessage());
            $this->error("");
            $this->error("Full error trace:");
            $this->error($e->getTraceAsString());
            Log::error('Test email failed', ['to' => $email, 'error' => $e->getMessage()]);
        }
    }
}
