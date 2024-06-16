<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

   $user_id = $_SESSION["id"];
   $date = date("Y-m-d");
   $sleep_time = $_POST["sleep-time"];
   $sleep_quality = $_POST["sleep-quality"];

   // Se os dados de hoje já foram enviados
   $check_query = "SELECT * FROM sleep_data WHERE sleep_date = '$date'";
   $check_result = $conn->query($check_query); 
   if ($check_result->num_rows > 0) {
        $message = "Dados de hoje ($date) já foram cadastrados.";
        header("Location:".DIR_PATH."/index.php?message=" . urlencode($message));
   };
}

?>

