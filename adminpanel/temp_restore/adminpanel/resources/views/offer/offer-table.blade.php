@extends('layouts.app')

@section('content')
    @include('includes.alert')
    <section class="content-main">
        <div class="content-header d-flex justify-content-between align-items-center">
            <h2 class="content-title">Offers & Promotions</h2>
            @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('offers-create'))
            <a href="{{ route('offer.create') }}" class="btn btn-primary">+ Add Offer</a>
            @endif
        </div>

        <div class="card mb-4">
            <header class="card-header">
                <form method="GET" action="{{ route('offer.table') }}" class="w-100">
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
                                <a href="{{ route('offer.table') }}" class="btn btn-secondary w-100">Clear</a>
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
                                <th>Title</th>
                                <th>Discount</th>
                                <th>Type</th>
                                <th>Start</th>
                                <th>End</th>
                                <th>Priority</th>
                                <th>Status</th>

                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($offers as $offer)
                                <tr>
                                    <td>{{ ($offers->currentPage() - 1) * $offers->perPage() + $loop->iteration }}</td>
                                    <td><a href="{{ route('offer.show', $offer->id) }}">{{ $offer->title }}</a></td>
                                    <td>{{ $offer->discount_value }}</td>
                                    <td>{{ ucfirst($offer->discount_type) }}</td>
                                    <td>{{ $offer->start_date }}</td>
                                    <td>{{ $offer->end_date }}</td>
                                    <td>{{ $offer->priority }}</td>
                                    {{-- ✅ Toggle status form --}}
                                    <td>
                                        @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('offers-edit'))
                                        <form action="{{ route('offer.toggle', $offer->id) }}" method="POST"
                                            style="display:inline-block;"
                                            onsubmit="return confirm('Are you sure you want to change the status of this offer?');">
                                            @csrf
                                            @method('PATCH')

                                            @if($offer->status == 1)
                                                <button type="submit" class="badge rounded-pill bg-success border-0">Active</button>
                                            @else
                                                <button type="submit"
                                                    class="badge rounded-pill bg-danger border-0">Inactive</button>
                                            @endif
                                        </form>
                                        @else
                                            @if($offer->status == 1)
                                                <span class="badge rounded-pill bg-success">Active</span>
                                            @else
                                                <span class="badge rounded-pill bg-danger">Inactive</span>
                                            @endif
                                        @endif
                                    </td>

                                    <td>
                                        @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('offers-edit'))
                                        <a href="{{ route('offer.edit', $offer->id) }}" class="btn btn-sm btn-warning"><i
                                                class="bi bi-pencil-square me-1"></i></a>
                                        @endif
                                        @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('offers-delete'))
                                        <form action="{{ route('offer.delete', $offer->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Delete this offer?')"><i
                                                    class="bi bi-trash me-1"></i></button>
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

        {{-- Pagination outside the card --}}
        <div class="pagination-area mt-30 mb-50">
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-start">
                    {{-- Previous Page Link --}}
                    @if ($offers->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link">&laquo;</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $offers->appends(request()->query())->previousPageUrl() }}"
                                aria-label="Previous">
                                &laquo;
                            </a>
                        </li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($offers->appends(request()->query())->getUrlRange(1, $offers->lastPage()) as $page => $url)
                        @if ($page == $offers->currentPage())
                            <li class="page-item active">
                                <a class="page-link" href="#">{{ str_pad($page, 2, '0', STR_PAD_LEFT) }}</a>
                            </li>
                        @else
                            @if ($page == 1 || $page == $offers->lastPage() || abs($page - $offers->currentPage()) <= 1)
                                <li class="page-item">
                                    <a class="page-link"
                                        href="{{ $url }}">{{ str_pad($page, 2, '0', STR_PAD_LEFT) }}</a>
                                </li>
                            @elseif (abs($page - $offers->currentPage()) == 2)
                                <li class="page-item disabled">
                                    <span class="page-link dot">...</span>
                                </li>
                            @endif
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($offers->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $offers->appends(request()->query())->nextPageUrl() }}"
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