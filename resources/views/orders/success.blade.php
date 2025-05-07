@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="alert alert-success text-center">
        <h1>Thank you for your order!</h1>
        <p>Your order has been placed successfully.</p>
        <a href="{{ url('/') }}" class="btn btn-primary mt-3">Return to Shop</a>
    </div>
</div>
@endsection
