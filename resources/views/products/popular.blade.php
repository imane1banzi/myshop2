@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Produits les plus populaires</h2>

    <div class="row">
        @foreach ($popularProducts as $item)
        @php $product = $item->product; @endphp
        @if($product)
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://dummyimage.com/450x300/dee2e6/6c757d.jpg' }}" class="card-img-top" alt="{{ $product->name }}" style="max-height: 200px; object-fit: cover;">
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text">Prix : {{ number_format($product->price, 2) }} MAD</p>
                    <p class="card-text"><small class="text-muted">Quantité vendue : {{ $item->total_sold }}</small></p>
                </div>
            </div>
        </div>
        @endif
        @endforeach
    </div>
</div>
@endsection
