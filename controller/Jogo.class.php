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


        while ($contador < 6){
            $_SESSION['paises_jogador'][$contador] = $array_paises[$contador];
            unset($array_paises[$contador]);
            $contador++;
        }

        $_SESSION['paises_pc'] = array_values($array_paises);

    }


}