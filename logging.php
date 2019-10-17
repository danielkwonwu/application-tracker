<?php
if (empty($_POST["username"]) || empty($_POST["password"]))
{
    $message = "Please enter a username and password";
    header("Location: login.php?error=" . urlencode($message));
    exit();
}
if(!preg_match("/^[\w_\-]+$/", $_POST["username"])){
    $message = "Invalid username or password";
    header("Location: login.php?error=" . urlencode($message));
    exit();
}
if(!preg_match("/^[\w_\-]+$/", $_POST["password"])){
    $message = "Invalid username or password";
    header("Location: login.php?error=" . urlencode($message));
    exit();
}
require 'sqlaccess.php';
$stmt = $mysqli->prepare("SELECT * FROM USERS WHERE user_id = ?");
$stmt->bind_param("s", $_POST["username"]);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows == 1)
{
    $row = $result->fetch_assoc();
    if (password_verify($_POST["password"], $row["user_pw"]))
    {
        session_start();
        $_SESSION["user_id"] = $row["user_id"];
        $_SESSION["token"] = bin2hex(openssl_random_pseudo_bytes(32));
        header("Location: index.php");
        exit();
    }
}
//If not validated, exit with an error message
$message = "Invalid username or password";
header("Location: login.php?error=" . urlencode($message));
?>