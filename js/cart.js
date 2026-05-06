function loadCart() {
    let cart = JSON.parse(localStorage.getItem('bakery_cart')) || [];
    const container = document.getElementById('cart-list');
    const checkoutBtn = document.getElementById('checkout-btn');
    
    if (cart.length === 0) {
        container.innerHTML = `
            <div class="empty-state">
                <ion-icon name="cart-outline"></ion-icon>
                <h2>Your cart is empty</h2>
                <p>Looks like you haven't added anything yet.</p>
                <a href="index.html" class="btn btn-primary" style="margin-top:20px;">Browse Menu</a>
            </div>
        `;
        document.getElementById('subtotal').innerText = '₹0';
        document.getElementById('grand-total').innerText = '₹0';
        checkoutBtn.style.pointerEvents = 'none';
        checkoutBtn.style.opacity = '0.5';
        return;
    }

    checkoutBtn.style.pointerEvents = 'auto';
    checkoutBtn.style.opacity = '1';

    let html = '<h2>Your Items</h2><hr style="margin:15px 0; border:0; border-top:1px solid #eee;">';
    let subtotal = 0;

    cart.forEach((item, index) => {
        let customText = item.customization 
            ? `${item.customization.flavor} base, ${item.customization.shape}, ${item.customization.frosting} frosting` 
            : '';
            
        let itemTotal = item.price * item.quantity;
        subtotal += itemTotal;

        html += `
            <div class="cart-item">
                <div class="ci-details">
                    <img src="${item.image}" class="ci-img">
                    <div class="ci-info">
                        <h4>${item.name}</h4>
                        <p>${customText}</p>
                        <p style="color:var(--primary-color); font-weight:bold; margin-top:5px;">₹${item.price}</p>
                    </div>
                </div>
                <div class="ci-actions">
                    <div>
                        <button class="qty-btn" onclick="updateQty(${index}, -1)">-</button>
                        <span style="margin:0 10px; font-weight:bold;">${item.quantity}</span>
                        <button class="qty-btn" onclick="updateQty(${index}, 1)">+</button>
                    </div>
                    <div style="font-weight:bold; width: 60px; text-align:right;">₹${itemTotal}</div>
                    <button class="remove-btn" onclick="removeItem(${index})"><ion-icon name="trash-outline"></ion-icon></button>
                </div>
            </div>
        `;
    });

    container.innerHTML = html;
    document.getElementById('subtotal').innerText = '₹' + subtotal;
    document.getElementById('grand-total').innerText = '₹' + (subtotal + 50); // Adding 50 for delivery
}

function updateQty(index, change) {
    let cart = JSON.parse(localStorage.getItem('bakery_cart'));
    cart[index].quantity += change;
    
    if (cart[index].quantity < 1) {
        cart.splice(index, 1);
    }
    
    localStorage.setItem('bakery_cart', JSON.stringify(cart));
    loadCart();
}

function removeItem(index) {
    let cart = JSON.parse(localStorage.getItem('bakery_cart'));
    cart.splice(index, 1);
    localStorage.setItem('bakery_cart', JSON.stringify(cart));
    loadCart();
}

// Initial Load
document.addEventListener('DOMContentLoaded', loadCart);
