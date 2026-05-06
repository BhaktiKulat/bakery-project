<?php
require_once 'php/session.php';

if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}

$user = getCurrentUser();
$orders = readJsonFile('data/orders.json');

// Filter orders for just this user
$myOrders = array_filter($orders, function($o) use ($user) {
    return $o['user_id'] === $user['id'];
});
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - Sweet Crumbs</title>
    <link rel="stylesheet" href="css/style.css">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <style>
        .profile-container { padding: 40px 5%; display: flex; gap: 30px; }
        .sidebar { flex: 1; background: white; padding: 30px; border-radius: var(--radius-md); box-shadow: var(--shadow-sm); height: fit-content; }
        .main-content { flex: 3; }
        .wallet-card { background: linear-gradient(135deg, var(--primary-color), var(--primary-hover)); color: white; padding: 30px; border-radius: var(--radius-md); margin-bottom: 30px; box-shadow: var(--shadow-md); }
        .wallet-card h3 { font-size: 24px; margin-bottom: 10px; }
        .wallet-card .balance { font-size: 48px; font-weight: 700; }
        .order-card { background: white; padding: 20px; border-radius: var(--radius-sm); box-shadow: var(--shadow-sm); margin-bottom: 20px; border: 1px solid #eee; }
        .order-header { display: flex; justify-content: space-between; border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom: 15px; }
    </style>
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar">
        <a href="index.html" class="logo">
            <span>🍰</span> Sweet Crumbs
        </a>
        <ul class="nav-links">
            <li><a href="index.html">Home</a></li>
            <li><a href="customize.html">Customize</a></li>
            <li><a href="cart.html"><ion-icon name="cart-outline" class="nav-icon"></ion-icon> Cart</a></li>
            <li><a href="php/logout.php" class="btn btn-outline">Logout</a></li>
        </ul>
    </nav>

    <div class="profile-container">
        <!-- SIDEBAR -->
        <div class="sidebar">
            <div style="text-align:center; margin-bottom: 20px;">
                <ion-icon name="person-circle" style="font-size: 80px; color: var(--primary-color);"></ion-icon>
                <h2><?php echo htmlspecialchars($user['name']); ?></h2>
                <p style="color: var(--text-light);"><?php echo htmlspecialchars($user['email']); ?></p>
            </div>
            <hr style="border:0; border-top:1px solid #eee; margin:20px 0;">
            <p><strong>Address:</strong><br><?php echo htmlspecialchars($user['address']); ?></p>
        </div>

        <!-- MAIN CONTENT -->
        <div class="main-content">
            <!-- BAKERY CASH WALLET -->
            <div class="wallet-card">
                <h3><ion-icon name="wallet"></ion-icon> Bakery Cash Wallet</h3>
                <div class="balance">₹<?php echo $user['bakery_cash'] ?? 0; ?></div>
                <p>Use this cash on your next orders to get discounts!</p>
            </div>

            <!-- ORDER HISTORY -->
            <h2 style="margin-bottom: 20px;">Recent Orders</h2>
            <?php if (empty($myOrders)): ?>
                <p>You haven't placed any orders yet. <a href="index.html" style="color:var(--primary-color);">Start shopping!</a></p>
            <?php else: ?>
                <?php foreach(array_reverse($myOrders) as $order): ?>
                    <div class="order-card">
                        <div class="order-header">
                            <div><strong>Order #<?php echo $order['order_id']; ?></strong></div>
                            <div><span style="background:var(--secondary-color); color:var(--primary-color); padding: 4px 10px; border-radius:15px; font-size:12px; font-weight:bold;">₹<?php echo $order['total_paid']; ?></span></div>
                        </div>
                        <p><strong>Items:</strong></p>
                        <ul style="margin-left: 20px; color: var(--text-light);">
                            <?php foreach($order['items'] as $item): ?>
                                <li><?php echo $item['quantity']; ?>x <?php echo htmlspecialchars($item['name']); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>
