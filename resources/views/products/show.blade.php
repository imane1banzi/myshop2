@extends('layouts.app')

@section('title', $product->name . ' · Myshop')

@section('content')
<section class="ds-container" style="padding-top:clamp(20px,3vw,32px);padding-bottom:var(--ds-section)">
    <nav class="ds-crumbs" aria-label="Fil d'Ariane">
        <a href="{{ route('welcomepage') }}">Accueil</a><span>/</span>
        <a href="{{ route('products.index') }}">Boutique</a><span>/</span>
        <span>{{ $product->name }}</span>
    </nav>

    <div class="ds-pdp">
        <div class="ds-pdp__media">
            <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
        </div>
        <div class="ds-pdp__info">
            <div class="ds-stack" style="gap:12px">
                @if ($product->category)
                    <span class="ds-eyebrow">{{ $product->category }}</span>
                @endif
                <h1 class="ds-pdp__title">{{ $product->name }}</h1>
                <span class="ds-pdp__price">{{ $product->price_label }}</span>
            </div>
            <p class="ds-body">{{ $product->description }}</p>
            <div class="ds-buy">
                <div class="ds-stepper">
                    <button type="button" data-qty-step="-1" data-qty-target="#pdpQty" aria-label="Diminuer la quantité">−</button>
                    <output id="pdpQty" aria-label="Quantité">1</output>
                    <button type="button" data-qty-step="1" data-qty-target="#pdpQty" aria-label="Augmenter la quantité">+</button>
                </div>
                <button type="button" class="ds-btn ds-btn--primary ds-btn--tall"
                        data-add-to-cart data-qty-from="#pdpQty" data-id="{{ $product->id }}" data-name="{{ $product->name }}" data-price="{{ $product->price }}" data-image="{{ $product->image_url }}">Ajouter au panier</button>
            </div>
            <div class="ds-specs">
                <div><span>Livraison</span><span>Partout au Maroc</span></div>
                <div><span>Paiement</span><span>À la livraison</span></div>
                <div><span>Échange</span><span>Sous 7 jours</span></div>
            </div>
            @auth
                @if (auth()->user()->isAdmin())
                    <a href="{{ route('products.edit', $product) }}" class="ds-btn ds-btn--sm" style="align-self:flex-start">Modifier ce produit</a>
                @endif
            @endauth
        </div>
    </div>

    @if ($related->isNotEmpty())
        <div class="ds-related">
            <h2>Vous aimerez aussi</h2>
            <div class="ds-grid ds-grid--220">
                @foreach ($related as $item)
                    <a href="{{ route('products.show', $item) }}" class="ds-card">
                        <span class="ds-card__media"><img src="{{ $item->image_url }}" alt="{{ $item->name }}" loading="lazy"></span>
                        <span class="ds-card__name">{{ $item->name }}</span>
                        <span class="ds-card__price" style="margin-top:-6px">{{ $item->price_label }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</section>
@endsection
