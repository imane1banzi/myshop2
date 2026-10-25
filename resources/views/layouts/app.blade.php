<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Myshop — bijoux délicats en plaqué or. Livraison partout au Maroc, paiement à la livraison.">
    <title>@yield('title', 'Myshop — Bijoux · Maroc')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/mon-logo.png') }}">

    {{-- Bootstrap : uniquement pour les vues admin pas encore migrées (@section('bootstrap', '1')) --}}
    @hasSection('bootstrap')
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @endif

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600&family=Jost:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="{{ asset('css/myshop.css') }}" rel="stylesheet">
    <script src="{{ asset('js/cart.js') }}" defer></script>
</head>
<body class="ds">
@php
    $navItems = [
        ['label' => 'Accueil', 'url' => route('welcomepage'), 'active' => request()->routeIs('welcomepage')],
        ['label' => 'Boutique', 'url' => route('products.index'), 'active' => request()->routeIs('products.*')],
        ['label' => 'À propos', 'url' => route('about'), 'active' => request()->routeIs('about')],
    ];
    $isAdmin = auth()->check() && auth()->user()->isAdmin();
@endphp
<div class="ds-page">
    <div class="ds-banner">Livraison partout au Maroc · Paiement à la livraison · Échange sous 7 jours</div>

    <header class="ds-header">
        <div class="ds-container ds-header__bar">
            <a href="{{ route('welcomepage') }}" class="ds-logo" aria-label="Myshop — accueil">
                <span class="ds-logo__mark"></span>
                <span class="ds-logo__text">
                    <span class="ds-logo__name">Myshop</span>
                    <span class="ds-logo__tag">Bijoux · Maroc</span>
                </span>
            </a>

            <nav class="ds-nav" aria-label="Navigation principale">
                @foreach ($navItems as $item)
                    <a href="{{ $item['url'] }}" class="ds-nav__link {{ $item['active'] ? 'is-active' : '' }}">{{ $item['label'] }}</a>
                @endforeach
                {{-- ADMIN : accès à la gestion --}}
                @if ($isAdmin)
                    <a href="{{ route('orders.index') }}" class="ds-nav__link ds-nav__link--admin {{ request()->routeIs('orders.*') ? 'is-active' : '' }}">Commandes</a>
                    <a href="{{ route('promo_codes.index') }}" class="ds-nav__link ds-nav__link--admin {{ request()->routeIs('promo_codes.*') ? 'is-active' : '' }}">Codes promo</a>
                @endif
            </nav>

            <div class="ds-header__actions">
                <a href="{{ auth()->check() ? route('my-orders.index') : route('login') }}" class="ds-iconbtn" aria-label="Mon compte">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" aria-hidden="true"><circle cx="12" cy="8" r="4"></circle><path d="M4 21c1.5-4 4.5-6 8-6s6.5 2 8 6"></path></svg>
                    <span class="ds-iconbtn__label">{{ auth()->check() ? \Illuminate\Support\Str::before(auth()->user()->name, ' ') : 'Connexion' }}</span>
                </a>
                <a href="{{ route('cart') }}" class="ds-iconbtn" aria-label="Panier">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" aria-hidden="true"><path d="M5 8h14l-1 13H6L5 8z"></path><path d="M9 8V6a3 3 0 0 1 6 0v2"></path></svg>
                    <span class="ds-iconbtn__label">Panier</span>
                    <span class="ds-badge" id="cartCountBadge">0</span>
                </a>
                <button type="button" class="ds-iconbtn ds-burger" id="dsMenuToggle" aria-label="Menu" aria-expanded="false" aria-controls="dsMobileNav">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" aria-hidden="true"><path d="M3 7h18M3 12h18M3 17h18"></path></svg>
                </button>
            </div>
        </div>
        <nav class="ds-mobile-nav" id="dsMobileNav" aria-label="Navigation mobile">
            @foreach ($navItems as $item)
                <a href="{{ $item['url'] }}">{{ $item['label'] }}</a>
            @endforeach
            @if ($isAdmin)
                <a href="{{ route('orders.index') }}">Commandes</a>
                <a href="{{ route('promo_codes.index') }}">Codes promo</a>
            @endif
        </nav>
    </header>

    <main class="ds-main">
        @yield('content')
    </main>

    <footer class="ds-footer">
        <div class="ds-container ds-footer__grid">
            <div class="ds-footer__col" style="gap:12px">
                <span class="ds-footer__brand"><span class="ds-logo__mark"></span><span>Myshop</span></span>
                <p style="line-height:1.7">Bijoux délicats en plaqué or.<br>Livraison partout au Maroc.</p>
            </div>
            <div class="ds-footer__col">
                <span class="ds-footer__title">Boutique</span>
                <a href="{{ route('products.index') }}">Tous les produits</a>
                <a href="{{ route('products.popular') }}">Articles populaires</a>
                <a href="{{ route('products.new-arrivals') }}">Nouveautés</a>
            </div>
            <div class="ds-footer__col">
                <span class="ds-footer__title">Myshop</span>
                <a href="{{ route('about') }}">À propos</a>
                <a href="{{ auth()->check() ? route('my-orders.index') : route('login') }}">Mon compte</a>
                <a href="{{ route('cart') }}">Panier</a>
            </div>
        </div>
        <div class="ds-container ds-footer__copy">Copyright &copy; Myshop 2024</div>
    </footer>

    <div class="ds-toast" id="dsToast" role="status" aria-live="polite" hidden>
        <span id="dsToastText"></span>
        <a href="{{ route('cart') }}">Voir le panier</a>
    </div>
</div>

@hasSection('bootstrap')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
@endif
@stack('scripts')
</body>
</html>
