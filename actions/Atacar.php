<?php

    session_start();

    require_once ('../controller/Configuracao.class.php');
    require_once ('../controller/Jogo.class.php');

    $jogo = new \Controller\Jogo($_SESSION['usuario']);

    $pais_jogador = $_POST['pais_jogador'];
    $pais_pc = $_POST['pais_pc'];

    $exercito = $_SESSION['paises_jogador'][$pais_jogador]['exercito'];
    $tamanho_pais_pc = sizeof($_SESSION['paises_pc']);
    $tamanho_pais_jogador = sizeof($_SESSION['paises_jogador']);
    $alvo = '';

    for($i = 0; $i < $tamanho_pais_pc; $i++){
        if($pais_pc == $_SESSION['paises_pc'][$i]['pais']){
            $alvo = $i;
        }
    }

    /*
     * Partida do jogador
     */

    //Pode atacar caso o exercito seja maior que 0
    if($exercito > 0){
        $jogo->atacar($pais_jogador,$alvo,'jogador');
    }else{
        $_SESSION['mensagens'] .= '<p>'.date("d/m/Y H:i:s").': '.$_SESSION['paises_jogador'][$pais_jogador]['pais'].' <b>não tem exercito para atacar</b></p>';
    }

    /*
     * Partida do computador
     */

    $tamanho_pais_pc = sizeof($_SESSION['paises_pc']);
    $tamanho_pais_jogador = sizeof($_SESSION['paises_jogador']);

    for($i = 0; $i < $tamanho_pais_pc; $i++){
        $tamanho_pais_pc_fronteira = sizeof($_SESSION['paises_pc'][$i]['fronteira']);
        for($j = 0; $j < $tamanho_pais_jogador; $j++){
            for($k = 0; $k < $tamanho_pais_pc_fronteira; $k++) {
                if($_SESSION['paises_pc'][$i]['fronteira'][$k] == $_SESSION['paises_jogador'][$j]['pais']){
                    if($_SESSION['paises_pc'][$i]['exercito'] > ($_SESSION['paises_jogador'][$j]['exercito']/2)
                        || $_SESSION['paises_pc'][$i]['exercito'] > $_SESSION['paises_jogador'][$j]['exercito']
                        || $_SESSION['paises_pc'][$i]['exercito'] == $_SESSION['paises_jogador'][$j]['exercito']){

                        $jogo->atacar($i,$j,'computador');
                        break 3;
                    }
                }
            }
        }
    }


    $jogo->distribuiExercito('jogador');
    $jogo->distribuiExercito('computador');
