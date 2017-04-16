<?php
/**
 * Created by PhpStorm.
 * User: angel
 * Date: 15/04/2017
 * Time: 20:04
 */

namespace Jogo;

use Configuracao\Configuracao;

class Jogo extends Configuracao
{

    function __construct($usuario){
        parent::__construct($usuario);
    }

    public function iniciarJogo(){
        //session_start();

        $contador = 0;

        $array_paises = $this::configuracaoPaises();

        shuffle($array_paises);

        $_SESSION['paises_jogador'] = array();
        $_SESSION['paises_pc'] = array();

        while ($contador < 6){
            array_push($_SESSION['paises_jogador'],$array_paises);
            $contador++;
        }

        //$array = array_diff($array_paises,$_SESSION['paises_jogador']);

        //sizeof($array);

    }
}