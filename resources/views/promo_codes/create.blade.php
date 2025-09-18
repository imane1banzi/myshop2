@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Ajouter un Code Promo</h2>
    <form action="{{ route('promo_codes.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Code</label>
            <input type="text" name="code" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Type</label>
            <select name="type" class="form-select">
                <option value="fixed">Montant fixe</option>
                <option value="percent">Pourcentage</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Valeur</label>
            <input type="number" name="value" class="form-control" step="0.01" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Date d'expiration</label>
            <input type="date" name="expires_at" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Enregistrer</button>
        <a href="{{ route('promo_codes.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
