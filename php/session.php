<?php
// Start the session so we can store logged-in user information
session_start();

// Helper function to read a JSON file and return it as a PHP array
function readJsonFile($filePath) {
    if (!file_exists($filePath)) {
        return [];
    }
    $jsonData = file_get_contents($filePath);
    return json_decode($jsonData, true) ?: [];
}

// Helper function to save a PHP array back into a JSON file
function writeJsonFile($filePath, $data) {
    $jsonData = json_encode($data, JSON_PRETTY_PRINT);
    file_put_contents($filePath, $jsonData);
}

// Function to check if a user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Function to get the currently logged in user details
function getCurrentUser() {
    if (!isLoggedIn()) return null;
    
    // Using __DIR__ to safely resolve the path relative to session.php
    $users = readJsonFile(__DIR__ . '/../data/users.json');
    foreach ($users as $user) {
        if ($user['id'] === $_SESSION['user_id']) {
            return $user;
        }
    }
    return null;
}
?>
