@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Commande #{{ $order->id }}</h2>

    <ul class="list-group mb-3">
        <li class="list-group-item"><strong>Date :</strong> {{ $order->created_at->format('Y-m-d H:i') }}</li>
        <li class="list-group-item"><strong>Statut :</strong> {{ $order->status ?? 'en attente' }}</li>
        @if($order->delivery_comment)
            <li class="list-group-item"><strong>Message livreur :</strong> {{ $order->delivery_comment }}</li>
        @endif
        <li class="list-group-item"><strong>Total :</strong> MAD {{ number_format($order->total_price, 2) }}</li>
    </ul>

    <h4>Articles</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Produit</th>
                <th>Prix</th>
                <th>Qté</th>
                <th>Sous-total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->items as $item)
            <tr>
                <td>{{ $item->product_name }}</td>
                <td>{{ number_format($item->product_price, 2) }} MAD</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->product_price * $item->quantity, 2) }} MAD</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('my-orders.index') }}" class="btn btn-secondary">Retour à mes commandes</a>
</div>
@endsection
