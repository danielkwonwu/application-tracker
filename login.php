<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>[AppTrac] Sign in</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h2>Sign in to view your applications.</h2>
    <form class="forms" action="logging.php" method="POST">
            <a class="logo" href="index.php"><h1 class="title">AppTrac</h1></a>
            <div class="grid">
                <label class="input-label" for="username">Username:</label>
                <input class="text-input" type="text" name="username" id="username" />
                <label class="input-label"  for="username">Password:</label>
                <input class="text-input" type="password" name="password" id="password" />
            </div>
            <input class="button" type="submit" value="LOGIN" />
            <a class="button" href="signup.php">SIGN UP</a>
            <?php if (!empty($_GET['error'])): 
            //simple login form, print if errored.
            ?>
            <div class="error">
                <?=htmlspecialchars($_GET['error']);?>
            </div>
            <?php endif;?>
        </form>
</body>
</html>
