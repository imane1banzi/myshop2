@extends('layouts.app')

@section('content')
<div class="container">
    <h2>All Orders</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Client</th>
                <th>Email</th>
                <th>Total</th>
                <th>Date</th>
                <th>Status livraison</th>
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
                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-primary btn-sm">Details</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $orders->links() }}
</div>
@endsection
