@extends('layouts.app')
@section('content')
@include('includes.alert')

<section class="content-main">
    <div class="content-header">
        <div>
            <h2 class="content-title card-title">Roles Management</h2>
        </div>
        <div>
            @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('roles-create'))
            <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">
                <i class="material-icons md-plus"></i> Create New Role
            </a>
            @endif
        </div>
    </div>

    <div class="card mb-4">
      <header class="card-header">
        <form method="GET" action="{{ route('admin.roles.table') }}" class="w-100">
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
                <a href="{{ route('admin.roles.table') }}" class="btn btn-secondary w-100">Clear</a>
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
                            <th>Role Name</th>
                            <th>Description</th>
                            <th>Permissions</th>
                            <th>Users</th>
                            <th>Created</th>
                            <th>Status</th>
                            <th class="text-start">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($roles as $role)
                        <tr>
                            <td>{{ ($roles->currentPage() - 1) * $roles->perPage() + $loop->iteration }}</td>
                            <td>
                                <span class="badge bg-primary">{{ $role->name }}</span>
                            </td>
                            <td>{{ $role->description ?? '-' }}</td>
                            <td>
                                <span class="badge bg-info">{{ $role->permissions_count }} permissions</span>
                            </td>
                            <td>
                                <span class="badge bg-secondary">{{ $role->users_count }} users</span>
                            </td>
                            <td>{{ $role->created_at->format('d M Y') }}</td>
                            <td>
                                @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('roles-edit'))
                                <form action="{{ route('admin.roles.toggle', $role->id) }}" method="POST" style="display:inline-block;"
                                    onsubmit="return confirm('Are you sure you want to change the status of this role?');">
                                    @csrf
                                    @method('PATCH')
                                    @if($role->status == 1)
                                        <button type="submit" class="badge rounded-pill bg-success">Active</button>
                                    @else
                                        <button type="submit" class="badge rounded-pill bg-danger">Inactive</button>
                                    @endif
                                </form>
                                @else
                                    @if($role->status == 1)
                                        <span class="badge rounded-pill bg-success">Active</span>
                                    @else
                                        <span class="badge rounded-pill bg-danger">Inactive</span>
                                    @endif
                                @endif
                            </td>
                            <td class="text-start">
                                @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('roles-edit'))
                                <a href="{{ route('admin.roles.edit', $role->id) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                @endif
                                @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('roles-delete'))
                                <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Are you sure you want to delete this role?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger btn-action-col d-inline-flex align-items-center justify-content-center "><i class="bi bi-trash me-1"></i> Delete</button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <p class="text-muted mb-0">No roles created yet.</p>
                                <a href="{{ route('admin.roles.create') }}" class="btn btn-sm btn-primary mt-2">Create First Role</a>
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
                @if ($roles->onFirstPage())
                    <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $roles->appends(request()->query())->previousPageUrl() }}">&laquo;</a></li>
                @endif

                @foreach ($roles->getUrlRange(1, $roles->lastPage()) as $page => $url)
                    @if ($page == $roles->currentPage())
                        <li class="page-item active"><a class="page-link" href="#">{{ str_pad($page, 2, '0', STR_PAD_LEFT) }}</a></li>
                    @else
                        @if ($page == 1 || $page == $roles->lastPage() || abs($page - $roles->currentPage()) <= 1)
                            <li class="page-item"><a class="page-link" href="{{ $url }}{{ strpos($url, '?') ? '&' : '?' }}{{ http_build_query(request()->query()) }}">{{ str_pad($page, 2, '0', STR_PAD_LEFT) }}</a></li>
                        @elseif (abs($page - $roles->currentPage()) == 2)
                            <li class="page-item disabled"><span class="page-link dot">...</span></li>
                        @endif
                    @endif
                @endforeach

                @if ($roles->hasMorePages())
                    <li class="page-item"><a class="page-link" href="{{ $roles->appends(request()->query())->nextPageUrl() }}">&raquo;</a></li>
                @else
                    <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
                @endif
            </ul>
        </nav>
    </div>

    {{-- Admin Users Section --}}
    <!-- <div class="content-header">
        <div>
            <h2 class="content-title card-title">Admin Users</h2>
            <p>View and manage admin user roles</p>
        </div>
        <div>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary">
                <i class="material-icons md-people"></i> View All Admin Users
            </a>
        </div>
    </div> -->
</section>

@endsection
