<?php

namespace App\Providers;
use App\Models\MainCategory;
use Illuminate\Support\Facades\View;
use Illuminate\Mail\MailManager;
use Symfony\Component\Mailer\Transport\Dsn;
use Symfony\Component\Mailer\Transport\Smtp\EsmtpTransportFactory;
use Illuminate\Pagination\Paginator;

use Illuminate\Support\ServiceProvider;

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
        Paginator::useBootstrap();

        $this->app->extend('mail.manager', function (MailManager $manager) {
            $manager->extend('smtp', function () {
                $config = $this->app['config']->get('mail.mailers.smtp', []);

                $factory = new EsmtpTransportFactory();

                // Construct DSN
                // ssl = implicit TLS (port 465), tls = STARTTLS (port 587)
                $encryption = $config['encryption'] ?? '';
                if ($encryption === 'ssl') {
                    $scheme = 'smtps';
                } elseif ($encryption === 'tls') {
                    $scheme = 'smtp';
                } else {
                    $scheme = 'smtp';
                }

                $dsn = new Dsn(
                    $scheme,
                    $config['host'],
                    $config['username'],
                    $config['password'],
                    $config['port']
                );

                $transport = $factory->create($dsn);

                $transport->getStream()->setStreamOptions([
                    'ssl' => [
                        'allow_self_signed' => true,
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                    ],
                ]);

                return $transport;
            });
            return $manager;
        });

        View::composer('partials.footer', function ($view) {
            $view->with('popularCategories', MainCategory::where('status', 'active')
                ->orderByRaw('CASE WHEN orderby IS NULL THEN 1 ELSE 0 END, orderby ASC, id ASC')
                ->take(4)
                ->get());
        });

        View::composer(['partials.header', 'layouts.app'], function ($view) {
            $view->with('categories', MainCategory::with([
                'subcategories' => function ($query) {
                    $query->where('status', 'active')
                          ->orderByRaw('CASE WHEN orderby IS NULL THEN 1 ELSE 0 END, orderby ASC, id ASC');
                },
                'subcategories.childCategories' => function ($query) {
                    $query->where('status', 'active')
                          ->orderByRaw('CASE WHEN orderby IS NULL THEN 1 ELSE 0 END, orderby ASC, id ASC');
                },
            ])
                ->where('status', 'active')
                ->orderByRaw('CASE WHEN orderby IS NULL THEN 1 ELSE 0 END, orderby ASC, id ASC')
                ->get());
        });
    }
}
