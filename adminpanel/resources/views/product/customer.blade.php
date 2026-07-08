@extends('layouts.app')
@section('content')
@include('includes.alert')
<section class="content-main">
    <div class="content-header">
        <div>
            <h2 class="content-title card-title">Customer List</h2>
        </div>
        <div>
            @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('customer-create'))
            <a href="{{ route('customerRegister') }}" class="btn btn-primary mb-3 ">Add new</a>
            @endif
            <a href="{{ route('customers.export') }}" class="btn btn-secondary mb-3"><i class="bi bi-file-earmark-excel"></i> Export to Excel</a>
        </div>
    </div>

    <div class="card mb-4">
        <header class="card-header">
            <form method="GET" action="{{ route('customer') }}" class="w-100">
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
                        <a href="{{ route('customer') }}" class="btn btn-secondary w-100">Clear</a>
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
                            <th>Username</th>
                            <th>Email</th>
                            <th>Mobile Number</th>
                            <th>Address</th>
                            <th>Status</th>
                            <th class="text-start">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customers as $key => $customer)
                        <tr>
                            <td>{{ $customers->firstItem() + $loop->index }}</td>
                            <td>
    <a href="{{ route('customerView', $customer->id) }}" class="text-decoration-none">
        {{ $customer->username }}
    </a>
</td>

                            <td>{{ $customer->email }}</td>
                            <td>{{ $customer->mobilenumber }}</td>
                            <td>{{ $customer->address }}</td>
                            <td>
                                @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('customer-edit'))
                                <form action="{{ route('customer.toggleStatus', $customer->id) }}" method="POST" style="display:inline-block;" 
                                    onsubmit="return confirm('Are you sure you want to change the status of this customer?');">
                                     @csrf
                                     @method('PATCH')

                                  @if($customer->status == 1)
                                    <button type="submit" class="badge rounded-pill bg-success">Active</button>
                                   @else
                                     <button type="submit" class="badge rounded-pill bg-danger">Inactive</button>
                                   @endif
                                 </form>
                                @else
                                    @if($customer->status == 1)
                                        <span class="badge rounded-pill bg-success">Active</span>
                                    @else
                                        <span class="badge rounded-pill bg-danger">Inactive</span>
                                    @endif
                                @endif
                             </td>
                            <td class="text-start">
                               @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('customer-delete'))
                                <a href="{{ route('customer.delete', $customer->id) }}" 
                                   onclick="return confirm('Are you sure you want to delete this customer?')" 
                                   class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash me-1"></i> Delete 
                                </a>
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
                @if ($customers->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link">&laquo;</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $customers->appends(request()->query())->previousPageUrl() }}" aria-label="Previous">
                            &laquo;
                        </a>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($customers->appends(request()->query())->getUrlRange(1, $customers->lastPage()) as $page => $url)
                    @if ($page == $customers->currentPage())
                        <li class="page-item active">
                            <a class="page-link" href="#">{{ str_pad($page, 2, '0', STR_PAD_LEFT) }}</a>
                        </li>
                    @else
                        @if ($page == 1 || $page == $customers->lastPage() || abs($page - $customers->currentPage()) <= 1)
                            <li class="page-item">
                                <a class="page-link" href="{{ $url }}">{{ str_pad($page, 2, '0', STR_PAD_LEFT) }}</a>
                            </li>
                        @elseif (abs($page - $customers->currentPage()) == 2)
                            <li class="page-item disabled">
                                <span class="page-link dot">...</span>
                            </li>
                        @endif
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($customers->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $customers->appends(request()->query())->nextPageUrl() }}" aria-label="Next">
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
