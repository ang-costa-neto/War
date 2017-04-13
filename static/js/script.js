function telaInicial(){
	var xhr = new XMLHttpRequest();
	xhr.open('GET','view/login.html');
	xhr.onload = function(){
		if(xhr.readyState === 4){
			document.getElementById('conteudo').innerHTML = xhr.responseText;
		}
	}
	xhr.send(null);
}

function realizarLogin(){
    var name = $('#name').val();
	
}