@extends('layouts.app')

@section('content')
@include('includes.alert')

<section class="content-main">

    {{-- Header --}}
    <div class="content-header d-flex justify-content-between align-items-center mb-3">
        <div>
            <h2 class="content-title card-title">Slider List</h2>
            <p>List of all sliders.</p>
        </div>
        <div>
            @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('slider-create'))
            <a href="{{ route('slider.create') }}" class="btn btn-primary btn-sm rounded">
                 Add New
            </a>
            @endif
        </div>
    </div>

    {{-- Card --}}
    <div class="card mb-4">

        {{-- Filters --}}
        <header class="card-header">
            <form method="GET" action="{{ route('slider.table') }}" class="w-100">
                <div class="row gx-3 align-items-center">
                    <div class="col-md-4 col-12">
                        <input type="text" name="search" id="searchInput" placeholder="Search..." class="form-control" value="{{ $search }}" />
                    </div>
                    <div class="col-md-2 col-6">
                        <select name="status" id="statusFilter" class="form-select" onchange="this.form.submit()">
                            <option value="">Status - All</option>
                            <option value="1" {{ $status == '1' ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ $status == '0' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                    <div class="col-md-2 col-6">
                        <button type="submit" id="searchBtn" class="btn btn-primary w-100">Search</button>
                    </div>
                    <div class="col-md-2 col-6">
                        <a href="{{ route('slider.table') }}" id="clearBtn" class="btn btn-secondary w-100">Clear</a>
                    </div>
                </div>
            </form>
        </header>

        {{-- Table --}}
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No.</th>
                            <th>Image</th>
                            <th>Text</th>
                            <th>Position</th>
                            <th>Order</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sliders as $index => $slider)
                            <tr class="slider-row" data-status="{{ $slider->status }}">
                                <td>{{ ($sliders->currentPage() - 1) * $sliders->perPage() + $index + 1 }}</td>

                                <td>
                                    <img src="{{ asset($slider->image) }}" width="80" class="img-thumbnail">
                                </td>

                                <td>{{ $slider->title_text ?? '-' }}</td>

                                <td>
                                    <span class="badge bg-info">
                                        {{ ucfirst($slider->slider_position) }}
                                    </span>
                                </td>

                                <td>{{ $slider->sort_order }}</td>

                                <td>
                        {{-- ✅ Toggle status form --}}
                        @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('slider-edit'))
                        <form action="{{ route('slider.toggle', $slider->id) }}" 
                              method="POST" 
                              style="display:inline-block;"
                              onsubmit="return confirm('Are you sure you want to change the status of this slider?');">
                            @csrf
                            @method('PATCH')

                            @if($slider->status == 1)
                                <button type="submit" class="badge rounded-pill bg-success border-0">Active</button>
                            @else
                                <button type="submit" class="badge rounded-pill bg-danger border-0">Inactive</button>
                            @endif
                        </form>
                        @else
                            @if($slider->status == 1)
                                <span class="badge rounded-pill bg-success">Active</span>
                            @else
                                <span class="badge rounded-pill bg-danger">Inactive</span>
                            @endif
                        @endif
                    </td>

                                <td class="d-flex gap-2">
                                    @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('slider-edit'))
                                    <a href="{{ route('slider.edit', $slider->id) }}"
                                       class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil-square me-1"></i>
                                    </a>
                                    @endif

                                    @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('slider-delete'))
                                    <form action="{{ route('slider.destroy', $slider->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Delete this slider?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger btn-action-col d-inline-flex align-items-center justify-content-center "><i class="bi bi-trash me-1"></i> Delete</button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">
                                    No sliders found.
                                </td>
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
                @if ($sliders->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link">&laquo;</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $sliders->appends(request()->query())->previousPageUrl() }}" aria-label="Previous">
                            &laquo;
                        </a>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($sliders->appends(request()->query())->getUrlRange(1, $sliders->lastPage()) as $page => $url)
                    @if ($page == $sliders->currentPage())
                        <li class="page-item active">
                            <a class="page-link" href="#">{{ str_pad($page, 2, '0', STR_PAD_LEFT) }}</a>
                        </li>
                    @else
                        @if ($page == 1 || $page == $sliders->lastPage() || abs($page - $sliders->currentPage()) <= 1)
                            <li class="page-item">
                                <a class="page-link" href="{{ $url }}">{{ str_pad($page, 2, '0', STR_PAD_LEFT) }}</a>
                            </li>
                        @elseif (abs($page - $sliders->currentPage()) == 2)
                            <li class="page-item disabled">
                                <span class="page-link dot">...</span>
                            </li>
                        @endif
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($sliders->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $sliders->appends(request()->query())->nextPageUrl() }}" aria-label="Next">
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

</section>

{{-- Client-side filter --}}
<script>
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const searchBtn = document.getElementById('searchBtn');
    const clearBtn = document.getElementById('clearBtn');

    // Show/hide clear button based on input
    searchInput.addEventListener('keyup', toggleClearButton);
    statusFilter.addEventListener('change', toggleClearButton);

    function toggleClearButton() {
        const hasSearch = searchInput.value.trim() !== '';
        const hasStatus = statusFilter.value !== '';

        if (hasSearch || hasStatus) {
            searchBtn.classList.add('d-none');
            clearBtn.classList.remove('d-none');
        } else {
            searchBtn.classList.remove('d-none');
            clearBtn.classList.add('d-none');
        }
    }

    // Search on Enter key
    searchInput.addEventListener('keyup', function(e) {
        if (e.key === 'Enter') {
            filterTable();
        }
    });

    function filterTable() {
        const search = document.getElementById('searchInput').value.toLowerCase();
        const status = document.getElementById('statusFilter').value;

        document.querySelectorAll('.slider-row').forEach(row => {
            const text = row.textContent.toLowerCase();
            const rowStatus = row.dataset.status;

            const matchSearch = text.includes(search);
            const matchStatus = status === '' || status === rowStatus;

            row.style.display = (matchSearch && matchStatus) ? '' : 'none';
        });
    }

    function clearFilters() {
        document.getElementById('searchInput').value = '';
        document.getElementById('statusFilter').value = '';
        
        document.querySelectorAll('.slider-row').forEach(row => {
            row.style.display = '';
        });

        // Hide clear button and show search button
        searchBtn.classList.remove('d-none');
        clearBtn.classList.add('d-none');
    }
</script>

@endsection
