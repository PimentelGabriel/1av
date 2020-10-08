<?php 
//session_start();
include('crud.php');

if($_SESSION['loginOK'] != 'Logado'){
    # não encontrou
    # grava sessão loginErro e redireciona o usuário para a página de login

    $_SESSION['loginErro'] = "Seção Desconectada, Digite seu login e senha";
    header("Location: index.php");
}



# recupera o registro para edição
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $update = true;
    $record = mysqli_query($db, "SELECT * FROM produtos WHERE id=$id");
    # testa o retorno do select e cria o vetor com os registros trazidos

    if ($record) {
        $n = mysqli_fetch_array($record);
        $nome = $n['nome'];
        $descricao = $n['descricao'];
        $qtdEstoque = $n['qtdEstoque'];
        $precoUnitario = $n['precoUnitario'];
        $ptoReposicao = $n['ptoReposicao'];
    }
}
?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Cadastro de Produtos</title>
    <link rel="stylesheet" type="text/css" href="css/css.css">
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
    <?php $results = mysqli_query($db, "SELECT * FROM produtos"); ?>
    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Qtd. em Estoque</th>
                <th>Preço Unitário</th>
                <th>Qtd p/ Reposição</th>
                <th colspan="2">Ação</th>
            </tr>
        </thead>
        <!-- cria o vetor com os registros trazidos do select -->
        <!-- Início while -->
        <?php while ($rs = mysqli_fetch_array($results)) { ?>
        <tr>
            <td><?php echo $rs['nome']; ?></td>
            <td><?php echo $rs['descricao']; ?></td>
            
            <td><?php echo $rs['qtdEstoque']?></td>
            <td><?php echo $rs['precoUnitario']?></td>
            <td><?php echo $rs['ptoReposicao']?></td>

            <td>
                <a href="produtos.php?edit=<?php echo $rs['id']; ?>" class="edit_btn">Alterar</a>
            </td>
            <td>
                <a href="crud.php?del=<?php echo $rs['id']; ?>" class="del_btn">Remover</a>
            </td>
        </tr>
        <?php } ?>
        <!-- Fim while -->
    </table>
    <!-- ------------------------------------------------------------ -->

    <form name="form" method="post" action="crud.php">
        <!-- campo oculto - contem o id do registro que vai ser atualizado -->
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        
        <div class="input-group">
            <label>Produto</label>
            <input type="text" name="nome" value="<?php echo $nome; ?>">
        </div>
        <div class="input-group">
            <label>Descrição</label>
            <input type="text" name="descricao" value="<?php echo $descricao; ?>">
        </div>
        <div class="input-group">
            <label>Qtd. Estoque</label>
            <input type="number" name="qtd-estoque" value="<?php echo $qtdEstoque; ?>">
        </div>
        <div class="input-group">
            <label>Preço Unitário</label>
            <input type="number" name="preco-unitario" value="<?php echo $precoUnitario; ?>">
        </div>
        <div class="input-group">
            <label>Qtd p/ Reposição</label>
            <input type="number" name="pto-reposicao" value="<?php echo $ptoReposicao; ?>">
        </div>
        <div class="input-group">
            <!-- <button class="btn" type="submit" name="adiciona">Adicionar</button> -->
            <?php if ($update == true) : ?>
            <button class="btn" type="submit" name="altera" style="background: #556B2F;">Alterar</button>
            <?php else : ?>
            <button class="btn" type="submit" name="adiciona">Adicionar</button>
            <?php endif;?>
        </div>
        <br><br> <br> <br> <br>
        <div class="input-group">
            <a ><input type="submit" class="btn" name="close-db" value="VOLTAR AO MENU"></a>
        </div>
    </form>
    <script>
        function limpaCampos(){
            //alert("AKDUJb");
            document.getElementByName('form').submit();
        }

        window.onload = setTimeout(() => {
            try {
                document.querySelector("body").removeChild(document.querySelector("div[class='msg']"));
            } catch (error) {
                return 0;
            }
        }, 5000);
    </script>
</body>

</html>