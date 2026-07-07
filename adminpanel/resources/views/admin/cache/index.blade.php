@extends('layouts.app')
@section('content')
    @include('includes.alert')
<div class="content-main">
    <div class="content-header">
        <div>
            <h2 class="content-title card-title">Smart Cache Management</h2>
        </div>
    </div>

    <div class="row">
        <!-- Cache Status Card -->
        <div class="col-lg-4">
            <div class="card card-body mb-4">
                <article class="icontext">
                    <span class="icon icon-sm rounded-circle bg-primary-light"><i class="text-primary material-icons md-storage"></i></span>
                    <div class="text">
                        <h6 class="mb-1 card-title">Cache Storage</h6>
                        <span>Driver: <b>{{ strtoupper($status['key']) }}</b></span>
                        <br>
                        <span>Size: <b>{{ number_format($status['size_in_bytes'] / 1024 / 1024, 2) }} MB</b></span>
                    </div>
                </article>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card card-body mb-4">
                <article class="icontext">
                    <span class="icon icon-sm rounded-circle bg-success-light"><i class="text-success material-icons md-history"></i></span>
                    <div class="text">
                        <h6 class="mb-1 card-title">Last Cleared</h6>
                        <span>{{ $status['last_cleared_at'] }}</span>
                    </div>
                </article>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card card-body mb-4">
                <article class="icontext">
                    <span class="icon icon-sm rounded-circle bg-warning-light"><i class="text-warning material-icons md-schedule"></i></span>
                    <div class="text">
                        <h6 class="mb-1 card-title">Auto-Clear</h6>
                        <span>Status: <b>{{ $status['auto_clear_daily'] ? 'Enabled' : 'Disabled' }}</b></span>
                        <br>
                        <span>Time: <b>{{ $status['auto_clear_cron_time'] }}</b></span>
                    </div>
                </article>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Manual Actions -->
        <div class="col-lg-7">
            <div class="card mb-4">
                <header class="card-header">
                    <h4 class="card-title">Manual Actions</h4>
                </header>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-6 mb-3">
                            <h5>Clear Application Cache</h5>
                            <p class="text-muted small">Instantly flushes all application, view, and config caches.</p>
                            <form action="{{ route('admin.cache.clear') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to clear all cache? This may temporarily slow down the site.')">
                                    <i class="material-icons md-delete_sweep"></i> Clear Cache Now
                                </button>
                            </form>
                        </div>
                        <div class="col-md-6 mb-3 border-start">
                            <h5>Rebuild & Re-index</h5>
                            <p class="text-muted small">Dispatches a background job to warm up the cache for critical modules.</p>
                            <form action="{{ route('admin.cache.rebuild') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary">
                                    <i class="material-icons md-autorenew"></i> Rebuild Cache
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dynamic Settings -->
        <div class="col-lg-5">
            <div class="card mb-4">
                <header class="card-header">
                    <h4 class="card-title">Auto-Clear Settings</h4>
                </header>
                <div class="card-body">
                    <form action="{{ route('admin.cache.update-auto') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label">Auto-Clear Daily</label>
                            <select name="auto_clear_daily" class="form-select">
                                <option value="1" {{ $status['auto_clear_daily'] ? 'selected' : '' }}>Enabled</option>
                                <option value="0" {{ !$status['auto_clear_daily'] ? 'selected' : '' }}>Disabled</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Cron Execution Time (24h format)</label>
                            <input type="time" name="auto_clear_cron_time" class="form-control" value="{{ $status['auto_clear_cron_time'] }}" required>
                            <small class="text-muted">Example: 02:30 for 2:30 AM</small>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Save Settings</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<style>
    .icontext {
        display: flex;
        align-items: center;
    }
    .icontext .icon {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
    }
    .bg-primary-light { background-color: #e3f2fd; }
    .bg-success-light { background-color: #e8f5e9; }
    .bg-warning-light { background-color: #fff3e0; }
    .material-icons { font-size: 24px; vertical-align: middle; }
</style>
@endpush
