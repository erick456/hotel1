

/*$(document).on("click",".btn_login",function(){
		$.ajax({
			url: urlbase+'Login/login',
			type: 'post',
			data: $('#form_login').serialize(),
		})
		success(function(data) {
			if (data == 1){
				location.href=urlbase+'Login/sistema';
			}else{
				new PNotify({text: 'DATOS ERRONEOS', type: 'error', styling: 'bootstrap3'});
			}
		});
})*/

function ingresar(campo){
	if($("#usuario").val()==""){
		$("#usuario").focus(); return 0;
	}
	if($("#clave").val()==""){
		$("#clave").focus(); return 0;
	}
	$.ajax({
		type: "POST",
		data: {clave:$("#clave").val(), usuario:$("#usuario").val() },
		url: urlbase+'Login/login',
		success: function(data){

			if(data=="1"){
				location.href=urlbase+'Login/sistema';
			}else{
				new PNotify({text: 'DATOS ERRONEOS', type: 'error', styling: 'bootstrap3'});
				setTimeout("actualizar()",1000);
			}

		}
	})
}

function actualizar(){
	location.href=urlbase;
}
