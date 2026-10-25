@extends('layouts.app')

@section('title', 'Valider votre commande · Myshop')

@section('content')
<section class="ds-container ds-section">
    <a href="{{ route('cart') }}" class="ds-small ds-muted">← Retour au panier</a>
    <h1 class="ds-h1" style="margin:16px 0 32px">Valider votre commande</h1>

    @if ($errors->any())
        <div class="ds-alert ds-alert--error">
            Merci de vérifier les champs du formulaire.
        </div>
    @endif

    <div class="ds-empty" id="checkoutEmpty" hidden>
        <p>Votre panier est vide.</p>
        <a href="{{ route('products.index') }}" class="ds-btn ds-btn--primary">Découvrir la boutique</a>
    </div>

    <div class="ds-two-col" id="checkoutContent">
        <form method="POST" action="{{ route('checkout.place') }}" id="checkoutForm" class="ds-form">
            @csrf

            <fieldset class="ds-fieldset">
                <legend class="ds-step" style="margin-bottom:16px">1 · Coordonnées</legend>
                <div class="ds-fields">
                    <label class="ds-field">Nom complet
                        <input type="text" name="fullname" class="ds-input" value="{{ old('fullname', auth()->user()->name ?? '') }}" required autocomplete="name">
                        @error('fullname')<span class="ds-error">{{ $message }}</span>@enderror
                    </label>
                    <label class="ds-field">Téléphone
                        <input type="tel" name="phone" class="ds-input" value="{{ old('phone') }}" required autocomplete="tel">
                        @error('phone')<span class="ds-error">{{ $message }}</span>@enderror
                    </label>
                </div>
                <label class="ds-field">Adresse email
                    <input type="email" name="email" class="ds-input" value="{{ old('email', auth()->user()->email ?? '') }}" required autocomplete="email">
                    @error('email')<span class="ds-error">{{ $message }}</span>@enderror
                </label>
            </fieldset>

            <fieldset class="ds-fieldset">
                <legend class="ds-step" style="margin-bottom:16px">2 · Livraison</legend>
                <label class="ds-field">Adresse de livraison
                    <textarea name="address" rows="3" class="ds-input" required autocomplete="street-address">{{ old('address') }}</textarea>
                    @error('address')<span class="ds-error">{{ $message }}</span>@enderror
                </label>
            </fieldset>

            <fieldset class="ds-fieldset">
                <legend class="ds-step" style="margin-bottom:16px">3 · Paiement</legend>
                <div class="ds-radio">
                    <span class="ds-radio__dot" aria-hidden="true"></span>
                    <div class="ds-radio__text"><span>Paiement à la livraison</span><span>Réglez en espèces à la réception de votre colis.</span></div>
                </div>
            </fieldset>

            <input type="hidden" name="cart_data" id="cart_data">
            <input type="hidden" name="total_price" id="total_price">

            <button type="submit" class="ds-btn ds-btn--primary" style="height:56px">Valider la commande · <span id="checkoutTotalLabel"></span></button>
        </form>

        <aside class="ds-summary" id="checkoutSummary">
            <h2 class="ds-h3">Votre commande</h2>
            <div class="ds-stack" id="checkoutItems" style="gap:16px"></div>
            <div class="ds-totals" id="checkoutTotals" style="padding-top:14px"></div>
        </aside>
    </div>
</section>
@endsection
