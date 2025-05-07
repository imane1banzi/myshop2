@extends('layouts.app')

@section('content')
    <div class="container my-4">
        <h1>Produits Populaires</h1>
    </div>

    <section class="py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                @foreach ($popularProducts as $product)
                    <div class="col-md-3 mb-5">
                        <div class="card h-100">
                            @if($product->price < 50)
                                <div class="badge bg-dark text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Sale</div>
                            @endif
                            <img class="card-img-top" src="{{ $product->image ? asset('storage/' . $product->image) : 'https://dummyimage.com/450x300/dee2e6/6c757d.jpg' }}" alt="{{ $product->name }}" />
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <h5 class="fw-bolder">{{ $product->name }}</h5>
                                    <span>{{ number_format($product->price, 2) }} MAD</span>
                                </div>
                            </div>
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center">
                                    <a class="btn btn-outline-dark mt-auto" href="{{ route('products.show', $product->id) }}">Voir détails</a>
                                    <button class="btn btn-success mt-auto" onclick="addToCart({{ $product->id }}, '{{ $product->name }}', {{ $product->price }}, '{{ $product->image ? asset('storage/' . $product->image) : 'https://dummyimage.com/450x300/dee2e6/6c757d.jpg' }}')">
                                        Ajouter au panier
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
