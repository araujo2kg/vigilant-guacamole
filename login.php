<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require 'config.php';
if(!empty($_SESSION["id"])){
    header("Location:".DIR_PATH."/index.php");
}
if(isset($_POST["submit"])){
    $usernameemail = $_POST["usernameemail"];
    $password = $_POST["password"];
    $result = mysqli_query($conn, "SELECT * FROM usuarios WHERE apelido = '$usernameemail' OR email = '$usernameemail'");
    $row = mysqli_fetch_assoc($result);
    if(mysqli_num_rows($result) > 0){
        if($password == $row["senha"]){
            $_SESSION["login"] = true;
            $_SESSION["id"] = $row["id"];
            header("Location:".DIR_PATH."/index.php");
        }
        else{
            echo
                "<script> alert('Erro: Senha incorreta!'); </script>";
        }
    }
    else {
        echo
            "<script> alert('Erro: Usuário não existe!'); </script>";
    }
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
        <title>Entrar</title>
        <style>
            .container {
                width: 500px;
            }
        </style>
    </head>
    <body>
        <?php include 'header.php'; ?>
        <main>
            <div class="container text-center log-card">
                <h2 class="display-4">Entrar</h2>
                <form method="post" autocomplete="off">
                    <input type="text" name="usernameemail" id="usernameemail" class="form-control" placeholder="Apelido ou Email" required>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Senha" required>
                    <button type="submit" name="submit" class="btn btn-primary" style="margin: 10px 0;">Continuar</button><br>
                    <span class="form-text">Não tem uma conta? <a href="<?php echo DIR_PATH; ?>/registration.php"> Cadastre-se agora!</a></span>
                </form>
                <br>
            </div>
        </main>
        <?php include 'footer.php'; ?>
    </body>
</html>