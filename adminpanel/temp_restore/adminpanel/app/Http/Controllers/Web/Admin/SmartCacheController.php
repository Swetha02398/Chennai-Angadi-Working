<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Jobs\RebuildCacheJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

class SmartCacheController extends Controller
{
    public function index()
    {
        $status = [
            'key' => config('cache.default'),
            'size_in_bytes' => $this->getCacheSize(),
            'last_cleared_at' => Setting::get('last_cleared_at', 'Never'),
            'auto_clear_daily' => Setting::get('auto_clear_daily', '0') === '1',
            'auto_clear_cron_time' => Setting::get('auto_clear_cron_time', '00:00'),
        ];

        return view('admin.cache.index', compact('status'));
    }

    public function clear(Request $request)
    {
        Artisan::call('cache:smart-clear', ['--force' => true]);
        return redirect()->back()->with('success', 'Cache cleared successfully!');
    }

    public function rebuild(Request $request)
    {
        RebuildCacheJob::dispatch();
        return redirect()->back()->with('success', 'Cache rebuild job dispatched!');
    }

    public function updateAutoClear(Request $request)
    {
        $request->validate([
            'auto_clear_daily' => ['required', 'boolean'],
            'auto_clear_cron_time' => ['required', 'regex:/^([01][0-9]|2[0-3])[:.][0-5][0-9]$/'],
        ]);

        $time = str_replace('.', ':', $request->auto_clear_cron_time);

        Setting::set('auto_clear_daily', $request->auto_clear_daily);
        Setting::set('auto_clear_cron_time', $time);

        return redirect()->back()->with('success', 'Auto-clear settings updated!');
    }

    private function getCacheSize()
    {
        // Simple way to get file cache size (assuming file driver is used)
        if (config('cache.default') !== 'file') {
            return 0;
        }

        $path = config('cache.stores.file.path');
        if (!is_dir($path)) {
            return 0;
        }

        $size = 0;
        foreach (new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path)) as $file) {
            $size += $file->getSize();
        }

        return $size;
    }
}
