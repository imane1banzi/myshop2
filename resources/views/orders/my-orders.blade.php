@extends('account.layout')

@section('title', 'Mes commandes · Myshop')

@section('account')
    @if ($orders->isEmpty())
        <div class="ds-empty">
            <p>Vous n'avez pas encore passé de commande.</p>
            <a href="{{ route('products.index') }}" class="ds-btn ds-btn--primary">Découvrir la boutique</a>
        </div>
    @else
        <div class="ds-orders">
            @foreach ($orders as $order)
                <div class="ds-order">
                    <div class="ds-order__id">
                        <span>#{{ $order->id }}</span>
                        <span>{{ $order->created_at->locale('fr')->translatedFormat('j M Y') }}</span>
                    </div>
                    @include('account.status-pill', ['status' => $order->status])
                    <span class="ds-order__items">{{ $order->items->pluck('product_name')->join(', ') }}</span>
                    <span class="ds-order__total">{{ number_format($order->total_price, 2, ',', ' ') }} MAD</span>
                    <a href="{{ route('my-orders.show', $order->id) }}" class="ds-btn ds-btn--sm">Détails</a>
                </div>
            @endforeach
        </div>
        <div class="ds-pagination">{{ $orders->links('pagination::default') }}</div>
    @endif
@endsection
