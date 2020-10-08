<?php 

if($_SESSION['loginOK'] != 'Logado'){
    # não encontrou
    # grava sessão loginErro e redireciona o usuário para a página de login

    $_SESSION['loginErro'] = "Usuário ou senha Inválido";
    header("Location: index.php");
}

//include('./php/conexao.php');
include('./php/crudVendas.php');

#iniciando variveis
$nome = "";
$descricao = "";
$id = 0;
$update = false;

$codven = "";
$idcli = "";
$idprod = "";
$nomecli = "";
$qtdven = "";
$nomeprod = "";

# recupera o registro para edição
if (isset($_GET['edit'])) {
    $codven = $_GET['edit'];
    $update = true;

    $selectVendasEdit = "SELECT
                            codven,
                            V.idcli,
                            V.idprod,
                            C.nomecli,
                            P.nome,
                            V.qtdVen as qtdven
                        FROM 
                            vendas as V,
                            clientes as C,
                            produtos as P 
                        WHERE
                            V.codven = '$codven' AND
                            V.idcli = C.idcli AND 
                            V.idprod = P.id";

    //print_r(mysqli_query($db, $selectVendasEdit));
    $record = mysqli_query($db, $selectVendasEdit);
    # testa o retorno do select e cria o vetor com os registros trazidos

    if ($record) {
        $n = mysqli_fetch_array($record);

        $codven = $n['codven'];
        $idcli = $n['idcli'];
        $idprod = $n['idprod'];
        $nomecli = $n['nomecli'];
        $nomeprod = $n['nome'];
        $qtdven = $n['qtdven'];
    }
}
?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Produtos</title>

    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/css.css">
    
    <!-- ADAPTANDO A FOLHA CSS PARA ESSA PÁGINA PHP -->
    <style>
        form{
            width: auto;
        };

        #msgQtd{
            color:red;
            font-size: .5em;
        }

    </style>
</head>

<body>

    <!-- teste se a sessão existe e exibe sua mensagem -->
    <?php if (isset($_SESSION['message'])) : ?>
    <div class="msg">
        <?php
            # exibe mensagem da sessão
            echo $_SESSION['message'];
            # apaga a sessão
            unset($_SESSION['message']);
            ?>
    </div>
    <?php endif ?>
    <!-- ------------------------------------------------- -->

    <!-- recupera os registros do banco de dados e exibe na página -->
    <?php 
        $selectVendas = "SELECT codven,
                            C.nomecli,
                            P.nome,
                            V.qtdVen,
                            V.qtdVen*P.precoUnitario as total
                        FROM 
                            vendas as V,
                            clientes as C,
                            produtos as P 
                        WHERE
                            V.idcli = C.idcli AND V.idprod = P.id";

        $rsSelect = mysqli_query($db, $selectVendas);
    ?>
    <table>
        <thead>
            <tr>
                <th>Cod.</th>
                <th>Cliente</th>
                <th>Produto</th>
                <th>Quantidade</th>
                <th>Total</th>
                <th colspan="2">Ação</th>
            </tr>
        </thead>
        <!-- cria o vetor com os registros trazidos do select -->
        <!-- Início while -->
        <?php while ($rs = mysqli_fetch_array($rsSelect)) { ?>
        <tr>
            <td><?php echo $rs['codven']; ?></td>
            <td><?php echo $rs['nomecli']; ?></td>
            <td><?php echo $rs['nome']?></td>
            <td><?php echo $rs['qtdVen'] ?></td>
            <td><?php echo $rs['total']?></td>

            <td>
                <a href="./vendas.php?edit=<?php echo $rs['codven']; ?>" class="edit_btn">Alterar</a>
            </td>
            <td>
                <a href="./php/crudVendas.php?del=<?php echo $rs['codven']; ?>" class="del_btn">Remover</a>
            </td>
        </tr>
        <?php } ?>
        <!-- Fim while -->
    </table>
    <!-- ------------------------------------------------------------ -->
    <div class="container">
        <div class="row-12">
                <form method="post" name="form" action="./php/crudVendas.php">
                    <label>ID da Venda:</label>
                    <input type="hidden" name="codven" value="<?php echo $codven; ?>"/>
                    <div class="form-row">
                        <div class="col-2">
                            <input type="number" disabled class="form-control" value="<?php echo $codven; ?>">
                        </div>
                    </div>
                    <br>
                    <label>Cliente</label>
                    <div class="form-row">
                        <div class="col-2">
                            <input type="number" oninput="verCliente();" min="1" class="form-control" id="idcli" name="idcli" placeholder="ID" value="<?php echo $idcli; ?>">
                        </div>
                        <div class="col-8">
                        <input type="text" id="nomecli" class="form-control" disabled placeholder="Cliente" value="<?php echo $nomecli; ?>">
                        </div>
                    </div>
                    <br>
                    <label>Produto</label>
                    <div class="form-row">
                        <div class="col-2">
                            <input type="number" oninput="verProduto();" name="idprod" id="idprod" min="1" class="form-control" placeholder="ID" value="<?php echo $idprod; ?>">
                        </div>
                        <div class="col-8">
                            <input type="text" id="nomeprod" class="form-control" disabled placeholder="Produto" value="<?php echo $nomeprod; ?>">
                        </div>
                        <div class="col-2">
                            <input type="number" class="form-control" oninput="verQtdEstoque();" id="qtdven" step="1" min="1" name="qtdven" placeholder="Qtd" value="<?php echo $qtdven; ?>">
                            <p id="msgQtd">
                            </p>
                        </div>
                    </div>
                    <br><br>
                    <div class="form-row">
                        <div class="col-3">
                            <?php if ($update == true) : ?>
                            <button class="btn" type="submit" name="altera" style="background: #556B2F;">Alterar</button>
                            <?php else : ?>
                            <button class="btn" type="submit" name="adiciona">Adicionar</button>
                            <?php endif;?>
                        </div>
                        <div class="col-6"></div>
                        <div class="col-2">
                            <input type="submit" class="btn" name="close-db" value="VOLTAR AO MENU">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        var res;
        function verCliente(){
            
            let id = parseInt(document.getElementById('idcli').value);
            
            //console.log(id);
            
            if(Number.isInteger(id)){
                try {
                    let serverAPi = "http://localhost:8080/LABWEBII/2av/loja/api/validaCliente.php?id=";
                    let xhr = new XMLHttpRequest();
                    
                    console.log(serverAPi+id);

                    xhr.open('GET', serverAPi+id);
                    xhr.send();

                    xhr.onreadystatechange = () => {
                        if(xhr.readyState == 4) {
                            if(xhr.status == 200){
                                var response = JSON.parse(xhr.responseText);
                                if(response.nomecli != null && response.nomecli != undefined){
                                    document.getElementById('nomecli').style = "color: black;";
                                    document.getElementById('nomecli').value = response.nomecli;
                                }else{
                                    document.getElementById('nomecli').value = "Id não encontrado";
                                    document.getElementById('nomecli').style = "color: red;";
                                }
                                
                            }
                        }
                    };
                                       
                } catch (e) {
                    document.getElementById('nomecli').value = "Sistema fora do ar";
                    document.getElementById('nomecli').style = "color: red;";
                }

            }else{
                document.getElementById('nomecli').value = "Erro: id invalido";
                document.getElementById('nomecli').style = "color: red;";
            }
        }

        function verProduto(){
            let id = parseInt(document.getElementById('idprod').value);
            
            //console.log(id);
            
            if(Number.isInteger(id)){
                try {
                    let serverAPi = "http://localhost:8080/LABWEBII/2av/loja/api/validaProduto.php?id=";
                    let xhr = new XMLHttpRequest();
                    
                    console.log(serverAPi+id);

                    xhr.open('GET', serverAPi+id);
                    xhr.send();

                    xhr.onreadystatechange = () => {
                        if(xhr.readyState == 4) {
                            console.table(xhr);
                            if(xhr.status == 200){
                                var response = JSON.parse(xhr.responseText);
                                if(response.nome != null && response.nome != undefined){
                                    document.getElementById('nomeprod').style = "color: black;";
                                    document.getElementById('nomeprod').value = response.nome;
                                }else{
                                    document.getElementById('nomeprod').value = "Id não encontrado";
                                    document.getElementById('nomeprod').style = "color: red;";
                                }
                                
                            }
                        }
                    };
                                       
                } catch (e) {
                    document.getElementById('nomeprod').value = "Sistema fora do ar";
                    document.getElementById('nomeprod').style = "color: red;";
                }

            }else{
                document.getElementById('nomeprod').value = "Erro: id invalido";
                document.getElementById('nomeprod').style = "color: red;";
            }
            verQtdEstoque();
        }
        
        function verQtdEstoque(){
            let id = parseInt(document.getElementById('idprod').value);
            
            //console.log(id);
            
            if(Number.isInteger(id)){
                try {
                    let serverAPi = "http://localhost:8080/LABWEBII/2av/loja/api/validaQtdEstoque.php?id=";
                    let xhr = new XMLHttpRequest();
                    
                    console.log(serverAPi+id);

                    xhr.open('GET', serverAPi+id);
                    xhr.send();

                    xhr.onreadystatechange = () => {
                        if(xhr.readyState == 4) {
                            if(xhr.status == 200){
                                var response = JSON.parse(xhr.responseText);
                                if(response.qtdEstoque != null && response.qtdEstoque != undefined){
                                    document.getElementById('msgQtd').innerText = "Valor máximo: "+response.qtdEstoque;
                                    
                                    if(parseInt(response.qtdEstoque) < parseInt(document.getElementById('qtdven').value)){
                                        document.getElementById('qtdven').style = "color: red;";
                                        document.getElementById('msgQtd').style = "color: red;";
                                    }else{
                                        document.getElementById('qtdven').style = "color: black;";
                                        document.getElementById('msgQtd').style = "color: black;";
                                    }
                                }else{
                                    document.getElementById('msgQtd').innerText = " ";
                                    document.getElementById('qtdven').style = "color: red;";
                                }
                                
                            }
                        }
                    };
                                       
                } catch (e) {
                    document.getElementById('msgQtd').innerText = "Sistema fora do ar";
                    document.getElementById('qtdven').style = "color: red;";
                }

            }else{
                document.getElementById('msgQtd').innerText = "Primeiro selecione o produto";
                document.getElementById('qtdven').style = "color: red;";
            }
        }
    </script>
</body>
</html>