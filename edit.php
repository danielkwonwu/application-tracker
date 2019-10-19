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
if (!$owner){
    header("Location: login.php");
    session_destroy();
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>[AppTrac] New Post</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="page-wrapper">
        <div class="header">
            <a class="logo" href="index.php"><h1 class="title">AppTrac</h1></a>
            <div class="user-container">
                <?php if (isset($_SESSION['user_id'])): ?>
                <p class="welcome">Welcome, <?=htmlspecialchars($_SESSION['user_id'])?></p>
                <form action="logout.php" method="POST">
                    <input class="button" type="submit" value="Sign Out">
                </form>
                <?php else: ?>
                <p class="welcome">Welcome, Guest</p>
                <a class="button" href="login.php">Sign In</a>
                <?php endif; ?>
            </div>
        </div>
        <div class="content">
            <?php 
                $stmt = $mysqli->prepare("SELECT * FROM APPS WHERE (app_key = ?)");
                $stmt->bind_param("i", $article);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
            ?>
            <form id="apps" class="form-container" action="editing.php" method="POST">
                <div class="grid">
                    <label class="input-label" for="company_name">Company Name:</label>
                    <input class="text-input" type="text" name="company_name" id="company_name" value = "<?=$row["company_name"]?>" /><br>
                    <label class="input-label" for="contact">Contact Information:</label>
                    <input class="text-input" type="text" name="contact" id="contact" value = "<?=$row["contact"]?>" /><br>
                    <label class="input-label" for="notes">Notes:</label><br>
                    <textarea form="apps" rows="10" name="notes" id="notes"><?=$row["notes"]?></textarea><br>
                </div>
                <input class="button" type="submit" value="Post" />
                <a class="button" href="index.php">BACK</a>
                <input type="hidden" name="token" value="<?=htmlspecialchars($_SESSION['token'])?>" />
                <input type="hidden" name="article" value="<?=htmlspecialchars($article)?>">
                <?php if (!empty($_GET['error'])): ?>
                <div class="error">
                    <?=htmlspecialchars($_GET['error']);?>
                </div>
                <?php endif;?>
            </form>
        </div>
    </div>
</body>
</html>