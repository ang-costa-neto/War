<?php

    session_start();

    require_once('../model/login.php');

    $nome = $_POST['nome'];

    $login = new Login();

    $login->fazerLogin($nome);


