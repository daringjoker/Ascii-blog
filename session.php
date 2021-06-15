<?php
session_start();
if(!isset($_SESSION['loggedin'])||$_SESSION['loggedin']!==true)
    header("location:login.php");

$accesslevel=$_SESSION['privilege'];
$username=$_SESSION['username'];
?>