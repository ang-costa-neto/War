$(function(){
    $('#paises_jogador').on('change',function(){
       $.post('http://localhost/chuvawar/actions/CarregarAlvos.php',{'pais':$('#paises_jogador').val()},function(data){
            console.log(data);
       });
    });
});