@extends('layouts.app')

@section('content')
@include('includes.alert')

<section class="content-main">

    <div class="content-header d-flex justify-content-between align-items-center">
        <div>
            <h2 class="content-title card-title">HSN Codes</h2>
            <p>List of all HSN codes.</p>
        </div>
        <div>
            @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('hsncode-create'))
            <a href="{{ route('hsncode.create') }}" class="btn btn-primary btn-sm rounded">
<i class="bi bi-plus-circle me-1"></i> Add New</a>
            @endif
        </div>
    </div>

    
    <div class="card mb-4">
        <header class="card-header">
            <form method="GET" action="{{ route('hsncode.table') }}" class="w-100">
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
                        <button type="submit" class="btn btn-primary w-100">
<i class="bi bi-search me-1"></i> Search</button>
                    </div>
                    @if($search || $status)
                    <div class="col-md-2 col-6">
                        <a href="{{ route('hsncode.table') }}" class="btn btn-secondary w-100">
<i class="bi bi-eraser me-1"></i> Clear</a>
                    </div>
                    @endif
                </div>
            </form>
        </header>

        <div class="card-body">
        <div class="table-responsive">
    <table class="table table-bordered ">
        <thead class="table-light">
            <tr>
                <th>No.</th>
                <th>HSN Code</th>
                <th>Description</th>
                <th>GST %</th>
                <th>CGST</th>
                <th>SGST</th>
                <th>IGST</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($hsnCodes as $hsn)
            <tr>
                 <td>{{ ($hsnCodes->currentPage() - 1) * $hsnCodes->perPage() + $loop->iteration }}</td>
                <td><a href="{{ route('hsncode.view', $hsn->id) }}">{{ $hsn->code }}</a></td>
                <td>{{ $hsn->description ?? '-' }}</td>
                <td>{{ $hsn->gst_rate }}%</td>
                <td>{{ $hsn->cgst_rate ?? '-' }}</td>
                <td>{{ $hsn->sgst_rate ?? '-' }}</td>
                <td>{{ $hsn->igst_rate ?? '-' }}</td>
                <td>
                        {{-- ✅ Toggle status form --}}
                        @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('hsncode-edit'))
                        <form action="{{ route('hsncode.toggle', $hsn->id) }}" 
                              method="POST" 
                              style="display:inline-block;"
                              onsubmit="return confirm('Are you sure you want to change the status of this HSN code?');">
                            @csrf
                            @method('PATCH')

                            @if($hsn->status == 1)
                                <button type="submit" class="badge rounded-pill bg-danger border-0">
<i class="bi bi-x-circle me-1"></i> Inactive</button>
                            @else
                                <button type="submit" class="badge rounded-pill bg-success border-0">
<i class="bi bi-check-circle me-1"></i> Active</button>
                            @endif
                        </form>
                        @else
                            @if($hsn->status == 1)
                                <span class="badge rounded-pill bg-success">
<i class="bi bi-check-circle me-1"></i> Active</span>
                            @else
                                <span class="badge rounded-pill bg-danger">
<i class="bi bi-x-circle me-1"></i> Inactive</span>
                            @endif
                        @endif
                    </td>
                <td>
                    @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('hsncode-edit'))
                    <a href="{{ route('hsncode.edit', $hsn->id) }}"  class="btn btn-sm btn-warning"><i class="bi bi-pencil-square me-1"></i> Edit</a>
                    @endif
                    @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('hsncode-delete'))
                    <form action="{{ route('hsncode.delete', $hsn->id) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger btn-action-col d-inline-flex align-items-center justify-content-center " onclick="return confirm('Delete this HSN Code?')"><i class="bi bi-trash me-1"></i> Delete</button>
                    </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>
</div>

    <div class="pagination-area mt-30 mb-50">
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-start">
                {{-- Previous Page Link --}}
                @if ($hsnCodes->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link">&laquo;</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $hsnCodes->appends(request()->query())->previousPageUrl() }}" aria-label="Previous">
                            &laquo;
                        </a>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($hsnCodes->getUrlRange(1, $hsnCodes->lastPage()) as $page => $url)
                    @if ($page == $hsnCodes->currentPage())
                        <li class="page-item active">
                            <a class="page-link" href="#">{{ str_pad($page, 2, '0', STR_PAD_LEFT) }}</a>
                        </li>
                    @else
                        @if ($page == 1 || $page == $hsnCodes->lastPage() || abs($page - $hsnCodes->currentPage()) <= 1)
                            <li class="page-item">
                                <a class="page-link" href="{{ $url }}{{ strpos($url, '?') ? '&' : '?' }}{{ http_build_query(request()->query()) }}">{{ str_pad($page, 2, '0', STR_PAD_LEFT) }}</a>
                            </li>
                        @elseif (abs($page - $hsnCodes->currentPage()) == 2)
                            <li class="page-item disabled">
                                <span class="page-link dot">...</span>
                            </li>
                        @endif
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($hsnCodes->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $hsnCodes->appends(request()->query())->nextPageUrl() }}" aria-label="Next">
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
