<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>[AppTrac]</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="page-wrapper">
        <div class="header">
            <a class="logo" href="index.php"><h1 class="title">AppTrac</h1></a>
            <div class="user-info">
                <?php
                session_start();
                if (isset($_SESSION['user_id'])):
                ?>
                <p class="welcome">Welcome, <?=htmlspecialchars($_SESSION['user_id'])?></p>
                <form action="logout.php" method="POST">
                    <input class="button" type="submit" value="Sign Out">
                </form>
                <a class="right button" href="post.php">Add Application</a>
                <?php 
                else: ?>
                <p class="welcome"><a class="button" href="login.php">Sign In</a> to view your apps.</p>
                <?php endif; ?>
            </div>
        </div>
        <div class="content">
            <?php
            if (!isset($_SESSION['user_id'])): ?>
            <img src = "career.jpg">
            <h2 class="logo"><a class="button" href="login.php">Sign In</a> to view your apps.</h2>
            <?php endif;
            require('sqlaccess.php');
            $stmt = $mysqli->prepare("SELECT * FROM APPS JOIN USERS WHERE (USERS.user_key = APPS.owner_key) AND USERS.user_id = ? ORDER BY (APPS.time) ASC");
            $stmt->bind_param("s", $_SESSION["user_id"]);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()):
            ?>
            <div class="app">
                <a class="link" href="view.php?article=<?=htmlspecialchars($row["app_key"])?>"><h2 class="article-title"><?=htmlspecialchars($row["company_name"])?></h2></a>
                <p class="subtitle">Applied on <?=htmlspecialchars(date('m/d/Y H:i:s', strtotime($row["time"])))?></p>
                <?php if (!empty($row["contact"])): ?>
                <p class="subtitle">Contact Info : <?=htmlspecialchars($row["contact"])?> </p>
                <?php endif; ?>
                <p class="post-content body"><?=htmlspecialchars($row["notes"])?></p>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>
