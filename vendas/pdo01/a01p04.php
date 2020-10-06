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

    $query = 'SELECT * FROM usuarios';

    //$stmt = $conexao->query($query);
    
	//$lista = $stmt->fetchAll();
	//PDO::FETCH_NUM indice com numero
	//PDO::FETCH_ASSOC indice associativo
	//PDO::FETCH_BOTH tras ambos
	
	/*
	echo "<pre>";
		#echo $lista[1]['nome']."<br>";
		#echo $lista[2][2];
		print_r($lista);
	echo "</pre>";
	*/
	
	foreach($conexao->query($query) as $key => $registro){
		echo $registro['nome'];
		echo '<hr>';
	}
	
} catch (PDOExeception $e) {
    echo "<pre>";
    echo 'Cod. Erro: '.$e->getCode().'<br>'.'Mewnsagem: '.$e->getMesage();
    echo "</pre>";
}