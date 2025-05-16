@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Order #{{ $order->id }} Details</h2>

    <div class="mb-4">
        <strong>Name:</strong> {{ $order->fullname }}<br>
        <strong>Email:</strong> {{ $order->email }}<br>
        <strong>Phone:</strong> {{ $order->phone }}<br>
        <strong>Address:</strong> {{ $order->address }}<br>
        <strong>Total:</strong> MAD {{ number_format($order->total_price, 2) }}<br>
        <strong>Ordered At:</strong> {{ $order->created_at->format('Y-m-d H:i') }}<br>
        <strong>Status:</strong> {{ ucfirst($order->status) }}<br>
        <strong>Commentaire:</strong> {{ $order->delivery_comment ?? 'Aucun' }}
    </div>

    <h4>Items:</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Product</th>
                <th>Price (MAD)</th>
                <th>Quantity</th>
                <th>Subtotal (MAD)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->items as $item)
            <tr>
                <td>{{ $item->product_name }}</td>
                <td>{{ number_format($item->product_price, 2) }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->product_price * $item->quantity, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <hr>

    <h4>Mettre à jour le statut de la commande</h4>

    <form action="{{ route('orders.update', $order->id) }}" method="POST" class="mt-3">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="status" class="form-label">Statut</label>
            <select name="status" id="status" class="form-select">
                <option value="en attente" {{ $order->status === 'en attente' ? 'selected' : '' }}>En attente</option>
                <option value="en cours" {{ $order->status === 'en cours' ? 'selected' : '' }}>En cours</option>
                <option value="livrée" {{ $order->status === 'livrée' ? 'selected' : '' }}>Livrée</option>
                <option value="retour" {{ $order->status === 'retour' ? 'selected' : '' }}>Retour</option>
                <option value="problème" {{ $order->status === 'problème' ? 'selected' : '' }}>Problème</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="delivery_comment" class="form-label">Commentaire (optionnel)</label>
            <textarea name="delivery_comment" id="delivery_comment" class="form-control" rows="3">{{ old('delivery_comment', $order->delivery_comment) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</div>
@endsection
