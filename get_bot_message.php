<?php
date_default_timezone_set('Asia/Dhaka');
require_once 'dbconfig/config.php';

$stmt = trim($_POST['txt'], "'"); // strip extra quotes if they exist
$sql = "SELECT reply FROM chatbot_hints WHERE LOWER(question) LIKE LOWER('%$stmt%')";
$result = $db->prepare($sql);
$result->execute();
if ($result->rowCount() > 0) {
    $row = $result->fetch(PDO::FETCH_ASSOC);
    $content = $row['reply'];
} else {
    $content = "Sorry not be able to understand you";
}
$result->closeCursor();

$added_on = date('Y-m-d h:i:s');
$db->prepare("INSERT INTO message(message,added_on,type) VALUES('$stmt','$added_on','user')")->execute();

$added_on = date('Y-m-d h:i:s');
$db->prepare("INSERT INTO message(message,added_on,type) VALUES('$content','$added_on','bot')")->execute();

echo $content;
echo " ";
?>