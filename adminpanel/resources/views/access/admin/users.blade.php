@extends('layouts.app')
@section('content')
@include('includes.alert')

<section class="content-main">
    <div class="content-header">
        <div>
            <h2 class="content-title card-title">Admin Users</h2>
        </div>
        <div>
            @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('users-create'))
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Add User
            </a>
            @endif
        </div>
    </div>

    <div class="card mb-4">
        <header class="card-header">
        <form method="GET" action="{{ route('admin.users.table') }}" class="w-100">
          <div class="row gx-3 align-items-center">
            <div class="col-md-4 col-12">
              <input type="text" name="search" placeholder="Search..." class="form-control" value="{{ $search ?? '' }}" />
            </div>
            <div class="col-md-2 col-6">
              <select name="status" class="form-select">
                <option value="">Status - All</option>
                <option value="1" {{ (isset($status) && $status == '1') ? 'selected' : '' }}>Active</option>
                <option value="0" {{ (isset($status) && $status == '0') ? 'selected' : '' }}>Inactive</option>
              </select>
            </div>
            <div class="col-md-2 col-6">
              <button type="submit" class="btn btn-primary w-100">Search</button>
            </div>
            @if((isset($search) && $search) || (isset($status) && $status !== ''))
              <div class="col-md-2 col-6">
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary w-100">Clear</a>
              </div>
            @endif
          </div>
        </form>
      </header>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>User</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role Type</th>
                            <th>Assigned Role</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td>{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img class="img-xs rounded-circle me-2"
                                        src="{{ $user->profile_image ? asset('assets/uploads/admin_profiles/' . $user->profile_image) : asset('assets/imgs/profile.svg') }}"
                                        alt="{{ $user->name }}">
                                    <span>{{ $user->name }}</span>
                                </div>
                            </td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if($user->role_type === 'superadmin')
                                    <span class="badge bg-danger">Super Admin</span>
                                @else
                                    <span class="badge bg-secondary">Admin</span>
                                @endif
                            </td>
                            <td>
                                @if($user->role)
                                    <span class="badge bg-primary">{{ $user->role->name }}</span>
                                @else
                                    <span class="text-muted">No role assigned</span>
                                @endif
                            </td>
                            <td>
                                @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('users-edit'))
                                <form action="{{ route('admin.users.toggle', $user->id) }}" method="POST" style="display:inline-block;"
                                    onsubmit="return confirm('Are you sure you want to change the status of this user?');">
                                    @csrf
                                    @method('PATCH')
                                    @if($user->status == 1)
                                        <button type="submit" class="badge rounded-pill bg-success">Active</button>
                                    @else
                                        <button type="submit" class="badge rounded-pill bg-danger">Inactive</button>
                                    @endif
                                </form>
                                @else
                                    @if($user->status == 1)
                                        <span class="badge rounded-pill bg-success">Active</span>
                                    @else
                                        <span class="badge rounded-pill bg-danger">Inactive</span>
                                    @endif
                                @endif
                            </td>
                            <td class="text-end">
                                @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('users-edit'))
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                @endif
                                @if($user->id !== auth()->id() && $user->role_type !== 'superadmin')
                                @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('users-delete'))
                                <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Are you sure you want to delete this admin user?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger btn-action-col d-inline-flex align-items-center justify-content-center "><i class="bi bi-trash me-1"></i> Delete</button>
                                </form>
                                @endif
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <p class="text-muted mb-0">No admin users found.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="pagination-area mt-30 mb-50">
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-start">
                @if ($users->onFirstPage())
                    <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $users->appends(request()->query())->previousPageUrl() }}">&laquo;</a></li>
                @endif

                @foreach ($users->appends(request()->query())->getUrlRange(1, $users->lastPage()) as $page => $url)
                    @if ($page == $users->currentPage())
                        <li class="page-item active"><a class="page-link" href="#">{{ str_pad($page, 2, '0', STR_PAD_LEFT) }}</a></li>
                    @else
                        @if ($page == 1 || $page == $users->lastPage() || abs($page - $users->currentPage()) <= 1)
                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ str_pad($page, 2, '0', STR_PAD_LEFT) }}</a></li>
                        @elseif (abs($page - $users->currentPage()) == 2)
                            <li class="page-item disabled"><span class="page-link dot">...</span></li>
                        @endif
                    @endif
                @endforeach

                @if ($users->hasMorePages())
                    <li class="page-item"><a class="page-link" href="{{ $users->appends(request()->query())->nextPageUrl() }}">&raquo;</a></li>
                @else
                    <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
                @endif
            </ul>
        </nav>
    </div>
</section>

@endsection
