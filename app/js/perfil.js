function nuevo(){
	$("#nuevo").modal("show");
}

function guardar(campo) {
	if(campo.descripcion.value==""){
		new PNotify({text: 'INGRESE DATOS DEL PERFIL', type: 'danger', styling: 'bootstrap3'});
		$("#descripcion").focus(); return 0;
	}
	$.ajax({
		type: "POST",
		data: $("#formPerfil").serialize(),
		url: urlbase+'Perfil/nuevo',
		success: function(data){
			$("#nuevo").modal("hide");
			if(data=="I"){
				 new PNotify({text: 'DATOS INSERTADO', type: 'success', styling: 'bootstrap3'});
			}else{
				if(data=='EI'){
					new PNotify({text: 'ERROR AL INSERTAR', type: 'success', styling: 'bootstrap3'});
				}else{
					if(data=='M'){
						new PNotify({text: 'SE MODIFICO CORRECTAMENTE', type: 'success', styling: 'bootstrap3'});
					}else{
						new PNotify({text: 'NO SE MODIFICO CORRECTAMENTE', type: 'success', styling: 'bootstrap3'});
					}
				}				
			}
			setTimeout("actualizar()",500); 
		}
	})
}

function editar(id){
	$.ajax({
		type: "POST",
		data: "id="+id,
		url: urlbase+'Perfil/VerEditar',
		success: function(data){
			datos=eval(data);
			$("#id").val(datos[0]["idperfil"]);
			$("#descripcion").val(datos[0]["descripcion"]);
			$("#nuevo").modal("show");
		}
	})
}

function eliminar(id){
	if(window.confirm("SEGURO QUE QUIERE ELIMINAR")){
		$.ajax({
			type: "POST",
			data: "id="+id,
			url: urlbase+'Perfil/eliminar',
			success: function(data){
				if(data=='E'){
					new PNotify({text: 'ELIMINADO CORRECTAMENTE', type: 'success', styling: 'bootstrap3'});
				}else{
					new PNotify({text: 'ERROR AL ELIMINAR', type: 'success', styling: 'bootstrap3'});
				}
				setTimeout("actualizar()",500);
			}

		})
	}
}

function inactivos(){
	$("#inactivos").modal("show");
}

function activar(id){
	$.ajax({
		type: "POST",
		data: "id="+id,
		url: urlbase+'Perfil/activar',
		success: function(data){
			if(data=='A'){
				new PNotify({text: 'ACTIVADO', type: 'success', styling: 'bootstrap3'});
			}else{
				new PNotify({text: 'ERROR AL ACTIVAR', type: 'success', styling: 'bootstrap3'});
			}
			setTimeout("actualizar()",500);
		}
	})
}

function actualizar(){
	location.href=window.location;
}