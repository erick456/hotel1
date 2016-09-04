$(document).ready(function(){
	// $("#perfil").on("change",function(){
	// 	var id = $(this).val();
	// 	if(id == ""){
	// 		$("#marcar_permisos").hide();
	// 	}else{
	// 		$("#marcar_permisos").show();
	// 		$.post(urlbase+"Permisos/VerPermisos", {id: id},function(response){

	// 			$("#marcar_permisos").empty();
	// 			$("#marcar_permisos").append(response);
	// 		});
	// 	}
	// });

	$("#guardar").on("click", function(){

		$.post(urlbase+"Permisos/guardar",$("#form_permisos").serialize()+"&perfil="+$("#perfil").val(),function(data){
			if(data=="inserto"){
				new PNotify({text: 'DATOS GUARDADOS', type: 'success', styling: 'bootstrap3'});
			}
			setTimeout("actualizar()",200);
		});
	});
});


function actualizar(){
	location.href=window.location;
}

$(document).on("change","#perfil",function(e) {
	e.preventDefault();
	$perfil = $(this).val();

	$.post(urlbase+"Permisos/traerPermisos",{idperfil:$perfil},function(json) {
		if(json.ok == "yes") {

			$(".checkbox").each(function() {
				console.log($(this).find('input[type=checkbox]').val());
				result = in_object($(this).find('input[type=checkbox]').val(),json.permisos)
				if(result.result) {
					$(this).find('input[value="'+result.id+'"]')
					.attr("checked","checked").parent(".icheckbox_flat-green").addClass("checked");

				} else {
					$(this).find(".icheckbox_flat-green").removeClass("checked");
					$(this).find(".icheckbox_flat-green").find("input[type=checkbox]").removeAttr("checked");
				}
			})
		} else {
			$(".checkbox").each(function() {
				$(this).find('input[type=checkbox]').parent(".icheckbox_flat-green").removeClass("checked");
				$(this).find("input[type=checkbox]").removeAttr("checked");
			})
		}

	},'json');
})

function in_object(valor,object) {
	for (var i = 0; i < object.length; i++) {

		if(valor == object[i].idmodulos) {

			return {result:true,id:object[i].idmodulos};
		}
	}
	return {result:false,id:null};
}