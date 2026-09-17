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
                    <div class="carousel-inner rounded shadow">
                        <div class="carousel-item active">
                            <a href="{{ route('products.index') }}" class="d-block position-relative text-decoration-none">
                                <img src="{{ asset('images/couv4.png') }}" class="d-block w-100" alt="My Shope - Des bijoux qui subliment votre style">
                                {{-- Zone cliquable sur le bouton DÉCOUVRIR incrusté en bas à droite --}}
                                <span style="position:absolute; right:3%; bottom:6%; width:24%; height:14%; cursor:pointer;" aria-hidden="true"></span>
                            </a>
                        </div>
                        <div class="carousel-item">
                            <a href="{{ route('products.index') }}" class="d-block position-relative text-decoration-none">
                                <img src="{{ asset('images/couv6.jpg') }}" class="d-block w-100" alt="My Shope - Elegance et raffinement">
                                {{-- Zone cliquable sur le bouton DÉCOUVRIR incrusté --}}
                                <span style="position:absolute; right:3%; bottom:6%; width:24%; height:14%; cursor:pointer;" aria-hidden="true"></span>
                            </a>
                        </div>
                        <div class="carousel-item">
                            <a href="{{ route('products.index') }}" class="d-block text-decoration-none">
                                <img src="{{ asset('images/couv5.jpg') }}" class="d-block w-100" alt="Myshope - Collection exclusive">
                            </a>
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

    <!-- About Section : aperçu, page complète sur /about -->
    <section id="about-preview" class="py-5 bg-light">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center">
                <p class="text-uppercase text-muted mb-1" style="letter-spacing: 3px;">Myshope — Jewelry Shop</p>
                <h2 class="fw-bolder">Des bijoux qui racontent votre histoire</h2>
                <p class="lead text-muted">Bagues torsadées, colliers dorés, éclat garanti.</p>
                <p>
                    Bienvenue chez <strong>Myshope</strong> : des bijoux délicats en plaqué or,
                    sertis de zircons, photographiés en fond blanc HD pour voir chaque détail.
                    Livraison rapide au Maroc, paiement à la livraison, échange sous 7 jours.
                </p>
                <a href="{{ route('about') }}" class="btn btn-dark rounded-pill px-4 mt-2">Découvrir notre histoire</a>
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
                            <!-- Product image : fond blanc uniforme -->
                            <div class="bg-white d-flex align-items-center justify-content-center p-3" style="height: 280px; overflow: hidden;">
                                <img style="max-height: 100%; max-width: 100%; object-fit: contain;" src="{{ $product->image ? asset('storage/' . $product->image) : 'https://dummyimage.com/450x300/dee2e6/6c757d.jpg' }}" alt="{{ $product->name }}" loading="lazy" />
                            </div>
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
                                    <button class="btn btn-success mt-auto" onclick="addToCart({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }}, '{{ $product->image ? asset('storage/' . $product->image) : 'https://dummyimage.com/450x300/dee2e6/6c757d.jpg' }}')">
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
