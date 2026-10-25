{{-- Carte produit. $variant : 'home' (bouton « + ») ou 'shop' (catégorie + bouton pleine largeur) --}}
@php $variant = $variant ?? 'shop'; @endphp
<article class="ds-card">
    <a href="{{ route('products.show', $product) }}" class="ds-card__media">
        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" loading="lazy">
        @if ($product->is_new)
            <span class="ds-card__tag">Nouveau</span>
        @endif
    </a>

    @if ($variant === 'home')
        <div class="ds-card__row">
            <div class="ds-card__info">
                <a href="{{ route('products.show', $product) }}" class="ds-card__name">{{ $product->name }}</a>
                <span class="ds-card__price">{{ $product->price_label }}</span>
            </div>
            <button type="button" class="ds-card__plus" title="Ajouter au panier" aria-label="Ajouter {{ $product->name }} au panier"
                    data-add-to-cart data-id="{{ $product->id }}" data-name="{{ $product->name }}" data-price="{{ $product->price }}" data-image="{{ $product->image_url }}">+</button>
        </div>
    @else
        <div class="ds-card__info">
            @if ($product->category)
                <span class="ds-card__cat">{{ $product->category }}</span>
            @endif
            <a href="{{ route('products.show', $product) }}" class="ds-card__name ds-card__name--lg">{{ $product->name }}</a>
            <span class="ds-card__price">{{ $product->price_label }}</span>
        </div>
        <button type="button" class="ds-card__add"
                data-add-to-cart data-id="{{ $product->id }}" data-name="{{ $product->name }}" data-price="{{ $product->price }}" data-image="{{ $product->image_url }}">Ajouter au panier</button>

        {{-- Actions administrateur : invisibles pour client/guest --}}
        @auth
            @if (auth()->user()->isAdmin())
                <div class="ds-card__admin">
                    <a href="{{ route('products.edit', $product) }}" class="ds-btn ds-btn--sm">Modifier</a>
                    <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Supprimer ce produit ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="ds-btn ds-btn--sm ds-btn--danger">Supprimer</button>
                    </form>
                </div>
            @endif
        @endauth
    @endif
</article>
