<?php
    require_once ('../static/shared/header.php');
    require_once ('../controller/Configuracao.class.php');
    require_once ('../controller/Jogo.class.php');

    session_start();

    $jogo = new \Jogo\Jogo($_SESSION['usuario']);

    $tamanho_pais_jogador = sizeof($_SESSION['paises_jogador']);
    $tamanho_pais_pc = sizeof($_SESSION['paises_pc']);

?>
<div class="col-md-6">
    <table class="table table-hover">
        <tr>
            <th><?= $_SESSION['usuario'] ?></th>
        </tr>
        <tr>
            <th>Pais</th>
            <th>Exercito</th>
        </tr>
        <?php for($i = 0; $i < $tamanho_pais_jogador; $i++){ ?>
            <tr>
                <td><?= $_SESSION['paises_jogador'][$i]['pais'] ?></td>
                <td><?= $_SESSION['paises_jogador'][$i]['exercito'] ?></td>
            </tr>
        <?php } ?>
    </table>
</div>
<div class="col-md-6">
    <table class="table table-hover">
        <tr>
            <th>PC</th>
        </tr>
        <tr>
            <th>Pais</th>
            <th>Exercito</th>
        </tr>
        <?php for($i = 0; $i < $tamanho_pais_jogador; $i++){ ?>
            <tr>
                <td><?= $_SESSION['paises_pc'][$i]['pais'] ?></td>
                <td><?= $_SESSION['paises_pc'][$i]['exercito'] ?></td>
            </tr>
        <?php } ?>
    </table>
</div>

<?php require_once ('../static/shared/footer.php'); ?>