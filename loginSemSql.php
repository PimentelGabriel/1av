<?php
$conexao = new PDO($dsn, $usuario, $senha);

$query = "SELECT * FROM usuario WHERE";
$query .= " email - :email";
$query .= " AND senha = :senha";

echo $query;

#prepara a query
$stmt = $conexao->prepare($query);

#examinar
$stmt->bindValue(':email', $_POST['email']);
$stmt->bindValue(':senha', $_POST['senha']);

#execultar
$stmt->execute();

$usuario = $stmt->fetch();

echo "<hr>";