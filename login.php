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
        <meta charset="utf-8">
        <title>Entrar</title>
    </head>
    <body>
        <h2>Entrar</h2>
        <form method="post" autocomplete="off">
            <label for="usernameemail">Apelido ou Email:</label>
            <input type="text" name="usernameemail" id="usernameemail" required> <br>
            <label for="password">Senha:</label>
            <input type="password" name="password" id="password" required> <br>
            <button type="submit" name="submit">Entrar</button>
        </form>
        <br>
        <a href="<?php echo DIR_PATH; ?>/registration.php">Cadastrar</a>
    </body>
</html>