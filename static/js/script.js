$(function(){
    $('.modal').modal();
    $('#paises_jogador').on('change',function(){
        var pais_selecionado = $('#paises_jogador').val();
        if(pais_selecionado !== ''){
           $.post('/actions/CarregarAlvos.php',{'pais':pais_selecionado},function(data){
               $('#select_pais_alvo').empty();
               $('#select_pais_alvo').html(data);
               $('.selectpicker').selectpicker({});
               $('#pais_alvo').on('change',function(){
                   var pais_alvo = $('#pais_alvo').val();
                   if(pais_alvo !== ''){
                        $('#atacar').removeClass('disabled');
                   }else{
                       $('#atacar').addClass('disabled');
                   }
               });
           });
        }else{
            $('#select_pais_alvo').empty();
            $('#atacar').addClass('disabled');
        }
    });
});

$('#atacar').click(function(){
    var pais_jogador = $('#paises_jogador').val();
    var pais_pc = $('#pais_alvo').val();

    $.post('/actions/Atacar.php',{'pais_jogador':pais_jogador,'pais_pc':pais_pc},function(data){
        location.reload();
    });
});