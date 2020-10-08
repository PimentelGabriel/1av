<?php 
//include('./php/conexao.php');
include('./php/crudClientes.php');

//A seção é iniciada no crud
if($_SESSION['loginOK'] != 'Logado'){
    # não encontrou
    # grava sessão loginErro e redireciona o usuário para a página de login

    $_SESSION['loginErro'] = "Seção Desconectada, Digite seu login e senha";
    header("Location: index.php");
}

#iniciando variveis
$nome = "";
$descricao = "";
$id = 0;
$update = false;

$nomecli = "";
$endercli = "";
$fonecli = "";
$emailcli = "";

# recupera o registro para edição
if (isset($_GET['edit'])) {
    $idcli = $_GET['edit'];
    $update = true;
    $record = mysqli_query($db, "SELECT * FROM clientes WHERE idcli=$idcli");
    # testa o retorno do select e cria o vetor com os registros trazidos

    if ($record) {
        $n = mysqli_fetch_array($record);
        $nomecli = $n['nomecli'];
        $endercli = $n['endercli'];
        $fonecli = $n['fonecli'];
        $emailcli = $n['emailcli'];
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
    <?php 
        $rsSelect = mysqli_query($db, "SELECT * FROM clientes");
    ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Endereço</th>
                <th>Fone</th>
                <th>Email</th>
                <th colspan="2">Ação</th>
            </tr>
        </thead>
        <!-- cria o vetor com os registros trazidos do select -->
        <!-- Início while -->
        <?php while ($rs = mysqli_fetch_array($rsSelect)) { ?>
        <tr>
            <td><?php echo $rs['idcli']; ?></td>
            <td><?php echo $rs['nomecli']; ?></td>
            <td><?php echo $rs['endercli']?></td>
            <td><?php echo $rs['fonecli'] ?></td>
            <td><?php echo $rs['emailcli']?></td>

            <td>
                <a href="clientes.php?edit=<?php echo $rs['idcli']; ?>" class="edit_btn">Alterar</a>
            </td>
            <td>
                <a href="./php/crudClientes.php?del=<?php echo $rs['idcli']; ?>" class="del_btn">Remover</a>
            </td>
        </tr>
        <?php } ?>
        <!-- Fim while -->
    </table>
    <!-- ------------------------------------------------------------ -->

    <form method="post" action="./php/crudClientes.php">
        <!-- campo oculto - contem o id do registro que vai ser atualizado -->
        <input type="hidden" name="idcli" value="<?php echo $id; ?>">
        
        <div class="input-group">
            <label>Nome</label>
            <input type="text" name="nomecli" value="<?php echo $nomecli; ?>">
        </div>
        <div class="input-group">
            <label>Endereço</label>
            <input type="text" name="endercli" value="<?php echo $endercli; ?>">
        </div>
        <div class="input-group">
            <label>Telefone</label>
            <input type="text" name="fonecli" value="<?php echo $fonecli; ?>">
        </div>
        <div class="input-group">
            <label>E-mail</label>
            <input type="text" name="emailcli" value="<?php echo $emailcli; ?>">
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