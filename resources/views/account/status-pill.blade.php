@php
    $status = $status ?? 'en attente';
    $modifier = match ($status) {
        'en cours' => 'ds-pill--shipping',
        'livrée' => 'ds-pill--done',
        'retour', 'problème' => 'ds-pill--issue',
        default => '',
    };
@endphp
<span class="ds-pill {{ $modifier }}">{{ \Illuminate\Support\Str::ucfirst($status) }}</span>
