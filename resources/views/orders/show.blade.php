@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Order #{{ $order->id }} Details</h2>

    {{-- Messages de succès / erreur --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                   <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('orders.update', $order->id) }}" method="POST" class="mt-3">
        @csrf
        @method('PUT')

        {{-- Infos client --}}
        <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" name="fullname" class="form-control" 
                   value="{{ old('fullname', $order->fullname) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" 
                   value="{{ old('email', $order->email) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Phone</label>
            <input type="text" name="phone" class="form-control" 
                   value="{{ old('phone', $order->phone) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Address</label>
            <textarea name="address" class="form-control" required>{{ old('address', $order->address) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Total Price (MAD)</label>
            <input type="number" step="0.01" name="total_price" class="form-control" 
                   value="{{ old('total_price', $order->total_price) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
                <option value="en attente" {{ $order->status === 'en attente' ? 'selected' : '' }}>En attente</option>
                <option value="en cours" {{ $order->status === 'en cours' ? 'selected' : '' }}>En cours</option>
                <option value="livrée" {{ $order->status === 'livrée' ? 'selected' : '' }}>Livrée</option>
                <option value="retour" {{ $order->status === 'retour' ? 'selected' : '' }}>Retour</option>
                <option value="problème" {{ $order->status === 'problème' ? 'selected' : '' }}>Problème</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Delivery Comment</label>
            <textarea name="delivery_comment" class="form-control" rows="3">{{ old('delivery_comment', $order->delivery_comment) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Ordered At</label>
            <input type="text" class="form-control" 
                   value="{{ $order->created_at->format('Y-m-d H:i') }}" readonly>
        </div>

        <hr>

        {{-- Items existants --}}
        <h4>Order Items</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price (MAD)</th>
                    <th>Quantity</th>
                    <th>Remove</th>
                </tr>
            </thead>
            <tbody>
              @foreach ($order->items as $index => $item)
<tr>
    <td>
        <select name="items[{{ $index }}][product_id]" class="form-select">
            @foreach ($products as $product)
                <option value="{{ $product->id }}" {{ $product->id == $item->product_id ? 'selected' : '' }}>
                    {{ $product->name }}
                </option>
            @endforeach
        </select>
    </td>
    <td>{{ number_format($item->product_price, 2) }}</td>
    <td>
        <input type="number" name="items[{{ $index }}][quantity]" class="form-control" value="{{ $item->quantity }}" min="1">
    </td>
    <td>{{ number_format($item->product_price * $item->quantity, 2) }}</td>
</tr>
@endforeach
            </tbody>
        </table>

        {{-- Ajouter un produit --}}
        <h5>Add New Product</h5>
        <div id="new-items"></div>
        <button type="button" class="btn btn-secondary mb-3" onclick="addNewItem()">+ Add Product</button>

        <button type="submit" class="btn btn-primary">Update Order</button>
        <a href="{{ route('orders.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>

<script>
    let newIndex = 0;
    function addNewItem() {
        const container = document.getElementById('new-items');
        const html = `
            <div class="row mb-2">
                <div class="col-md-5">
                    <select name="new_items[${newIndex}][product_id]" class="form-control">
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="number" step="0.01" name="new_items[${newIndex}][price]" class="form-control" placeholder="Price">
                </div>
                <div class="col-md-2">
                    <input type="number" name="new_items[${newIndex}][quantity]" value="1" min="1" class="form-control">
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
        newIndex++;
    }
</script>
@endsection
