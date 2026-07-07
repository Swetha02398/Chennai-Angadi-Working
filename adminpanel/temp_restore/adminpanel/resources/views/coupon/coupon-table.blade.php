@extends('layouts.app')

@section('content')
    @include('includes.alert')

    <section class="content-main">
        <div class="content-header d-flex justify-content-between align-items-center">
            <div>
                <h2 class="content-title card-title">Coupon List</h2>
            </div>
            <div>
                @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('coupons-create'))
                <a href="{{ route('coupon.create') }}" class="btn btn-primary btn-sm rounded">+ Add Coupon</a>
                @endif
            </div>
        </div>

        <div class="card mb-4">
            <header class="card-header">
                <form method="GET" action="{{ route('coupon.table') }}" class="w-100">
                    <div class="row gx-3 align-items-center">
                        <div class="col-md-4 col-12">
                            <input type="text" name="search" placeholder="Search..." class="form-control"
                                value="{{ $search }}" />
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
                                <a href="{{ route('coupon.table') }}" class="btn btn-secondary w-100">Clear</a>
                            </div>
                        @endif
                    </div>
                </form>
            </header>

            <div class="card-body">
                <div class="table-responsive">
                    <table id=".table" class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>No.</th>
                                <th>Coupon Code</th>
                                <th>Usage Limit</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- ✅ Loop through coupons --}}
                            @forelse($coupons as $index => $coupon)
                                <tr>
                                    <td>{{ ($coupons->currentPage() - 1) * $coupons->perPage() + $index + 1 }}</td>
                                    <td><a href="{{ route('coupon.view', $coupon->id) }}"> {{ $coupon->code }}</a></td>
                                    <td>{{ $coupon->usage_limit ?? '-' }}</td>
                                    <td>{{ $coupon->start_date ? date('d-m-Y', strtotime($coupon->start_date)) : '-' }}</td>
                                    <td>{{ $coupon->end_date ? date('d-m-Y', strtotime($coupon->end_date)) : '-' }}</td>
                                    <td>
                                        {{-- ✅ Toggle status form - based on actual DB status --}}
                                        @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('coupons-edit'))
                                        <form action="{{ route('coupon.toggle', $coupon->id) }}" method="POST"
                                            style="display:inline-block;"
                                            onsubmit="return confirm('Are you sure you want to change the status of this coupon?');">
                                            @csrf
                                            @method('PATCH')

                                            @if($coupon->status == 1)
                                                <button type="submit" class="badge rounded-pill bg-success border-0">Active</button>
                                            @else
                                                <button type="submit"
                                                    class="badge rounded-pill bg-danger border-0">Inactive</button>
                                            @endif
                                        </form>
                                        @else
                                            @if($coupon->status == 1)
                                                <span class="badge rounded-pill bg-success">Active</span>
                                            @else
                                                <span class="badge rounded-pill bg-danger">Inactive</span>
                                            @endif
                                        @endif
                                    </td>

                                    <td>
                                        @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('coupons-edit'))
                                        <a href="{{ route('coupon.edit', $coupon->id) }}" class="btn btn-sm btn-warning"> <i
                                                class="bi bi-pencil-square me-1"></i></a>
                                        @endif

                                        @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('coupons-delete'))
                                        <form action="{{ route('coupon.delete', $coupon->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure to delete this coupon?')">
                                                <i class="bi bi-trash me-1"></i>
                                            </button>
                                        </form>
                                        @endif

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No cart found.</td>
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
                    @if ($coupons->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link">&laquo;</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $coupons->appends(request()->query())->previousPageUrl() }}"
                                aria-label="Previous">
                                &laquo;
                            </a>
                        </li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($coupons->appends(request()->query())->getUrlRange(1, $coupons->lastPage()) as $page => $url)
                        @if ($page == $coupons->currentPage())
                            <li class="page-item active">
                                <a class="page-link" href="#">{{ str_pad($page, 2, '0', STR_PAD_LEFT) }}</a>
                            </li>
                        @else
                            @if ($page == 1 || $page == $coupons->lastPage() || abs($page - $coupons->currentPage()) <= 1)
                                <li class="page-item">
                                    <a class="page-link"
                                        href="{{ $url }}">{{ str_pad($page, 2, '0', STR_PAD_LEFT) }}</a>
                                </li>
                            @elseif (abs($page - $coupons->currentPage()) == 2)
                                <li class="page-item disabled">
                                    <span class="page-link dot">...</span>
                                </li>
                            @endif
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($coupons->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $coupons->appends(request()->query())->nextPageUrl() }}"
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