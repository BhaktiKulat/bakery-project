<?php
require_once 'session.php';

// Check if form is submitted via POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password']; // In a real app, always hash passwords! Keeping simple for beginner logic.
    $address = $_POST['address'];

    // 1. Read existing users
    $usersFile = '../data/users.json';
    $users = readJsonFile($usersFile);

    // 2. Check if email already exists
    foreach ($users as $u) {
        if ($u['email'] === $email) {
            die("Email already registered. <a href='../login.php'>Login here</a>");
        }
    }

    // 3. Create a new user array
    $newUser = [
        "id" => uniqid("user_"), // Generate a unique ID like user_60f...
        "name" => $name,
        "email" => $email,
        "password" => $password, 
        "address" => $address,
        "bakery_cash" => 0, // Initial balance
        "saved_designs" => []
    ];

    // 4. Add to the list and save
    $users[] = $newUser;
    writeJsonFile($usersFile, $users);

    // 5. Redirect to login page
    header("Location: ../login.php?signup=success");
    exit();
}
?>
