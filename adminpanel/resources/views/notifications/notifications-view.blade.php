@extends('layouts.app')
@section('content')
<section class="content-main">
<div class="container mt-4">

    <h2>Notification Details</h2>

    <div class="card p-4">
        <div class="row mb-3">
<!-- <div class="col-md-6 mb-3">
    <label class="form-label fw-bold">Role</label><br>
    @php
        $role = $notification->role ?? ''; // get saved value
        // Map role to badge color
        $badgeClass = match(strtolower($role)) {
            'customer' => 'bg-primary',
            'admin' => 'bg-warning text-dark',
            default => 'bg-secondary'
        };
    @endphp

    @if($role)
        <span class="badge {{ $badgeClass }}">{{ ucfirst($role) }}</span>
    @endif
</div> -->

            <div class="col-md-6">
                <label class="form-label fw-bold">Type</label>
                <input type="text" class="form-control" value="{{ ucfirst($notification->type) }}" disabled>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-bold">Title</label>
                <input type="text" class="form-control" value="{{ $notification->title }}" disabled>
            </div>

            <div class="col-md-12">
                <label class="form-label fw-bold">Message</label>
                <textarea class="form-control" rows="4" disabled>{{ $notification->message }}</textarea>
            </div>

            <div class="col-md-12">
                <label class="form-label fw-bold">Sent To Users</label>
                <div class="form-control p-2" style="height:auto; min-height: 50px;">
                  @php
    $recipient = $notification->recipients->first();
    
    // If DB stored JSON string → decode it
    $users = $recipient && is_string($recipient->users)
        ? json_decode($recipient->users, true)
        : ($recipient->users ?? []);
    
    // Ensure $users is always an array
    if (!is_array($users)) {
        $users = [];
    }
@endphp

@forelse($users as $user)
    <div>
        {{ $user['name'] ?? 'Unknown' }} ({{ $user['email'] ?? 'N/A' }})
    </div>
@empty
    <div>No users found</div>
@endforelse

                </div>
            </div>

        </div>

        <div class="mt-3">
            @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('notifications-edit'))
            <a href="{{ route('notifications.edit', $notification->id) }}" class="btn btn-primary"><i class="bi bi-pencil-square me-1"></i> Edit</a>
            @endif
            <a href="{{ route('notifications.table') }}" class="btn btn-secondary"><i class="bi bi-arrow-left-circle me-1"></i> Back</a>
        </div>
    </div>

</div>
</section>
@endsection
