<?php

    session_start();

    require_once ('../controller/Configuracao.class.php');
    require_once ('../controller/Jogo.class.php');

    $jogo = new \Controller\Jogo($_SESSION['usuario']);

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

    //Pode atacar caso o exercito seja maior que 0
    if($exercito > 0){
        //Mostra de quem é vez da partidada
        $_SESSION['mensagens'] .= '<p>'.date("d/m/Y H:i:s").': <b>Rodada do Jogador</b></p>';

        while($contador < $exercito){
            //Roda o dado
            $dado = $jogo->rodaDado();
            $_SESSION['mensagens'] .= '<p>'.date("d/m/Y H:i:s").': Valor no dado foi '.$dado.'</p>';

            $_SESSION['mensagens'] .= '<p>'.date("d/m/Y H:i:s").': '.$_SESSION['paises_jogador'][$pais_jogador]['pais']
                                    .' ataca '.$_SESSION['paises_pc'][$alvo]['pais'].'</p>';

            //Se o valor do dado for maior que 5, vence a batalha e registra no historico
            if($dado > 5){

                $_SESSION['paises_pc'][$alvo]['exercito']--;

                $_SESSION['mensagens'] .= '<p>'.date("d/m/Y H:i:s").': O '.$_SESSION['paises_pc'][$alvo]['pais']
                                        .' perdeu 1 exercito, resta '.$_SESSION['paises_pc'][$alvo]['exercito'].'</p>';

                if( $_SESSION['paises_pc'][$alvo]['exercito'] <= 0){

                    $_SESSION['paises_jogador'][$pais_jogador]['exercito']--;

                    $_SESSION['mensagens'] .= '<p>'.date("d/m/Y H:i:s").': '.$_SESSION['paises_jogador'][$pais_jogador]['pais']
                                            .' dominou '.$_SESSION['paises_pc'][$alvo]['pais'].'</p>';

                    array_push($_SESSION['paises_jogador'],$_SESSION['paises_pc'][$alvo]);
                    unset($_SESSION['paises_pc'][$alvo]);
                    $_SESSION['paises_pc'] = array_values($_SESSION['paises_pc']);
                    $_SESSION['paises_jogador'][key(array_slice($_SESSION['paises_jogador'], -1, 1, TRUE))]['exercito'] = 1;
                    break;
                }
            }else{
                //Se o dado for menor ou igual a 5 perde a batalha e registra no historico
                $_SESSION['paises_jogador'][$pais_jogador]['exercito']--;

                $_SESSION['mensagens'] .= '<p>'.date("d/m/Y H:i:s").': O '.$_SESSION['paises_jogador'][$pais_jogador]['pais']
                                        .' perdeu 1 exercito, resta '.$_SESSION['paises_jogador'][$pais_jogador]['exercito'].'</p>';

                if($_SESSION['paises_jogador'][$pais_jogador]['exercito'] <= 0){

                    $_SESSION['paises_pc'][$alvo]['exercito']--;

                    $_SESSION['mensagens'] .= '<p>'.date("d/m/Y H:i:s").': '.$_SESSION['paises_pc'][$alvo]['pais']
                                            .' dominou '.$_SESSION['paises_jogador'][$pais_jogador]['pais'].'</p>';

                    array_push($_SESSION['paises_pc'],$_SESSION['paises_jogador'][$pais_jogador]);
                    unset($_SESSION['paises_jogador'][$pais_jogador]);
                    $_SESSION['paises_jogador'] = array_values($_SESSION['paises_jogador']);
                    $_SESSION['paises_pc'][key(array_slice($_SESSION['paises_pc'], -1, 1, TRUE))]['exercito'] = 1;
                    break;
                }
            }
            $contador++;
        }
    }else{
        $_SESSION['mensagens'] .= '<p>'.date("d/m/Y H:i:s").': O '.$_SESSION['paises_jogador'][$pais_jogador]['pais'].' <b>não tem exercito para atacar</b></p>';
    }

    /*
     * Partida do computador
     */

    //Recalcula o tamanho do array
    $tamanho_pais_pc = sizeof($_SESSION['paises_pc']);
    $tamanho_pais_jogador = sizeof($_SESSION['paises_jogador']);

    $possibilidade_ataque = array();
    $contador = 0;

    //Mostra a vem de que é
    $_SESSION['mensagens'] .= '<p>'.date("d/m/Y H:i:s").': <b>Rodada do Computador</b></p>';

    //Preenche um array de possibilidade de ataque
    for($i = 0; $i < $tamanho_pais_pc; $i++){
        $tamanho_pais_pc_fronteira = sizeof($_SESSION['paises_pc'][$i]['fronteira']);
        for($j = 0; $j < $tamanho_pais_jogador; $j++){
            for($k = 0; $k < $tamanho_pais_pc_fronteira; $k++) {
                if($_SESSION['paises_pc'][$i]['fronteira'][$k] == $_SESSION['paises_jogador'][$j]['pais']){
                    if($_SESSION['paises_pc'][$i]['exercito'] > $_SESSION['paises_jogador'][$j]['exercito']){

                        $possibilidade_ataque[$contador]['pais_ataque_id'] = $i;
                        $possibilidade_ataque[$contador]['pais_ataque'] = $_SESSION['paises_pc'][$i]['pais'];
                        $possibilidade_ataque[$contador]['pais_ataque_exercito'] = $_SESSION['paises_pc'][$i]['exercito'];
                        $possibilidade_ataque[$contador]['pais_alvo_id'] = $j;
                        $possibilidade_ataque[$contador]['pais_alvo'] = $_SESSION['paises_jogador'][$j]['pais'];
                        $possibilidade_ataque[$contador]['pais_alvo_exercito'] = $_SESSION['paises_jogador'][$j]['exercito'];

                    }else if($_SESSION['paises_pc'][$i]['exercito'] == $_SESSION['paises_jogador'][$j]['exercito']){

                        $possibilidade_ataque[$contador]['pais_ataque_id'] = $i;
                        $possibilidade_ataque[$contador]['pais_ataque'] = $_SESSION['paises_pc'][$i]['pais'];
                        $possibilidade_ataque[$contador]['pais_ataque_exercito'] = $_SESSION['paises_pc'][$i]['exercito'];
                        $possibilidade_ataque[$contador]['pais_alvo_id'] = $j;
                        $possibilidade_ataque[$contador]['pais_alvo'] = $_SESSION['paises_jogador'][$j]['pais'];
                        $possibilidade_ataque[$contador]['pais_alvo_exercito'] = $_SESSION['paises_jogador'][$j]['exercito'];

                    }
                }
            }
        }
    }


    $tamanho_possibilidade_ataque = sizeof($possibilidade_ataque);
    $contador = 0;

    //Analisa as possibilidades de ataque e realiza o ataque
    for($i = 0; $i < $tamanho_possibilidade_ataque; $i++){
        if($possibilidade_ataque[$i]['pais_ataque_exercito'] > ($possibilidade_ataque[$i]['pais_alvo_exercito']/2)){

            while($contador < $possibilidade_ataque[$i]['pais_ataque_exercito']){
                $dado = $jogo->rodaDado();
                $_SESSION['mensagens'] .= '<p>'.date("d/m/Y H:i:s").': Valor no dado foi '.$dado.'</p>';

                $_SESSION['mensagens'] .= '<p>'.date("d/m/Y H:i:s").': '.$_SESSION['paises_pc'][$possibilidade_ataque[$i]['pais_ataque_id']]['pais']
                                        .' ataca '.$_SESSION['paises_jogador'][$possibilidade_ataque[$i]['pais_alvo_id']]['pais'].'</p>';

                if($dado > 5){
                    $_SESSION['paises_jogador'][$possibilidade_ataque[$i]['pais_alvo_id']]['exercito']--;

                    $_SESSION['mensagens'] .= '<p>'.date("d/m/Y H:i:s").': O '.$_SESSION['paises_jogador'][$possibilidade_ataque[$i]['pais_alvo_id']]['pais']
                                            .' perdeu 1 exercito, resta '.$_SESSION['paises_jogador'][$possibilidade_ataque[$i]['pais_alvo_id']]['exercito'].'</p>';

                    if( $_SESSION['paises_jogador'][$possibilidade_ataque[$i]['pais_alvo_id']]['exercito'] <= 0){

                        $_SESSION['paises_pc'][$possibilidade_ataque[$i]['pais_ataque_id']]['exercito']--;

                        $_SESSION['mensagens'] .= '<p>'.date("d/m/Y H:i:s").': '.$_SESSION['paises_pc'][$possibilidade_ataque[$i]['pais_ataque_id']]['pais']
                                                .' dominou '.$_SESSION['paises_jogador'][$possibilidade_ataque[$i]['pais_alvo_id']]['pais'].'</p>';

                        array_push($_SESSION['paises_pc'],$_SESSION['paises_jogador'][$possibilidade_ataque[$i]['pais_alvo_id']]);
                        unset($_SESSION['paises_jogador'][$possibilidade_ataque[$i]['pais_alvo_id']]);
                        $_SESSION['paises_jogador'] = array_values($_SESSION['paises_jogador']);
                        $_SESSION['paises_pc'][key(array_slice($_SESSION['paises_pc'], -1, 1, TRUE))]['exercito'] = 1;
                        break;
                    }
                }else{
                    $_SESSION['paises_pc'][$possibilidade_ataque[$i]['pais_ataque_id']]['exercito']--;

                    $_SESSION['mensagens'] .= '<p>'.date("d/m/Y H:i:s").': O '.$_SESSION['paises_pc'][$possibilidade_ataque[$i]['pais_ataque_id']]['pais']
                                            .' perdeu 1 exercito, resta '.$_SESSION['paises_pc'][$possibilidade_ataque[$i]['pais_ataque_id']]['exercito'].'</p>';

                    if($_SESSION['paises_pc'][$possibilidade_ataque[$i]['pais_ataque_id']]['exercito'] <= 0){

                        $_SESSION['paises_jogador'][$possibilidade_ataque[$i]['pais_alvo_id']]['exercito']--;

                        $_SESSION['mensagens'] .= '<p>'.date("d/m/Y H:i:s").': '.$_SESSION['paises_jogador'][$possibilidade_ataque[$i]['pais_alvo_id']]['pais']
                                            .' dominou '.$_SESSION['paises_pc'][$possibilidade_ataque[$i]['pais_ataque_id']]['pais'].'</p>';

                        array_push($_SESSION['paises_jogador'],$_SESSION['paises_pc'][$possibilidade_ataque[$i]['pais_ataque_id']]);
                        unset($_SESSION['paises_pc'][$possibilidade_ataque[$i]['pais_ataque_id']]);
                        $_SESSION['paises_pc'] = array_values($_SESSION['paises_pc']);
                        $_SESSION['paises_jogador'][key(array_slice($_SESSION['paises_jogador'], -1, 1, TRUE))]['exercito'] = 1;
                        break;
                    }
                }
                $contador++;
            }
            break;

        }else if ($possibilidade_ataque[$i]['pais_ataque_exercito'] > $possibilidade_ataque[$i]['pais_alvo_exercito']){

            while($contador < $possibilidade_ataque[$i]['pais_ataque_exercito']){
                $dado = $jogo->rodaDado();
                $_SESSION['mensagens'] .= '<p>'.date("d/m/Y H:i:s").': Valor no dado foi '.$dado.'</p>';

                $_SESSION['mensagens'] .= '<p>'.date("d/m/Y H:i:s").': '.$_SESSION['paises_pc'][$possibilidade_ataque[$i]['pais_ataque_id']]['pais']
                                        .' ataca '.$_SESSION['paises_jogador'][$possibilidade_ataque[$i]['pais_alvo_id']]['pais'].'</p>';

                if($dado > 5){
                    $_SESSION['paises_jogador'][$possibilidade_ataque[$i]['pais_alvo_id']]['exercito']--;

                    $_SESSION['mensagens'] .= '<p>'.date("d/m/Y H:i:s").': O '.$_SESSION['paises_jogador'][$possibilidade_ataque[$i]['pais_alvo_id']]['pais']
                                            .' perdeu 1 exercito, resta '.$_SESSION['paises_jogador'][$possibilidade_ataque[$i]['pais_alvo_id']]['exercito'].'</p>';

                    if( $_SESSION['paises_jogador'][$possibilidade_ataque[$i]['pais_alvo_id']]['exercito'] <= 0){

                        $_SESSION['paises_pc'][$possibilidade_ataque[$i]['pais_ataque_id']]['exercito']--;

                        $_SESSION['mensagens'] .= '<p>'.date("d/m/Y H:i:s").': '.$_SESSION['paises_pc'][$possibilidade_ataque[$i]['pais_ataque_id']]['pais']
                                            .' dominou '.$_SESSION['paises_jogador'][$possibilidade_ataque[$i]['pais_alvo_id']]['pais'].'</p>';

                        array_push($_SESSION['paises_pc'],$_SESSION['paises_jogador'][$possibilidade_ataque[$i]['pais_alvo_id']]);
                        unset($_SESSION['paises_jogador'][$possibilidade_ataque[$i]['pais_alvo_id']]);
                        $_SESSION['paises_jogador'] = array_values($_SESSION['paises_jogador']);
                        $_SESSION['paises_pc'][key(array_slice($_SESSION['paises_pc'], -1, 1, TRUE))]['exercito'] = 1;
                        break;
                    }
                }else{
                    $_SESSION['paises_pc'][$possibilidade_ataque[$i]['pais_ataque_id']]['exercito']--;

                    $_SESSION['mensagens'] .= '<p>'.date("d/m/Y H:i:s").': O '.$_SESSION['paises_pc'][$possibilidade_ataque[$i]['pais_ataque_id']]['pais']
                                            .' perdeu 1 exercito, resta '.$_SESSION['paises_pc'][$possibilidade_ataque[$i]['pais_ataque_id']]['exercito'].'</p>';

                    if($_SESSION['paises_pc'][$possibilidade_ataque[$i]['pais_ataque_id']]['exercito'] <= 0){

                        $_SESSION['paises_jogador'][$possibilidade_ataque[$i]['pais_alvo_id']]['exercito']--;

                        $_SESSION['mensagens'] .= '<p>'.date("d/m/Y H:i:s").': '.$_SESSION['paises_jogador'][$possibilidade_ataque[$i]['pais_alvo_id']]['pais']
                                            .' dominou '.$_SESSION['paises_pc'][$possibilidade_ataque[$i]['pais_ataque_id']]['pais'].'</p>';

                        array_push($_SESSION['paises_jogador'],$_SESSION['paises_pc'][$possibilidade_ataque[$i]['pais_ataque_id']]);
                        unset($_SESSION['paises_pc'][$possibilidade_ataque[$i]['pais_ataque_id']]);
                        $_SESSION['paises_pc'] = array_values($_SESSION['paises_pc']);
                        $_SESSION['paises_jogador'][key(array_slice($_SESSION['paises_jogador'], -1, 1, TRUE))]['exercito'] = 1;
                        break;
                    }
                }
                $contador++;
            }
            break;

        }else if ($possibilidade_ataque[$i]['pais_ataque_exercito'] == $possibilidade_ataque[$i]['pais_alvo_exercito']){

            while($contador < $possibilidade_ataque[$i]['pais_ataque_exercito']){
                $dado = $jogo->rodaDado();
                $_SESSION['mensagens'] .= '<p>'.date("d/m/Y H:i:s").': Valor no dado foi '.$dado.'</p>';

                $_SESSION['mensagens'] .= '<p>'.date("d/m/Y H:i:s").': '.$_SESSION['paises_pc'][$possibilidade_ataque[$i]['pais_ataque_id']]['pais']
                                        .' ataca '.$_SESSION['paises_jogador'][$possibilidade_ataque[$i]['pais_alvo_id']]['pais'].'</p>';

                if($dado > 5){
                    $_SESSION['paises_jogador'][$possibilidade_ataque[$i]['pais_alvo_id']]['exercito']--;

                    $_SESSION['mensagens'] .= '<p>'.date("d/m/Y H:i:s").': O '.$_SESSION['paises_jogador'][$possibilidade_ataque[$i]['pais_alvo_id']]['pais']
                                            .' perdeu 1 exercito, resta '.$_SESSION['paises_jogador'][$possibilidade_ataque[$i]['pais_alvo_id']]['exercito'].'</p>';

                    if( $_SESSION['paises_jogador'][$possibilidade_ataque[$i]['pais_alvo_id']]['exercito'] <= 0){

                        $_SESSION['paises_pc'][$possibilidade_ataque[$i]['pais_ataque_id']]['exercito']--;

                        $_SESSION['mensagens'] .= '<p>'.date("d/m/Y H:i:s").': '.$_SESSION['paises_pc'][$possibilidade_ataque[$i]['pais_ataque_id']]['pais']
                                            .' dominou '.$_SESSION['paises_jogador'][$possibilidade_ataque[$i]['pais_alvo_id']]['pais'].'</p>';

                        array_push($_SESSION['paises_pc'],$_SESSION['paises_jogador'][$possibilidade_ataque[$i]['pais_alvo_id']]);
                        unset($_SESSION['paises_jogador'][$possibilidade_ataque[$i]['pais_alvo_id']]);
                        $_SESSION['paises_jogador'] = array_values($_SESSION['paises_jogador']);
                        $_SESSION['paises_pc'][key(array_slice($_SESSION['paises_pc'], -1, 1, TRUE))]['exercito'] = 1;
                        break;
                    }
                }else{
                    $_SESSION['paises_pc'][$possibilidade_ataque[$i]['pais_ataque_id']]['exercito']--;

                    $_SESSION['mensagens'] .= '<p>'.date("d/m/Y H:i:s").': O '.$_SESSION['paises_pc'][$possibilidade_ataque[$i]['pais_ataque_id']]['pais']
                                            .' perdeu 1 exercito, resta '.$_SESSION['paises_pc'][$possibilidade_ataque[$i]['pais_ataque_id']]['exercito'].'</p>';

                    if($_SESSION['paises_pc'][$possibilidade_ataque[$i]['pais_ataque_id']]['exercito'] <= 0){

                        $_SESSION['paises_jogador'][$possibilidade_ataque[$i]['pais_alvo_id']]['exercito']--;

                        $_SESSION['mensagens'] .= '<p>'.date("d/m/Y H:i:s").': '.$_SESSION['paises_jogador'][$possibilidade_ataque[$i]['pais_alvo_id']]['pais']
                                                .' dominou '.$_SESSION['paises_pc'][$possibilidade_ataque[$i]['pais_ataque_id']]['pais'].'</p>';

                        array_push($_SESSION['paises_jogador'],$_SESSION['paises_pc'][$possibilidade_ataque[$i]['pais_ataque_id']]);
                        unset($_SESSION['paises_pc'][$possibilidade_ataque[$i]['pais_ataque_id']]);
                        $_SESSION['paises_pc'] = array_values($_SESSION['paises_pc']);
                        $_SESSION['paises_jogador'][key(array_slice($_SESSION['paises_jogador'], -1, 1, TRUE))]['exercito'] = 1;
                        break;
                    }
                }
                $contador++;
            }
            break;

        }
    }



    //Jogador recebe 6 exercitos aleatoriamento pelo mapa
    for($i = 0; $i < 6; $i++){
        $pais_sorteado = rand(0,(sizeof($_SESSION['paises_jogador'])-1));
        $_SESSION['paises_jogador'][$pais_sorteado]['exercito']+= 1;
        $_SESSION['mensagens'] .= '<p>'.date("d/m/Y H:i:s").': <b>'.$_SESSION['paises_jogador'][$pais_sorteado]['pais'].' 
                                        recebeu 1 exercito, totalizando '.$_SESSION['paises_jogador'][$pais_sorteado]['exercito'].'</b></p>';
    }

    //Computador recebe 6 exercitos aleatoriamento pelo mapa
    for($i = 0; $i < 6; $i++){
        $pais_sorteado = rand(0,(sizeof($_SESSION['paises_pc'])-1));
        $_SESSION['paises_pc'][$pais_sorteado]['exercito']+= 1;
        $_SESSION['mensagens'] .= '<p>'.date("d/m/Y H:i:s").': <b>'.$_SESSION['paises_pc'][$pais_sorteado]['pais'].' 
                                    recebeu 1 exercito, totalizando '.$_SESSION['paises_pc'][$pais_sorteado]['exercito'].'</b></p>';
    }


