<?php

class Jogo extends Configuracao
{
    public function novoJogo(){

        //cria um array com a configuracao dos paises
        $array_paises = $this->configuracaoPais();

        //Adiciona os paises sorteados ao usuario
        $_SESSION['paises'] = array();
        
    }

    public function encerrarJogo(){

    }
}