<?php
require_once 'session.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // 1. Read users from JSON
    $users = readJsonFile('../data/users.json');
    $isAuthenticated = false;

    // 2. Loop through users to find a match
    foreach ($users as $user) {
        if ($user['email'] === $email && $user['password'] === $password) {
            // Found a match! Log them in by saving their ID in the session
            $_SESSION['user_id'] = $user['id'];
            $isAuthenticated = true;
            break;
        }
    }

    // 3. Redirect based on success or failure
    if ($isAuthenticated) {
        header("Location: ../profile.php");
        exit();
    } else {
        header("Location: ../login.php?error=invalid");
        exit();
    }
}
?>
