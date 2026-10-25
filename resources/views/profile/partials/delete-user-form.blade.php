<section class="ds-panel">
    <header class="ds-stack" style="gap:6px">
        <h2 class="ds-h3">Supprimer le compte</h2>
        <p class="ds-small ds-muted">Une fois votre compte supprimé, toutes ses données seront définitivement effacées. Saisissez votre mot de passe pour confirmer.</p>
    </header>

    <form method="post" action="{{ route('profile.destroy') }}" class="ds-stack"
          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer votre compte ?')">
        @csrf
        @method('delete')

        <label class="ds-field">Mot de passe
            <input type="password" name="password" class="ds-input" autocomplete="current-password">
            @error('password', 'userDeletion')<span class="ds-error">{{ $message }}</span>@enderror
        </label>

        <button type="submit" class="ds-btn ds-btn--danger" style="height:50px;padding:0 28px">Supprimer le compte</button>
    </form>
</section>
