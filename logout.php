<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require 'config.php';
$_SESSION = [];
session_unset();
session_destroy();
header("Location:".DIR_PATH."/login.php");
?>