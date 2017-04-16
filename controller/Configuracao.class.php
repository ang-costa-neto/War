<?php
/**
 * Created by PhpStorm.
 * User: angel
 * Date: 15/04/2017
 * Time: 19:54
 */

namespace Configuracao;


class Configuracao
{

    private $name;

    function __construct($nome){
        $this->name = $nome;
    }

    public function iniciarSessao(){
        session_start();

        if (session_status() === PHP_SESSION_ACTIVE) {
            if (isset($_SESSION['usuario']) && $_SESSION['usuario'] == $this->name) {
                return 0;
            } else {
                session_destroy();
                session_start();
                $_SESSION['usuario'] = $this->name;
                return 1;
            }
        }else{
            $_SESSION['usuario'] = $this->name;
            return 1;
        }
    }


    static function configuracaoPaises(){
        //array de pais com suas fronteiras
        $brasil = array(
            "pais" => "Brasil",
            "fronteira" => array("Argentina", "Colombia", "Egito")
        );

        $argentina = array (
            "pais" => "Argentina",
            "fronteira" => array("Brasil", "Colombia")
        );

        $mexico = array(
            "pais" => "Mexico",
            "fronteiras" => array("Colombia", "EUA")
        );

        $eua = array(
            "pais" => "EUA",
            "fronteiras" => array("Mexico", "Russia","Reino Unido")
        );

        $reino_unido = array(
            "pais" => "Reino Unido",
            "fronteiras" => array("EUA", "Franca","Alemanha")
        );

        $franca  = array(
            "pais" => "Franca",
            "fronteiras" => array("Alemanha", "Reino Unido", "Egito")
        );

        $alemanha = array(
            "pais" => "Alemanha",
            "fronteiras" => array("Franca", "Reino Unido", "Egito", "Russia")
        );

        $egito = array(
            "pais" => "Egito",
            "fronteiras" => array("Franca", "Alemanha", "Brasil", "Africa do Sul")
        );

        $africa_sul = array(
            "pais" => "Africa do Sul",
            "fronteiras" => array("Egito")
        );

        $russia = array(
            "pais" => "Alemanha",
            "fronteiras" => array("Alemanha", "China", "EUA")
        );

        $china = array(
            "pais" => "China",
            "fronteiras" => array("Russia")
        );

        //Retorna um array com os paises para o sorteio do usuario
        return array(
            $africa_sul,
            $alemanha,
            $argentina,
            $brasil,
            $china,
            $egito,
            $eua,
            $franca,
            $mexico,
            $reino_unido,
            $russia
        );
    }

}