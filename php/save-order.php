<?php
require_once 'session.php';

if (!isLoggedIn()) {
    die("Unauthorized");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_SESSION['user_id'];
    $cartData = json_decode($_POST['cart_data'], true);
    $subtotal = (int)$_POST['subtotal'];
    $tax = (int)$_POST['tax'];
    $discount = (int)$_POST['discount'];
    $totalPaid = (int)$_POST['total'];
    $earnedCash = (int)$_POST['earned'];

    $orderId = "ORD" . rand(10000, 99999);

    // 1. Save to orders.json
    $ordersFile = '../data/orders.json';
    $orders = readJsonFile($ordersFile);
    
    $newOrder = [
        "order_id" => $orderId,
        "user_id" => $userId,
        "date" => date("Y-m-d H:i:s"),
        "items" => $cartData,
        "subtotal" => $subtotal,
        "tax" => $tax,
        "discount_used" => $discount,
        "total_paid" => $totalPaid,
        "earned_cash" => $earnedCash,
        "status" => "Preparing"
    ];
    
    $orders[] = $newOrder;
    writeJsonFile($ordersFile, $orders);

    // 2. Update user's Bakery Cash in users.json
    $usersFile = '../data/users.json';
    $users = readJsonFile($usersFile);
    
    foreach ($users as &$user) {
        if ($user['id'] === $userId) {
            // Deduct used cash, add newly earned cash
            $currentCash = $user['bakery_cash'] ?? 0;
            $user['bakery_cash'] = $currentCash - $discount + $earnedCash;
            break;
        }
    }
    writeJsonFile($usersFile, $users);

    // 3. Clear JS localStorage and Redirect to Success Page
    // We can use a simple HTML page that clears storage and redirects
    echo "
    <script>
        localStorage.removeItem('bakery_cart');
        window.location.href = '../order-success.html?id=$orderId';
    </script>
    ";
    exit();
}
?>
