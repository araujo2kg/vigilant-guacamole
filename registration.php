<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require 'config.php';
if(!empty($_SESSION["id"])){
    header("Location:".DIR_PATH."/index.php");
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
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link href="styles.css" rel="stylesheet">
        <meta charset="utf-8">
        <title>Cadastro</title>
    </head>
    <body>
        <?php include 'header.php'; ?>
        <main>
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
            <a href="<?php echo DIR_PATH; ?>/login.php">Entrar</a>
        </main>
        <?php include 'footer.php'; ?>
    </body>
</html>