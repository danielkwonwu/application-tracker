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
                    <input class="user-button" type="submit" value="LOGOUT">
                </form>
                <a class="right button" href="post.php">Add Application</a>
                <?php 
                else: ?>
                <p class="welcome">Log in to view your apps.</p>
                <a class="user-button" href="login.php">LOGIN</a>
                <?php endif; ?>
            </div>
        </div>
        <div class="content">
            <?php
            require('sqlaccess.php');
            $stmt = $mysqli->prepare("SELECT * FROM APPS JOIN USERS WHERE (USERS.user_key = APPS.owner_key) ORDER BY (APPS.time) ASC");
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()):
            ?>
            <div class="post">
                <a class="link" href="view.php?article=<?=htmlspecialchars($row["app_key"])?>"><h2 class="article-title"><?=htmlspecialchars($row["company_name"])?></h2></a>
                <?php if (!empty($row["contact"])): ?>
                <p class="subtitle">Contact Info : <?=htmlspecialchars($row["contact"])?> </p>
                <?php endif; ?>
                <p class="subtitle">Posted by <?=htmlspecialchars($row["user_id"])?> on  <?=htmlspecialchars(date('m/d/Y H:i:s', strtotime($row["time"])))?></p>
                <p class="post-content body"><?=htmlspecialchars($row["notes"])?></p>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>
