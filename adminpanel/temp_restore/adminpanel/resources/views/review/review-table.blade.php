@extends('layouts.app')
@section('content')
@include('includes.alert')
<style>
.rating {
  direction: rtl;
  unicode-bidi: bidi-override;
  display: inline-block;
}

.rating input {
  display: none;
}

.rating label {
  font-size: 20px;
  color: #ccc;
  cursor: pointer;
}

.rating input:checked ~ label,
.rating label:hover,
.rating label:hover ~ label {
  color: #ffc107;
}
</style>


<section class="content-main">
    <div class="content-header">
        <div>
            <h2 class="content-title card-title">Reviews</h2>
        </div>
    </div>

    <div class="card mb-4">
        <header class="card-header">
            <form method="GET" action="{{ route('review.table') }}" class="w-100">
                <div class="row gx-3 align-items-center">
                    <div class="col-md-4 col-12">
                        <input type="text" name="search" placeholder="Search by Name, Email, Product..." 
                               class="form-control" value="{{ $search }}" />
                    </div>

                    <div class="col-md-2 col-6">
                        <select name="status" class="form-select" onchange="this.form.submit()">
                            <option value="">Status - All</option>
                            <option value="1" {{ $status == '1' ? 'selected' : '' }}>Approved</option>
                            <option value="0" {{ $status == '0' ? 'selected' : '' }}>Pending</option>
                        </select>
                    </div>

                    <div class="col-md-2 col-6">
                        <button type="submit" class="btn btn-primary w-100">Search</button>
                    </div>

                    @if($search || $status)
                    <div class="col-md-2 col-6">
                        <a href="{{ route('review.table') }}" class="btn btn-secondary w-100">Clear</a>
                    </div>
                    @endif
                </div>
            </form>
        </header>

        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Product</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Rating</th>
                        <th>Comment</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reviews as $review)
                    <tr>
                        <td>{{ ($reviews->currentPage() - 1) * $reviews->perPage() + $loop->iteration }}</td>
                        <td>{{ $review->product->productname ?? '-' }}</td>
                        <td>{{ $review->name ?? 'N/A' }}</td>
                        <td><a href="{{ route('review.view', $review->id) }}">{{ $review->email ?? 'N/A' }}</a></td>
<td>
    @for ($i = 1; $i <= 5; $i++)
        <span style="color: {{ $i <= $review->rating ? '#ffc107' : '#ccc' }}; font-size:18px;">★</span>
    @endfor
</td>

                        <td>{{ $review->comment }}</td>
                        <td>
                            @if($review->approved)
                                <span class="badge rounded-pill bg-success">Approved</span>
                            @else
                                <span class="badge rounded-pill bg-warning">Pending</span>
                            @endif
                        </td>
                        <td>
                            @if(!$review->approved)
                            @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('reviews-edit'))
                            <form action="{{ route('review.approve', $review->id) }}" method="POST" style="display:inline-block">
                                @csrf
                                <button class="btn btn-sm btn-primary">Approve</button>
                            </form>
                            @endif
                            @endif
                            @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('reviews-delete'))
                            <form action="{{ route('review.delete', $review->id) }}" method="POST" style="display:inline-block"
                                  onsubmit="return confirm('Delete this review?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="pagination-area mt-30 mb-50">
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-start">
                @if ($reviews->onFirstPage())
                    <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $reviews->appends(request()->query())->previousPageUrl() }}" aria-label="Previous">&laquo;</a>
                    </li>
                @endif

                @foreach ($reviews->appends(request()->query())->getUrlRange(1, $reviews->lastPage()) as $page => $url)
                    @if ($page == $reviews->currentPage())
                        <li class="page-item active"><a class="page-link" href="#">{{ str_pad($page, 2, '0', STR_PAD_LEFT) }}</a></li>
                    @else
                        @if ($page == 1 || $page == $reviews->lastPage() || abs($page - $reviews->currentPage()) <= 1)
                            <li class="page-item">
                                <a class="page-link" href="{{ $url }}">
                                    {{ str_pad($page, 2, '0', STR_PAD_LEFT) }}
                                </a>
                            </li>
                        @elseif (abs($page - $reviews->currentPage()) == 2)
                            <li class="page-item disabled"><span class="page-link dot">...</span></li>
                        @endif
                    @endif
                @endforeach

                @if ($reviews->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $reviews->appends(request()->query())->nextPageUrl() }}" aria-label="Next">&raquo;</a>
                    </li>
                @else
                    <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
                @endif
            </ul>
        </nav>
    </div>

</section>
@endsection
