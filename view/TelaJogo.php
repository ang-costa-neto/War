<?php
    require_once ('../static/shared/header.php');
    require_once ('../controller/Configuracao.class.php');
    require_once ('../controller/Jogo.class.php');

    session_start();

    $jogo = new \controller\Jogo($_SESSION['usuario']);

    $tamanho_pais_jogador = sizeof($_SESSION['paises_jogador']);
    $tamanho_pais_pc = sizeof($_SESSION['paises_pc']);

?>
<div class="row">
    <div class="col-md-6">
        <table class="table table-striped">
            <tr class="info" align="center">
                <th colspan="2"><?= $_SESSION['usuario'] ?></th>
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
        <table class="table table-striped">
            <tr class="danger">
                <th colspan="2">PC</th>
            </tr>
            <tr>
                <th>Pais</th>
                <th>Exercito</th>
            </tr>
            <?php for($i = 0; $i < $tamanho_pais_pc; $i++){ ?>
                <tr>
                    <td><?= $_SESSION['paises_pc'][$i]['pais'] ?></td>
                    <td><?= $_SESSION['paises_pc'][$i]['exercito'] ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <select class="selectpicker" id="paises_jogador">
            <option value="">Selecione um País</option>
            <?php for($i = 0; $i < $tamanho_pais_jogador; $i++){ ?>
                <option value="<?= $i ?>"><?= $_SESSION['paises_jogador'][$i]['pais'] ?></option>
            <?php } ?>
        </select>
        <br><br>
        <button id="atacar" class="btn btn-danger disabled">Atacar</button>
    </div>
    <div class="col-md-3">
        <div id="select_pais_alvo">

        </div>

    </div>
    <div class="col-md-6">
        <h2>Historico</h2>
        <p>
            <?= $_SESSION['mensagens'] ?>
        </p>
    </div>
</div>

<?php
    if($tamanho_pais_jogador == 0){
    ?>
        <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modal" data-show="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content panel-danger">
                    <div class="modal-header panel-heading">
                        <h4 class="modal-title" id="myModalLabel">Você perdeu</h4>
                    </div>
                    <div class="modal-body">
                        O computador Venceu
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>
<?php
    }else if($tamanho_pais_pc == 0){
        echo 'ok';
?>
        <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modal" data-show="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content panel-primary">
                    <div class="modal-header panel-heading">
                        <h4 class="modal-title" id="myModalLabel">Parabens</h4>
                    </div>
                    <div class="modal-body">
                        Você venceu
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>
<?php
    }

    require_once ('../static/shared/footer.php');

?>