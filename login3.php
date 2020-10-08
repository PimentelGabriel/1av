<?php
if (!empty($_GET['login']) && !empty($_GET['senha'])) {
    try {

        $dsn = "mysql:host=localhost;dbname=loja";
        $user = "root";
        $senha = "";
        
        $conexao = new PDO($dsn, $user, $senha);
        $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $login = $_GET['login'];
        $senha = $_GET['senha'];

        $query =   "SELECT *
                    FROM usuarios
                    WHERE login = ? AND senha = ?";

        $stmt = $conexao->prepare($query);

        $stmt->bindValue(1, $_GET['login']);
        $stmt->bindValue(2, $_GET['senha']);

        $stmt->execute();

        $usuario = $stmt->fetchAll();

        echo "<hr>";
        echo "<pre>";
        print_r($usuario);
        echo "</pre>";
        
    } catch (PDOException $e) {
        echo 'Cod. Erro: ' . $e->getCode() . 'Messagem: ' . $e->getMessage();
    }
}