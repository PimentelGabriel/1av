<?php
session_start();

include('conexao.php');

// $server = 'localhost';
// $user = 'root';
// $psw = '';
// $dbase = 'loja';

// $server = 'sql313.epizy.com';
// $user = 'epiz_26890237';
// $psw = 'TvD58e0zmR5FH88';
// $dbase = 'epiz_26890237_loja';

// $db = mysqli_connect($server, $user, $psw, $dbase);

$_SESSION['db'] = $db;

//print_r($db);

# inicializa variáveis
$nomecli = "";
$endercli = "";
$id = 0;
$update = false;
$idcli = "";
$idprod = "";
$qtdven = "";

// print_r(validaCliente($_GET['a']));
// echo "<hr>";
// print_r(validaProduto($_GET['b']));
// print_r();

#testa se close db foi acionado
if(isset($_POST['close-db'])){
    mysqli_close($db);
    header('location: ../loja.php');
}

# adiciona Venda
if (isset($_POST['adiciona'])) {
    $idcli = $_POST['idcli'];
    $idprod = $_POST['idprod'];
    $qtdven = $_POST['qtdven'];

    validaCliente($idcli);

    if( filter_input(INPUT_POST, 'idcli')  &&
        filter_input(INPUT_POST, 'idprod') &&
        filter_input(INPUT_POST, 'qtdven')
    ){
        if( validaProduto($idprod) == 0 &&
            validaCliente($idcli) == 0 ){
            if(verEstoque($idprod, $qtdven)){    
                updateEstoque($idprod, $qtdven);
            
                mysqli_query($db, "INSERT INTO vendas (idcli, idprod, qtdVen) VALUE ('$idcli', '$idprod', '$qtdven')");

                # grava mensagem na sessão
                $_SESSION['message'] = "Venda efetuada!";
            }else{
                $_SESSION['message'] = "Estoque insuficiente!";
            }
        }else{
            $_SESSION['message'] = "Cliente ou produto não cadastrado!";
        }
    }else{
        $_SESSION['message'] = "Erro: Venda não efetuada!";
    }
    //echo $_SESSION['message'];
    header('location: ./../vendas.php');
}

# altera Venda
if (isset($_POST['altera'])) {
    
    $codven = $_POST['codven'];
    echo "CodVen: ".$codven."<p>";
    $idcli = $_POST['idcli'];
    $idprod = $_POST['idprod'];
    $qtdven = $_POST['qtdven'];

    if(filter_input(INPUT_POST, 'codven', FILTER_VALIDATE_INT) &&
        filter_input(INPUT_POST, 'idcli', FILTER_VALIDATE_INT) &&
        filter_input(INPUT_POST, 'idprod', FILTER_VALIDATE_INT) &&
        filter_input(INPUT_POST, 'qtdven', FILTER_VALIDATE_INT)
    ){
        if( validaProduto($idprod) == 0 &&
            validaCliente($idcli) == 0 ){
            if(verEstoque($idprod, $qtdven)){    
                updateEstoque($idprod, $qtdven);

                print_r(mysqli_query($db, "UPDATE vendas SET idcli = '$idcli', idprod = '$idprod', qtdVen = '$qtdven' WHERE codven = '$codven'"));
                $_SESSION['message'] = "Cliente alterado!";
            }else{
                $_SESSION['message'] = "Estoque insuficiente!";
            }
        }else{
            $_SESSION['message'] = "Cliente ou produto não cadastrado!";
        }
    }else{
        # grava mensagem na sessão
        $_SESSION['message'] = "Erro: O Cliente não foi alterado!";
    }
    
    //header('location: ./../vendas.php');
}

# remove Venda
if (isset($_GET['del'])) {
    $id = $_GET['del'];
    mysqli_query($_SESSION['db'], "DELETE FROM vendas WHERE codven=$id");

    # grava mensagem na sessão
    $_SESSION['message'] = "Venda Cancelada!";
        
    //header('location: ./../vendas.php');
}


// ____ __ __ __  __   ___ ______ __   ___   __  __  __ 
// ||    || || ||\ ||  //   | || | ||  // \\  ||\ || (( \
// ||==  || || ||\\|| ((      ||   || ((   )) ||\\||  \\ 
// ||    \\_// || \||  \\__   ||   ||  \\_//  || \|| \_))
//


#Atualização do BD quando realizada a venda


    //echo verEstoque($_GET['a'], $_GET['b']) ? "ok": "no ok";
    

function verEstoque($id, $qtdven){
    $query = "SELECT qtdEstoque FROM produtos WHERE id =".$id;
    $rsSelect = mysqli_query($_SESSION['db'], $query);
    $rs = mysqli_fetch_array($rsSelect);
    //print_r($rs[0]);

    //echo (int)$rs[0]." >= ".$qtdven." = ". (((int)$rs[0] >= $qtdven)?true:false);
    
    if((int)$rs[0] >= $qtdven) return true;
    else return false;
    
    //return ((int)$rs >= $qtdven);
}

function updateEstoque($id, $qtdven){
    if(isset($id) && isset($qtdven))
        print_r(mysqli_query($_SESSION['db'],   "UPDATE 
                                                    produtos
                                                SET 
                                                    qtdEstoque= (SELECT qtdEstoque FROM produtos WHERE id = ".$id.") - ".$qtdven." 
                                                WHERE
                                                    id = ".$id) );
}

function validaCliente($id){
    if(isset($id)){

        $query = "SELECT idcli FROM clientes WHERE idcli =".$id;
        $rsSelect = mysqli_query($_SESSION['db'], $query);
        // echo "<pre>";
        // print_r($rsSelect);
        // echo "<hr/><br/>";
        $rs = mysqli_fetch_array($rsSelect);

        //print_r($rs);
        //echo "</pre>";

        return isset($rs)?0:-1;
    }else{
        return -1;
    }
}

function validaProduto($id){
    if(isset($id)){
        $query = "SELECT id FROM produtos WHERE id =".$id;
        $rsSelect = mysqli_query($_SESSION['db'], $query);
        // echo "<pre>";
        // print_r($rsSelect);
        //echo "<hr/><br/>";
        $rs = mysqli_fetch_array($rsSelect);

        //print_r($rs);
        //echo "</pre>";

        return isset($rs)?0:-1;
    }else{
        return -1;
    }
}