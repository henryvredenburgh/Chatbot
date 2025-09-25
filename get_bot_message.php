<?php
date_default_timezone_set('Asia/Dhaka');
require_once 'dbconfig/config.php';

// --- Fetch reply ---
$sql = "SELECT reply FROM chatbot_hints WHERE LOWER(question) LIKE ?";
$stmt = $db->prepare($sql);
$term = "%" . strtolower($_POST['txt']) . "%";
$stmt->execute([$term]);

if ($stmt->rowCount() > 0) {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $content = $row['reply'];
} else {
    $content = "Sorry not be able to understand you";
}
$stmt->closeCursor();

// --- Insert user message ---
$added_on = date('Y-m-d H:i:s');
$insertUser = $db->prepare("INSERT INTO message (message, added_on, type) VALUES (?, ?, 'user')");
$insertUser->execute([$_POST['txt'], $added_on]);

// --- Insert bot reply ---
$added_on = date('Y-m-d H:i:s');
$insertBot = $db->prepare("INSERT INTO message (message, added_on, type) VALUES (?, ?, 'bot')");
$insertBot->execute([$content, $added_on]);

// --- Output reply ---
echo $content . " ";
?>
