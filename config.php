<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


session_start();

$dir_path = dirname($_SERVER['SCRIPT_NAME']);
define('DIR_PATH', $dir_path);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "seminario-project";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>