@extends('layouts.app')
@section('content')
@include('includes.alert')
<section class="content-main">
<div class="container mt-4">
    <div class="content-header">
        <div>
             <h2>Admin Notifications</h2>
        </div>
        <div>
            <a href="{{ route('notifications.table') }}" class="btn btn-primary mb-3">Back to All Notifications</a>
        </div>
  </div>
     <!-- Table -->
       <div class="card mb-4">
        <header class="card-header">
            <form method="GET" action="{{ route('notifications.admin') }}" class="w-100">
                <div class="row gx-3 align-items-center">
                    <div class="col-md-4 col-12">
                        <input type="text" name="search" placeholder="Search..." class="form-control" value="{{ $search }}" />
                    </div>
                    <div class="col-md-2 col-6">
                        <select name="status" class="form-select" onchange="this.form.submit()">
                            <option value="">Status - All</option>
                            <option value="read" {{ $status == 'read' ? 'selected' : '' }}>Read</option>
                            <option value="unread" {{ $status == 'unread' ? 'selected' : '' }}>Unread</option>
                        </select>
                    </div>
                    <div class="col-md-2 col-6">
                        <button type="submit" class="btn btn-primary w-100">Search</button>
                    </div>
                    @if($search || $status)
                    <div class="col-md-2 col-6">
                        <a href="{{ route('notifications.admin') }}" class="btn btn-secondary w-100">Clear</a>
                    </div>
                    @endif
                </div>
            </form>
        </header>

        <div class="card-body">
                    <div class="table-responsive table-centered">
                        <table class="table mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>No.</th>
                                    <th>Title</th>
                                    <th>Message</th>
                                    <th>From Role</th>
                                    <th>To Role</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($notifications->isNotEmpty())
                                    @foreach ($notifications as $item)
                                    <tr>
                                        <td>{{ ($notifications->currentPage() - 1) * $notifications->perPage() + $loop->iteration }}</td>
                                        <td>
                                            <a href="{{ route('notifications.view', $item->id) }}">
                                                {{ $item->title ?? 'N/A' }}
                                            </a>
                                        </td>
                                        <td>{{ Str::limit($item->message ?? '', 40) }}</td>
                                        <td>
                                            <span class="badge bg-primary">{{ ucfirst($item->from_role ?? 'N/A') }}</span>
                                        </td>
                                        <td>
                                            @php
                                                $roles = $item->recipients->pluck('role')->unique();
                                            @endphp
                                            @foreach($roles as $role)
                                                <span class="badge bg-info">{{ ucfirst($role) }}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('notifications-edit'))
                                            <form action="{{ route('notification.toggle', $item->id) }}" method="POST" style="display:inline-block;" 
                                                onsubmit="return confirm('Are you sure you want to change the status of this notification?');">
                                                 @csrf
                                                 @method('PATCH')

                                              @if($item->status === 'read')
                                                <button type="submit" class="badge rounded-pill bg-success">Read</button>
                                               @else
                                                <button type="submit" class="badge rounded-pill bg-warning">Unread</button>
                                               @endif
                                             </form>
                                            @else
                                                @if($item->status === 'read')
                                                    <span class="badge rounded-pill bg-success">Read</span>
                                                @else
                                                    <span class="badge rounded-pill bg-warning">Unread</span>
                                                @endif
                                            @endif
                                        </td>
                                        <td>

                                @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('notifications-edit'))
                                <a href="{{ route('notifications.edit', $item->id) }}" class="btn btn-warning btn-sm">
                                    <i class='bi bi-pencil-square me-1'></i> Edit
                                </a>
                                @endif

                                @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('notifications-delete'))
                                <form action="{{ route('notifications.destroy', $item->id) }}" 
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm btn-action-col d-inline-flex align-items-center justify-content-center "
                                            onclick="return confirm('Are you sure you want to delete this notification?')"><i class="bi bi-trash me-1"></i> Delete</button>
                                </form>
                                @endif
                            </td>

                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7" class="text-center">No Admin Notifications Available</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div> <!-- end table -->
</div>
                                    </div>

  <div class="pagination-area mt-30 mb-50">
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-start">
                {{-- Previous Page Link --}}
                @if ($notifications->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link">&laquo;</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $notifications->appends(request()->query())->previousPageUrl() }}" aria-label="Previous">
                            &laquo;
                        </a>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($notifications->getUrlRange(1, $notifications->lastPage()) as $page => $url)
                    @if ($page == $notifications->currentPage())
                        <li class="page-item active">
                            <a class="page-link" href="#">{{ str_pad($page, 2, '0', STR_PAD_LEFT) }}</a>
                        </li>
                    @else
                        @if ($page == 1 || $page == $notifications->lastPage() || abs($page - $notifications->currentPage()) <= 1)
                            <li class="page-item">
                                <a class="page-link" href="{{ $url }}{{ strpos($url, '?') ? '&' : '?' }}{{ http_build_query(request()->query()) }}">{{ str_pad($page, 2, '0', STR_PAD_LEFT) }}</a>
                            </li>
                        @elseif (abs($page - $notifications->currentPage()) == 2)
                            <li class="page-item disabled">
                                <span class="page-link dot">...</span>
                            </li>
                        @endif
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($notifications->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $notifications->appends(request()->query())->nextPageUrl() }}" aria-label="Next">
                            &raquo;
                        </a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link">&raquo;</span>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
</section>
@endsection
