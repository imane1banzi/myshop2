@extends('layouts.app')

@section('content')
    @php
        // Mosaïque : la grande image (1re) met en avant un collier si possible
        $lead = $products->firstWhere('category', 'Colliers') ?? $products->first();
        $hero = $lead ? collect([$lead])->merge($products->where('id', '!=', $lead->id))->take(3) : collect();
        // Photo d'ambiance de l'encart « histoire » : déposer public/images/home-about.jpg
        $storyImage = file_exists(public_path('images/home-about.jpg')) ? asset('images/home-about.jpg') : null;
    @endphp

    <section class="ds-container ds-hero">
        <div class="ds-hero__grid">
            <div class="ds-hero__copy">
                <p class="ds-eyebrow ds-eyebrow--wide">Nouvelle collection</p>
                <h1 class="ds-hero__title">Des bijoux qui subliment votre style</h1>
                <p class="ds-lead">Bagues torsadées, colliers dorés, éclat garanti. Des pièces délicates en plaqué or, serties de zircons.</p>
                <div class="ds-actions" style="margin-top:8px">
                    <a href="{{ route('products.index') }}" class="ds-btn ds-btn--primary">Découvrir</a>
                    <a href="{{ route('about') }}" class="ds-btn ds-btn--secondary">Notre histoire</a>
                </div>
            </div>

            @if ($hero->isNotEmpty())
                <div class="ds-mosaic">
                    @foreach ($hero as $product)
                        <a href="{{ route('products.show', $product) }}" aria-label="{{ $product->name }}">
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <section class="ds-container" style="padding-top:var(--ds-section)">
        <div class="ds-section-head">
            <h2 class="ds-h2">Nos pièces</h2>
            <a href="{{ route('products.index') }}" class="ds-link">Voir toute la boutique</a>
        </div>
        <div class="ds-grid ds-grid--230">
            @foreach ($products as $product)
                @include('products.partials.card', ['product' => $product, 'variant' => 'home'])
            @endforeach
        </div>
    </section>

    <section class="ds-container" style="padding-top:var(--ds-section);padding-bottom:var(--ds-section)">
        <div class="ds-story">
            <div class="ds-story__media">
                @if ($storyImage)
                    <img src="{{ $storyImage }}" alt="Bijoux Myshop" loading="lazy">
                @endif
            </div>
            <div class="ds-story__body">
                <p class="ds-eyebrow ds-eyebrow--wide">Myshop</p>
                <h2 class="ds-h2">Des bijoux qui racontent votre histoire</h2>
                <p class="ds-body">Bienvenue chez Myshop : des bijoux délicats en plaqué or, sertis de zircons, photographiés en fond blanc HD pour voir chaque détail. Livraison rapide au Maroc, paiement à la livraison, échange sous 7 jours.</p>
                <a href="{{ route('about') }}" class="ds-link" style="align-self:flex-start">Découvrir notre histoire</a>
            </div>
        </div>
    </section>
@endsection
