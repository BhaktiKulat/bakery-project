<?php
require_once 'php/session.php';

// Force user to login before checkout
if (!isLoggedIn()) {
    header("Location: login.php?error=login_required");
    exit();
}

$user = getCurrentUser();
$bakeryCash = $user['bakery_cash'] ?? 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Sweet Crumbs</title>
    <link rel="stylesheet" href="css/style.css">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <style>
        .checkout-container { max-width: 1000px; margin: 40px auto; padding: 0 5%; display: flex; gap: 30px; }
        .checkout-main { flex: 2; }
        .checkout-sidebar { flex: 1; }
        
        .c-card { background: white; padding: 30px; border-radius: var(--radius-md); box-shadow: var(--shadow-sm); margin-bottom: 20px; }
        .c-card h3 { margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
        
        .bill-row { display: flex; justify-content: space-between; margin-bottom: 15px; color: var(--text-dark); font-size: 15px; }
        .bill-total { font-size: 20px; font-weight: bold; border-top: 2px dashed #ddd; padding-top: 15px; margin-top: 15px; }
        
        .cash-toggle { background: #e8f5e9; padding: 15px; border-radius: 8px; border: 1px solid #c8e6c9; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between;}
    </style>
</head>
<body>

    <nav class="navbar">
        <a href="index.html" class="logo"><span>🍰</span> Sweet Crumbs</a>
    </nav>

    <div class="checkout-container">
        
        <div class="checkout-main">
            <div class="c-card">
                <h3><ion-icon name="location"></ion-icon> Delivery Address</h3>
                <p><strong><?php echo htmlspecialchars($user['name']); ?></strong></p>
                <p style="color: var(--text-light); margin-top: 10px;"><?php echo htmlspecialchars($user['address']); ?></p>
            </div>

            <div class="c-card">
                <h3><ion-icon name="card"></ion-icon> Payment Method</h3>
                <div style="border: 1px solid var(--primary-color); padding: 15px; border-radius: 8px; background: var(--secondary-color);">
                    <input type="radio" checked> Cash on Delivery / Pay on Arrival
                </div>
            </div>
        </div>

        <div class="checkout-sidebar">
            <div class="c-card" style="position: sticky; top: 100px;">
                <h3>Bill Details</h3>
                
                <div class="cash-toggle">
                    <div>
                        <strong>Bakery Cash</strong><br>
                        <small>Available: ₹<span id="avail-cash"><?php echo $bakeryCash; ?></span></small>
                    </div>
                    <input type="checkbox" id="use-cash-cb" style="width:20px; height:20px;">
                </div>

                <div class="bill-row"><span>Item Total</span> <span id="b-subtotal">₹0</span></div>
                <div class="bill-row"><span>Delivery Fee</span> <span>₹50</span></div>
                <div class="bill-row"><span>Taxes (5%)</span> <span id="b-tax">₹0</span></div>
                <div class="bill-row" id="cash-discount-row" style="display:none; color: green;"><span>Bakery Cash Applied</span> <span id="b-discount">-₹0</span></div>
                
                <div class="bill-total bill-row"><span>To Pay</span> <span id="b-total">₹0</span></div>
                
                <p style="font-size: 12px; color: green; margin-top: 10px; text-align:center;">
                    You will earn ₹<span id="earn-cash">0</span> Bakery Cash on this order!
                </p>

                <!-- Hidden Form to submit to PHP -->
                <form action="php/save-order.php" method="POST" id="checkout-form">
                    <input type="hidden" name="cart_data" id="cart_data">
                    <input type="hidden" name="subtotal" id="h_subtotal">
                    <input type="hidden" name="tax" id="h_tax">
                    <input type="hidden" name="discount" id="h_discount">
                    <input type="hidden" name="total" id="h_total">
                    <input type="hidden" name="earned" id="h_earned">
                    <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 20px;">Confirm Order</button>
                </form>
            </div>
        </div>

    </div>

    <script src="js/billing.js"></script>
</body>
</html>
