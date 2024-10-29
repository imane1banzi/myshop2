let cart = JSON.parse(localStorage.getItem('cart')) || [];
let discount = 0;

function addToCart(id, name, price, image) {
    const product = cart.find(item => item.id === id);
    if (product) {
        product.quantity++;
    } else {
        cart.push({ id, name, price, image, quantity: 1 });
    }
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartCount();
    updateTotalPrice();
}

function updateCartCount() {
    const cartBadge = document.querySelector('.badge');
    const totalQuantity = cart.reduce((sum, item) => sum + item.quantity, 0);
    cartBadge.textContent = totalQuantity;
}

function updateTotalPrice() {
    const totalPrice = cart.reduce((sum, item) => sum + item.price * item.quantity, 0) * (1 - discount);
    document.getElementById('totalPriceContainer').textContent = `Total Price: MAD ${totalPrice.toFixed(2)}`;
}

document.addEventListener('DOMContentLoaded', () => {
    updateCartCount();
    updateTotalPrice();
});
document.getElementById('cartModalTrigger').addEventListener('click', showCartItems);

function showCartItems() {
    const cartItemsContainer = document.getElementById('cartItemsContainer');
    cartItemsContainer.innerHTML = cart.map(item => `
        <div class="col-md-12">
            <div class="card p-3 shadow-sm border-0 rounded-3">
                <div class="row align-items-center">
                    <div class="col-md-2"><img src="${item.image}" class="img-fluid rounded" alt="${item.name}"></div>
                    <div class="col-md-3"><h6>${item.name}</h6><p class="text-muted">MAD ${item.price.toFixed(2)} per unit</p></div>
                    <div class="col-md-3">
                        <label class="form-label">Quantity</label>
                        <input type="number" min="1" value="${item.quantity}" onchange="updateQuantity(${item.id}, this.value)" class="form-control form-control-sm text-center" />
                    </div>
                    <div class="col-md-3">
                        <h6>Total: MAD ${(item.price * item.quantity).toFixed(2)}</h6>
                    </div>
                    <div class="col-md-1">
                        <button class="btn btn-danger btn-sm" onclick="removeFromCart(${item.id})">Remove</button>
                    </div>
                </div>
            </div>
        </div>
    `).join('');
    updateTotalPrice();
}

function updateQuantity(id, quantity) {
    const product = cart.find(item => item.id === id);
    if (product) {
        product.quantity = parseInt(quantity, 10);
        localStorage.setItem('cart', JSON.stringify(cart));
        updateCartCount();
        showCartItems();
    }
}

function removeFromCart(id) {
    cart = cart.filter(item => item.id !== id);
    localStorage.setItem('cart', JSON.stringify(cart));
    showCartItems();
    updateCartCount();
    updateTotalPrice();
}

function applyDiscount() {
    discount = 0.1; // 10% de remise par exemple
    updateTotalPrice();
}
