<?php

    const  CRIA_UMA_NOVA_SESSAO = 1;
    const  CONTINUA_SESSAO = 0;

    ini_set('xdebug.var_display_max_depth', 5);
    ini_set('xdebug.var_display_max_children', 256);
    ini_set('xdebug.var_display_max_data', 1024);

    require_once '../controller/Configuracao.class.php';
    require_once '../controller/Jogo.class.php';

    $nome = $_POST['nome'];

    $login = new \Configuracao\Configuracao($nome);
    $jogo = new \Jogo\Jogo($nome);

    ;

    if($login->iniciarSessao() == CRIA_UMA_NOVA_SESSAO){
        $jogo->iniciarJogo();
    }else{

    }

    echo '<pre>';
        var_dump($_SESSION);
    echo '</pre>';