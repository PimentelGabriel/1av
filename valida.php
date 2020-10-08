<?php
session_start();

include("conexao.php");
# login e senha preenchidos entra no if para validar
if ((isset($_POST['login'])) && (isset($_POST['senha']))) {

    # buscar na tabela usuarios o login e senha 
    # incluir proteção contra SQL Injection
    

    # encontrou
    # grava sessão loginOK e redireciona o usuário para a página loja.html
    $_SESSION['loginOK'] = 'Logado';
    header("Location: loja.php");

    # não encontrou
    # grava sessão loginErro e redireciona o usuário para a página de login
    $_SESSION['loginErro'] = "Usuário ou senha Inválido";
    header("Location: index.php");
} else {
    # campo usuário e senha não preenchido 
    # grava sessão loginErro e redireciona o usuário para a página de login
    $_SESSION['loginErro'] = "Usuário ou senha inválido";
    header("Location: index.php");
}