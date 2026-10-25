/*
 * Panier Myshop (localStorage) — refonte.
 * Clés localStorage : `cart` (lignes du panier) et `discount` (code promo appliqué).
 * API globale conservée : addToCart, updateQuantity, removeFromCart,
 * applyPromoCode, removePromoCode, proceedToCheckout, updateCartCount.
 */
let cart = [];
try {
    cart = JSON.parse(localStorage.getItem('cart')) || [];
} catch (e) {
    console.warn('Panier localStorage illisible, réinitialisé.', e);
    cart = [];
}

// discount = { code, type: 'percent' | 'fixed', value } ou null
let discount = null;
try {
    const raw = JSON.parse(localStorage.getItem('discount'));
    if (raw && typeof raw === 'object') {
        discount = raw;
    } else if (typeof raw === 'number' && raw > 0) {
        // Ancien format : fraction (0.1 = -10 %)
        discount = { code: '', type: 'percent', value: raw * 100 };
    }
} catch (e) {
    discount = null;
}
let promoCodes = [];

function saveCart() {
    try {
        localStorage.setItem('cart', JSON.stringify(cart));
        if (discount) {
            localStorage.setItem('discount', JSON.stringify(discount));
        } else {
            localStorage.removeItem('discount');
        }
    } catch (e) {
        console.warn('Sauvegarde panier impossible.', e);
    }
}

function formatPrice(n) {
    return Number(n).toLocaleString('fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) + ' MAD';
}

function escapeHtml(str) {
    return String(str ?? '').replace(/[&<>"']/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
}

function getTotals() {
    const subtotal = cart.reduce((sum, item) => sum + item.price * item.quantity, 0);
    let discountAmount = 0;
    if (discount && subtotal > 0) {
        discountAmount = discount.type === 'fixed'
            ? Math.min(Number(discount.value), subtotal)
            : subtotal * Number(discount.value) / 100;
    }
    return { subtotal, discountAmount, total: Math.max(0, subtotal - discountAmount) };
}

function addToCart(id, name, price, image, quantity = 1) {
    id = Number(id);
    price = Number(price);
    quantity = Math.max(1, parseInt(quantity, 10) || 1);
    const product = cart.find(item => item.id === id);
    if (product) {
        product.quantity += quantity;
    } else {
        cart.push({ id, name, price, image, quantity });
    }
    saveCart();
    updateCartCount();
    showToast(`${name} ajouté au panier`);
}

function updateCartCount() {
    const cartBadge = document.getElementById('cartCountBadge');
    if (!cartBadge) return;
    cartBadge.textContent = cart.reduce((sum, item) => sum + item.quantity, 0);
}

let toastTimer;
function showToast(message) {
    const toast = document.getElementById('dsToast');
    if (!toast) return;
    document.getElementById('dsToastText').textContent = message;
    toast.hidden = false;
    // Relance l'animation d'entrée
    toast.style.animation = 'none';
    void toast.offsetWidth;
    toast.style.animation = '';
    clearTimeout(toastTimer);
    toastTimer = setTimeout(() => { toast.hidden = true; }, 2800);
}

function updateQuantity(id, quantity) {
    const product = cart.find(item => item.id === Number(id));
    if (!product) return;
    product.quantity = parseInt(quantity, 10) || 0;
    if (product.quantity <= 0) {
        cart = cart.filter(item => item !== product);
    }
    saveCart();
    refresh();
}

function changeQuantity(id, delta) {
    const product = cart.find(item => item.id === Number(id));
    if (product) updateQuantity(id, product.quantity + delta);
}

function removeFromCart(id) {
    cart = cart.filter(item => item.id !== Number(id));
    saveCart();
    refresh();
}

function refresh() {
    updateCartCount();
    renderCartPage();
    renderCheckout();
}

/* ---------- Page panier (/cart) ---------- */
function renderCartPage() {
    const page = document.getElementById('cartPage');
    if (!page) return;
    const empty = document.getElementById('cartEmpty');
    const full = document.getElementById('cartFull');

    if (cart.length === 0) {
        empty.hidden = false;
        full.hidden = true;
        return;
    }
    empty.hidden = true;
    full.hidden = false;

    document.getElementById('cartItemsContainer').innerHTML = cart.map(item => `
        <div class="ds-line">
            <div class="ds-line__img"><img src="${escapeHtml(item.image)}" alt="${escapeHtml(item.name)}"></div>
            <div class="ds-line__body">
                <a href="/products/${item.id}" class="ds-line__name">${escapeHtml(item.name)}</a>
                <div class="ds-line__controls">
                    <div class="ds-stepper ds-stepper--sm">
                        <button type="button" onclick="changeQuantity(${item.id}, -1)" aria-label="Diminuer la quantité">−</button>
                        <span>${item.quantity}</span>
                        <button type="button" onclick="changeQuantity(${item.id}, 1)" aria-label="Augmenter la quantité">+</button>
                    </div>
                    <button type="button" class="ds-textlink" onclick="removeFromCart(${item.id})">Retirer</button>
                </div>
            </div>
            <span class="ds-line__total">${formatPrice(item.price * item.quantity)}</span>
        </div>
    `).join('');

    renderTotals(document.getElementById('cartTotals'));
    syncPromoUi();
}

function renderTotals(container) {
    if (!container) return;
    const { subtotal, discountAmount, total } = getTotals();
    container.innerHTML = `
        <div><span>Sous-total</span><span>${formatPrice(subtotal)}</span></div>
        ${discountAmount > 0 ? `<div class="ds-totals__disc"><span>Remise${discount.code ? ' (' + escapeHtml(discount.code) + ')' : ''}</span><span>−${formatPrice(discountAmount)}</span></div>` : ''}
        <div class="ds-totals__grand"><span>Total</span><span>${formatPrice(total)}</span></div>
    `;
}

/* ---------- Codes promo ---------- */
async function loadPromoCodes() {
    try {
        const response = await fetch('/api/promo-codes');
        promoCodes = await response.json();
    } catch (error) {
        console.error('Erreur lors du chargement des codes promo :', error);
    }
}

function setPromoFeedback(message, ok) {
    const feedback = document.getElementById('promoFeedback');
    if (!feedback) return;
    feedback.textContent = message;
    feedback.className = 'ds-promo-msg ' + (ok ? 'is-ok' : 'is-error');
    feedback.hidden = !message;
}

function syncPromoUi() {
    const input = document.getElementById('promoCodeInput');
    const button = document.getElementById('promoButton');
    if (!input || !button) return;
    input.disabled = !!discount;
    if (discount && discount.code) input.value = discount.code;
    button.textContent = discount ? 'Retirer' : 'Appliquer';
}

function togglePromoCode() {
    if (discount) {
        removePromoCode();
    } else {
        applyPromoCode();
    }
}

async function applyPromoCode() {
    const inputField = document.getElementById('promoCodeInput');
    const input = inputField.value.trim().toUpperCase();

    if (discount) {
        setPromoFeedback('Un code promo est déjà appliqué.', false);
        return;
    }
    if (!input) {
        setPromoFeedback('Saisissez un code promo.', false);
        return;
    }
    if (promoCodes.length === 0) await loadPromoCodes();

    const promo = promoCodes.find(p => p.code.toUpperCase() === input);
    if (!promo) {
        setPromoFeedback('Code promo invalide', false);
        return;
    }
    if (promo.expires_at && new Date(promo.expires_at) < new Date()) {
        setPromoFeedback('Ce code promo a expiré.', false);
        return;
    }

    discount = { code: promo.code.toUpperCase(), type: promo.type === 'fixed' ? 'fixed' : 'percent', value: Number(promo.value) };
    saveCart();
    setPromoFeedback(discount.type === 'percent'
        ? `Code appliqué : −${discount.value} %`
        : `Code appliqué : −${formatPrice(discount.value)}`, true);
    renderCartPage();
}

function removePromoCode() {
    discount = null;
    saveCart();
    const inputField = document.getElementById('promoCodeInput');
    if (inputField) inputField.value = '';
    setPromoFeedback('', true);
    renderCartPage();
}

function proceedToCheckout() {
    saveCart();
    window.location.href = '/checkout';
}

/* ---------- Checkout ---------- */
function renderCheckout() {
    const summary = document.getElementById('checkoutSummary');
    if (!summary) return;

    if (cart.length === 0) {
        document.getElementById('checkoutContent').hidden = true;
        document.getElementById('checkoutEmpty').hidden = false;
        return;
    }

    document.getElementById('checkoutItems').innerHTML = cart.map(item => `
        <div class="ds-mini">
            <div class="ds-mini__img"><img src="${escapeHtml(item.image)}" alt="${escapeHtml(item.name)}"></div>
            <div class="ds-mini__body"><span>${escapeHtml(item.name)}</span><span>Qté ${item.quantity}</span></div>
            <span style="font-size:14px;white-space:nowrap">${formatPrice(item.price * item.quantity)}</span>
        </div>
    `).join('');
    renderTotals(document.getElementById('checkoutTotals'));

    const { total } = getTotals();
    document.getElementById('cart_data').value = JSON.stringify(cart);
    document.getElementById('total_price').value = total.toFixed(2);
    document.getElementById('checkoutTotalLabel').textContent = formatPrice(total);
}

/* ---------- Interactions déclaratives ---------- */
document.addEventListener('click', event => {
    // <button data-add-to-cart data-id data-name data-price data-image [data-qty-from="#id"]>
    const addBtn = event.target.closest('[data-add-to-cart]');
    if (addBtn) {
        const d = addBtn.dataset;
        const qtyEl = d.qtyFrom ? document.querySelector(d.qtyFrom) : null;
        addToCart(d.id, d.name, d.price, d.image, qtyEl ? qtyEl.textContent : 1);
        return;
    }
    // <button data-qty-step="1|-1" data-qty-target="#id">
    const stepBtn = event.target.closest('[data-qty-step]');
    if (stepBtn) {
        const target = document.querySelector(stepBtn.dataset.qtyTarget);
        if (target) {
            target.textContent = Math.max(1, (parseInt(target.textContent, 10) || 1) + parseInt(stepBtn.dataset.qtyStep, 10));
        }
        return;
    }
    // Menu mobile
    const menuBtn = event.target.closest('#dsMenuToggle');
    if (menuBtn) {
        const nav = document.getElementById('dsMobileNav');
        const open = nav.classList.toggle('is-open');
        menuBtn.setAttribute('aria-expanded', open ? 'true' : 'false');
    }
});

document.addEventListener('DOMContentLoaded', () => {
    refresh();
    if (document.getElementById('promoCodeInput')) {
        loadPromoCodes();
        document.getElementById('promoCodeInput').addEventListener('keydown', e => {
            if (e.key === 'Enter') { e.preventDefault(); togglePromoCode(); }
        });
    }
});
