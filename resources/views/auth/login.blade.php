@extends('layouts.app')

@section('title', 'Connexion · Myshop')

@section('content')
<section class="ds-container ds-auth ds-section">
    <div class="ds-auth__card">
        <form method="POST" action="{{ route('login') }}" class="ds-auth__pane">
            @csrf
            <h1 class="ds-h1" style="font-size:40px">Connexion</h1>

            @if (session('status'))
                <div class="ds-alert" style="margin:0">{{ session('status') }}</div>
            @endif

            <label class="ds-field">E-mail
                <input type="email" name="email" class="ds-input ds-input--cream" value="{{ old('email') }}" required autofocus autocomplete="username">
                @error('email')<span class="ds-error">{{ $message }}</span>@enderror
            </label>
            <label class="ds-field">Mot de passe
                <input type="password" name="password" class="ds-input ds-input--cream" required autocomplete="current-password">
                @error('password')<span class="ds-error">{{ $message }}</span>@enderror
            </label>
            <div class="ds-auth__row">
                <label class="ds-check"><input type="checkbox" name="remember">Se souvenir de moi</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="ds-textlink" style="font-size:13px">Mot de passe oublié ?</a>
                @endif
            </div>
            <button type="submit" class="ds-btn ds-btn--primary ds-btn--tall" style="margin-top:6px">Se connecter</button>
        </form>
        <div class="ds-auth__pane ds-auth__pane--alt">
            <h2 class="ds-h2" style="font-size:32px">Pas encore de compte ?</h2>
            <p class="ds-body" style="font-size:15px">Créez votre compte pour retrouver l'historique de vos commandes et suivre vos livraisons.</p>
            <a href="{{ route('register') }}" class="ds-btn ds-btn--secondary" style="align-self:flex-start;height:50px;padding:0 28px">Créer un compte</a>
        </div>
    </div>
</section>
@endsection
