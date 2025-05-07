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
        <strong>Ordered At:</strong> {{ $order->created_at->format('Y-m-d H:i') }}
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
</div>
@endsection
