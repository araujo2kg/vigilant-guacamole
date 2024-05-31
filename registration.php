<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require 'config.php';
if(!empty($_SESSION["id"])){
    header("Location: /seminario-project2/index.php");
}
if(isset($_POST["submit"])){
    $name = $_POST["name"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmpassword = $_POST["confirmpassword"];
    $duplicate = mysqli_query($conn, "SELECT * FROM usuarios WHERE apelido = '$username' OR email = '$email'");
    if(mysqli_num_rows($duplicate) > 0){
        echo
        "<script> alert('Erro: Usuário ou email já existem!'); </script>";
    }
    else{
        if($password == $confirmpassword){
            $query = "INSERT INTO usuarios (nome, apelido, email, senha) VALUES ('$name', '$username', '$email', '$password')";
            mysqli_query($conn,$query);
            echo
            "<script> alert('Cadastro completo!'); </script>";
        }
        else{
           echo 
            "<script> alert('Erro: Senhas não coincidem!'); </script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8">
        <title>Cadastro</title>
    </head>
    <body>
        <h2>Cadastro</h2>
        <form method="post" autocomplete="off">
            <label for="name">Nome :</label>
            <input type="text" name="name" id="name" required> <br>
            <label for="username">Apelido :</label>
            <input type="text" name="username" id="username" required> <br>
            <label for="email">Email :</label>
            <input type="email" name="email" id="email" required> <br>
            <label for="password">Senha :</label>
            <input type="password" name="password" id="password" required> <br>
            <label for="confirmpassword">Confirmação Senha :</label>
            <input type="password" name="confirmpassword" id="confirmpassword" required> <br>
            <button type="submit" name="submit">Cadastrar</button>
        </form>
        <br>
        <a href="/seminario-project2/login.php">Entrar</a>
    </body>
</html>