<section class="ds-panel">
    <header class="ds-stack" style="gap:6px">
        <h2 class="ds-h3">Mot de passe</h2>
        <p class="ds-small ds-muted">Utilisez un mot de passe long et aléatoire pour sécuriser votre compte.</p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="ds-stack">
        @csrf
        @method('put')

        <label class="ds-field">Mot de passe actuel
            <input type="password" name="current_password" class="ds-input" autocomplete="current-password">
            @error('current_password', 'updatePassword')<span class="ds-error">{{ $message }}</span>@enderror
        </label>
        <label class="ds-field">Nouveau mot de passe
            <input type="password" name="password" class="ds-input" autocomplete="new-password">
            @error('password', 'updatePassword')<span class="ds-error">{{ $message }}</span>@enderror
        </label>
        <label class="ds-field">Confirmer le mot de passe
            <input type="password" name="password_confirmation" class="ds-input" autocomplete="new-password">
            @error('password_confirmation', 'updatePassword')<span class="ds-error">{{ $message }}</span>@enderror
        </label>

        <div class="ds-actions" style="align-items:center">
            <button type="submit" class="ds-btn ds-btn--primary" style="height:50px;padding:0 28px">Enregistrer</button>
            @if (session('status') === 'password-updated')
                <span class="ds-promo-msg is-ok">Enregistré.</span>
            @endif
        </div>
    </form>
</section>
