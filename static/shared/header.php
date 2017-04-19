<?php
    define( 'SERVER', 'http://'.$_SERVER['SERVER_NAME'] );
    define( 'DIRECTORY_ROOT', '/ChuWar/' );
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>ChuWar</title>
    <link rel="stylesheet" href="<?= SERVER.DIRECTORY_ROOT ?>static/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= SERVER.DIRECTORY_ROOT ?>static/css/bootstrap-select.min.css">
</head>
<body>
<div class="container">
    <h1 align="center">ChuWar</h1>
    <div class="row">
        <div id="conteudo">