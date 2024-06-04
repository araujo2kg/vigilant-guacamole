<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require 'config.php';
if(!empty($_SESSION["id"])){
    $id = $_SESSION["id"];
    $result = mysqli_query($conn, "SELECT * FROM usuarios WHERE id = $id");
    $row = mysqli_fetch_assoc($result);
}
else{
    header("Location:".DIR_PATH."/login.php");
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8">
        <title>Início</title>
    </head>
    <body>
        <h1>Bem vindo <?php echo $row["nome"]; ?>!</h1>
        <a href="<?php echo DIR_PATH; ?>/logout.php">Sair</a>
    </body>
</html>