<?php 
    include 'config.php';
    session_start();
    if(empty($_POST) or (empty($_POST["email"]) or (empty($_POST["senha"])))){
        
        print "<script>location.href='login.php';</script>";

    }
    
    $email = $_POST["email"];
    $senha = $_POST["senha"];

        $sql = "SELECT * FROM produtostab WHERE email = '$email' AND senha = '$senha'";

       $resultado = $conn->query($sql);

    if(mysqli_num_rows($resultado) == 1 ){
        $_SESSION["email"] = $email;
        $_SESSION["senha"] = $senha;
        print "<script>location.href='sistema.php';</script>";

    }else{
        print "<script>alert,('Usuário e/ou Senha Incorreto(s)');</script>";
        print "<script>location.href='login.php';</script>";

    }

   