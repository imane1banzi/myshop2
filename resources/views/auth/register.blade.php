@extends('layouts.app')

@section('title', 'Créer un compte · Myshop')

@section('content')
<section class="ds-container ds-auth ds-section">
    <div class="ds-auth__card">
        <form method="POST" action="{{ route('register') }}" class="ds-auth__pane">
            @csrf
            <h1 class="ds-h1" style="font-size:40px">Créer un compte</h1>

            <label class="ds-field">Nom
                <input type="text" name="name" class="ds-input ds-input--cream" value="{{ old('name') }}" required autofocus autocomplete="name">
                @error('name')<span class="ds-error">{{ $message }}</span>@enderror
            </label>
            <label class="ds-field">E-mail
                <input type="email" name="email" class="ds-input ds-input--cream" value="{{ old('email') }}" required autocomplete="username">
                @error('email')<span class="ds-error">{{ $message }}</span>@enderror
            </label>
            <div class="ds-fields">
                <label class="ds-field">Mot de passe
                    <input type="password" name="password" class="ds-input ds-input--cream" required autocomplete="new-password">
                    @error('password')<span class="ds-error">{{ $message }}</span>@enderror
                </label>
                <label class="ds-field">Confirmer le mot de passe
                    <input type="password" name="password_confirmation" class="ds-input ds-input--cream" required autocomplete="new-password">
                    @error('password_confirmation')<span class="ds-error">{{ $message }}</span>@enderror
                </label>
            </div>
            <button type="submit" class="ds-btn ds-btn--primary ds-btn--tall" style="margin-top:6px">S'inscrire</button>
        </form>
        <div class="ds-auth__pane ds-auth__pane--alt">
            <h2 class="ds-h2" style="font-size:32px">Déjà inscrit ?</h2>
            <p class="ds-body" style="font-size:15px">Connectez-vous pour retrouver l'historique de vos commandes et suivre vos livraisons.</p>
            <a href="{{ route('login') }}" class="ds-btn ds-btn--secondary" style="align-self:flex-start;height:50px;padding:0 28px">Se connecter</a>
        </div>
    </div>
</section>
@endsection
