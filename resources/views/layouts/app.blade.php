<!DOCTYPE html>
<html lang="en">
<head>
  <script src="{{ asset('js/cart.js') }}" defer></script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>MyShop</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/favicon.ico') }}">
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
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                <li class="nav-item"><a class="nav-link active" aria-current="page" href="{{ route('welcomepage') }}">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Shop</a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="{{ route('products.index') }}">All Products</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="#!">Popular Items</a></li>
                        <li><a class="dropdown-item" href="#!">New Arrivals</a></li>
                    </ul>
                </li>
            </ul>
            
            <!-- Cart Button -->
            <button class="btn btn-outline-dark position-relative" type="button" id="cartModalTrigger" data-bs-toggle="modal" data-bs-target="#shoppingCartModal">
                <i class="bi-cart-fill me-1"></i>
                Cart
                <span class="badge bg-danger text-white ms-1 rounded-pill position-absolute top-0 start-100 translate-middle">0</span>
            </button>
            
            <!-- Cart Modal -->
            <div class="modal fade" id="shoppingCartModal" tabindex="-1" aria-labelledby="shoppingCartModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header bg-dark text-white">
                            <h5 class="modal-title" id="shoppingCartModalLabel">Shopping Cart</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div id="cartItemsContainer" class="row g-3">
                                <!-- Cart details will be added here dynamically with JavaScript -->
                            </div>
                            <div id="totalPriceContainer" class="text-end fw-bold mt-4 fs-5">
                                Total Price: MAD 0
                            </div>
                            <div class="d-flex justify-content-end mt-3">
                                <!-- Promo Code Section -->
                                <div class="mb-3">
                                    <label for="promoCodeInput" class="form-label">Promo Code</label>
                                    <div class="input-group">
                                        <input type="text" id="promoCodeInput" class="form-control" placeholder="Enter promo code">
                                        <button class="btn btn-success" onclick="applyPromoCode()">Apply</button>
                                        <button class="btn btn-outline-danger" onclick="removePromoCode()" id="removePromoBtn" style="display: none;">Remove Promo Code</button>
                                        <button class="btn btn-primary" onclick="proceedToCheckout()">Proceed to Checkout</button>
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
                <!-- Logout Button -->
                <form method="POST" action="{{ route('logout') }}" class="ms-3">
                    @csrf
                    <button class="btn btn-outline-dark" type="submit">
                        <i class="bi-box-arrow-right me-1"></i>
                        Logout
                    </button>
                </form>
            @else
                <!-- Login Button -->
                <button class="btn btn-outline-dark ms-3" data-bs-toggle="modal" data-bs-target="#loginModal">
                    <i class="bi-box-arrow-in-right me-1"></i>
                    Login
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
                <h5 class="modal-title" id="loginModalLabel">Login</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Login Form -->
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Address -->
                    <div class="mb-3">
                        <input type="email" id="email" class="form-control" name="email" placeholder="Email" :value="old('email')" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <input type="password" id="password" class="form-control" name="password" placeholder="Password" required autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me -->
                    <div class="form-check mb-3">
                        <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                        <label class="form-check-label" for="remember_me">Remember me</label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary w-100">Log In</button>
                </form>

                <!-- Forgot Password Link -->
                <div class="text-center mt-3">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="btn btn-link">Forgot Password?</a>
                    @endif
                </div>

                <!-- Register Link -->
                <div class="text-center mt-3">
                    <a href="{{ route('register') }}" class="btn btn-link">Don't have an account? Register</a>
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
    <!-- Footer -->
    <footer class="py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; MyShop 2023</p>
        </div>
    </footer>
    @endunless
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="{{ asset('js/scripts.js') }}"></script>
</body>
</html>
