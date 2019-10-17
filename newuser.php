<?php
//validates the input of the user registration form
if (empty($_POST["username"]) || empty($_POST["password"]) || empty($_POST["password2"]))
{
    $message = "Please fill out all fields";
    header("Location: signup.php?error=" . urlencode($message));
    exit();
}
if ($_POST["password"] != $_POST["password2"])
{
    $message = "Passwords do not match";
    header("Location: signup.php?error=" . urlencode($message));
    exit();
}
if(!preg_match("/^[\w_\-]+$/", $_POST["username"])){
    $message = "Username can only contain characters a-z, A-Z, 0-9, underscores, and hyphens";
    header("Location: signup.php?error=" . urlencode($message));
    exit();
}
if(strlen($_POST["username"]) < 8 || strlen($_POST["username"]) > 30){
    $message = "Username and password must be 8 or more characters";
    header("Location: signup.php?error=" . urlencode($message));
    exit();
}
if(strlen($_POST["password"]) < 8){
    $message = "Username must be between 8 and 30 characters";
    header("Location: signup.php?error=" . urlencode($message));
    exit();
}
// if passed validation, the input is checked if the username is taken or not.
require('sqlaccess.php');
$stmt = $mysqli->prepare("SELECT * FROM USERS WHERE user_id = ?");
$stmt->bind_param("s", $_POST["username"]);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0)
{
    $message = "Username has already been taken";
    header("Location: signup.php?error=" . urlencode($message));
    exit();
}
// if all tests pass, the input data is stored into the database.
$stmt = $mysqli->prepare("INSERT INTO USERS (user_id, user_pw) VALUES (?, ?)");
$stmt->bind_param("ss", $_POST["username"], password_hash($_POST["password"], PASSWORD_BCRYPT));
$stmt->execute();
session_start();
$_SESSION["user_id"] = $_POST["username"];
$_SESSION["token"] = bin2hex(openssl_random_pseudo_bytes(32));
header("Location: index.php");
?>