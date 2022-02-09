<?php
// Initialize the session
session_start();
 
// Include config file
require_once "config.php";
unset($_SESSION["id"]);
unset($_SESSION["username"]);
unset($_SESSION["loggedin"]);
header("location: login.php");
exit();
?>