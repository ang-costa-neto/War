<?php

class Login
{

    /*
     * Executa o login do usuario
     * @param $nome recebe o nome do usuario para verificacao/criacao da sessao
     */
    public function login($nome){
        if($_SESSION['usuario'] == $nome){

        }else{
            //Limpa uma sessao caso exista
            unset($_SESSION);

            session_start();
            $_SESSION['usuario'] = $nome;
            $_SESSION['pontos'] = 0;
        }
    }

    public function encerrarLogin(){
        unset($_SESSION);
    }

}