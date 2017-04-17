$(function(){
    $('#paises_jogador').on('change',function(){
        var pais_selecionado = $('#paises_jogador').val();
        console.log(pais_selecionado);
        if(pais_selecionado !== ''){
           $.post('http://localhost/chuvawar/actions/CarregarAlvos.php',{'pais':pais_selecionado},function(data){
               console.log(data);
               if(data !== 0){
                   $('#select_pais_alvo').empty();
                   $('#select_pais_alvo').html(data);
                   $('.selectpicker').selectpicker({});
               }else{
                   $('#select_pais_alvo').empty();
                   $('#select_pais_alvo').html('<strong>Os paises na fronteira estão em seu time</strong>');
               }
           });
        }else{
            $('#select_pais_alvo').empty();
        }
    });
});