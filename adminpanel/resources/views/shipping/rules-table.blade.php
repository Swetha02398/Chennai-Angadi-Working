@extends('layouts.app')
@section('content')
    @include('includes.alert')

    <section class="content-main">
        <div class="content-header">
            <div>
                <h2 class="content-title">Shipping Rules</h2>

            </div>
            <div>
                @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('shipping-create'))
                <a href="{{ route('shipping.rules.create') }}" class="btn btn-primary btn-sm">
                    + Add Rule
                </a>
                @endif
            </div>
        </div>
        <div class="card mb-4">
            <header class="card-header">
                <form method="GET" action="{{ route('shipping.rules.table') }}" class="w-100">
                    <div class="row gx-3 align-items-center">
                        <div class="col-md-4 col-12">
                            <input type="text" name="search" placeholder="Search..." class="form-control"
                                value="{{ $search ?? '' }}" />
                        </div>
                        <div class="col-md-2 col-6">
                            <select name="status" class="form-select">
                                <option value="">Status - All</option>
                                <option value="1" {{ (isset($status) && $status == '1') ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ (isset($status) && $status == '0') ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-2 col-6">
                            <button type="submit" class="btn btn-primary w-100">Search</button>
                        </div>
                        @if((isset($search) && $search) || (isset($status) && $status !== ''))
                            <div class="col-md-2 col-6">
                                <a href="{{ route('shipping.rules.table') }}" class="btn btn-secondary w-100">Clear</a>
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
                            <th>Zone</th>
                            <th>States</th>
                            <th>Condition Type</th>
                            <th>Shipping Amount</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rules as $rule)
                            <tr>
                                <td>{{ ($rules->currentPage() - 1) * $rules->perPage() + $loop->iteration }}</td>
                                <td>{{ $rule->zone->name ?? '-' }}</td>
                                <td>{{ implode(', ', $rule->states ?? []) }}</td>
                                <td>{{ $rule->condition_type }}</td>
                                <td>₹ {{ $rule->slabs->first()?->shipping_amount ?? '-' }}</td>
                                <td>
                                    @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('shipping-edit'))
                                    <form action="{{ route('shipping.rules.toggle', $rule->id) }}" method="POST"
                                        style="display:inline-block;" onsubmit="return confirm('Change rule status?');">

                                        @csrf
                                        @method('PATCH')

                                        @if($rule->is_active)
                                            <button type="submit" class="badge rounded-pill bg-success">
                                                Active
                                            </button>
                                        @else
                                            <button type="submit" class="badge rounded-pill bg-danger">
                                                Inactive
                                            </button>
                                        @endif
                                    </form>
                                    @else
                                        @if($rule->is_active)
                                            <span class="badge rounded-pill bg-success">Active</span>
                                        @else
                                            <span class="badge rounded-pill bg-danger">Inactive</span>
                                        @endif
                                    @endif


                                </td>

                                <td>
                                    @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('shipping-edit'))
                                    <a href="{{ route('shipping.rules.edit', $rule->id) }}" class="btn btn-sm btn-warning"><i
                                            class="bi bi-pencil-square me-1"></i></a>
                                    @endif

                                    @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('shipping-delete'))
                                    <form action="{{ route('shipping.rules.delete', $rule->id) }}" method="POST"
                                        style="display:inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger btn-action-col d-inline-flex align-items-center justify-content-center " onclick="return confirm('Delete?')"><i class="bi bi-trash me-1"></i> Delete</button>
                                    </form>
                                    @endif
                                    <a href="{{ route('shipping.rules.view', $rule->id) }}" class="btn btn-sm btn-info"><i
                                            class="bi bi-eye-fill me-1"></i></a>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
        </div>
        <!-- Pagination -->
        <div class="pagination-area mt-30 mb-50">
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-start">
                    {{-- Previous Page Link --}}
                    @if ($rules->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link">&laquo;</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $rules->appends(request()->query())->previousPageUrl() }}"
                                aria-label="Previous">
                                &laquo;
                            </a>
                        </li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($rules->getUrlRange(1, $rules->lastPage()) as $page => $url)
                        @if ($page == $rules->currentPage())
                            <li class="page-item active">
                                <a class="page-link" href="#">{{ str_pad($page, 2, '0', STR_PAD_LEFT) }}</a>
                            </li>
                        @else
                            @if ($page == 1 || $page == $rules->lastPage() || abs($page - $rules->currentPage()) <= 1)
                                <li class="page-item">
                                    <a class="page-link"
                                        href="{{ $url }}{{ strpos($url, '?') ? '&' : '?' }}{{ http_build_query(request()->query()) }}">{{ str_pad($page, 2, '0', STR_PAD_LEFT) }}</a>
                                </li>
                            @elseif (abs($page - $rules->currentPage()) == 2)
                                <li class="page-item disabled">
                                    <span class="page-link dot">...</span>
                                </li>
                            @endif
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($rules->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $rules->appends(request()->query())->nextPageUrl() }}"
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