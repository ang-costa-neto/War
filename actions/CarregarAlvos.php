<?php

    session_start();

    $pais = $_POST['pais'];


    $tamanho_pais_jogador_alvo = sizeof($_SESSION['paises_jogador'][$pais]['fronteira']);
    $tamanho_pais_pc = sizeof($_SESSION['paises_pc']);
?>

<select class="selectpicker" id="pais_alvo">
    <option value="">Selecione um país para atacar</option>
    <?php for($i = 0; $i < $tamanho_pais_pc; $i++){ ?>
        <?php for($j = 0; $j < $tamanho_pais_jogador_alvo; $j++){ ?>
            <?php if( $_SESSION['paises_pc'][$i]['pais'] == $_SESSION['paises_jogador'][$pais]['fronteira'][$j] ){ ?>
                <option value="<?= $_SESSION['paises_jogador'][$pais]['fronteira'][$j] ?>"><?= $_SESSION['paises_jogador'][$pais]['fronteira'][$j] ?></option>
            <?php } ?>
        <?php } ?>
    <?php } ?>
</select>
