<?php
session_start();

# conecta com o BD
$server = 'localhost';
$user = 'root';
$psw = '';
$dbase = 'loja';

// $server = 'sql313.epizy.com';
// $user = 'epiz_26890237';
// $psw = 'TvD58e0zmR5FH88';
// $dbase = 'epiz_26890237_loja';

$db = mysqli_connect($server, $user, $psw, $dbase);

# inicializa variáveis
$nome = "";
$descricao = "";
$id = 0;
$update = false;
$qtdEstoque = 0;
$precoUnitario = 0.0;
$ptoReposicao = 0;

#testa se close db foi acionado

if(isset($_POST['close-db'])){
    mysqli_close($db);
    header('location: index.html');
}

# adiciona produto
if (isset($_POST['adiciona'])) {

    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $qtdEstoque = $_POST['qtd-estoque'];
    $precoUnitario = $_POST['preco-unitario'];
    $ptoReposicao = $_POST['pto-reposicao'];

    mysqli_query($db, "INSERT INTO produtos (nome, descricao, qtdEstoque, precoUnitario, ptoReposicao) VALUE ('$nome', '$descricao', '$qtdEstoque', '$precoUnitario', '$ptoReposicao')");
    
    //mysqli_query($db, "INSERT INTO produtos (nome, descricao) VALUES ('$nome', '$descricao')");

    # grava mensagem na sessão
    $_SESSION['message'] = "Produto adicionado!";
    header('location: produtos.php');
}

# altera produto
if (isset($_POST['altera'])) {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $qtdEstoque = $_POST['qtd-estoque'];
    $precoUnitario = $_POST['preco-unitario'];
    $ptoReposicao = $_POST['pto-reposicao'];

    print_r($_POST);

    mysqli_query($db, "UPDATE produtos SET nome ='$nome', descricao = '$descricao', qtdEstoque = '$qtdEstoque', precoUnitario = '$precoUnitario', ptoReposicao = '$ptoReposicao' WHERE id = '$id'");

    # grava mensagem na sessão
    $_SESSION['message'] = "Produto alterado!";
    header('location: produtos.php');
}

# remove produto
if (isset($_GET['del'])) {
    $id = $_GET['del'];
    mysqli_query($db, "DELETE FROM produtos WHERE id=$id");

    # grava mensagem na sessão
    $_SESSION['message'] = "Produto removido!";
    header('location: produtos.php');
}