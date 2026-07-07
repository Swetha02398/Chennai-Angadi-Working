@extends('layouts.app')

@section('content')
@include('includes.alert')

<section class="content-main">

    <div class="content-header d-flex justify-content-between align-items-center">
        <div>
            <h2 class="content-title card-title">GST Settings</h2>
            <p>Manage GST configuration for the store.</p>
        </div>
        <div>
            @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('gsthsn-create'))
            <a href="{{ route('gsthsn.create') }}" class="btn btn-primary btn-sm rounded">+ Add GST</a>
            @endif
        </div>
    </div>
<div class="card mb-4">
        <header class="card-header">
            <form method="GET" action="{{ route('gsthsn.table') }}" class="w-100">
                <div class="row gx-3 align-items-center">
                    <div class="col-md-4 col-12">
                        <input type="text" name="search" placeholder="Search..." class="form-control" value="{{ $search }}" />
                    </div>
                    <div class="col-md-2 col-6">
                        <select name="status" class="form-select" onchange="this.form.submit()">
                            <option value="">Status - All</option>
                            <option value="1" {{ $status == '1' ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ $status == '0' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                    <div class="col-md-2 col-6">
                        <button type="submit" class="btn btn-primary w-100">Search</button>
                    </div>
                    @if($search || $status)
                    <div class="col-md-2 col-6">
                        <a href="{{ route('gsthsn.table') }}" class="btn btn-secondary w-100">Clear</a>
                    </div>
                    @endif
                </div>
            </form>
        </header>

        <div class="card-body">
            <div class="table-responsive">
    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>No.</th>
                <th>Default Tax Rate (%)</th>
                <th>Auto GST</th>
                <th>Rounding</th>
                <th>Notes</th>
                <th>Updated</th>
                
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            @forelse($gst as $item)
              <tr>
                <td>{{ ($gst->currentPage() - 1) * $gst->perPage() + $loop->iteration }}</td>
                <td>{{ $item->default_tax_rate }}</td>
                <td>{{ $item->enable_auto_gst ? 'Enabled' : 'Disabled' }}</td>
                <td>{{ ucfirst($item->rounding_method ?? '-') }}</td>
                <td>{{ $item->notes ?? '-' }}</td>
                <td>{{ $item->updated_at->format('d-m-Y') }}</td>

                    <td>
                        @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('gsthsn-edit'))
                        <a href="{{ route('gsthsn.edit', $item->id) }}" 
                           class="btn btn-sm btn-warning">
                           <i class="bi bi-pencil-square me-1"></i> 
                        </a>
                        @endif

                        @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('gsthsn-delete'))
                        <form action="{{ route('gsthsn.delete', $item->id) }}" 
                              method="POST" 
                              style="display:inline-block;"
                              onsubmit="return confirm('Are you sure you want to delete this GST setting?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger btn-action-col d-inline-flex align-items-center justify-content-center "><i class="bi bi-trash me-1"></i> Delete</button>
                        </form>
                        @endif
                    </td>
                </tr>

            @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">No GST settings found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
</div>
</div>
    <div class="pagination-area mt-30 mb-50">
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-start">
                {{-- Previous Page Link --}}
                @if ($gst->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link">&laquo;</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $gst->appends(request()->query())->previousPageUrl() }}" aria-label="Previous">
                            &laquo;
                        </a>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($gst->getUrlRange(1, $gst->lastPage()) as $page => $url)
                    @if ($page == $gst->currentPage())
                        <li class="page-item active">
                            <a class="page-link" href="#">{{ str_pad($page, 2, '0', STR_PAD_LEFT) }}</a>
                        </li>
                    @else
                        @if ($page == 1 || $page == $gst->lastPage() || abs($page - $gst->currentPage()) <= 1)
                            <li class="page-item">
                                <a class="page-link" href="{{ $url }}{{ strpos($url, '?') ? '&' : '?' }}{{ http_build_query(request()->query()) }}">{{ str_pad($page, 2, '0', STR_PAD_LEFT) }}</a>
                            </li>
                        @elseif (abs($page - $gst->currentPage()) == 2)
                            <li class="page-item disabled">
                                <span class="page-link dot">...</span>
                            </li>
                        @endif
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($gst->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $gst->appends(request()->query())->nextPageUrl() }}" aria-label="Next">
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
