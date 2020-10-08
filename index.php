<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Loja TADS - Login</title>

    <link href="css/css.css" rel="stylesheet"/>
</head>
<body>
    <p><?php
    if(isset($_SESSION['loginOK']))
    if($_SESSION['loginOK'] == 'Logado'){
        # testa se existe sessão loginErro
        if (isset($_SESSION['loginErro'])) {
            # recupera e mostra o valor da sessão loginErro 
            echo $_SESSION['loginErro'] . '<br><br>';
            # apaga a sessão loginErro 
            unset($_SESSION['loginErro']);
        }
    }else{
        # não encontrou
        # grava sessão loginErro e redireciona o usuário para a página de login

        echo "Seção Desconectada, Digite seu login e senha <br><br>";
    }
    ?></p>
    <form method="POST" action="valida.php">
        <h2>Loja TADS - Login</h2>
        <label>Login</label>
        <input type="text" name="login" placeholder="Login" required autofocus/>
        <br><br>
        <label>Senha</label>
        <input type="password" name="senha" placeholder="Senha" required/>
        <br><br>
        <button type="submit">Entrar</button>
</body>
</html>