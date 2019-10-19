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
    $stmt = $mysqli->prepare("UPDATE APPS SET company_name = ?, contact = ?, notes = ? WHERE app_key = ?");
    $stmt->bind_param("sssi", $_POST["company_name"], $_POST["contact"], $_POST["notes"], $article);
    $stmt->execute();
    header("Location: index.php");
}
else{
    echo "[$article]failed to edit";
}
?>