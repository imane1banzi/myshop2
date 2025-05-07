@extends('layouts.app')

@section('content')
    <!-- Header-->
    <header class="py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="../images/couverture.png" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="../images/couverture.png" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="../images/couverture.png" class="d-block w-100" alt="...">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- About Section -->
    <section id="about" class="py-5 bg-light">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center">
                <h2 class="fw-bolder">About Us</h2>
                <p class="lead text-muted">Discover the finest accessories to complement your lifestyle.</p>
                <p>
                    Welcome to our e-commerce platform, your one-stop destination for high-quality, stylish accessories. 
                    We are committed to offering a curated selection of products that cater to your unique tastes and needs. 
                    Whether you're searching for the latest fashion trends, practical everyday items, or special gifts for loved ones, 
                    our store has something for everyone.
                </p>
                <p>
                    Our mission is to provide an enjoyable shopping experience by combining quality products with exceptional service. 
                    We pride ourselves on competitive pricing, fast shipping, and a customer-centric approach. Thank you for choosing us, 
                    and we look forward to serving you!
                </p>
            </div>
        </div>
    </section>

    <!-- Product Section -->
    <section class="py-5" style="margin-top: 10px;">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                @foreach ($products as $product)
                    <div class="col mb-5">
                        <div class="card h-100">
                            <!-- Product image -->
                            <img class="card-img-top" src="{{ $product->image ? asset('storage/' . $product->image) : 'https://dummyimage.com/450x300/dee2e6/6c757d.jpg' }}" alt="{{ $product->name }}" />
                            <!-- Product details -->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name -->
                                    <h5 class="fw-bolder">{{ $product->name }}</h5>
                                    <!-- Product price -->
                                    {{ number_format($product->price, 2) }} MAD
                                </div>
                            </div>
                            <!-- Product actions -->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center">
                                    <!-- View Options button -->
                                    <a class="btn btn-outline-dark mt-auto" style="margin-bottom: 10px" href="{{ route('products.show', $product->id) }}">View options</a>
                                    
                                    <!-- Add to Cart button with an encouraging color -->
                                    <button class="btn btn-success mt-auto" onclick="addToCart({{ $product->id }}, '{{ $product->name }}', {{ $product->price }}, '{{ $product->image ? asset('storage/' . $product->image) : 'https://dummyimage.com/450x300/dee2e6/6c757d.jpg' }}')">
                                        Add to Cart
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
