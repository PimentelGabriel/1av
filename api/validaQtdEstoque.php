<?php

if(isset($_GET['id'])){
    include('../conexao/conexaoPDO.php');
    
    try{   
        $consulta = $conexao->query("SELECT qtdEstoque FROM produtos WHERE id = ".$_GET['id'].";");

        print_r(json_encode($consulta->fetch(PDO::FETCH_ASSOC)));
    }catch(PDOException $e){
        print_r($e);
    }finally{
        $conexao->connection = null;
    }
}