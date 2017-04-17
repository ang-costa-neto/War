<?php

    session_start();

    require_once ('../controller/Configuracao.class.php');
    require_once ('../controller/Jogo.class.php');

    $jogo = new \Jogo\Jogo($_SESSION['usuario']);

    $contador = 0;

    $pais_jogador = $_POST['pais_jogador'];
    $pais_pc = $_POST['pais_pc'];

    $exercito = $_SESSION['paises_jogador'][$pais_jogador]['exercito'];
    $tamanho_pais_pc = sizeof($_SESSION['paises_pc']);
    $alvo = '';

    for($i = 0; $i < $tamanho_pais_pc; $i++){
        if($pais_pc == $_SESSION['paises_pc'][$i]['pais']){
            $alvo = $i;
        }
    }

    while($contador < $exercito){
        $dado = $jogo->rodaDado();
        if($dado > 5){
            $_SESSION['paises_pc'][$alvo]['exercito']--;
            if( $_SESSION['paises_pc'][$alvo]['exercito'] == 0){
                array_push($_SESSION['paises_jogador'],$_SESSION['paises_pc'][$alvo]);
                unset($_SESSION['paises_pc'][$alvo]);
                $_SESSION['paises_pc'] = array_values($_SESSION['paises_pc']);
                break;
            }
        }else{
            $_SESSION['paises_jogador'][$pais_jogador]['exercito']--;
            if($_SESSION['paises_jogador'][$pais_jogador]['exercito'] == 0){
                array_push($_SESSION['paises_pc'],$_SESSION['paises_jogador'][$pais_jogador]);
                unset($_SESSION['paises_jogador'][$pais_jogador]);
                $_SESSION['paises_jogador'] = array_values($_SESSION['paises_jogador']);
                break;
            }
        }
        $contador++;
    }

