@extends('layouts.app')

@section('content')
<section class="content-main">
<div class="container mt-4">

    {{-- Laravel backend errors --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <h2 class="mb-4">Create Customer Cart</h2>

   <form id="cartForm" action="{{ route('cart.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label>Select Customer *</label>
        <select name="customer_id" class="form-control" required>
            <option value="">Select Customer</option>
            @foreach($customers as $cust)
                <option value="{{ $cust->id }}">{{ $cust->username }} ({{ $cust->email }})</option>
            @endforeach
        </select>
    </div>

    <div id="productsContainer">
        <div class="row product-row mb-2">
            <div class="col-md-6">
                <label>Select Product *</label>
                <select name="products[0][id]" class="form-control" required>
                    <option value="">Select Product</option>
                    @foreach($products as $prod)
                        <option value="{{ $prod->id }}">{{ $prod->productname }} - ₹{{ $prod->price }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label>Quantity *</label>
                <input type="number" name="products[0][quantity]" class="form-control" min="1" value="1" required>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger remove-product mt-4">Remove</button>
            </div>
        </div>
    </div>

    <button type="button" class="btn btn-primary mb-3" id="addProduct">Add Another Product</button><br><br><br>
    <button type="submit" class="btn btn-success">Add to Cart</button>
</form>

<script>
let productIndex = 1;
document.getElementById('addProduct').addEventListener('click', function() {
    const container = document.getElementById('productsContainer');
    const newRow = document.querySelector('.product-row').cloneNode(true);
    newRow.querySelector('select').value = '';
    newRow.querySelector('input').value = 1;
    newRow.querySelector('select').name = `products[${productIndex}][id]`;
    newRow.querySelector('input').name = `products[${productIndex}][quantity]`;
    container.appendChild(newRow);

    newRow.querySelector('.remove-product').addEventListener('click', function() {
        newRow.remove();
    });

    productIndex++;
});

// Remove first row button
document.querySelector('.remove-product').addEventListener('click', function() {
    this.closest('.product-row').remove();
});
</script>
@endsection