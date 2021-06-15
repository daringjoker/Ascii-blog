<?php
session_start();
$_SESSION = array();
session_destroy();
if(isset($_SERVER["HTTP_REFERER"]))
$ref=$_SERVER["HTTP_REFERER"];
else
    $ref="/";
header("location: $ref");
exit;
?>
