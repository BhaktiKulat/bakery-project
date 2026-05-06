<?php
require_once 'session.php';

if (!isLoggedIn()) {
    die("Unauthorized");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = getCurrentUser();
    $rating = (int)$_POST['rating'];
    $comment = $_POST['comment'];

    $feedbacksFile = '../data/feedback.json';
    $feedbacks = readJsonFile($feedbacksFile);

    $newFeedback = [
        "user_id" => $user['id'],
        "name" => $user['name'],
        "rating" => $rating,
        "comment" => $comment,
        "date" => date("Y-m-d H:i:s")
    ];

    $feedbacks[] = $newFeedback;
    writeJsonFile($feedbacksFile, $feedbacks);

    header("Location: ../feedback.php?success=1");
    exit();
}
?>
