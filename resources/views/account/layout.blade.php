{{-- Gabarit « Mon compte » : menu latéral + contenu (@section('account')) --}}
@extends('layouts.app')

@section('content')
<section class="ds-container ds-section">
    <p class="ds-eyebrow" style="margin-bottom:12px">Mon compte</p>
    <h1 class="ds-h1" style="margin-bottom:32px">@yield('account_title', 'Bonjour, ' . \Illuminate\Support\Str::before(auth()->user()->name, ' '))</h1>
    <div class="ds-account">
        <nav class="ds-account__nav" aria-label="Mon compte">
            <a href="{{ route('my-orders.index') }}" class="{{ request()->routeIs('my-orders.*') ? 'is-active' : '' }}">Mes commandes</a>
            <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.*') ? 'is-active' : '' }}">Profil</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">Déconnexion</button>
            </form>
        </nav>
        <div class="ds-account__content">
            @yield('account')
        </div>
    </div>
</section>
@endsection
