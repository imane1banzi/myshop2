@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Order #{{ $order->id }} Details</h2>

    {{-- Messages --}}
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

    {{-- FORMULAIRE PRINCIPAL --}}
    <form action="{{ route('orders.update', $order->id) }}" method="POST" class="mt-3">
        @csrf
        @method('PUT')

        {{-- Infos client --}}
        <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" name="fullname" class="form-control" value="{{ old('fullname', $order->fullname) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $order->email) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Phone</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone', $order->phone) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Address</label>
            <textarea name="address" class="form-control" required>{{ old('address', $order->address) }}</textarea>
        </div>

        {{-- Champ Code Promo --}}
        <div class="mb-3">
            <label class="form-label">Promo Code</label>
            <input type="text" name="coupon_code" id="promo_code" class="form-control" value="{{ old('coupon_code', $order->coupon_code) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Total Price (MAD)</label>
            <input type="number" step="0.01" name="total_price" id="total_price_input" class="form-control" value="{{ old('total_price', $order->total_price) }}" required>
        </div>

        {{-- Affichage total et remise --}}
        <div class="mt-3 text-end">
            <div><strong>Total: MAD <span id="totalPriceDisplay">{{ number_format($order->total_price, 2) }}</span></strong></div>
            <div class="text-success" id="discountDisplay" style="display:none;">
                Réduction appliquée: -<span id="discountAmount">0.00</span> MAD
            </div>
        </div>

        {{-- Status --}}
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
            <input type="text" class="form-control" value="{{ $order->created_at->format('Y-m-d H:i') }}" readonly>
        </div>

        <hr>

        {{-- Items --}}
        <h4>Items:</h4>
        <table class="table table-bordered" id="itemsTable">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price (MAD)</th>
                    <th>Quantity</th>
                    <th>Subtotal (MAD)</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $index => $item)
                <tr>
                    <td>
                        <select name="items[{{ $index }}][product_id]" class="form-select product-select">
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}" data-price="{{ $product->price }}"
                                    {{ $product->id == $item->product_id ? 'selected' : '' }}>
                                    {{ $product->name }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td class="price">{{ number_format($item->product_price, 2) }}</td>
                    <td>
                        <input type="number" name="items[{{ $index }}][quantity]" class="form-control quantity-input" value="{{ $item->quantity }}" min="1" required>
                    </td>
                    <td class="subtotal">{{ number_format($item->product_price * $item->quantity, 2) }}</td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm remove-item">Remove</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <button type="button" class="btn btn-success mb-3" id="addItemBtn">Add Product</button>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Update Order</button>
            <a href="{{ route('orders.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </form>
</div>

{{-- JS --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const productsData = @json($products->map(fn($p) => ['id'=>$p->id,'name'=>$p->name,'price'=>(float) $p->price]));
    const itemsTable = document.getElementById('itemsTable').querySelector('tbody');
    const totalPriceDisplay = document.getElementById('totalPriceDisplay');
    const totalPriceInput = document.getElementById('total_price_input');
    const discountDisplay = document.getElementById('discountDisplay');
    const discountAmountEl = document.getElementById('discountAmount');
    const promoInput = document.getElementById('promo_code');

    let discount = 0;

    function parseNumber(v) {
        const n = parseFloat(String(v).replace(',', '.'));
        return isNaN(n) ? 0 : n;
    }

    function updateSubtotal(row) {
        const select = row.querySelector('.product-select');
        const qtyInput = row.querySelector('.quantity-input');
        const priceCell = row.querySelector('.price');
        const subtotalCell = row.querySelector('.subtotal');

        const option = select.selectedOptions[0];
        const price = parseNumber(option.dataset.price ?? 0);
        const quantity = parseInt(qtyInput.value) || 0;

        priceCell.textContent = price.toFixed(2);
        subtotalCell.textContent = (price * quantity).toFixed(2);

        updateTotal();
    }

    function updateTotal() {
        let total = 0;
        itemsTable.querySelectorAll('tr').forEach(row => {
            total += parseNumber(row.querySelector('.subtotal').textContent);
        });

        discount = 0;
        // exemple: appliquer code promo PROMO10 = 10% de remise
        if (promoInput.value.trim().toUpperCase() === "PROMO10") {
            discount = total * 0.1;
        }

        total -= discount;
        totalPriceDisplay.textContent = total.toFixed(2);
        totalPriceInput.value = total.toFixed(2);

        if (discount > 0) {
            discountDisplay.style.display = "block";
            discountAmountEl.textContent = discount.toFixed(2);
        } else {
            discountDisplay.style.display = "none";
        }
    }

    function initRowListeners(row) {
        row.querySelector('.product-select').addEventListener('change', () => updateSubtotal(row));
        row.querySelector('.quantity-input').addEventListener('input', () => updateSubtotal(row));
        row.querySelector('.remove-item').addEventListener('click', () => { row.remove(); updateTotal(); reindexRows(); });
    }

    function reindexRows() {
        itemsTable.querySelectorAll('tr').forEach((row, idx) => {
            row.querySelector('.product-select').name = `items[${idx}][product_id]`;
            row.querySelector('.quantity-input').name = `items[${idx}][quantity]`;
        });
    }

    itemsTable.querySelectorAll('tr').forEach(row => { initRowListeners(row); updateSubtotal(row); });

    document.getElementById('addItemBtn').addEventListener('click', function() {
        const index = itemsTable.querySelectorAll('tr').length;
        const tr = document.createElement('tr');
        const optionsHtml = productsData.map(p => `<option value="${p.id}" data-price="${p.price}">${p.name}</option>`).join('');
        tr.innerHTML = `
            <td><select name="items[${index}][product_id]" class="form-select product-select">${optionsHtml}</select></td>
            <td class="price">0.00</td>
            <td><input type="number" name="items[${index}][quantity]" class="form-control quantity-input" value="1" min="1" required></td>
            <td class="subtotal">0.00</td>
            <td><button type="button" class="btn btn-danger btn-sm remove-item">Remove</button></td>
        `;
        itemsTable.appendChild(tr);
        initRowListeners(tr);
        updateSubtotal(tr);
    });

    promoInput.addEventListener('input', updateTotal);
    document.querySelector('form').addEventListener('submit', updateTotal);
});
</script>
@endsection
