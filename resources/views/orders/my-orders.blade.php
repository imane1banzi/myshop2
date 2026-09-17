@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Mes commandes</h2>
    <p class="text-muted">Historique réservé au client authentifié.</p>

    @if($orders->isEmpty())
        <div class="alert alert-info">Vous n'avez pas encore passé de commande.</div>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>N°</th>
                    <th>Total</th>
                    <th>Date</th>
                    <th>Statut</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                <tr>
                    <td>#{{ $order->id }}</td>
                    <td>MAD {{ number_format($order->total_price, 2) }}</td>
                    <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                    <td>{{ $order->status ?? 'en attente' }}</td>
                    <td>
                        <a href="{{ route('my-orders.show', $order->id) }}" class="btn btn-primary btn-sm">Détails</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $orders->links() }}
    @endif
</div>
@endsection
