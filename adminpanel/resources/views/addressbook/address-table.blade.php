@extends('layouts.app')

@section('content')
    <section class="content-main">
        <div class="content-header d-flex justify-content-between align-items-center">
            <h2 class="content-title card-title">Address Book</h2>
            <a href="{{ route('addressbook.create') }}" class="btn btn-primary">+ Add Address</a>
        </div>

        @include('includes.alert')


        <div class="card mb-4">
            <header class="card-header">
                <form method="GET" action="{{ route('addressbook.table') }}" class="w-100">
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
                                <a href="{{ route('addressbook.table') }}" class="btn btn-secondary w-100">Clear</a>
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
                                <th>ID</th>
                                <th>Customer</th>
                                <th>Title</th>

                                <th>Phone</th>
                                <th>City</th>
                                <th>Country</th>

                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($addresses as $address)
                                <tr>
                                    <td>{{ ($addresses->currentPage() - 1) * $addresses->perPage() + $loop->iteration }}</td>
                                    <td><a
                                            href="{{ route('addressbook.view', $address->id) }}">{{ $address->customer->username ?? '-' }}</a>
                                    </td>
                                    <td>{{ $address->title }}</td>

                                    <td>{{ $address->phone }}</td>
                                    <td>{{ $address->city }}</td>
                                    <td>{{ $address->country }}</td>

                                    <td>
                                        {{-- ✅ Toggle status form --}}
                                        <form action="{{ route('addressbook.toggle', $address->id) }}" method="POST"
                                            style="display:inline-block;"
                                            onsubmit="return confirm('Are you sure you want to change the status of this address?');">
                                            @csrf
                                            @method('PATCH')

                                            @if($address->status == 1)
                                                <button type="submit" class="badge rounded-pill bg-success border-0">Active</button>
                                            @else
                                                <button type="submit"
                                                    class="badge rounded-pill bg-danger border-0">Inactive</button>
                                            @endif
                                        </form>
                                    </td>
                                    <td>
                                        <a href="{{ route('addressbook.edit', $address->id) }}"
                                            class="btn btn-sm btn-warning"><i class="bi bi-pencil-square me-1"></i></a>
                                        <a href="{{ route('addressbook.destroy', $address->id) }}"
                                            onclick="return confirm('Are you sure want to delete?')"
                                            class="btn btn-sm btn-danger"><i class="bi bi-trash me-1"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="pagination-area mt-30 mb-50">
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-start">
                        {{-- Previous Page Link --}}
                        @if ($addresses->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">&laquo;</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $addresses->appends(request()->query())->previousPageUrl() }}"
                                    aria-label="Previous">
                                    &laquo;
                                </a>
                            </li>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach ($addresses->appends(request()->query())->getUrlRange(1, $addresses->lastPage()) as $page => $url)
                            @if ($page == $addresses->currentPage())
                                <li class="page-item active">
                                    <a class="page-link" href="#">{{ str_pad($page, 2, '0', STR_PAD_LEFT) }}</a>
                                </li>
                            @else
                                @if ($page == 1 || $page == $addresses->lastPage() || abs($page - $addresses->currentPage()) <= 1)
                                    <li class="page-item">
                                        <a class="page-link"
                                            href="{{ $url }}">{{ str_pad($page, 2, '0', STR_PAD_LEFT) }}</a>
                                    </li>
                                @elseif (abs($page - $addresses->currentPage()) == 2)
                                    <li class="page-item disabled">
                                        <span class="page-link dot">...</span>
                                    </li>
                                @endif
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($addresses->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $addresses->appends(request()->query())->nextPageUrl() }}"
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