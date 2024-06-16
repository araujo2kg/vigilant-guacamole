<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

   $user_id = $_SESSION["id"];
   $date = date("Y-m-d");
   $sleep_time = $_POST["sleep-time"];
   $sleep_quality = $_POST["sleep-quality"];

   // Se os dados de hoje já foram enviados
   $check_query = "SELECT * FROM sleep_data WHERE sleep_date = '$date' AND user_id = $user_id";
   $check_result = $conn->query($check_query); 
   if ($check_result->num_rows > 0) {
        $message = "Dados de hoje ($date) já foram cadastrados.";
        header("Location:".DIR_PATH."/index.php?message=" . urlencode($message));
   } 
   else {
      // Inserir os dados de hoje
      $insert_query = "INSERT INTO sleep_data (user_id, sleep_date, sleep_time, sleep_quality) VALUES ($user_id, '$date', $sleep_time, $sleep_quality)";

      if ($conn->query($insert_query) === TRUE) {
         $message = "Dados inseridos com sucesso.";
         header("Location:".DIR_PATH."/index.php?message=" . urlencode($message));
      } else {
         $message = "Erro ao inserir dados: " . $conn->error;
         header("Location:".DIR_PATH."/index.php?message=" . urlencode($message));
      }
   }
}

?>

