@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <p class="text-uppercase text-muted mb-1" style="letter-spacing: 3px;">Myshope — Jewelry Shop</p>
        <h1 class="fw-bolder">Notre Histoire</h1>
        <p class="lead text-muted">Des bijoux délicats pour sublimer votre quotidien.</p>
    </div>

    <div class="row align-items-center g-5">
        <div class="col-md-6">
            <img src="{{ asset('images/couv3.jpg') }}" class="img-fluid rounded shadow" alt="Myshope bijoux">
        </div>
        <div class="col-md-6">
            <h3 class="fw-bold mb-3">L'éclat, sans compromis</h3>
            <p>
                Bienvenue chez <strong>Myshope</strong>, votre destination bijoux au Maroc.
                Nous sélectionnons des pièces intemporelles : bagues torsadées en plaqué or,
                colliers chaînes dorées, bracelets et boucles — sertis de zircons éclatants.
            </p>
            <p>
                Chaque bijou est photographié sur fond blanc pour que vous voyiez le vrai détail :
                la finition miroir, le sertissage, la brillance. Pas de surprise à la livraison.
            </p>
            <ul class="list-unstyled mt-3">
                <li class="mb-2">✨ Qualité contrôlée : plaqué or, fermoirs sécurisés</li>
                <li class="mb-2">📦 Livraison rapide partout au Maroc</li>
                <li class="mb-2">💳 Paiement à la livraison + codes promo</li>
                <li class="mb-2">↩️ Échange facile sous 7 jours</li>
            </ul>
            <div class="mt-4">
                <a href="{{ route('products.index') }}" class="btn btn-dark rounded-pill px-4">Voir nos bijoux</a>
                <a href="{{ route('welcomepage') }}#about-preview" class="btn btn-outline-dark rounded-pill px-4 ms-2">Retour accueil</a>
            </div>
        </div>
    </div>

    <div class="row text-center mt-5 g-4">
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm p-4">
                <h4>💎</h4>
                <h5 class="fw-bold">Sélection soignée</h5>
                <p class="text-muted mb-0">Bagues, colliers et ensembles choisis pour leur éclat et leur tenue au quotidien.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm p-4">
                <h4>📸</h4>
                <h5 class="fw-bold">Photos honnêtes</h5>
                <p class="text-muted mb-0">Visuels fond blanc HD, sans retouche excessive. Ce que vous voyez, c'est ce que vous recevez.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm p-4">
                <h4>🤝</h4>
                <h5 class="fw-bold">Service client</h5>
                <p class="text-muted mb-0">Suivi de commande, historique dans « Mes commandes », réponse rapide.</p>
            </div>
        </div>
    </div>
</div>
@endsection
