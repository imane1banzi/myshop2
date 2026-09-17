@extends('layouts.app')

@section('content')

        <!-- Section pour ajouter un produit : ADMIN uniquement -->
        @auth
            @if(auth()->user()->isAdmin())
                <div class="container my-4">
                    <a href="{{ route('products.create') }}" class="btn btn-success">Ajouter un produit</a>
                </div>
            @endif
        @endauth

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
                            <!-- Product image : fond blanc e-commerce, taille uniforme -->
                            <div class="bg-white d-flex align-items-center justify-content-center p-3" style="height: 300px; overflow: hidden;">
                                <img class="img-fluid" style="max-height: 100%; max-width: 100%; object-fit: contain; background: #fff;" src="{{ $product->image ? asset('storage/' . $product->image) : 'https://dummyimage.com/450x300/dee2e6/6c757d.jpg' }}" alt="{{ $product->name }}" loading="lazy" />
                            </div>
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder">{{ $product->name }}</h5>
                                    <!-- Product price-->
                                    <span>{{ number_format($product->price, 2) }} MAD</span>
                                </div>
                            </div>
                            <!-- Product actions-->
                         <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">

    <!-- Actions client -->
    <div class="d-grid gap-2 mb-3">
        <a href="{{ route('products.show', $product->id) }}"
           class="btn btn-outline-dark rounded-pill">
            <i class="bi bi-eye"></i> Voir les détails
        </a>

        <button
            class="btn btn-success rounded-pill fw-semibold"
            onclick="addToCart({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }}, '{{ $product->image ? asset('storage/' . $product->image) : 'https://dummyimage.com/450x300/dee2e6/6c757d.jpg' }}')">
            <i class="bi bi-cart-plus"></i> Ajouter au panier
        </button>
    </div>

    <!-- Actions administrateur : ADMIN uniquement, invisible pour client/guest -->
    @auth
        @if(auth()->user()->isAdmin())
            <div class="d-flex justify-content-center gap-2">
                <a href="{{ route('products.edit', $product->id) }}"
                   class="btn btn-outline-primary btn-sm rounded-pill">
                    <i class="bi bi-pencil"></i> Modifier
                </a>

                <form action="{{ route('products.destroy', $product->id) }}"
                      method="POST"
                      onsubmit="return confirm('Supprimer ce produit ?')">
                    @csrf
                    @method('DELETE')

                    <button type="submit"
                            class="btn btn-outline-danger btn-sm rounded-pill">
                        <i class="bi bi-trash"></i> Supprimer
                    </button>
                </form>
            </div>
        @endif
    @endauth

</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endsection
       