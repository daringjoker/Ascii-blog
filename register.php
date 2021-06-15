<?php if (!isset($_POST['email'])):?>
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
<div class="main" style="padding:10px!important;">
    <header>
        <img src="static/img/logo.png" width="400px" height="240px" style="margin-top:35%;">
    </header>
    <div class="centerize">
        <form  method="POST">
            <label for="fname">First Name</label>
            <input type="text" id="fname" name="firstname">
            <label for="lname">Last Name</label>
            <input type="text" id="lname" name="lastname">
            <label for="mail">Email</label>
            <input type="email" id="mail" name="email">
            <label for="username">Username</label>
            <input type="text" id="username" name="username">
            <label for="password">Password</label>
            <input type="password" id="password" name="password">
            <label for="password2">Confirm Password</label>
            <input type="password" id="password2" name="password2">
            <input type="submit" value="Sign Up">
        </form>
    </div>
</div>
</body>
</html>
<?php else:{
    include_once ("core/utilities.php");
        $fname=$_POST["firstname"];
        $lname=$_POST['lastname'];
        $username=$_POST['username'];
        $password=$_POST['password'];
        $password2=$_POST['password2'];
        $email=$_POST['email'];
        if($fname===""||$lname===""||$username===""|| $password===""||$email==="")
        {
            error("required fields cannot be empty");
        }
        if(strlen($password)<6||strlen($password)>50)
        {
            error("password must be between 6 and 50 characters");
        }
        if($password!==$password2)
        {
            error("passwors do not match");
        }
        if(!filter_var($email,FILTER_VALIDATE_EMAIL))
        {
            error("email is not valid");
        }
//        if (!preg_match("/^[a-zA-Z]*$/",$fname)||!!preg_match("/^[a-zA-Z]*$/",$lname)) {
//            error("Only letters allowed in name");
//        }
        if (!preg_match("/^[a-zA-Z0-9-_]*$/",$username)) {
        error("Only letters numbers and - _ allowed for the username");
        }
        include_once("core/database.php");
        addUser($fname,$lname,$email,$username,$password);
        header("location: login.php");
    }
    ?>

<?php endif;?>
