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
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link href="styles.css" rel="stylesheet">
        <meta charset="utf-8">
        <title>Início</title>
    </head>
    <body>
        <?php include 'header.php'; ?>
        <main>
            <div class="container">
                <div class="row" id="greeting">
                    <h1>Bem vindo <?php echo $row["nome"]; ?>!</h1>
                </div>
                <div class="row" id="form-display">
                    <div class="col-6" id="data-collect">
                        <?php $date_test = date("Y-m-d");
                        echo "<script> console.log('testing:  $date_test'); </script>";
                        ?>

                    </div>
                    <div class="col-6" id="data-display"></div>
                </div>
                <div class="row" id="sleep-calc"></div>
            </div>
        </main>
        <?php include 'footer.php'; ?>
    </body>
</html>