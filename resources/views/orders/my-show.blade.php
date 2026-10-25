@extends('account.layout')

@section('title', 'Commande #' . $order->id . ' · Myshop')
@section('account_title', 'Commande #' . $order->id)

@section('account')
    <dl class="ds-dl">
        <div><dt>Date</dt><dd>{{ $order->created_at->locale('fr')->translatedFormat('j F Y à H:i') }}</dd></div>
        <div><dt>Statut</dt><dd>@include('account.status-pill', ['status' => $order->status])</dd></div>
        @if ($order->delivery_comment)
            <div><dt>Message livreur</dt><dd>{{ $order->delivery_comment }}</dd></div>
        @endif
        <div><dt>Livraison</dt><dd>{{ $order->address }}</dd></div>
        <div><dt>Total</dt><dd>{{ number_format($order->total_price, 2, ',', ' ') }} MAD</dd></div>
    </dl>

    <h2 class="ds-h3" style="margin-bottom:16px">Articles</h2>
    <div style="overflow-x:auto">
        <table class="ds-table">
            <thead>
                <tr><th>Produit</th><th>Prix</th><th>Qté</th><th>Sous-total</th></tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                    <tr>
                        <td>{{ $item->product_name }}</td>
                        <td>{{ number_format($item->product_price, 2, ',', ' ') }} MAD</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->product_price * $item->quantity, 2, ',', ' ') }} MAD</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <a href="{{ route('my-orders.index') }}" class="ds-link" style="margin-top:32px">← Retour à mes commandes</a>
@endsection
