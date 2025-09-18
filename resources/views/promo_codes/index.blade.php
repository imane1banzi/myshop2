@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Liste des Codes Promo</h2>
    <a href="{{ route('promo_codes.create') }}" class="btn btn-success mb-3">+ Nouveau Code</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Code</th>
                <th>Type</th>
                <th>Valeur</th>
                <th>Expiration</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($promoCodes as $promo)
                <tr>
                    <td>{{ $promo->code }}</td>
                    <td>{{ $promo->type }}</td>
                    <td>{{ $promo->type == 'percent' ? $promo->value.'%' : $promo->value.' MAD' }}</td>
                    <td>{{ $promo->expires_at ?? '-' }}</td>
                    <td>
                        <a href="{{ route('promo_codes.edit', $promo->id) }}" class="btn btn-primary btn-sm">Modifier</a>
                        <form action="{{ route('promo_codes.destroy', $promo->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
