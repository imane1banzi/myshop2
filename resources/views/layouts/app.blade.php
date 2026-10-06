<!DOCTYPE html>
<html lang="en">
<head>
  <script src="{{ asset('js/cart.js') }}" defer></script>
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
    <!-- Custom styles -->
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
</head>
<body>
    @unless(request()->routeIs('login'))
 <!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container px-4 px-lg-5">
        <a class="navbar-brand" href="{{ route('welcomepage') }}">Myshop</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Basculer la navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
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
            
            <!-- Cart Button -->
            <button class="btn btn-outline-dark position-relative" type="button" id="cartModalTrigger" data-bs-toggle="modal" data-bs-target="#shoppingCartModal">
                <i class="bi-cart-fill me-1"></i>
                Panier
                <span id="cartCountBadge" class="badge bg-danger text-white ms-1 rounded-pill position-absolute top-0 start-100 translate-middle">0</span>
            </button>
            
            <!-- Cart Modal -->
            <div class="modal fade" id="shoppingCartModal" tabindex="-1" aria-labelledby="shoppingCartModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header bg-dark text-white">
                            <h5 class="modal-title" id="shoppingCartModalLabel">Panier</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                        </div>
                        <div class="modal-body">
                            <div id="cartItemsContainer" class="row g-3">
                                <!-- Les détails du panier seront ajoutés ici dynamiquement avec JavaScript -->
                            </div>
                            <div id="totalPriceContainer" class="text-end fw-bold mt-4 fs-5">
                                Prix total : MAD 0
                            </div>
                            <div class="d-flex justify-content-end mt-3">
                                <!-- Promo Code Section -->
                                <div class="mb-3">
                                    <label for="promoCodeInput" class="form-label">Code promo</label>
                                    <div class="input-group">
                                        <input type="text" id="promoCodeInput" class="form-control" placeholder="Saisissez votre code promo">
                                        <button class="btn btn-success" onclick="applyPromoCode()">Appliquer</button>
                                        <button class="btn btn-outline-danger" onclick="removePromoCode()" id="removePromoBtn" style="display: none;">Retirer le code promo</button>
                                        <button class="btn btn-primary" onclick="proceedToCheckout()">Passer commande</button>
                                    </div>
                                    <small id="promoFeedback" class="form-text"></small>
                                </div>
                                
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            

            <!-- Authentication Buttons -->
            @if (Auth::check())
                {{-- Client : son nom / Admin : son nom + Admin --}}
                @if(auth()->user()->isAdmin())
                    <span class="badge bg-danger ms-3">{{ auth()->user()->name }} — Admin</span>
                @else
                    <span class="badge bg-success ms-3">{{ auth()->user()->name }}</span>
                @endif
                <!-- Logout Button -->
                <form method="POST" action="{{ route('logout') }}" class="ms-3">
                    @csrf
                    <button class="btn btn-outline-dark" type="submit">
                        <i class="bi-box-arrow-right me-1"></i>
                        Déconnexion
                    </button>
                </form>
            @else
                {{-- Invité : rien, juste Login --}}
                <!-- Login Button -->
                <button class="btn btn-outline-dark ms-3" data-bs-toggle="modal" data-bs-target="#loginModal">
                    <i class="bi-box-arrow-in-right me-1"></i>
                    Connexion
                </button>
            @endif
        </div>
    </div>
</nav>

<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="loginModalLabel">Connexion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">
                <!-- Login Form -->
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Address -->
                    <div class="mb-3">
                        <input type="email" id="email" class="form-control" name="email" placeholder="E-mail" :value="old('email')" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <input type="password" id="password" class="form-control" name="password" placeholder="Mot de passe" required autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me -->
                    <div class="form-check mb-3">
                        <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                        <label class="form-check-label" for="remember_me">Se souvenir de moi</label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary w-100">Se connecter</button>
                </form>

                <!-- Forgot Password Link -->
                <div class="text-center mt-3">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="btn btn-link">Mot de passe oublié ?</a>
                    @endif
                </div>

                <!-- Register Link -->
                <div class="text-center mt-3">
                    <a href="{{ route('register') }}" class="btn btn-link">Pas de compte ? Inscrivez-vous</a>
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
