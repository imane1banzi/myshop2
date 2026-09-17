@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="text-center mb-4" style="color: gray">{{ $product->name }}</h1>
    <div class="card mb-4 shadow">
        <div class="row g-0">
            <div class="col-md-5 bg-white d-flex align-items-center justify-content-center p-4" style="min-height: 400px;">
                <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://dummyimage.com/450x300/dee2e6/6c757d.jpg' }}" style="max-height: 380px; width: 100%; object-fit: contain;" alt="{{ $product->name }}">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title">Description</h5>
                    <p class="card-text">{{ $product->description }}</p>
                    <h5 class="card-title">Price</h5>
                    <p class="card-text">${{ number_format($product->price, 2) }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="text-center">
        <a href="{{ route('products.index') }}" class="btn btn-primary">Back to Products</a>
    </div>
</div>
@endsection
