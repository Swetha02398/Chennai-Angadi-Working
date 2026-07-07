<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CacheClearCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:smart-clear {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Smart Cache Clear with dynamic settings';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $autoClear = \App\Models\Setting::get('auto_clear_daily', '0');

        if ($autoClear === '1' || $this->option('force')) {
            \Illuminate\Support\Facades\Artisan::call('cache:clear');
            \Illuminate\Support\Facades\Artisan::call('view:clear');
            \Illuminate\Support\Facades\Artisan::call('config:clear');
            \Illuminate\Support\Facades\Artisan::call('route:clear');

            \App\Models\Setting::set('last_cleared_at', now()->toDateTimeString());

            $this->info('Cache cleared successfully!');
            \Illuminate\Support\Facades\Log::info('Smart Cache Clear executed at ' . now());
        } else {
            $this->info('Auto clear is disabled. Use --force to clear manually.');
        }

        return Command::SUCCESS;
    }
}
