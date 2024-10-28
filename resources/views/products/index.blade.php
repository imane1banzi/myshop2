@extends('layouts.app')

@section('content')

        <!-- Section pour ajouter un produit -->
        <div class="container my-4">
            <a href="{{ route('products.create') }}" class="btn btn-success">Ajouter un produit</a>
        </div>

        <!-- Product section -->
        <section class="py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="row gx-4 gx-lg-5 justify-content-center">
                    @foreach ($products as $product)
                    <div class="col-md-3 mb-5"> <!-- col-md-3 ajoute la disposition en 4 produits par ligne -->
                        <div class="card h-100">
                            <!-- Sale badge-->
                            @if($product->price < 50)
                            <div class="badge bg-dark text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Sale</div>
                            @endif
                            <!-- Product image-->
                            <img class="card-img-top" src="{{ $product->image ? asset('storage/' . $product->image) : 'https://dummyimage.com/450x300/dee2e6/6c757d.jpg' }}" alt="{{ $product->name }}" />
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder">{{ $product->name }}</h5>
                                    <!-- Product price-->
                                    <span>{{ number_format($product->price, 2) }}MAD</span>
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center">
                                    <a class="btn btn-outline-dark mt-auto" href="{{ route('products.show', $product->id) }}">Voir détails</a>
                                    <button class="btn btn-success mt-auto" onclick="addToCart({{ $product->id }}, '{{ $product->name }}', {{ $product->price }}, '{{ $product->image ? asset('storage/' . $product->image) : 'https://dummyimage.com/450x300/dee2e6/6c757d.jpg' }}')">
                                        Add to Cart
                                    </button>
                                    <!-- Edit button -->
                                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning mt-auto">Modifier</a>
                                    <!-- Delete button -->
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger mt-auto">Supprimer</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endsection
       