function telaInicial(){

	$.get('view/login.html',function(data){
	   $('#conteudo').html(data)
    });

}

function realizarLogin(){
    var name = $('#name').val();

   $.post('controller/iniciarJogo.php',{"nome":name},function(data){
       console.log(data);
   })

	
}