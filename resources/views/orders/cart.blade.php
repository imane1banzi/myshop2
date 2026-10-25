@extends('layouts.app')

@section('title', 'Panier · Myshop')

@section('content')
{{-- Rendu côté client depuis le localStorage : voir renderCartPage() dans public/js/cart.js --}}
<section class="ds-container ds-section" id="cartPage">
    <h1 class="ds-h1" style="margin-bottom:32px">Panier</h1>

    <div class="ds-empty" id="cartEmpty">
        <p>Votre panier est vide.</p>
        <a href="{{ route('products.index') }}" class="ds-btn ds-btn--primary">Découvrir la boutique</a>
    </div>

    <div class="ds-two-col" id="cartFull" hidden>
        <div class="ds-lines" id="cartItemsContainer"></div>

        <aside class="ds-summary">
            <h2 class="ds-h3">Récapitulatif</h2>
            <div class="ds-stack" style="gap:8px">
                <label for="promoCodeInput" class="ds-summary__label">Code promo</label>
                <div class="ds-promo">
                    <input type="text" id="promoCodeInput" placeholder="Saisissez votre code" autocomplete="off">
                    <button type="button" id="promoButton" onclick="togglePromoCode()">Appliquer</button>
                </div>
                <span id="promoFeedback" class="ds-promo-msg" role="status" hidden></span>
            </div>
            <div class="ds-totals" id="cartTotals"></div>
            <button type="button" class="ds-btn ds-btn--primary ds-btn--tall" onclick="proceedToCheckout()">Passer commande</button>
            <p class="ds-muted" style="font-size:12px;text-align:center">Paiement à la livraison</p>
        </aside>
    </div>
</section>
@endsection
