@extends('layouts.app')

@section('title', 'Notre histoire · Myshop')

@section('content')
<section class="ds-container ds-section">
    <div class="ds-hero__grid">
        <div class="ds-about__img">
            <img src="{{ asset('images/couv5.png') }}" alt="Bijoux Myshop">
        </div>
        <div class="ds-stack" style="gap:24px">
            <p class="ds-eyebrow ds-eyebrow--wide">Notre histoire</p>
            <h1 class="ds-h1">L'éclat, sans compromis</h1>
            <p class="ds-body">
                Bienvenue chez Myshop, votre destination bijoux au Maroc. Nous sélectionnons des pièces intemporelles :
                bagues torsadées en plaqué or, colliers chaînes dorées, bracelets et boucles — sertis de zircons éclatants.
            </p>
            <p class="ds-body">
                Chaque bijou est photographié sur fond blanc pour que vous voyiez le vrai détail : la finition miroir,
                le sertissage, la brillance. Pas de surprise à la livraison.
            </p>
            <ul class="ds-list">
                <li>Qualité contrôlée : plaqué or, fermoirs sécurisés</li>
                <li>Livraison rapide partout au Maroc</li>
                <li>Paiement à la livraison + codes promo</li>
                <li>Échange facile sous 7 jours</li>
            </ul>
            <div class="ds-actions">
                <a href="{{ route('products.index') }}" class="ds-btn ds-btn--primary">Voir nos bijoux</a>
                <a href="{{ route('welcomepage') }}" class="ds-btn ds-btn--secondary">Retour accueil</a>
            </div>
        </div>
    </div>

    <div class="ds-features" style="margin-top:var(--ds-section)">
        <div class="ds-feature">
            <p class="ds-eyebrow">01</p>
            <h3>Sélection soignée</h3>
            <p class="ds-body" style="font-size:15px">Bagues, colliers et ensembles choisis pour leur éclat et leur tenue au quotidien.</p>
        </div>
        <div class="ds-feature">
            <p class="ds-eyebrow">02</p>
            <h3>Photos honnêtes</h3>
            <p class="ds-body" style="font-size:15px">Visuels fond blanc HD, sans retouche excessive. Ce que vous voyez, c'est ce que vous recevez.</p>
        </div>
        <div class="ds-feature">
            <p class="ds-eyebrow">03</p>
            <h3>Service client</h3>
            <p class="ds-body" style="font-size:15px">Suivi de commande, historique dans « Mes commandes », réponse rapide.</p>
        </div>
    </div>
</section>
@endsection
