<?php
session_start(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
    
</head>
<body>
        <div class="box">
                <h1>Login</h1>
                <form action="acesso.php" method="POST">                                       
                    <input type="text" name="email" placeholder="E-mail">
                    <br><br>
                    <input type="password" name="senha" placeholder="Senha">
                    <br><br>
                    <input class="inputSubmit" type="submit" name="submit" value="Enviar" >
                </form>
                <a href="cadastro.php">Cadastre-se</a>                
        </div>
</body>
</html>