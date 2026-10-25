let cart = [];
try {
    cart = JSON.parse(localStorage.getItem('cart')) || [];
} catch (e) {
    console.warn('Panier localStorage illisible, réinitialisé.', e);
    cart = [];
}
let discount = 0;
let promoCodes = [];

// Panier toujours exploitable même si le localStorage contient d'anciennes données
function safeCart() {
    return Array.isArray(cart) ? cart : [];
}

function cartItemPrice(item) {
    const p = Number(item.price);
    return isNaN(p) ? 0 : p;
}

function cartItemQty(item) {
    const q = parseInt(item.quantity, 10);
    return isNaN(q) || q < 0 ? 0 : q;
}

function saveCart() {
    try {
        localStorage.setItem('cart', JSON.stringify(cart));
    } catch (e) {
        console.warn('Sauvegarde panier impossible.', e);
    }
} 

function addToCart(id, name, price, image) {
    if (!Array.isArray(cart)) cart = [];
    const product = cart.find(item => item.id === id);
    if (product) {
        product.quantity++;
    } else {
        cart.push({ id, name, price, image, quantity: 1 });
    }
    saveCart();
    updateCartCount();
    updateTotalPrice();
}

function updateCartCount() {
    const cartBadge = document.getElementById('cartCountBadge');
    if (!cartBadge) return;
    const totalQuantity = safeCart().reduce((sum, item) => sum + cartItemQty(item), 0);
    cartBadge.textContent = totalQuantity;
}

function updateTotalPrice() {
    const el = document.getElementById('totalPriceContainer');
    if (!el) return;
    const totalPrice = safeCart().reduce((sum, item) => sum + cartItemPrice(item) * cartItemQty(item), 0) * (1 - discount);
    el.textContent = `Prix total : MAD ${totalPrice.toFixed(2)}`;
}

document.addEventListener('DOMContentLoaded', () => {
    const trigger = document.getElementById('cartModalTrigger');
    if (trigger) trigger.addEventListener('click', openCartModal);
    updateCartCount();
    updateTotalPrice();
});

// Ouverture du panier : rendu + affichage modale, la modale s'ouvre même si le rendu échoue
function openCartModal() {
    try {
        renderCartItems();
    } catch (e) {
        console.warn('Rendu panier impossible.', e);
    }
    try {
        updateTotalPrice();
    } catch (e) {
        console.warn('Total panier impossible.', e);
    }
    const modalEl = document.getElementById('shoppingCartModal');
    if (modalEl && window.bootstrap) {
        window.bootstrap.Modal.getOrCreateInstance(modalEl).show();
    }
}

function renderCartItems() {
    const cartItemsContainer = document.getElementById('cartItemsContainer');
    if (!cartItemsContainer) return;
    const items = safeCart();
    if (items.length === 0) {
        cartItemsContainer.innerHTML = `
        <div class="col-12">
            <div class="cart-empty">
                <i class="bi bi-bag" style="font-size: 2.5rem;"></i>
                <p class="mt-2 mb-3">Votre panier est vide.</p>
                <a href="/products" class="btn btn-gold-solid rounded-pill px-4">Découvrir la boutique</a>
            </div>
        </div>`;
        updateTotalPrice();
        return;
    }
    cartItemsContainer.innerHTML = items.map(item => {
        const price = cartItemPrice(item);
        const qty = cartItemQty(item);
        const img = item.image || '';
        const name = item.name || '';
        return `
        <div class="col-12">
            <div class="cart-item p-3 shadow-sm">
                <div class="row align-items-center g-2">
                    <div class="col-3 col-md-2"><img src="${img}" class="img-fluid rounded" alt="${name}" loading="lazy" decoding="async" style="max-height: 90px; width: 100%; object-fit: cover;"></div>
                    <div class="col-9 col-md-4"><h6 class="item-name mb-1">${name}</h6><p class="price mb-0">MAD ${price.toFixed(2)} par unité</p></div>
                    <div class="col-6 col-md-3">
                        <label class="form-label small text-muted mb-1">Quantité</label>
                        <input type="number" min="1" value="${qty}" onchange="updateQuantity(${item.id}, this.value)" class="form-control form-control-sm text-center" />
                    </div>
                    <div class="col-6 col-md-2 text-md-end">
                        <div class="price">MAD ${(price * qty).toFixed(2)}</div>
                    </div>
                    <div class="col-12 col-md-1 text-md-end">
                        <button class="btn btn-outline-danger btn-sm rounded-pill" onclick="removeFromCart(${item.id})">Retirer</button>
                    </div>
                </div>
            </div>
        </div>
        `;
    }).join('');
    updateTotalPrice();
}

// Alias historique (quantité / suppression rechargent le contenu sans rouvrir la modale)
function showCartItems() {
    renderCartItems();
}

function updateQuantity(id, quantity) {
    const product = safeCart().find(item => item.id === id);
    if (product) {
        const q = parseInt(quantity, 10);
        product.quantity = isNaN(q) || q < 1 ? 1 : q;
        saveCart();
        updateCartCount();
        renderCartItems();
    }
}

function removeFromCart(id) {
    cart = safeCart().filter(item => item.id !== id);
    saveCart();
    renderCartItems();
    updateCartCount();
    updateTotalPrice();
}
async function loadPromoCodes() {
    try {
        const response = await fetch('/api/promo-codes');
        promoCodes = await response.json(); // stocker les codes promo
    } catch (error) {
        console.error("Erreur lors du chargement des codes promo :", error);
    }
}
loadPromoCodes();

async function applyPromoCode() {
    const inputField = document.getElementById('promoCodeInput');
    const input = inputField.value.trim().toUpperCase();
    const feedback = document.getElementById('promoFeedback');
    const applyButton = inputField.nextElementSibling;
    const removeButton = document.getElementById('removePromoBtn');

    // Promo déjà appliquée ?
    if (discount > 0) {
        feedback.textContent = "Un code promo est déjà appliqué.";
        feedback.className = "form-text text-warning";
        return;
    }

    // Chercher le code promo dans la liste chargée
    const promo = promoCodes.find(p => p.code.toUpperCase() === input);

    if (!promo) {
        feedback.textContent = "Code promo invalide.";
        feedback.className = "form-text text-danger";
        return;
    }

    // Vérifier expiration
    if (promo.expires_at && new Date(promo.expires_at) < new Date()) {
        feedback.textContent = "Ce code promo a expiré.";
        feedback.className = "form-text text-danger";
        return;
    }

    // Appliquer réduction
    if (promo.type === "percent") {
        discount = promo.value / 100;
    } else if (promo.type === "fixed") {
        discount = promo.value; // réduction fixe en MAD
    }

    feedback.textContent = `Code promo appliqué avec succès.`;
    feedback.className = "form-text text-success";

    inputField.disabled = true;
    applyButton.disabled = true;
    removeButton.style.display = 'inline-block';

    updateTotalPrice();
}

function removePromoCode() {
    const inputField = document.getElementById('promoCodeInput');
    const feedback = document.getElementById('promoFeedback');
    const applyButton = inputField.nextElementSibling;
    const removeButton = document.getElementById('removePromoBtn');

    discount = 0;
    inputField.disabled = false;
    inputField.value = '';
    applyButton.disabled = false;
    feedback.textContent = "Code promo retiré.";
    feedback.className = "form-text text-muted";
    removeButton.style.display = 'none';
    updateTotalPrice();
}


function proceedToCheckout() {
    localStorage.setItem('discount', discount); // stocke la remise active
    window.location.href = "/checkout"; // redirige vers la page Laravel
}