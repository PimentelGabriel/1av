<?php
if (!empty($_GET['login'] && $_GET['senha'])) {
    echo "I'm Here<br><br>";

    $dsn = "mysql:host=localhost;dbname=loja";
    $user = "root";
    $senha = "";

    try {
        $conexao = new PDO($dsn, $user, $senha);
        $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $login = $_GET['login'];
        $senha = $_GET['senha'];

        echo "<pre>";
        print_r($conexao);
        echo "</pre>";

        // # montando o select
        // $query = 'SELECT * FROM usuarios where';
        // $query .= " login = '{$login}'";
        // $query .= " AND senha = '{$senha}'";

        # mostrando o select
        echo $query;

        $query = "SELECT * FROM usuarios WHERE login = :login AND senha = :senha";

        # execut
        # executando o select
        $stmt = $conexao->query($query);

        // echo "<hr>";
        // echo "<pre>";
        // print_r($stmt);
        // echo "</pre>";

        $stmt->bindValue(':login', $_GET['login']);
        $stmt->bindValue(':senha', $_GET['senha']);

        // echo "<hr>";
        // echo "<pre>";
        // print_r($stmt);
        // echo "</pre>";
        
        $stmt->execute();

        // echo "<hr>";
        // echo "<pre>";
        // print_r($stmt);
        // echo "</pre>";

        $usuario = $stmt->fetch();

        # mostrando a execução do select
        echo "<hr>";
        echo "<pre>";
        print_r($usuario);
        echo "</pre>";

    } catch (PDOException $e) {
        echo 'Cod. Erro: ' . $e->getCode() . 'Messagem: ' . $e->getMessage();
    }
}