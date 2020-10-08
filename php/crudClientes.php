<?php
session_start();

include('conexao.php');

// $server = 'localhost';
// $user = 'root';
// $psw = '';
// $dbase = 'vendas';

// // $server = 'sql313.epizy.com';
// // $user = 'epiz_26890237';
// // $psw = 'TvD58e0zmR5FH88';
// // $dbase = 'epiz_26890237_loja';

// $db = mysqli_connect($server, $user, $psw, $dbase);

//print_r($db);

# inicializa variáveis
$nomecli = "";
$endercli = "";
$id = 0;
$update = false;
$qtdEstoque = 0;
$precoUnitario = 0.0;
$ptoReposicao = 0;

#testa se close db foi acionado

if(isset($_POST['close-db'])){
    mysqli_close($db);
    header('location: ../loja.html');
}

# adiciona Cliente
if (isset($_POST['adiciona'])) {
    $nomecli = $_POST['nomecli'];
    $endercli = $_POST['endercli'];
    $fonecli = $_POST['fonecli'];
    $emailcli = $_POST['emailcli'];

    if( filter_input(INPUT_POST, 'nomecli')   &&
        filter_input(INPUT_POST, 'endercli')  &&
        filter_input(INPUT_POST, 'fonecli')   &&
        filter_input(INPUT_POST, 'emailcli')
    ){
        echo "<pre>";
        print_r($db);
        print_r(mysqli_query($db, "INSERT INTO clientes (nomecli, endercli, fonecli, emailcli) VALUE ('$nomecli', '$endercli', '$fonecli', '$emailcli')"));
        echo "</pre>";

        # grava mensagem na sessão
        $_SESSION['message'] = "Cliente adicionado!";
    }else{
        $_SESSION['message'] = "Erro: O Cliente não foi adicionado!";
    }
    //header('location: ../clientes.php');
}

# altera Cliente
if (isset($_POST['altera'])) {
    $idcli = $_POST['idcli'];
    $nomecli = $_POST['nomecli'];
    $endercli = $_POST['endercli'];
    $fonecli = $_POST['fonecli'];
    $emailcli = $_POST['emailcli'];

    if(filter_input(INPUT_POST, 'nomecli') &&
        filter_input(INPUT_POST, 'endercli') &&
        filter_input(INPUT_POST, 'fonecli') &&
        filter_input(INPUT_POST, 'emailcli')
    ){
        mysqli_query($db, "UPDATE clientes SET nomecli ='$nomecli', endercli = '$endercli', fonecli = '$fonecli', emailcli = '$emailcli' WHERE idcli = '$idcli'");
        $_SESSION['message'] = "Cliente alterado!";
    }else{
        # grava mensagem na sessão
        $_SESSION['message'] = "Erro: O Cliente não foi alterado!";
    }
    //header('location: ../clientes.php');
}

# remove Cliente
if (isset($_GET['del'])) {
    $idcli = $_GET['del'];
    mysqli_query($db, "DELETE FROM clientes WHERE idcli=$idcli");

    # grava mensagem na sessão
    $_SESSION['message'] = "Cliente removido!";
        
    //header('location: ../clientes.php');
}