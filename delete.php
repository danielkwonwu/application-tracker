<?php
session_start();

$article = filter_input(INPUT_POST, "article", FILTER_SANITIZE_NUMBER_INT);

if(!isset($_SESSION["user_id"]) || !isset($_SESSION["token"])){
    header("Location: login.php");
	exit();
}
if(!hash_equals($_SESSION["token"], $_POST["token"])){
    header("Location: login.php");
	exit();
}
//validates the post inputs and submits the contents to the database
require('sqlaccess.php');
$stmt = $mysqli->prepare("SELECT * FROM USERS JOIN APPS WHERE APPS.owner_key = USERS.user_key AND user_id = ?");
$stmt->bind_param("s", $_SESSION["user_id"]);
$stmt->execute();
$result = $stmt->get_result();
$owner = false;
while ($row = $result->fetch_assoc())
{
    if ($row["app_key"] == $article)
    {
        $owner = true;
    }
}

if ($owner){
    $stmt = $mysqli->prepare("DELETE FROM posts WHERE (app_key = ?)");
    $stmt->bind_param("i", $article);
    $stmt->execute();
    header("Location: index.php");
}
?>