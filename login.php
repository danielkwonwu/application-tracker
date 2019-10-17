<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>[AppTrac] Sign in</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body id = "login">
    <h2>Sign in to view your applications.</h2>
    <form name = "SignInForm" action="logging.php" method = "POST">
        <h3 class = 'center'>Sign in to access files</h3>
        <p class = "left">
            <label for="id">| Account >: </label> 
            <input type = 'text' name = "id">
        </p>
        <p class = "left">
            <label for="pw">| Password >: </label> > 
            <input type = 'text' name = "pw">
        </p>
        <p class = "right">
            <input type = "submit" value = "Sign In">
        </p>
        <p class = "right">
            <label for = "signup">If you don't have an account > </label><input type = "button" value = "Sign Up" onclick = "window.location='signup.php';">
        </p>
    </form>
</body>
</html>
