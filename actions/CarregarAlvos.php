<?php

    session_start();

    const SEM_PAISES_ATACAR = 0;

    $pais = $_POST['pais'];

    $tamanho_pais_alvo_fronteira = sizeof($_SESSION['paises_jogador'][$pais]['fronteira']);
    $tamanho_pais_pc = sizeof($_SESSION['paises_pc']);

    $option = array();

    //Verifica se o pais faz fronteira com um pais inimigo
    for($i = 0; $i < $tamanho_pais_pc; $i++){
        for($j = 0; $j < $tamanho_pais_alvo_fronteira; $j++){
           if( $_SESSION['paises_pc'][$i]['pais'] == $_SESSION['paises_jogador'][$pais]['fronteira'][$j] ){
                array_push($option, $_SESSION['paises_jogador'][$pais]['fronteira'][$j]);
           }
        }
    }

    $tamanho_paises_atacar = sizeof($option);

    if($tamanho_paises_atacar > 0){

?>
        <select class="selectpicker" id="pais_alvo">
            <option value="">Selecione um país para atacar</option>
            <?php for($i = 0; $i < $tamanho_paises_atacar; $i++){ ?>
                <option value="<?= $option[$i] ?>"><?= $option[$i] ?></option>
            <?php } ?>
        </select>
<?php }else{
        return SEM_PAISES_ATACAR;
    }

