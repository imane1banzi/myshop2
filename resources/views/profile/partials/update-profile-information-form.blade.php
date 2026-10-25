<section class="ds-panel">
    <header class="ds-stack" style="gap:6px">
        <h2 class="ds-h3">Informations du profil</h2>
        <p class="ds-small ds-muted">Mettez à jour votre nom et l'adresse e-mail de votre compte.</p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="ds-stack">
        @csrf
        @method('patch')

        <label class="ds-field">Nom
            <input type="text" name="name" class="ds-input" value="{{ old('name', $user->name) }}" required autocomplete="name">
            @error('name')<span class="ds-error">{{ $message }}</span>@enderror
        </label>
        <label class="ds-field">E-mail
            <input type="email" name="email" class="ds-input" value="{{ old('email', $user->email) }}" required autocomplete="username">
            @error('email')<span class="ds-error">{{ $message }}</span>@enderror
        </label>

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <p class="ds-small ds-muted">
                Votre adresse e-mail n'est pas vérifiée.
                <button form="send-verification" class="ds-textlink" style="font-size:13px">Renvoyer le lien de vérification.</button>
            </p>
            @if (session('status') === 'verification-link-sent')
                <p class="ds-promo-msg is-ok">Un nouveau lien de vérification a été envoyé à votre adresse e-mail.</p>
            @endif
        @endif

        <div class="ds-actions" style="align-items:center">
            <button type="submit" class="ds-btn ds-btn--primary" style="height:50px;padding:0 28px">Enregistrer</button>
            @if (session('status') === 'profile-updated')
                <span class="ds-promo-msg is-ok">Enregistré.</span>
            @endif
        </div>
    </form>
</section>
