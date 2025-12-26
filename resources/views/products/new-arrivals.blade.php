@extends('layouts.app')

@section('content')

<section class="py-5">
    <div class="container px-4 px-lg-5 my-5">

        <!-- Titre + sélecteur pagination -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bolder">Nouveaux produits</h2>

            <form method="GET" action="{{ route('products.new-arrivals') }}">
                <label class="me-2">Produits par page :</label>
                <select name="per_page"
                        class="form-select d-inline-block w-auto"
                        onchange="this.form.submit()">
                    <option value="5" {{ $perPage == 5 ? 'selected' : '' }}>5</option>
                    <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                    <option value="15" {{ $perPage == 15 ? 'selected' : '' }}>15</option>
                </select>
            </form>
        </div>

        <div class="row gx-4 gx-lg-5 justify-content-center">

            @foreach ($newArrivals as $product)
            <div class="col-md-3 mb-5">
                <div class="card h-100 position-relative">

                    <!-- 🔥 Badge NEW -->
                    @if($product->created_at->gte(now()->subDays(7)))
                        <div class="badge bg-danger text-white position-absolute"
                             style="top: 0.5rem; right: 0.5rem">
                            NEW
                        </div>
                    @endif

                    <!-- Product image -->
                    <img class="card-img-top"
                         src="{{ $product->image 
                            ? asset('storage/' . $product->image) 
                            : 'https://dummyimage.com/450x300/dee2e6/6c757d.jpg' }}"
                         alt="{{ $product->name }}" />

                    <!-- Product details -->
                    <div class="card-body p-4">
                        <div class="text-center">
                            <h5 class="fw-bolder">{{ $product->name }}</h5>
                            <span>{{ number_format($product->price, 2) }} MAD</span>
                        </div>
                    </div>

                    <!-- Product actions -->
                    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                        <div class="text-center">

                            <a class="btn btn-outline-dark mt-auto"
                               href="{{ route('products.show', $product->id) }}">
                                Voir détails
                            </a>

                            <!-- 🛒 JS Add to Cart -->
                            <button class="btn btn-success mt-auto"
                                onclick="addToCart(
                                    {{ $product->id }},
                                    '{{ $product->name }}',
                                    {{ $product->price }},
                                    '{{ $product->image 
                                        ? asset('storage/' . $product->image) 
                                        : 'https://dummyimage.com/450x300/dee2e6/6c757d.jpg' }}'
                                )">
                                Add to Cart
                            </button>

                        </div>
                    </div>
                </div>
            </div>
            @endforeach

        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $newArrivals->links() }}
        </div>

    </div>
</section>

@endsection
