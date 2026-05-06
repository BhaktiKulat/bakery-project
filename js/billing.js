document.addEventListener('DOMContentLoaded', () => {
    let cart = JSON.parse(localStorage.getItem('bakery_cart')) || [];
    
    if(cart.length === 0) {
        window.location.href = 'cart.html';
        return;
    }

    // Calculations
    let subtotal = 0;
    cart.forEach(item => subtotal += (item.price * item.quantity));
    
    let delivery = 50;
    let tax = Math.round(subtotal * 0.05); // 5% tax
    
    let userCash = parseInt(document.getElementById('avail-cash').innerText);
    let discountApplied = 0;
    
    // UI Elements
    const cbCash = document.getElementById('use-cash-cb');
    const rowDiscount = document.getElementById('cash-discount-row');
    const elDiscount = document.getElementById('b-discount');
    const elTotal = document.getElementById('b-total');
    const elEarned = document.getElementById('earn-cash');

    function updateBill() {
        let finalTotal = subtotal + delivery + tax - discountApplied;
        
        // You earn 5% of final amount paid as new bakery cash
        let earned = Math.round(finalTotal * 0.05);

        document.getElementById('b-subtotal').innerText = '₹' + subtotal;
        document.getElementById('b-tax').innerText = '₹' + tax;
        elTotal.innerText = '₹' + finalTotal;
        elEarned.innerText = earned;

        // Update hidden form inputs for PHP
        document.getElementById('cart_data').value = JSON.stringify(cart);
        document.getElementById('h_subtotal').value = subtotal;
        document.getElementById('h_tax').value = tax;
        document.getElementById('h_discount').value = discountApplied;
        document.getElementById('h_total').value = finalTotal;
        document.getElementById('h_earned').value = earned;
    }

    // Toggle Bakery Cash usage
    cbCash.addEventListener('change', function() {
        if(this.checked && userCash > 0) {
            // Use maximum cash available, but not more than total bill
            let tempTotal = subtotal + delivery + tax;
            discountApplied = Math.min(userCash, tempTotal);
            rowDiscount.style.display = 'flex';
            elDiscount.innerText = '-₹' + discountApplied;
        } else {
            discountApplied = 0;
            rowDiscount.style.display = 'none';
        }
        updateBill();
    });

    updateBill();
});
