<?php
# O PDO é uma classe nativa do PHP desde a versão 5.1
# classe PDO - parâmetro:
# PDO(dsn, usuario, senha)
# dsn - Data source name - nome da fonte de dados

# $dns = '<tipoDB> :host= <localhost> ; dbame = <nomeDB>';
$dsn = "mysql:host=localhost;dbname=vendas";
$user = "root";
$senha = "";

// $dsn = "mysql:host=sql313.epizy.com;dbname=epiz_26890237_vendas";
// $user = "epiz_26890237";
// $senha = "TvD58e0zmR5FH88";

try {
    $conexao = new PDO($dsn, $user, $senha);
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOExeception $e) {
    echo "<pre>";
    echo 'Cod. Erro: '.$e->getCode().'<br>'.'Mewnsagem: '.$e->getMesage();
    echo "</pre>";
}