@extends('layouts.app')

@section('title', $title . ' · Myshop')

@section('content')
<section class="ds-container ds-section">
    <p class="ds-eyebrow" style="margin-bottom:12px">Boutique</p>
    <div class="ds-section-head">
        <h1 class="ds-h1">{{ $title }}</h1>
        {{-- Ajout produit : ADMIN uniquement --}}
        @auth
            @if (auth()->user()->isAdmin())
                <a href="{{ route('products.create') }}" class="ds-btn ds-btn--primary">Ajouter un produit</a>
            @endif
        @endauth
    </div>

    <div class="ds-filters">
        <div class="ds-chips">
            @if ($showCategories)
                <a href="{{ route('products.index', array_filter(['sort' => $sort !== 'pop' ? $sort : null])) }}" class="ds-chip {{ $category ? '' : 'is-active' }}">Tous</a>
                @foreach (\App\Models\Product::CATEGORIES as $cat)
                    <a href="{{ route('products.index', array_filter(['cat' => $cat, 'sort' => $sort !== 'pop' ? $sort : null])) }}" class="ds-chip {{ $category === $cat ? 'is-active' : '' }}">{{ $cat }}</a>
                @endforeach
            @endif
        </div>
        <form method="GET" action="{{ route('products.index') }}" class="ds-sort">
            @if ($category)
                <input type="hidden" name="cat" value="{{ $category }}">
            @endif
            <label for="sort">Trier par</label>
            <select name="sort" id="sort" class="ds-select" onchange="this.form.submit()">
                @foreach ($sorts as $value => $label)
                    <option value="{{ $value }}" {{ $sort === $value ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
            <noscript><button type="submit" class="ds-btn ds-btn--sm">OK</button></noscript>
        </form>
    </div>

    <p class="ds-small ds-muted" style="margin-bottom:20px">{{ $products->count() }} {{ $products->count() > 1 ? 'pièces' : 'pièce' }}</p>

    @if ($products->isEmpty())
        <div class="ds-empty">
            <p>Aucune pièce dans cette catégorie pour le moment.</p>
            <a href="{{ route('products.index') }}" class="ds-btn ds-btn--primary">Voir tous les produits</a>
        </div>
    @else
        <div class="ds-grid">
            @foreach ($products as $product)
                @include('products.partials.card', ['product' => $product, 'variant' => 'shop'])
            @endforeach
        </div>
    @endif
</section>
@endsection
