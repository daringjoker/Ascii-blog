<?php require_once("utilities.php")?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gremlin Diaries</title>
    <link rel="stylesheet" href="static/css/hdr.css">
</head>
<body>
<header class="hdr">


        <?php   echo headerify("Gremlin Diaries");?>
</header>
<div>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="blog.php">Blogs</a></li>
            <li><a href="about.php">About</a></li>
<!--            <li><a href="contact.php">Contact</a></li>-->
            <li>
                <?php
                session_start();
                if(isset($_SESSION['loggedin'])&&$_SESSION['loggedin']===true){
                echo "<a id='profile' href='panel.php' title='Control Panel'>{$_SESSION['username']}</a>";
                echo "<a id='logout' href='logout.php' title='logout'>	&#x26d2;</a>";
                }
                else{
                echo "<a id='profile' href='login.php'>login</a>";
                }?>
            </li>
        </ul>
    </nav>
</div>

