@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h2 class="mb-4">Valider votre commande</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('checkout.place') }}" id="checkoutForm">
        @csrf

        <div class="mb-3">
            <label for="fullname" class="form-label">Nom complet</label>
            <input type="text" name="fullname" id="fullname" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Adresse email</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Téléphone</label>
            <input type="text" name="phone" id="phone" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Adresse de livraison</label>
            <textarea name="address" id="address" class="form-control" rows="3" required></textarea>
        </div>

        <input type="hidden" name="cart_data" id="cart_data">
        <input type="hidden" name="total_price" id="total_price">

        <button type="submit" class="btn btn-primary">Valider la commande</button>
    </form>
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const form = document.getElementById("checkoutForm");
        const cart = JSON.parse(localStorage.getItem("cart")) || [];
        const discount = parseFloat(localStorage.getItem("discount")) || 0;

        const total = cart.reduce((sum, item) => sum + item.price * item.quantity, 0);
        const finalPrice = total * (1 - discount);

        // Injecte les données cachées dans le formulaire
        document.getElementById("cart_data").value = JSON.stringify(cart);
        document.getElementById("total_price").value = finalPrice.toFixed(2);
    });
</script>
@endsection
