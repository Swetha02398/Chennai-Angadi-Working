<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Jobs\RebuildCacheJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

class SmartCacheApiController extends Controller
{
    public function status()
    {
        return response()->json([
            'status' => 'success',
            'data' => [
                'key' => config('cache.default'),
                'size_in_bytes' => $this->getCacheSize(),
                'last_cleared_at' => Setting::get('last_cleared_at', 'Never'),
                'auto_clear_daily' => Setting::get('auto_clear_daily', '0') === '1',
                'auto_clear_cron_time' => Setting::get('auto_clear_cron_time', '00:00'),
            ]
        ]);
    }

    public function clear(Request $request)
    {
        Artisan::call('cache:smart-clear', ['--force' => true]);
        return response()->json([
            'status' => 'success',
            'message' => 'Cache cleared successfully!'
        ]);
    }

    public function rebuild(Request $request)
    {
        RebuildCacheJob::dispatch();
        return response()->json([
            'status' => 'success',
            'message' => 'Cache rebuild job dispatched!'
        ]);
    }

    public function getAutoClear()
    {
        return response()->json([
            'status' => 'success',
            'data' => [
                'auto_clear_daily' => Setting::get('auto_clear_daily', '0') === '1',
                'auto_clear_cron_time' => Setting::get('auto_clear_cron_time', '00:00'),
            ]
        ]);
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

        return response()->json([
            'status' => 'success',
            'message' => 'Auto-clear settings updated!'
        ]);
    }

    private function getCacheSize()
    {
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
