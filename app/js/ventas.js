$(document).on("click","#nueva_venta", function(e){
	window.location = urlbase+"Ventas/nuevo";
});

$(function(){
	$("#credito").hide();
});

function select_clientes(){
	$("#select_clientes").modal("show");
}

function Selecion_cliente(id,nombres,apellidos){
	$("#idcliente").val(id);
	$("#nombres_cliente").val(nombres.split(" ").join(" ")+ ' '+apellidos.split(" ").join(" "));
	$("#select_clientes").modal("hide");
}

function select_productos(){
	$("#select_productos").modal("show");
}

function Selecion_producto(id,producto){
	$("#idproducto").val(id);
	$("#producto").val(producto);
	$("#select_productos").modal("hide");

	var id_producto=$("#idproducto").val();

	$("#unidad_medida").empty();
	$.getJSON(urlbase+'Ventas/MostraUnidades/'+id_producto, function(json) {
		$("#unidad_medida").append('<option value="0">Unidad Medida</option>');
		$.each(json,function(idunidad,value){
			$("#unidad_medida").append('<option value="'+value.idunidad+'">'+value.descripcion+'</option>');
		});
	});

}

$(document).on("change",$("#unidad_medida"),function(e){
	e.preventDefault();

	if($("#unidad_medida").val() == "0"){
		$("#precio").val("");
	}else{
		
		$unidad = $("#unidad_medida").val();
		$producto=$("#idproducto").val();
		$.post(urlbase+'Ventas/TraerPrecio', {idunidad: $unidad, idproducto:$producto}, function(data) {
			var datos=eval(data);
			$("#precio").val(datos[0]["precio"]);
		});
	}
});


var total_general=0;
var subtotal_general=0;
var impuestos=0;

function ver_ventas(campo){
	if($("#producto").val()==""){
		new PNotify({text: 'INGRESE DATOS DEL Producto', type: 'danger', styling: 'bootstrap3'});
		$("#producto").focus(); return 0;
	}
	if($("#unidad_medida").val()=="0"){
		$("#unidad_medida").focus(); return 0;
	}
	if($("#precio").val()==""){
		$("#precio").focus(); return 0;
	}
	if($("#cantidad").val()==""){
		$("#cantidad").focus(); return 0;
	}
	var html= "";

	if($("#producto_"+$("#idproducto").val()+$("#unidad_medida").val()).length == 0 ){

		var subtotal= ($("#cantidad").val() * $("#precio").val()).toFixed(3);
		subtotal_general = parseInt(subtotal_general) + parseInt(subtotal);
		html += "<tr id='producto_"+$("#idproducto").val()+$("#unidad_medida").val()+"'>";	
		html += "<td><input type='hidden' name='producto_lista[]' class='form-control' value='"+$("#idproducto").val()+"'>"+$("#producto").val()+"</td>";
		html += "<td><input type='hidden' class='form-control' name='unidad_lista[]' value='"+$("#unidad_medida").val()+"'>"+$("#unidad_medida").val()+"</td>";
		html += "<td><input type='hidden' class='form-control' name='precio_lista[]' value='"+$("#precio").val()+"'>"+$("#precio").val()+"</td>";
		html += "<td><input type='hidden' class='form-control' name='cantidad_lista[]' value='"+$("#cantidad").val()+"'>"+$("#cantidad").val()+"</td>";
		html += "<td><input type='hidden' class='form-control' name='subtotal_lista[]' value='"+subtotal+"'>"+subtotal+"</td>";
		if($("#igv_estado").is(':checked')){
			var igv_sub = (subtotal * 0.18 ).toFixed(3);
			html += "<td><input type='hidden' class='form-control' name='igv_lista[]' value='"+igv_sub+"'>"+ igv_sub +"</td>";
			
		}else{
			var igv_sub = 0;
			html += "<td><input type='hidden' class='form-control' name='igv_lista[]' value='"+igv_sub+"'>"+igv_sub+"</td>";
			
		}		
		impuestos = (parseFloat(impuestos) + parseFloat(igv_sub)).toFixed(3);
		var resultado = (parseInt(subtotal) + parseFloat(igv_sub)).toFixed(3);
		total_general = (parseFloat(total_general) + parseFloat(resultado)).toFixed(3);
		html += "<td>"+resultado +"</td>";
		html +="<td><button class='btn btn-danger btn-xs' onclick=$(this).closest('tr').remove();restar_total('"+resultado+"');restar_igv('"+igv_sub +"');restar_sub('"+subtotal+"');><i class='fa fa-remove'></i></button></td>"
		html += "</tr>";
		$("#cargar_ventas").append(html);

		$("#imp_venta").val(impuestos);
		$("#subtotal_venta").val(subtotal_general);
		$("#total_venta").val(total_general);
	}else{
		alert("Ya ingreso este Producto con su respectiva U. Medida");
	}

	$("#unidad_medida").val("0");
	$("#precio").val("");
	$("#cantidad").val("");
}

var restar_total= function (resultado){
	total_general = (total_general - resultado).toFixed(3);
	$("#total_venta").val(total_general);
}
var restar_igv = function(igv_sub){
	impuestos = (impuestos - igv_sub).toFixed(3);
	$("#imp_venta").val(impuestos);
}
var restar_sub = function(subtotal){
	subtotal_general = (subtotal_general - subtotal).toFixed(3);
	$("#subtotal_venta").val(subtotal_general);
}

function Guardar_venta(campo){
	if($("#nombres_cliente").val()==""){
		new PNotify({text: 'INGRESE DATOS DEL CLIENTE', type: 'danger', styling: 'bootstrap3'});
		$("#nombres_cliente").focus(); return 0;
	}
	if($("#mesa").val()=="0"){
		$("#mesa").focus(); return 0;
	}
	if($("#tipo_transaccion").val()=="0"){
		$("#tipo_transaccion").focus(); return 0;
	}

	if($("#cargar_ventas tr").length == 0){
		alert("Seleccione un producto"); return 0;
	}
	if($("#tipo_transaccion").val() == "1"){
		if($("#num_cuotas").val() == ""){
			$("#num_cuotas").focus(); return 0;
		}
		if($("#intervalo_dias").val() == ""){
			$("#intervalo_dias").focus(); return 0;
		}
	}
	
	if($("#tipo_transaccion").val() == "1"){
		
		$("#editar_conograma").empty();
		
		var numero_cuotas = parseInt($("#num_cuotas").val());
		var intervalo_dias = $("#intervalo_dias").val();
		var monto_cuotas = $("#total_venta").val()/numero_cuotas;

		subtotal = Math.round(monto_cuotas * 100) / 100;

		var f = new Date();

		var fecha = f.getDate() + "-" + (f.getMonth()+1) + "-" + f.getFullYear();

		if( f.getDate() < 10){
			var fecha_actual = f.getFullYear() + "-" + (f.getMonth()+1) + "-0" +  f.getDate();
		}else{
			var fecha_actual = f.getFullYear() + "-" + (f.getMonth()+1) + "-" +  f.getDate();
		}

		var year_a = f.getFullYear();
		var mes_a = f.getMonth()+1;
		var dia_a = f.getDate();

		mes_a = (mes_a < 10) ? ("0" + mes_a) : mes_a;
	    dia_a = (dia_a < 10) ? ("0" + dia_a) : dia_a;

	    var fecha_primero = dia_a + "-" + mes_a + "-" + year_a;

	    fecha_primero_s = fecha_primero.split("-");
	    fecha_primero_s = fecha_primero_s[2]+"-"+fecha_primero_s[1]+"-"+fecha_primero_s[0];

		var html = "";
		var n_cuotas = parseInt(numero_cuotas);

		var cont_mont = 0;
		for (var i = 1;i<= n_cuotas; i++) {
			cont_mont = cont_mont + subtotal;
			if(i==1){
				html += "<tr>";
				html += "<td><input type='hidden' name='idcouta[]' value='"+ i +"'>"+i+"</td>";
				html += "<td><input type='text' id='cambio"+i+"' onkeypress='return NumerosCuota(event)' onkeyup='cambiar_monto();' name='monto_cuota[]' value='"+ subtotal +"'></td>";
				html += "<td><input type='date' name='fecha_pago[]' min='"+ fecha_actual +"' value='"+fecha_primero_s +"'></td>";
				html += "</tr>";
			}else{
				var intervalo = parseInt(intervalo_dias);
				fecha = suma_fecha(intervalo,fecha);
				var fecha_original = fecha.split("-");
				fecha_original = fecha_original[2]+"-"+ fecha_original[1]+"-"+fecha_original[0];
				html += "<tr>";
				html += "<td><input type='hidden' name='idcouta[]' value='"+ i +"'>"+i+"</td>";
				if( i == n_cuotas){
					var resta = $("#total_venta").val() - cont_mont;
					var valor = (subtotal + resta).toFixed(3);
					html += "<td><input type='text' id='cambio"+i+"' name='monto_cuota[]' value='"+ valor +"'></td>";
				}else{
					html += "<td><input type='text' id='cambio"+i+"' name='monto_cuota[]' value='"+ subtotal +"'></td>";
				}
				html += "<td><input type='date' name='fecha_pago[]' min='"+ fecha_actual +"' value='"+fecha_original +"'></td>";
				html += "</tr>";
			}
			
		}
		
		$("#editar_conograma").append(html);
		$("#ver_cronograma").modal("show");
	}else{
		$.ajax({
			type: "POST",
			data: $("#form_ventas").serialize(),
			url: urlbase+'Ventas/guardar_venta',
			success: function(data){
				if(data == 1){
					new PNotify({text: 'Venta Realizado correctamente', type: 'success', styling: 'bootstrap3'});
				}else{
					new PNotify({text: 'Eroor al guardar Venta', type: 'danger', styling: 'bootstrap3'});
				}
				setTimeout("actualizar()",500);

			}
		})
	}
}

/*$(document).on("change", "#cambio1",function(){
	var monto_inicial = $(this).val();

	alert(monto_inicial);
	if(monto_inicial != ""){
		alert($("#cambio1").val());
	}

});*/

function cambiar_monto(){
	var monto_inicial = parseFloat($("#cambio1").val());
	var total = parseFloat($("#total_venta").val());
	if($("#cambio1").val() == ""){
		alert("No permite campo Vacio"); return 0;
	}
	if(monto_inicial >=  total){
		alert("El monto no debe superar o igualar total"); return 0;
	}else{
		var numero_cuotas = parseInt($("#num_cuotas").val()) - 1;
		var resto_total = total - monto_inicial;

		var monto_cuota_actual = (resto_total/numero_cuotas).toFixed(3);
		var suma = 0;

		for (var i = 2; i <= numero_cuotas; i++) {
			suma = suma + parseFloat(monto_cuota_actual);
			$("#cambio"+i+"").val(monto_cuota_actual);
		}
		
		var monto_final = (parseFloat(total) - (parseFloat(suma) + parseFloat(monto_inicial))).toFixed(3);
		var j = numero_cuotas +1;
		$("#cambio"+j+"").val(monto_final);
	}
	

	
}

function NumerosCuota(e){
    tecla = e.keyCode || e.which; 
    base =/[0-9.]/; 
    teclado = String.fromCharCode(tecla).toLowerCase(); 
    return base.test(teclado); 
}


suma_fecha = function(d,fecha){
	var fec = new Date();
	var fecha_tem = fecha || (fec.getDate()+"/"+(fec.getMonth()+1)+"/"+fec.getFullYear());
	var sep = fecha_tem.indexOf('/') != -1 ? '/' : '-';

	var fecha_espacios = fecha_tem.split(sep);
	var fecha_ultimo = fecha_espacios[2]+'/'+fecha_espacios[1]+'/'+fecha_espacios[0];
	var fecha_suma = new Date(fecha_ultimo);
	fecha_suma.setDate(fecha_suma.getDate() + parseInt(d));

	var year = fecha_suma.getFullYear();
	var mes = fecha_suma.getMonth()+1;
	var dia = fecha_suma.getDate();

	mes = (mes < 10) ? ("0" + mes) : mes;
    dia = (dia < 10) ? ("0" + dia) : dia;

    var fecha_final = dia + sep + mes + sep + year;
	return (fecha_final);	
}

$(document).on("change",$("#tipo_transaccion"),function(){
	if($("#tipo_transaccion").val() == 1){
		$("#credito").show();
	}else{
		$("#credito").hide();
	}
});

function guardar_credito(campo){

	var cont = 0;
	
	$('input[name^="monto_cuota"]').each(function(){

		cont = cont + parseFloat($(this).val());
	});
	if( $("#total_venta").val() != cont){
		alert("Distribucion Incorrecta"); return 0;
	}

	$("#ver_cronograma").modal("hide");
	$.ajax({
		type: "POST",
		data: $("#form_ventas").serialize(),
		url: urlbase+'Ventas/guardar_venta',
		success: function(data){
			if(data == 1){
				new PNotify({text: 'Venta Realizado correctamente', type: 'success', styling: 'bootstrap3'});
			}else{
				new PNotify({text: 'Eroor al guardar Venta', type: 'danger', styling: 'bootstrap3'});
			}
			setTimeout("actualizar()",500);
		}
	})

}

function historial_cliente(){
	$.ajax({
		type: "POST",
		data: "idcliente="+$("#idcliente").val(),
		url: urlbase+'Ventas/historial',
		success: function(data){
			alert(data);
		}
	});



	//$("#historial_cliente").modal("show");
}

function actualizar(){

	location.href=urlbase+'Ventas';
}


