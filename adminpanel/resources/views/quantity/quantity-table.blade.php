@extends('layouts.app')
@section('content')
    @include('includes.alert')
    <section class="content-main">
        <div class="container mt-4">
            <div class="content-header">
                <div>
                    <h2 class="content-title card-title">Weight List</h2>
                </div>
                <div>
                    @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('quantity-create'))
                    <a href="{{ route('quantity.create') }}" class="btn btn-primary btn-sm rounded">
<i class="bi bi-plus-circle me-1"></i> Add New</a>
                    @endif
                </div>
            </div>

            <!-- Search and Filter Section -->
            <div class="card mb-4">
                <header class="card-header">
                    <form method="GET" action="{{ route('quantity.table') }}" class="w-100">
                        <div class="row gx-3 align-items-center">
                            <div class="col-md-4 col-12">
                                <input type="text" name="search" placeholder="Search..." class="form-control"
                                    value="{{ $search ?? '' }}" />
                            </div>
                            <div class="col-md-2 col-6">
                                <select name="status" class="form-select" onchange="this.form.submit()">
                                    <option value="">Status-All</option>
                                    <option value="1" {{ (isset($status) && $status == '1') ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="0" {{ (isset($status) && $status == '0') ? 'selected' : '' }}>Inactive
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-2 col-6">
                                <button type="submit" class="btn btn-primary w-100">
<i class="bi bi-search me-1"></i> Search</button>
                            </div>
                            @if((isset($search) && $search) || (isset($status) && $status !== ''))
                                <div class="col-md-2 col-6">
                                    <a href="{{ route('quantity.table') }}" class="btn btn-secondary w-100">
<i class="bi bi-eraser me-1"></i> Clear</a>
                                </div>
                            @endif
                        </div>
                    </form>
                </header>
                <div class="card-body">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                <th>Weight</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($quantities as $q)
                                <tr>
                                    <td>{{ ($quantities->currentPage() - 1) * $quantities->perPage() + $loop->iteration }}</td>
                                    <td>{{ $q->name }}</td>
                                    <td>{{ $q->label }}</td>
                                    <td>
                                        @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('quantity-edit'))
                                        <form action="{{ route('quantity.toggle', $q->id) }}" method="POST"
                                            style="display:inline-block;"
                                            onsubmit="return confirm('Are you sure you want to change the status of this quantity?');">
                                            @csrf
                                            @method('PATCH')

                                            @if($q->status == 1)
                                                <button type="submit" class="badge rounded-pill bg-success">
<i class="bi bi-check-circle me-1"></i> Active</button>
                                            @else
                                                <button type="submit" class="badge rounded-pill bg-danger">
<i class="bi bi-x-circle me-1"></i> Inactive</button>
                                            @endif
                                        </form>
                                        @else
                                            @if($q->status == 1)
                                                <span class="badge rounded-pill bg-success">
<i class="bi bi-check-circle me-1"></i> Active</span>
                                            @else
                                                <span class="badge rounded-pill bg-danger">
<i class="bi bi-x-circle me-1"></i> Inactive</span>
                                            @endif
                                        @endif


                                    </td>
                                    <td>
                                        @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('quantity-edit'))
                                        <a href="{{ route('quantity.edit', $q->id) }}" class="btn btn-sm btn-warning"> <i class="bi bi-pencil-square me-1"></i> Edit</a>
                                        @endif
                                        @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('quantity-delete'))
                                        <form action="{{ route('quantity.destroy', $q->id) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger btn-action-col d-inline-flex align-items-center justify-content-center "><i class="bi bi-trash me-1"></i> Delete</button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>


            <!-- Pagination -->
            <div class="pagination-area mt-30 mb-50">
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-start">
                        {{-- Previous Page Link --}}
                        @if ($quantities->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">&laquo;</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $quantities->appends(request()->query())->previousPageUrl() }}"
                                    aria-label="Previous">
                                    &laquo;
                                </a>
                            </li>
                        @endif

                        {{-- Pagination Elements --}}
                        @php
                            $cur = $quantities->currentPage();
                            $last = $quantities->lastPage();
                            $shown = [];
                            // Always show: 1, last, and pages within 1 of current
                            for ($p = 1; $p <= $last; $p++) {
                                if ($p == 1 || $p == $last || abs($p - $cur) <= 1) {
                                    $shown[] = $p;
                                }
                            }
                            $shown = array_unique($shown);
                            sort($shown);
                        @endphp
                        @php $prevShown = null; @endphp
                        @foreach ($shown as $page)
                            @if ($prevShown !== null && $page - $prevShown > 1)
                                <li class="page-item disabled">
                                    <span class="page-link dot">...</span>
                                </li>
                            @endif
                            @if ($page == $quantities->currentPage())
                                <li class="page-item active">
                                    <a class="page-link" href="#">{{ str_pad($page, 2, '0', STR_PAD_LEFT) }}</a>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $quantities->appends(request()->query())->url($page) }}">{{ str_pad($page, 2, '0', STR_PAD_LEFT) }}</a>
                                </li>
                            @endif
                            @php $prevShown = $page; @endphp
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($quantities->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $quantities->appends(request()->query())->nextPageUrl() }}"
                                    aria-label="Next">
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
