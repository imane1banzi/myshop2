@extends('layouts.app')

@section('content')

<section class="py-5">
    <div class="container px-4 px-lg-5 my-5">

        <h2 class="fw-bolder text-center mb-4">
            Produits les plus populaires
        </h2>

        <div class="row gx-4 gx-lg-5 justify-content-center">

            @foreach ($popularProducts as $item)
                @php $product = $item->product; @endphp

                @if($product)
                <div class="col-md-3 mb-5">
                    <div class="card h-100 position-relative">

                        <!-- 🔥 Badge POPULAR -->
                        <div class="badge bg-dark text-white position-absolute"
                             style="top: 0.5rem; right: 0.5rem">
                            Popular
                        </div>

                        <img class="card-img-top"
                             src="{{ $product->image_url }}"
                             alt="{{ $product->name }}" />

                        <!-- Product details -->
                        <div class="card-body p-4">
                            <div class="text-center">
                                <h5 class="fw-bolder">{{ $product->name }}</h5>
                                <span>{{ number_format($product->price, 2) }} MAD</span>
                                <div class="mt-2">
                                    <small class="text-muted">
                                        Vendus : {{ $item->total_sold }}
                                    </small>
                                </div>
                            </div>
                        </div>

                        <!-- Product actions -->
                        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                            <div class="text-center">

                                <a class="btn btn-outline-dark mt-auto"
                                   href="{{ route('products.show', $product->id) }}">
                                    Voir détails
                                </a>

                                <button class="btn btn-success mt-auto"
                                    onclick="addToCart(
                                        {{ $product->id }},
                                        '{{ addslashes($product->name) }}',
                                        {{ $product->price }},
                                        '{{ $product->image_url }}'
                                    )">
                                    Add to Cart
                                </button>

                            </div>
                        </div>

                    </div>
                </div>
                @endif
            @endforeach

        </div>

    </div>
</section>

@endsection
