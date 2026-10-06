@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Toutes les commandes</h2>
        {{-- Raccourci gestion des coupons --}}
        <a href="{{ route('promo_codes.index') }}" class="btn btn-success">
            <i class="bi bi-ticket-perforated"></i> Gérer les coupons
        </a>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>N°</th>
                <th>Client</th>
                <th>E-mail</th>
                <th>Total</th>
                <th>Date</th>
                <th>Statut livraison</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->fullname }}</td>
                <td>{{ $order->email }}</td>
                <td>MAD {{ number_format($order->total_price, 2) }}</td>
                <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                <td>{{ $order->status }}</td>
                <td>
                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-primary btn-sm">Détails</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $orders->links() }}
</div>
@endsection
