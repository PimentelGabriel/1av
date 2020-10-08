<?php
if (!empty($_POST['email'] && $_POST['senha'])) {
    $dsn = 'mysql:host=localhost;dbname=vendas';
    $usuario = 'root';
    $senhaBD = '';

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    try {
        $conexao = new PDO($dsn, $usuario, $senhaBD);

        # montando o select
        $query = "SELECT * FROM usuario where";
        $query .= " email = :email";
        $query .= " AND senha = :email";

        # mostrando o select
        echo $query;

        # execut
        # executando o select
        $stmt = $conexao->query($query);

        $usuario = $stmt->fetchAll();

        # mostrando a execução do select
        echo "<hr>;";
        echo "<pre>";
        print_r($usuario);
        echo "</pre>";

    } catch (PDOException $e) {
        echo 'Cod. Erro: ' . $e->getCode() . 'Messagem: ' . $e->getMessage();
    }
}