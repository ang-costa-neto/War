<?php

namespace controller;

use controller\Configuracao;

/*
 * Classe de jogo ações no jogo
 * @param usuario nome do usuario para dar continuidade ao jogo
 */

class Jogo extends Configuracao
{

    const MENSAGEM_INICIO_RODADA = 1;
    const MENSAGEM_VALOR_DADO = 2;
    const MENSAGEM_ATAQUE = 3;
    const MENSAGEM_PERDEU_EXERCITO = 4;
    const MENSAGEM_DOMINOU_PAIS = 5;
    const MENSAGEM_DISTRIBUIR_PAIS = 6;

    function __construct($usuario){
        parent::__construct($usuario);
    }

    public function iniciarJogo(){
        $contador = 0;

        $array_paises = $this::configuracaoPaises();

        shuffle($array_paises);


        while ($contador < 6){
            $_SESSION['paises_jogador'][$contador] = $array_paises[$contador];
            unset($array_paises[$contador]);
            $contador++;
        }

        $_SESSION['paises_pc'] = array_values($array_paises);

    }

    /*
     * @param $id_pais recebe o pais selecionado
     * @param $id_pais_alvo recebe o pais alvo
     * @param $jogador recebe o jogador da rodada
     * @param $codigo_mensagem recebe o codigo da mensagem
     */
    public function mensagens($id_pais="",$id_pais_alvo="",$jogador,$dado="",$codigo_mensagem){

        $inimigo = ($jogador == 'paises_jogador') ? 'paises_pc' : 'paises_jogador';
        $nome_jogador = ($jogador == 'jogador') ? 'Jogador' : 'Computador';

        switch($codigo_mensagem) {
            case 1:
                $_SESSION['mensagens'] .= '<p>' . date("d/m/Y H:i:s") . ': <b>Rodada do ' . $nome_jogador . '</b></p>';
                break;
            case 2:
                $_SESSION['mensagens'] .= '<p>' . date("d/m/Y H:i:s") . ': Valor no dado foi ' . $dado . '</p>';
                break;
            case 3:
                $_SESSION['mensagens'] .= '<p>' . date("d/m/Y H:i:s") . ': ' . $_SESSION[$jogador][$id_pais]['pais']
                    . ' ataca ' . $_SESSION[$inimigo][$id_pais_alvo]['pais'] . '</p>';
                break;
            case 4:
                $_SESSION['mensagens'] .= '<p>'.date("d/m/Y H:i:s").': '.$_SESSION[$jogador][$id_pais]['pais']
                    .' perdeu 1 exercito, resta '.$_SESSION[$jogador][$id_pais]['exercito'].'</p>';
                break;
            case 5:
                $_SESSION['mensagens'] .= '<p>' . date("d/m/Y H:i:s") . ': ' . $_SESSION[$jogador][$id_pais]['pais']
                    . ' dominou ' . $_SESSION[$inimigo][$id_pais_alvo]['pais'] . '</p>';
                break;
            case 6:
                $_SESSION['mensagens'] .= '<p>'.date("d/m/Y H:i:s").': <b>'.$_SESSION[$jogador][$id_pais]['pais'].' 
                                    recebeu 1 exercito, totalizando '.$_SESSION[$jogador][$id_pais]['exercito'].'</b></p>';
                break;
        }
    }

    /*
     * @param $id_pais recebe o pais selecionado
     * @param $id_pais_alvo recebe o pais alvo
     * @param $jogador recebe o jogador da rodada
     */
    public function atacar($id_pais,$id_pais_alvo,$jogador){

        $contador = 0;
        //Define o array que será utilizado como jogador
        $tipo_jogador = ($jogador == strtolower('jogador')) ? 'paises_jogador' : 'paises_pc';
        //Define o array que será utilizado como inimigo
        $inimigo = ($jogador == strtolower('jogador')) ? 'paises_pc' : 'paises_jogador';

        $this->mensagens(null,null,$jogador,null,self::MENSAGEM_INICIO_RODADA);

        while($contador <= $_SESSION[$tipo_jogador][$id_pais]['exercito']){

            //Caso o pais alvo nao tenha nehum exercito, ganha automaticamente
            if($_SESSION[$inimigo][$id_pais_alvo]['exercito'] == 0){

                $_SESSION[$tipo_jogador][$id_pais]['exercito']--;

                $this->mensagens($id_pais,$id_pais_alvo,$tipo_jogador,null,self::MENSAGEM_DOMINOU_PAIS);

                break;
            }

            //Roda o dado
            $valorDado = rand(0,10);

            $this->mensagens(null,null,null,$valorDado,self::MENSAGEM_VALOR_DADO);

            $this->mensagens($id_pais, $id_pais_alvo, $tipo_jogador, null, self::MENSAGEM_ATAQUE);

            $pais_recebendo_dano = $id_pais_alvo;
            $jogador_recebendo_dano = $inimigo;
            $inimigo_jogador = $tipo_jogador;
            $pais = $id_pais;

            //Altera o valor das variaveis para que quando o dado for menor que 5 o jogador da rodada sofre dano
            if($valorDado < 5){

                $pais_recebendo_dano = $id_pais;
                $jogador_recebendo_dano = $tipo_jogador;
                $inimigo_jogador = $inimigo;
                $pais = $id_pais_alvo;

            }

            $_SESSION[$jogador_recebendo_dano][$pais_recebendo_dano]['exercito']--;

            $this->mensagens($pais_recebendo_dano,null,$jogador_recebendo_dano,null,self::MENSAGEM_PERDEU_EXERCITO);


            if( $_SESSION[$jogador_recebendo_dano][$pais_recebendo_dano]['exercito'] <= 0){

                $_SESSION[$jogador_recebendo_dano][$pais]['exercito']--;

                $this->mensagens($pais,$pais_recebendo_dano,$inimigo_jogador,null,self::MENSAGEM_DOMINOU_PAIS);

                array_push($_SESSION[$inimigo_jogador],$_SESSION[$jogador_recebendo_dano][$pais_recebendo_dano]);
                unset($_SESSION[$jogador_recebendo_dano][$pais_recebendo_dano]);
                $_SESSION[$jogador_recebendo_dano] = array_values($_SESSION[$jogador_recebendo_dano]);
                $_SESSION[$inimigo_jogador][key(array_slice($_SESSION[$inimigo_jogador], -1, 1, TRUE))]['exercito'] = 1;
                break;
            }

            $contador++;
        }
    }

    /*
     * @param $jogador recebe o jogador que ira receber os exercitos
     */
    public function distribuiExercito($jogador){

        $tipo_jogador = ($jogador == strtolower('jogador')) ? 'paises_jogador' : 'paises_pc';

        for($i = 0; $i < 6; $i++){
            $pais_sorteado = rand(0,(sizeof($_SESSION[$tipo_jogador])-1));
            $_SESSION[$tipo_jogador][$pais_sorteado]['exercito']+= 1;
            $this->mensagens($pais_sorteado,null,$tipo_jogador,null,self::MENSAGEM_DISTRIBUIR_PAIS);
        }
    }

}