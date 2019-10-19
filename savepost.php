<?php
if (empty($_POST["company_name"]) || empty($_POST["contact"]))
{
    $message = "Please enter company name and contact info.";
    header("Location: writePost.php?error=" . urlencode($message));
    exit();
}
session_start();
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
$stmt = $mysqli->prepare("SELECT * FROM USERS WHERE user_id = ?");
$stmt->bind_param("s", $_SESSION["user_id"]);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows == 1)
{
    $row = $result->fetch_assoc();
    $stmt = $mysqli->prepare("INSERT INTO APPS (owner_key, company_name, notes, contact) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $row["user_key"], $_POST["post_title"], $_POST["post_content"], $_POST["contact"]);
    $stmt->execute();
    header("Location: index.php");
}
?>