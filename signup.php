<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>[AppTrac] Sign Up</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class = "header">
        <a class="link" href="index.php"><h1 class="logo">AppTrac</h1></a>
    </div>
    <form class="form-container" action="newuser.php" method="POST">
            <div class="grid">
                <h2>Sign up to start tracking your applications.</h2>
                <label class="input-label" for="username">New username:</label>
                <input class="text-input" type="text" name="username" id="username" /> <br>
                <label class="input-label"  for="username">New password:</label>
                <input class="text-input" type="password" name="password" id="password" /> <br>
                <label class="input-label"  for="username">Confirm password:</label>
                <input class="text-input" type="password" name="password2" id="password2" />
            </div>
            <ul>
                <li>Username can only contain characters a-z, A-Z, 0-9, underscores, and hyphens</li>
                <li>Username must be between 8 and 30 characters</li>
                <li>Password must be 8 or more characters</li>
            </ul>
            <input class="button" type="submit" value="REGISTER" />
            <a class="button" href="login.php">Back to Login</a>
            <?php if (!empty($_GET['error'])): ?>
            <div class="error">
                <?=htmlspecialchars($_GET['error']);?>
            </div>
            <?php endif;?>
        </form>
</body>
</html>