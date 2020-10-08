<?php
  session_start();

  if(isset($_SESSION['loginOK'])){
    if($_SESSION['loginOK'] != 'Logado'){
      # não encontrou
      # grava sessão loginErro e redireciona o usuário para a página de login
      //http_response_code(404);
      header("location: index.php");

      $_SESSION['loginErro'] = "Seção Desconectada, Digite seu login e senha";
    }
  }else{
    # não encontrou
    # grava sessão loginErro e redireciona o usuário para a página de login
    //http_response_code(404);
    //header("location: index.php", true, 404);
    header("location: index.php");
      
    $_SESSION['loginErro'] = "Seção Desconectada, Digite seu login e senha";
  }
?>

<!DOCTYPE html>
<html>
    <head>
       <title>Loja</title>
       <meta charset="utf-8"/> 
       <link rel="stylesheet" href="css/bootstrap.min.css"/> 
    </head>
    <body>
        <div class="container">
          <br>
          <br>
            <div class="row">
              <h2>Loja do Lojista</h2>
            </div>
          <br>
          <br>
            <div class="row">
              <div class="col">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                    <a class="nav-link active">Menu Principal</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="produtos.php">Produtos</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="clientes.php">Clientes</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="vendas.php">Vendas</a>
                  </li>
                </ul>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <div class="card">
                  <div class="card-header">
                    Destaque
                  </div>
                  <div class="card-body">
                    <h5 class="card-title">Produto Especial</h5>
                    <p class="card-text">Conheça nossos produtos especiais, feito especial mente para pessoas especials, como voçê que é especial.</p>
                    <a href="#" class="btn btn-primary">Visitar</a>
                  </div>
                </div>
              </div>
              <div class="col">
                <div class="card">
                  <div class="card-header">
                    Destaque
                  </div>
                  <div class="card-body">
                    <h5 class="card-title">Elite</h5>
                    <p class="card-text">Conhece nossa linha de eleite feita com materia prima de elite e proficionais de elite.</p>
                    <a href="#" class="btn btn-primary">Visitar</a>
                  </div>
                </div>
              </div>
            </div>
        </div>
    </body>
</html>