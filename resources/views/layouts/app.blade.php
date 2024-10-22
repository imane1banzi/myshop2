<!DOCTYPE html>
<html lang="en">
<head>
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
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="#!">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#!">About</a></li>
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
               
                    
                    <button class="btn btn-outline-dark" href="javascript:;" type="submit" id="cartModalTrigger" data-bs-toggle="modal" data-bs-target="#shoppingCartModal">
                        <i class="bi-cart-fill me-1"></i>
                        Cart
                        <span class="badge bg-dark text-white ms-1 rounded-pill">0</span>
                    </button>
                    <div class="modal fade" id="shoppingCartModal" tabindex="-1" aria-labelledby="shoppingCartModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="shoppingCartModalLabel">Shopping Cart</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              <!-- Insert your detailed cart content here -->
                              <div class="container py-5 h-100">
                                <div class="row d-flex justify-content-center align-items-center h-100">
                                  <div class="col-12">
                                    <div class="card card-registration card-registration-2" style="border-radius: 15px;">
                                      <div class="card-body p-0">
                                        <div class="row g-0">
                                          <div class="col-lg-8">
                                            <div class="p-5">
                                              <div class="d-flex justify-content-between align-items-center mb-5">
                                                <h1 class="fw-bold mb-0">Shopping Cart</h1>
                                                <h6 class="mb-0 text-muted">3 items</h6>
                                              </div>
                                              <hr class="my-4">
                                              
                                              <!-- Cart Items -->
                                              <div class="row mb-4 d-flex justify-content-between align-items-center">
                                                <div class="col-md-2 col-lg-2 col-xl-2">
                                                  <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-shopping-carts/img5.webp" class="img-fluid rounded-3" alt="Cotton T-shirt">
                                                </div>
                                                <div class="col-md-3 col-lg-3 col-xl-3">
                                                  <h6 class="text-muted">Shirt</h6>
                                                  <h6 class="mb-0">Cotton T-shirt</h6>
                                                </div>
                                                <div class="col-md-3 col-lg-3 col-xl-2 d-flex">
                                                  <button class="btn btn-link px-2" onclick="this.parentNode.querySelector('input[type=number]').stepDown()">
                                                    <i class="fas fa-minus"></i>
                                                  </button>
                                                  <input min="0" name="quantity" value="1" type="number" class="form-control form-control-sm" />
                                                  <button class="btn btn-link px-2" onclick="this.parentNode.querySelector('input[type=number]').stepUp()">
                                                    <i class="fas fa-plus"></i>
                                                  </button>
                                                </div>
                                                <div class="col-md-3 col-lg-2 col-xl-2 offset-lg-1">
                                                  <h6 class="mb-0">€ 44.00</h6>
                                                </div>
                                                <div class="col-md-1 col-lg-1 col-xl-1 text-end">
                                                  <a href="#" class="text-muted"><i class="fas fa-times"></i></a>
                                                </div>
                                              </div>
                                              
                                              <!-- Repeat Cart Items for more products -->
                                              
                                              <hr class="my-4">
                                              
                                              <div class="pt-5">
                                                <h6 class="mb-0"><a href="#" class="text-body"><i class="fas fa-long-arrow-alt-left me-2"></i>Back to shop</a></h6>
                                              </div>
                                            </div>
                                          </div>
                                          <div class="col-lg-4 bg-body-tertiary">
                                            <div class="p-5">
                                              <h3 class="fw-bold mb-5 mt-2 pt-1">Summary</h3>
                                              <hr class="my-4">
                                              <div class="d-flex justify-content-between mb-4">
                                                <h5 class="text-uppercase">items 3</h5>
                                                <h5>€ 132.00</h5>
                                              </div>
                                              <h5 class="text-uppercase mb-3">Shipping</h5>
                                              <div class="mb-4 pb-2">
                                                <select class="form-select">
                                                  <option value="1">Standard-Delivery- €5.00</option>
                                                  <option value="2">Express Delivery - €10.00</option>
                                                </select>
                                              </div>
                                              <h5 class="text-uppercase mb-3">Discount code</h5>
                                              <div class="mb-5">
                                                <input type="text" class="form-control form-control-lg" placeholder="Enter your code" />
                                              </div>
                                              <hr class="my-4">
                                              <div class="d-flex justify-content-between mb-5">
                                                <h5 class="text-uppercase">Total price</h5>
                                                <h5>€ 137.00</h5>
                                              </div>
                                              <button type="button" class="btn btn-dark btn-block btn-lg">Checkout</button>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                
                @if (Auth::check())
                <form method="POST" action="{{ route('logout') }}" class="ms-3">
                    @csrf
                    <button class="btn btn-outline-dark" type="submit">
                        <i class="bi-box-arrow-right me-1"></i>
                        Logout
                    </button>
                </form>
            @endif
            </div>
        </div>
    </nav>

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
