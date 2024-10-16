<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Welcome to My Application')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <header>
        <!-- Navigation Menu -->
        @auth
            <nav>
                <a href="{{ route('products.index') }}">Products</a>
                <a href="{{ route('logout') }}" 
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </nav>
        @endauth
    </header>

    <main>
       
            @yield('content') <!-- This will load other pages content -->
    
    </main>

    <footer>
        <!-- Footer content (optional) -->
    </footer>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
