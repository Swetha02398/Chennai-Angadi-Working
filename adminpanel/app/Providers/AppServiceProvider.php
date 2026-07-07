<?php

namespace App\Providers;
use App\Models\ProductVariant;

use Illuminate\Support\ServiceProvider;
use Illuminate\Mail\Events\MessageSending;
use Illuminate\Support\Facades\Event;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Low stock count for sidebar
        view()->composer('*', function ($view) {
            $lowStockCount = ProductVariant::where('stock', '<', 10)->count();
            $view->with('lowStockCount', $lowStockCount);
        });

        // ===================================================================
        // FIX: Disable SSL peer verification for Symfony Mailer (Laravel 9+)
        // The config/mail.php 'stream.ssl' options only work with SwiftMailer
        // (Laravel 8 and below). For Laravel 9+ we must override the transport
        // directly. This is required for XAMPP / local environments.
        // ===================================================================
        $this->app->afterResolving('mail.manager', function ($mailManager) {
            try {
                $transport = $mailManager->mailer('smtp')->getSymfonyTransport();

                if ($transport instanceof \Symfony\Component\Mailer\Transport\Smtp\EsmtpTransport) {
                    $stream = $transport->getStream();
                    if (method_exists($stream, 'setStreamOptions')) {
                        $stream->setStreamOptions([
                            'ssl' => [
                                'allow_self_signed' => true,
                                'verify_peer'       => false,
                                'verify_peer_name'  => false,
                            ],
                        ]);
                    }
                }
            } catch (\Exception $e) {
                \Log::warning('Mail SSL override failed: ' . $e->getMessage());
            }
        });
    }
}
