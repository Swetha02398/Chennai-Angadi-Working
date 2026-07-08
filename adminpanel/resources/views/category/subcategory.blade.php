@extends('layouts.app')
@section('content')
    @include('includes.alert')
    <section class="content-main">

        <!-- ==================== SUB CATEGORY TABLE ==================== -->
        <div class="content-header">
            <div>
                <h2 class="content-title card-title">Sub Categories</h2>
            </div>
            @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('categories-create'))
            <div>
                <a href="{{ route('subcategory.create') }}" class="btn btn-primary btn-sm rounded">+ Add Sub Category</a>
            </div>
            @endif
        </div>

        <div class="card mb-4">
            <header class="card-header">
                <form method="GET" action="{{ route('subcategory.index') }}" class="w-100">
                    <div class="row gx-3 align-items-center">
                        <div class="col-md-4 col-12">
                            <input type="text" name="search" placeholder="Search..." class="form-control"
                                value="{{ $search }}" />
                        </div>
                        <div class="col-md-2 col-6">
                            <select name="status" class="form-select" onchange="this.form.submit()">
                                <option value="">Status - All</option>
                                <option value="active" {{ $status == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ $status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-2 col-6">
                            <button type="submit" class="btn btn-primary w-100">Search</button>
                        </div>
                        @if($search || $status)
                            <div class="col-md-2 col-6">
                                <a href="{{ route('subcategory.index') }}" class="btn btn-secondary w-100">Clear</a>
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
                                <th>Image</th>
                                <th>Sub Category Name</th>
                                <th>Slug Name</th>
                                <th>Parent Category</th>
                                <th>Order By</th>
                                <th>Status</th>
                                <th class="text-start">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($subcategories as $index => $sub)
                                <tr>
                                    <td>{{ ($subcategories->currentPage() - 1) * $subcategories->perPage() + $index + 1 }}</td>

                                    {{-- Display Subcategory Image --}}
                                    <td>
                                        @if($sub->subimage)
                                            <img src="{{ asset($sub->subimage) }}" alt="{{ $sub->name }}" width="40" height="40"
                                                class="rounded-circle" style="object-fit: cover;">
                                        @else
                                            <span class="text-muted">No Image</span>
                                        @endif
                                    </td>

                                    <td><b>{{ $sub->name }}</b></td>
                                    <td>{{ $sub->slug }}</td>
                                    <td>{{ $sub->mainCategory->name ?? '—' }}</td>
                                    <td>{{ $sub->orderby ?? '—' }}</td>

                                    {{-- Status toggle --}}
                                    <td>
                                        @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('categories-edit'))
                                        <form action="{{ route('subcategory.toggle', $sub->id) }}" method="POST"
                                            style="display:inline-block;"
                                            onsubmit="return confirm('Are you sure you want to change the status of this sub category?');">
                                            @csrf
                                            @method('PATCH')
                                            @if($sub->status == 'active')
                                                <button type="submit" class="badge rounded-pill bg-success">Active</button>
                                            @else
                                                <button type="submit" class="badge rounded-pill bg-danger">Inactive</button>
                                            @endif
                                        </form>
                                        @else
                                            @if($sub->status == 'active')
                                                <span class="badge rounded-pill bg-success">Active</span>
                                            @else
                                                <span class="badge rounded-pill bg-danger">Inactive</span>
                                            @endif
                                        @endif
                                    </td>

                                    {{-- Actions --}}
                                    <td class="text-start">
                                        @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('categories-edit'))
                                        <a href="{{ route('subcategory.edit', $sub->id) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil-square me-1"></i> Edit</a>
                                        @endif
                                        @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('categories-delete'))
                                        <form action="{{ route('subcategory.destroy', $sub->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger btn-action-col d-inline-flex align-items-center justify-content-center " type="submit"><i class="bi bi-trash me-1"></i> Delete</button>
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
                    @if ($subcategories->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link">&laquo;</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $subcategories->appends(request()->query())->previousPageUrl() }}"
                                aria-label="Previous">
                                &laquo;
                            </a>
                        </li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($subcategories->appends(request()->query())->getUrlRange(1, $subcategories->lastPage()) as $page => $url)
                        @if ($page == $subcategories->currentPage())
                            <li class="page-item active">
                                <a class="page-link" href="#">{{ str_pad($page, 2, '0', STR_PAD_LEFT) }}</a>
                            </li>
                        @else
                            @if ($page == 1 || $page == $subcategories->lastPage() || abs($page - $subcategories->currentPage()) <= 1)
                                <li class="page-item">
                                    <a class="page-link"
                                        href="{{ $url }}">{{ str_pad($page, 2, '0', STR_PAD_LEFT) }}</a>
                                </li>
                            @elseif (abs($page - $subcategories->currentPage()) == 2)
                                <li class="page-item disabled">
                                    <span class="page-link dot">...</span>
                                </li>
                            @endif
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($subcategories->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $subcategories->appends(request()->query())->nextPageUrl() }}"
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
    </section>
@endsection