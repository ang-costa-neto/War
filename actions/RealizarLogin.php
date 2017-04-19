<?php

    const  CRIA_UMA_NOVA_SESSAO = 1;
    const  CONTINUA_SESSAO = 0;

    require_once '../controller/Configuracao.class.php';
    require_once '../controller/Jogo.class.php';

    $nome = $_POST['nome'];

    $login = new \controller\Configuracao($nome);
    $jogo = new \controller\Jogo($nome);

    //Realiza o login

    if($login->iniciarSessao() == CRIA_UMA_NOVA_SESSAO){
        $jogo->iniciarJogo();
        header('Location: ../view/TelaJogo.php');
    }else{
        header('Location: ../view/TelaJogo.php');
    }