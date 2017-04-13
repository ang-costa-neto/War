<?php

class Login
{
    public function fazerLogin($nome){

        if(isset($_SESSION['usuario'])){
            if($_SESSION['usuario'] === $nome) {
                pass;
            }
        }else{
            //Limpa uma sessao caso exista
            unset($_SESSION);

            $_SESSION['usuario'] = $nome;
            $_SESSION['pontos'] = 0;
        }
    }
}