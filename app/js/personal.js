function nuevo(){
	$("#nuevo").modal("show");
}

function guardar(campo){
	if($("#nombres").val()==""){
		$("#nombres").focus(); return 0;
	}
	if($("#apellidos").val()==""){
		$("#apellidos").focus(); return 0;
	}
	if($("#usuario").val()==""){
		$("#usuario").focus(); return 0;
	}
	if($("#clave").val()==""){
		$("#clave").focus(); return 0;
	}
	if($("#tipo_personal").val()==""){
		$("#tipo_personal").focus(); return 0;
	}
	$.ajax({
		type: "POST",
		data: $("#form_personal").serialize(),
		url: urlbase+'Personal/guardar',
		success: function(data){
			
			$("#nuevo").modal("hide");
			if(data=='I'){
				new PNotify({text: 'DATOS INSERTADO', type: 'success', styling: 'bootstrap3'});
			}else{
				if(data=='EI'){
					new PNotify({text: 'ERROR AL INSERTAR', type: 'error', styling: 'bootstrap3'});
				}else{
					if(data=='M'){
						new PNotify({text: 'DATOS ACTUALIZADOS', type: 'success', styling: 'bootstrap3'});
					}else{
						new PNotify({text: 'ERROR AL ACTUALIZAR', type: 'error', styling: 'bootstrap3'});
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
		url: urlbase+'Personal/VerEditar',
		success: function(data){
			datos=eval(data);
			$("#id").val(datos[0]["idpersonal"]);
			$("#nombres").val(datos[0]["nombres"]);
			$("#apellidos").val(datos[0]["apellidos"]);
			$("#usuario").val(datos[0]["usuario"]);
			$("#clave").val(datos[0]["clave"]);
			$("#tipo_personal").val(datos[0]["idperfil"]);
			$("#nuevo").modal("show");
		}
	})
}

function eliminar(id){
	if(window.confirm("SEGURO QUE QUIERE ELIMNAR?")){
		$.ajax({
			type: "POST",
			data: "id="+id,
			url: urlbase+'Personal/eliminar',
			success: function(data){
				if(data=='E'){
					new PNotify({text: 'ELIMINADO CORRECTAMENTE', styling: 'bootstrap3'});
				}else{
					new PNotify({text: 'ERROR AL ELIMINAR', type: 'error', styling: 'bootstrap3'});
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
		url: urlbase+'Personal/activar',
		success: function(data){
			if(data=='A'){
				new PNotify({text: 'ACTIVADO', type: 'success', styling: 'bootstrap3'});
			}else{
				new PNotify({text: 'ERROR AL ACTIVAR', type: 'error', styling: 'bootstrap3'});
			}
			setTimeout("actualizar()",500); 
		}
	})
}


function actualizar(){
	location.href=window.location;
}
