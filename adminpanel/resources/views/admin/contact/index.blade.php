@extends('layouts.app')
@section('content')
    @include('includes.alert')
<section class="content-main">
    <div class="container mt-4">
        <div class="content-header">
            <div>
                <h2 class="content-title card-title">Contact Enquiries</h2>
            </div>
        </div>
     <div class="card mb-4">
            <header class="card-header">
                <form action="{{ route('admin.contact.index') }}" method="GET" class="row g-3 align-items-center">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control" placeholder="Search by Name, Email or Phone..." value="{{ $search }}">
                    </div>
                    <div class="col-md-3">
                        <select name="status" class="form-select" onchange="this.form.submit()">
                            <option value="">All Status</option>
                            <option value="unread" {{ $status == 'unread' ? 'selected' : '' }}>Unread</option>
                            <option value="read" {{ $status == 'read' ? 'selected' : '' }}>Read</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary flex-fill">
<i class="bi bi-search me-1"></i> Search</button>
                            <a href="{{ route('admin.contact.index') }}" class="btn btn-secondary flex-fill">
<i class="bi bi-eraser me-1"></i> Clear</a>
                        </div>
                    </div>
                </form>
            </header>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="contactTable">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th class="text-start">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($enquiries as $enquiry)
                            <tr>
                                <td>{{ ($enquiries->currentPage() - 1) * $enquiries->perPage() + $loop->iteration }}</td>
                                <td><b>{{ $enquiry->name }}</b></td>
                                <td>{{ $enquiry->email }}</td>
                                <td>{{ $enquiry->created_at->format('d-m-Y') }}</td>
                                <td>
                                    @php
                                        $statusClass = match ($enquiry->status) {
                                            'unread', 'pending' => 'bg-warning text-dark',
                                            'read' => 'bg-success text-white',
                                            default => 'bg-secondary text-white'
                                        };
                                        $statusLabel = ($enquiry->status === 'unread' || $enquiry->status === 'pending') ? 'Unread' : ucfirst($enquiry->status);
                                    @endphp
                                    <span class="badge {{ $statusClass }}">
                                        @php
                                            $icon = ($enquiry->status === 'unread' || $enquiry->status === 'pending') ? '<i class="bi bi-envelope me-1"></i>' : '<i class="bi bi-envelope-open me-1"></i>';
                                        @endphp
                                        {!! $icon !!} {{ $statusLabel }}
                                    </span>
                                </td>
                                <td class="text-start">
                                    <a href="{{ route('admin.contact.show', $enquiry->id) }}" class="btn btn-sm"
                                        style="background-color: #0099ffff; color: #000; padding: 3px 7px; font-size: 11px;"
                                        title="View Enquiry">
                                        <i class="bi bi-eye-fill"></i> View
                                    </a>
                                    <form action="{{ route('admin.contact.destroy', $enquiry->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger px-2" 
                                            style="padding: 3px 7px; font-size: 11px;"
                                            onclick="return confirm('Are you sure you want to delete this enquiry?')">
                                            <i class="bi bi-trash-fill"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="material-icons md-email" style="font-size: 48px;"></i>
                                        <p class="mt-2">No enquiries found</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- PAGINATION --}}
        <div class="pagination-area mt-30 mb-50">
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-start">
                    {{-- Previous Page Link --}}
                    @if ($enquiries->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link">&laquo;</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $enquiries->appends(request()->query())->previousPageUrl() }}" aria-label="Previous">
                                &laquo;
                            </a>
                        </li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($enquiries->appends(request()->query())->getUrlRange(1, $enquiries->lastPage()) as $page => $url)
                        @if ($page == $enquiries->currentPage())
                            <li class="page-item active">
                                <a class="page-link" href="#">{{ str_pad($page, 2, '0', STR_PAD_LEFT) }}</a>
                            </li>
                        @else
                            @if ($page == 1 || $page == $enquiries->lastPage() || abs($page - $enquiries->currentPage()) <= 1)
                                <li class="page-item">
                                    <a class="page-link" href="{{ $url }}">{{ str_pad($page, 2, '0', STR_PAD_LEFT) }}</a>
                                </li>
                            @elseif (abs($page - $enquiries->currentPage()) == 2)
                                <li class="page-item disabled">
                                    <span class="page-link dot">...</span>
                                </li>
                            @endif
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($enquiries->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $enquiries->appends(request()->query())->nextPageUrl() }}" aria-label="Next">
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
    </div>
</section>
@endsection

@push('scripts')
{{-- Bootstrap icons are already in layout --}}
@endpush
