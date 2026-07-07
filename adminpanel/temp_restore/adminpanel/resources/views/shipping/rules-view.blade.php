@extends('layouts.app')
@section('content')

<section class="content-main">
    <div class="content-header">
        <h2 class="content-title">Shipping Rule Details</h2>
    </div>

    <div class="card">
        <div class="card-body">

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="fw-bold">Shipping Zone:</label>
                        <p class="bg-light p-2 rounded">{{ $rule->zone->name ?? '-' }}</p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="fw-bold">States:</label>
                        <p class="bg-light p-2 rounded">{{ implode(', ', $rule->states ?? []) }}</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="fw-bold">Condition Type:</label>
                        <p class="bg-light p-2 rounded">{{ ucfirst($rule->condition_type) }}</p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="fw-bold">Status:</label>
                        <p class="bg-light p-2 rounded">
                            <span class="badge {{ $rule->is_active ? 'bg-success' : 'bg-secondary' }}">
                                {{ $rule->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>

            <hr>

            <h5 class="mb-2">Shipping Slabs</h5>
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Min ({{ $rule->condition_type === 'weight' ? 'g' : '₹' }})</th>
                        <th>Max ({{ $rule->condition_type === 'weight' ? 'g' : '₹' }})</th>
                        <th>Amount (₹)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rule->slabs as $slab)
                        <tr>
                            <td>{{ $slab->min_slab }}</td>
                            <td>{{ $slab->max_slab }}</td>
                            <td>{{ $slab->shipping_amount }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-3">
                @if(auth()->user()->isSuperAdmin() || auth()->user()->hasPermission('shipping-edit'))
                <a href="{{ route('shipping.rules.edit', $rule->id) }}" class="btn btn-primary">Edit </a>
                @endif
                <a href="{{ route('shipping.rules.table') }}" class="btn btn-secondary">Back </a>
            </div>

        </div>
    </div>
</section>

@endsection