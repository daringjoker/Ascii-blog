<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gremlin Diaries</title>
    <link rel="stylesheet" href="static/css/login.css">
</head>
<body>
<div class="main">
    <header>
        <img src="static/img/logo.png" width="400px" height="240px">
    </header>
    <div class="centerize">
        <form action="api.php?action=login" method="POST">
            <label for="username">Username</label>
            <input type="text" id="username" name="username">
            <label for="password">Password</label>
            <input type="password" id="password" name="password">
            <input type="submit" value="LOG IN">
            <small>don't have an account? <a href="register.php">signup</a> now</small>
        </form>
    </div>
</div>
</body>
</html>
