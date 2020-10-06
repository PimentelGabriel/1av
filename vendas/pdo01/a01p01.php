<?php
# O PDO é uma classe nativa do PHP desde a versão 5.1
# classe PDO - parâmetro:
# PDO(dsn, usuario, senha)
# dsn - Data source name - nome da fonte de dados


# $dns = '<tipoDB> :host= <localhost> ; dbame = <nomeDB>';
$dsn = "mysql:host=localhost;dbname=vendas";
$user = "root";
$senha = "";

try {
    $conexao = new PDO($dsn, $user, $senha);
    //$conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = '
    CREATE TABLE usuarios(
        idcli int(5) not null primary key auto_increment,
        nomecli varchar(50) not null,
        endcli varchar(100) not null,
        fonecli varchar(15) not null,
        emailcli varchar(50) not null
    )';

    print_r($conexao->exec($query));
    
} catch (PDOExeception $e) {
    echo "<pre>";
    echo 'Cod. Erro: '.$e->getCode().'<br>'.'Mewnsagem: '.$e->getMesage();
    echo "</pre>";
}