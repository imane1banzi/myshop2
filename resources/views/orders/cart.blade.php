<!-- Cart Modal -->
<div class="modal fade" id="shoppingCartModal" tabindex="-1" aria-labelledby="shoppingCartModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="shoppingCartModalLabel">Panier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">

                <div id="cartItemsContainer" class="row g-3">
                    @foreach($products as $product)
                        <div class="col-12 d-flex justify-content-between border-bottom pb-2">
                            <div>{{ $product->name }}</div>
                            <div>MAD {{ number_format($product->price, 2) }}</div>
                        </div>
                    @endforeach
                </div>

                <div id="totalPriceContainer" class="text-end fw-bold mt-4 fs-5">
                    Prix total : MAD {{ number_format($products->sum('price'), 2) }}
                </div>

                <div class="d-flex justify-content-end mt-3">
                    <button class="btn btn-success me-2" onclick="applyDiscount()">Appliquer la remise</button>
                    <form method="POST" action="{{ route('checkout') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary">Passer commande</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

    