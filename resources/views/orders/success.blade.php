@extends('layouts.app')

@section('title', 'Merci pour votre commande · Myshop')

@section('content')
<section class="ds-success">
    <span class="ds-success__mark" aria-hidden="true"></span>
    <h1 class="ds-h1" style="font-size:clamp(40px,5vw,56px)">Merci pour votre commande</h1>
    <p class="ds-body">
        Votre commande{{ session('order_id') ? ' #' . session('order_id') : '' }} a bien été enregistrée.
        Nous vous contacterons par téléphone pour confirmer la livraison.
    </p>
    <div class="ds-actions">
        @auth
            <a href="{{ route('my-orders.index') }}" class="ds-btn ds-btn--primary">Mes commandes</a>
        @endauth
        <a href="{{ route('products.index') }}" class="ds-btn {{ auth()->check() ? 'ds-btn--secondary' : 'ds-btn--primary' }}">Continuer mes achats</a>
    </div>
</section>
<script>
    // Vide le panier avant l'exécution de cart.js (chargé en defer)
    localStorage.removeItem('cart');
    localStorage.removeItem('discount');
</script>
@endsection
