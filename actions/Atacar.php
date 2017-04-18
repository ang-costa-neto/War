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

    while($contador < $exercito){
        $dado = $jogo->rodaDado();
        $_SESSION['mensagens'] .= '<p>'.date("d/m/Y H:i:s").': Valor no dado foi '.$dado.'</p>';

        $_SESSION['mensagens'] .= '<p>'.date("d/m/Y H:i:s").': '.$_SESSION['paises_jogador'][$pais_jogador]['pais'].' ataca '.$_SESSION['paises_pc'][$alvo]['pais'].'</p>';

        if($dado > 5){
            $_SESSION['paises_pc'][$alvo]['exercito']--;

            $_SESSION['mensagens'] .= '<p>'.date("d/m/Y H:i:s").': O '.$_SESSION['paises_pc'][$alvo]['pais'].' perdeu 1 exercito, resta '.$_SESSION['paises_pc'][$alvo]['exercito'].'</p>';

            if( $_SESSION['paises_pc'][$alvo]['exercito'] == 0){

                $_SESSION['paises_jogador'][$pais_jogador]['exercito']--;

                $_SESSION['mensagens'] .= '<p>'.date("d/m/Y H:i:s").': '.$_SESSION['paises_jogador'][$pais_jogador]['pais'].' dominou '.$_SESSION['paises_pc'][$alvo]['pais'].'</p>';

                array_push($_SESSION['paises_jogador'],$_SESSION['paises_pc'][$alvo]);
                unset($_SESSION['paises_pc'][$alvo]);
                $_SESSION['paises_pc'] = array_values($_SESSION['paises_pc']);
                $_SESSION['paises_jogador'][key(array_slice($_SESSION['paises_jogador'], -1, 1, TRUE))]['exercito'] = 1;
                break;
            }
        }else{
            $_SESSION['paises_jogador'][$pais_jogador]['exercito']--;

            $_SESSION['mensagens'] .= '<p>'.date("d/m/Y H:i:s").': O '.$_SESSION['paises_jogador'][$pais_jogador]['pais'].' perdeu 1 exercito, resta '.$_SESSION['paises_jogador'][$pais_jogador]['exercito'].'</p>';

            if($_SESSION['paises_jogador'][$pais_jogador]['exercito'] == 0){

                $_SESSION['paises_pc'][$alvo]['exercito']--;

                $_SESSION['mensagens'] .= '<p>'.date("d/m/Y H:i:s").': '.$_SESSION['paises_pc'][$alvo]['pais'].' dominou '.$_SESSION['paises_jogador'][$pais_jogador]['pais'].'</p>';

                array_push($_SESSION['paises_pc'],$_SESSION['paises_jogador'][$pais_jogador]);
                unset($_SESSION['paises_jogador'][$pais_jogador]);
                $_SESSION['paises_jogador'] = array_values($_SESSION['paises_jogador']);
                $_SESSION['paises_pc'][key(array_slice($_SESSION['paises_pc'], -1, 1, TRUE))]['exercito'] = 1;
                break;
            }
        }
        $contador++;
    }

    /*
     * Partida do computador
     */

    //Recalcula o tamanho do array
    $tamanho_pais_pc = sizeof($_SESSION['paises_pc']);
    $tamanho_pais_jogador = sizeof($_SESSION['paises_jogador']);

    $possibilidade_ataque = array();
    $contador = 0;

    for($i = 0; $i < $tamanho_pais_pc; $i++){
        $tamanho_pais_pc_fronteira = sizeof($_SESSION['paises_pc'][$i]['fronteira']);
        for($j = 0; $j < $tamanho_pais_jogador; $j++){
            for($k = 0; $k < $tamanho_pais_pc_fronteira; $k++) {
                if($_SESSION['paises_pc'][$i]['fronteira'][$k] == $_SESSION['paises_jogador'][$j]['pais']){
                    if ($_SESSION['paises_pc'][$i]['exercito'] > $_SESSION['paises_jogador'][$j]['exercito']){

                        $possibilidade_ataque[$contador]['pais_ataque'] = $_SESSION['paises_pc'][$i]['pais'];

                        $possibilidade_ataque[$contador]['pais_ataque_exercito'] = $_SESSION['paises_pc'][$i]['exercito'];

                        $possibilidade_ataque[$contador]['pais_alvo'] = $_SESSION['paises_jogador'][$j]['pais'];

                        $possibilidade_ataque[$contador]['pais_ataque_exercito'] = $_SESSION['paises_jogador'][$j]['exercito'];

                    }else if($_SESSION['paises_pc'][$i]['exercito'] == $_SESSION['paises_jogador'][$j]['exercito']){

                        $possibilidade_ataque[$contador]['pais_ataque'] = $_SESSION['paises_pc'][$i]['pais'];

                        $possibilidade_ataque[$contador]['pais_ataque_exercito'] = $_SESSION['paises_pc'][$i]['exercito'];

                        $possibilidade_ataque[$contador]['pais_alvo'] = $_SESSION['paises_jogador'][$j]['pais'];

                        $possibilidade_ataque[$contador]['pais_ataque_exercito'] = $_SESSION['paises_jogador'][$j]['exercito'];
                    }
                    $contador++;
                }
            }
        }
    }

