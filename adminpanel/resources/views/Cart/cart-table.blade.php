@extends('layouts.app')

@section('content')
@include('includes.alert')

<section class="content-main">
    <div class="content-header d-flex justify-content-between align-items-center">
        <div>
            <h2 class="content-title card-title">Add to Cart List</h2>
            <p>List of all items in the cart.</p>
        </div>
        <div>
            <a href="{{ route('cart.create') }}" class="btn btn-primary btn-sm rounded">+ Add to Cart</a>
        </div>
    </div>
    <div class="card mb-4">
        <header class="card-header">
            <form method="GET" action="{{ route('cart.table') }}" class="w-100">
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
                        <a href="{{ route('cart.table') }}" class="btn btn-secondary w-100">Clear</a>
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
                <th>Customer Name</th>
                <th>Product Name</th>
                <th>Price at Add Time</th>
                <th>Row Total</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            {{-- ✅ Loop through coupons --}}
             @forelse(($carts ?? []) as $index => $cart)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td><a href="{{ route('cart.view', $cart->id) }}">{{ optional($cart->customer)->username ?? '-' }}</a></td>
            <td>{{ optional($cart->product)->productname ?? '-' }}</td>
            <td>{{ number_format($cart->price_at_add_time, 2) }}</td>
            <td>{{ number_format($cart->row_total, 2) }}</td>
        
                    <td>
                        {{-- ✅ Toggle status form --}}
                        <form action="{{ route('cart.toggle', $cart->id) }}" 
                              method="POST" 
                              style="display:inline-block;"
                              onsubmit="return confirm('Are you sure you want to change the status of this cart item?');">
                            @csrf
                            @method('PATCH')

                            @if($cart->status == 1)
                                <button type="submit" class="badge rounded-pill bg-danger border-0">Inactive</button>
                            @else
                                <button type="submit" class="badge rounded-pill bg-success border-0">Active</button>
                            @endif
                        </form>
                    </td>

                  
                        
                    <td><form action="{{ route('cart.delete', $cart->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                       <button type="submit" class="btn btn-sm btn-danger btn-action-col d-inline-flex align-items-center justify-content-center " onclick="return confirm('Are you sure to delete this cart item?')"><i class="bi bi-trash me-1"></i> Delete</button>
                       </form>

                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">No cart found.</td>
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
                @if ($carts->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link">&laquo;</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $carts->appends(request()->query())->previousPageUrl() }}" aria-label="Previous">
                            &laquo;
                        </a>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($carts->appends(request()->query())->getUrlRange(1, $carts->lastPage()) as $page => $url)
                    @if ($page == $carts->currentPage())
                        <li class="page-item active">
                            <a class="page-link" href="#">{{ str_pad($page, 2, '0', STR_PAD_LEFT) }}</a>
                        </li>
                    @else
                        @if ($page == 1 || $page == $carts->lastPage() || abs($page - $carts->currentPage()) <= 1)
                            <li class="page-item">
                                <a class="page-link" href="{{ $url }}">{{ str_pad($page, 2, '0', STR_PAD_LEFT) }}</a>
                            </li>
                        @elseif (abs($page - $carts->currentPage()) == 2)
                            <li class="page-item disabled">
                                <span class="page-link dot">...</span>
                            </li>
                        @endif
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($carts->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $carts->appends(request()->query())->nextPageUrl() }}" aria-label="Next">
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
