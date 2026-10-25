<!DOCTYPE html>
<html lang="en">
<head>
  <script src="{{ asset('js/cart.js') }}?v=4" defer></script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Myshop</title>
    <link rel="icon" type="image/png" href="{{ asset('images/mon-logo.png') }}">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Police élégante pour le logo -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
            <style>
        .brand-logo { font-family: 'Playfair Display', Georgia, serif; font-weight: 700; font-size: 1.6rem; letter-spacing: 2px; }
        .navbar-icon-btn { width: 42px; height: 42px; display: inline-flex; align-items: center; justify-content: center; border-radius: 50% !important; font-size: 1.25rem; padding: 0 !important; }
        .btn-gold { color: #b8860b; border-color: #c9a227; background-color: transparent; }
        .btn-gold:hover, .btn-gold:focus { color: #fff; background-color: #b8860b; border-color: #b8860b; }
        .btn-gold-solid { background: linear-gradient(135deg, #b8860b, #d4a017); border: none; color: #fff; font-weight: 600; }
        .btn-gold-solid:hover, .btn-gold-solid:focus { color: #fff; filter: brightness(1.06); box-shadow: 0 4px 12px rgba(184,134,11,.4); }
        .cart-header { background: linear-gradient(135deg, #9a6b0f, #c9a227 60%, #e6c15a); }
        .cart-title { font-family: 'Playfair Display', Georgia, serif; font-weight: 700; letter-spacing: 1px; }
        .cart-body-bg { background: #faf7f0; }
        #totalPriceContainer { font-family: 'Playfair Display', Georgia, serif; font-size: 1.35rem; color: #8a5f0b; }
        .cart-item { border: 1px solid #ead9a8; border-left: 4px solid #c9a227; border-radius: .9rem; background: #fff; }
        .cart-item .price { color: #9a6b0f; font-weight: 700; }
        .cart-item .item-name { font-family: 'Playfair Display', Georgia, serif; }
        .cart-empty { text-align: center; padding: 2.5rem 1rem; color: #8a6d2b; }
        .promo-card { background: #fff; border: 1px dashed #c9a227; border-radius: .9rem; }
        @media (max-width: 576px) {
            #shoppingCartModal .modal-body { max-height: 70vh; overflow-y: auto; -webkit-overflow-scrolling: touch; }
            .cart-item img { max-height: 64px !important; }
            #totalPriceContainer { font-size: 1.1rem; }
        }
        .link-gold { color: #9a6b0f; text-decoration: none; font-weight: 500; }
        .link-gold:hover { color: #7a5208; text-decoration: underline; }
        .auth-input { border-radius: .6rem; border: 1px solid #e0d3ac; }
        .auth-input:focus { border-color: #c9a227; box-shadow: 0 0 0 .2rem rgba(201,162,39,.2); }
    </style>
    <!-- Custom styles -->
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
</head>
<body>
    @unless(request()->routeIs('login'))
 <!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container px-4 px-lg-5">
        <a class="navbar-brand brand-logo" href="{{ route('welcomepage') }}">Myshop</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Basculer la navigation"><span class="navbar-toggler-icon"></span></button>
        <!-- Icônes tout à droite de la navbar : panier + authentification (toujours visibles) -->
        <div class="d-flex align-items-center gap-2 ms-auto order-lg-last">
            <!-- Cart Button (ouverture gérée en JS : openCartModal) -->
            <button class="btn btn-gold position-relative navbar-icon-btn" type="button" id="cartModalTrigger" title="Panier" aria-label="Ouvrir le panier">
                <i class="bi bi-bag-fill"></i>
                <span id="cartCountBadge" class="badge bg-danger text-white ms-1 rounded-pill position-absolute top-0 start-100 translate-middle">0</span>
            </button>
            <!-- Authentication Buttons -->
            @if (Auth::check())
                {{-- Client : son nom / Admin : son nom + Admin --}}
                @if(auth()->user()->isAdmin())
                    <span class="badge bg-danger">{{ auth()->user()->name }} — Admin</span>
                @else
                    <span class="badge bg-success">{{ auth()->user()->name }}</span>
                @endif
                <!-- Logout Button -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-gold navbar-icon-btn" type="submit" title="Déconnexion" aria-label="Se déconnecter">
                        <i class="bi bi-box-arrow-right"></i>
                    </button>
                </form>
            @else
                <!-- Login Button -->
                <button type="button" class="btn btn-gold navbar-icon-btn" data-bs-toggle="modal" data-bs-target="#loginModal" title="Connexion" aria-label="Se connecter">
                    <i class="bi bi-person-circle"></i>
                </button>
            @endif
        </div>
        <div class="collapse navbar-collapse order-lg-2" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                <li class="nav-item"><a class="nav-link active" aria-current="page" href="{{ route('welcomepage') }}">Accueil</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">À propos</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Boutique</a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="{{ route('products.index') }}">Tous les produits</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="{{ route('products.popular') }}">Articles populaires</a></li>
                        <li><a class="dropdown-item" href="{{ route('products.new-arrivals') }}">Nouveautés</a></li>
                    </ul>
                </li>
                {{-- ADMIN : accès à tout --}}
                @auth
                    @if(auth()->user()->isAdmin())
                        <li class="nav-item"><a class="nav-link fw-bold text-danger" href="{{ route('orders.index') }}">Commandes</a></li>
                        <li class="nav-item"><a class="nav-link fw-bold text-danger" href="{{ route('promo_codes.index') }}">Codes promo</a></li>
                    @else
                        {{-- CLIENT AUTHENTIFIÉ : historique personnel --}}
                        <li class="nav-item"><a class="nav-link" href="{{ route('my-orders.index') }}">Mes commandes</a></li>
                    @endif
                @endauth

        </div>
    </div>
</nav>

<!-- Cart Modal (hors navbar : une modale dans un conteneur display:none ne peut pas s'afficher) -->
<div class="modal fade" id="shoppingCartModal" tabindex="-1" aria-labelledby="shoppingCartModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 overflow-hidden" style="border-radius: 1rem;">
            <div class="modal-header cart-header text-white border-0">
                <h5 class="modal-title cart-title" id="shoppingCartModalLabel"><i class="bi bi-bag-fill me-2"></i>Panier</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body p-4 cart-body-bg">
                <div id="cartItemsContainer" class="row g-3">
                    <!-- Les détails du panier seront ajoutés ici dynamiquement avec JavaScript -->
                </div>
                <hr style="border-top: 1px solid #c9a227; opacity: .5;">
                <div class="row g-3 align-items-stretch">
                    <div class="col-md-7">
                        <div class="promo-card p-3 h-100">
                            <label for="promoCodeInput" class="form-label fw-semibold mb-2"><i class="bi bi-ticket-perforated me-1"></i>Code promo</label>
                            <div class="input-group">
                                <input type="text" id="promoCodeInput" class="form-control" placeholder="Saisissez votre code promo">
                                <button class="btn btn-success" onclick="applyPromoCode()">Appliquer</button>
                            </div>
                            <small id="promoFeedback" class="form-text"></small>
                            <button class="btn btn-outline-danger btn-sm rounded-pill mt-2" onclick="removePromoCode()" id="removePromoBtn" style="display: none;">Retirer le code promo</button>
                        </div>
                    </div>
                    <div class="col-md-5 d-flex flex-column justify-content-between text-md-end">
                        <div id="totalPriceContainer" class="fw-bold mb-3">
                            Prix total : MAD 0
                        </div>
                        <button class="btn btn-gold-solid rounded-pill px-4 py-2" onclick="proceedToCheckout()"><i class="bi bi-bag-check me-1"></i>Passer commande</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 overflow-hidden" style="border-radius: 1rem;">
            <div class="modal-header cart-header text-white border-0">
                <h5 class="modal-title cart-title" id="loginModalLabel"><i class="bi bi-person-circle me-2"></i>Connexion</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body p-4 cart-body-bg">
                <!-- Login Form -->
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Address -->
                    <div class="mb-3">
                        <input type="email" id="email" class="form-control auth-input" name="email" placeholder="E-mail" :value="old('email')" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <input type="password" id="password" class="form-control auth-input" name="password" placeholder="Mot de passe" required autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me -->
                    <div class="form-check mb-3">
                        <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                        <label class="form-check-label" for="remember_me">Se souvenir de moi</label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-gold-solid rounded-pill w-100 py-2">Se connecter</button>
                </form>

                <!-- Forgot Password Link -->
                <div class="text-center mt-3">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="btn btn-link link-gold">Mot de passe oublié ?</a>
                    @endif
                </div>

                <!-- Register Link -->
                <div class="text-center mt-3">
                    <a href="{{ route('register') }}" class="btn btn-link link-gold">Pas de compte ? Inscrivez-vous</a>
                </div>
            </div>
        </div>
    </div>
</div>




    @endunless
    

    <!-- Main content -->
    <main class="py-5">
        @yield('content')
    </main>
    @unless(request()->routeIs('login'))
    <!-- Footer visible sur tout le site -->
    <footer class="py-5 bg-dark">
        <div class="container">
            <div class="row text-white-50 small">
                <div class="col-md-4 mb-3">
                    <h6 class="text-white">Myshop</h6>
                    <p class="mb-0">Bijoux délicats en plaqué or.<br>Livraison partout au Maroc.</p>
                </div>
                <div class="col-md-4 mb-3 text-center">
                    <a href="{{ route('about') }}" class="text-white text-decoration-none me-3">À propos</a>
                    <a href="{{ route('products.index') }}" class="text-white text-decoration-none me-3">Boutique</a>
                    <a href="{{ route('checkout') }}" class="text-white text-decoration-none">Panier</a>
                </div>
                <div class="col-md-4 mb-3 text-md-end">
                    <p class="m-0">Copyright &copy; Myshop 2024</p>
                </div>
            </div>
        </div>
    </footer>
    @endunless
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="{{ asset('js/scripts.js') }}"></script>
</body>
</html>
