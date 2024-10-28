let cart = JSON.parse(localStorage.getItem('cart')) || [];

function addToCart(id, name, price, image) {
    const product = cart.find(item => item.id === id);
    if (product) {
        product.quantity++;
    } else {
        cart.push({ id, name, price, image, quantity: 1 });
    }
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartCount();
}

function updateCartCount() {
    const cartBadge = document.querySelector('.badge');
    const totalQuantity = cart.reduce((sum, item) => sum + item.quantity, 0);
    cartBadge.textContent = totalQuantity;
}

// Call this on page load to set initial cart count
document.addEventListener('DOMContentLoaded', updateCartCount);
document.getElementById('cartModalTrigger').addEventListener('click', showCartItems);

function showCartItems() {
    const cartItemsContainer = document.getElementById('cartItemsContainer');
    cartItemsContainer.innerHTML = cart.map(item => `
        <div class="row mb-4">
            <div class="col-md-2"><img src="${item.image}" class="img-fluid" alt="${item.name}"></div>
            <div class="col-md-3"><h6>${item.name}</h6></div>
            <div class="col-md-3">
                <input type="number" min="1" value="${item.quantity}" onchange="updateQuantity(${item.id}, this.value)" class="form-control" />
            </div>
            <div class="col-md-3">Price: MAD ${item.price}</div>
            <div class="col-md-1"><button class="btn btn-danger" onclick="removeFromCart(${item.id})">Remove</button></div>
        </div>
    `).join('');
}

function updateQuantity(id, quantity) {
    const product = cart.find(item => item.id === id);
    if (product) {
        product.quantity = parseInt(quantity, 10);
        localStorage.setItem('cart', JSON.stringify(cart));
        updateCartCount();
    }
}

function removeFromCart(id) {
    cart = cart.filter(item => item.id !== id);
    localStorage.setItem('cart', JSON.stringify(cart));
    showCartItems();
    updateCartCount();
}
