@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="alert alert-success text-center">
        <h1>Merci pour votre commande !</h1>
        <p>Votre commande a été enregistrée avec succès.</p>
        <a href="{{ url('/') }}" class="btn btn-primary mt-3">Retour à la boutique</a>
    </div>
</div>
<script>
    // Vider le panier du localStorage
    localStorage.removeItem('cart');
    localStorage.removeItem('promoCode'); // si tu utilises aussi un code promo

    // Tu peux aussi forcer le rafraîchissement du panier sur d'autres pages
</script>
@endsection
