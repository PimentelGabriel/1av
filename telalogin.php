<?php
session_start();
# testa se existe sessão loginErro
if (isset($_SESSION['loginErro'])) {
    # recupera e mostra o valor da sessão loginErro 
    echo $_SESSION['loginErro'] . '<br><br>';
    # apaga a sessão loginErro 
    unset($_SESSION['loginErro']);
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loja TADS - Login</title>
</head>

<body>
    <form method="POST" action="valida.php">
        <h2>Loja TADS - Login</h2>
        <label>Login</label>
        <input type="email" name="login" placeholder="Login" required autofocus>
        <label>Senha</label>
        <input type="password" name="senha" placeholder="Senha" required>
        <button type="submit">Entrar</button>
    </form>
</body>

</html>