@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Modifier le Code Promo</h2>

    <form action="{{ route('promo_codes.update', $promoCode) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Code</label>
            <input
                type="text"
                name="code"
                class="form-control"
                value="{{ old('code', $promoCode->code) }}"
                required>
        </div>

        <div class="mb-3">
            <label class="form-label">Type</label>
            <select name="type" class="form-select">
                <option value="fixed" {{ old('type', $promoCode->type) == 'fixed' ? 'selected' : '' }}>
                    Montant fixe
                </option>
                <option value="percent" {{ old('type', $promoCode->type) == 'percent' ? 'selected' : '' }}>
                    Pourcentage
                </option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Valeur</label>
            <input
                type="number"
                name="value"
                class="form-control"
                step="0.01"
                value="{{ old('value', $promoCode->value) }}"
                required>
        </div>

        <div class="mb-3">
            <label class="form-label">Date d'expiration</label>
            <input
                type="date"
                name="expires_at"
                class="form-control"
                value="{{ old('expires_at', optional($promoCode->expires_at)->format('Y-m-d')) }}">
        </div>

        <button type="submit" class="btn btn-primary">
            Mettre à jour
        </button>

        <a href="{{ route('promo_codes.index') }}" class="btn btn-secondary">
            Annuler
        </a>
    </form>
</div>
@endsection