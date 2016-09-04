function nuevo(){
    $("#modulo").val("0");
    $("#descrip").val("");
    $("#nuevo").modal("show");
    $("#agrega_principal").show();
}

function agr_principal(){
    $("#descripcion").val("");
    $("#icono").val("0");
    $("#principal").modal("show");
}

function guardar_prin(campo){
    if($("#descripcion").val()==""){
        $("#descripcion").focus(); return 0;
    }
    if($("#icono").val()=="0"){
        $("#icono").focus(); return 0;
    }

    $.ajax({
        type: "POST",
        data: $("#form_principal").serialize(),
        url: urlbase+'Modulos/AgregaPrincipal',
        success: function(data){
            //$json = JSON.parse(data);
            $json = jQuery.parseJSON(data);
            if($json.code == 'IP'){
                new PNotify({text: 'DATOS INSERTADO', type: 'success', styling: 'bootstrap3'});
            }else{
                new PNotify({text: 'ERROR AL INSERTAR', type: 'error', styling: 'bootstrap3'});
            }
            $("#modulo").html($json.html);
            $('#modulo option[value="'+$json.id+'"]').attr("selected","selected");

            $("#principal").modal("hide");
        }
    })
}

function guardar(campo){
    if($("#modulo").val()=="0"){
        $("#modulo").focus(); return 0;
    }
    if($("#descrip").val()==""){
        ($("#descrip")).focus(); return 0;
    }
    $.ajax({
        type: "POST",
        data: $("#form_modulos").serialize(),
        url: urlbase+'Modulos/guardar',
        success: function(data){
            $("#nuevo").modal("hide");
            if(data=='IM'){
                new PNotify({text: 'DATOS INSERTADO', type: 'success', styling: 'bootstrap3'});
            }else{
                if(data=='EIM'){
                    new PNotify({text: 'ERROR AL INSERTAR', type: 'error', styling: 'bootstrap3'});
                }else{
                    if(data=='MM'){
                        new PNotify({text: 'MODIFICADO CORRECTAMENTE', type: 'success', styling: 'bootstrap3'});
                    }else{
                        new PNotify({text: 'ERROR MODIFICAR', type: 'error', styling: 'bootstrap3'});
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
        url: urlbase+'Modulos/VerEditar',
        success: function(data){
            datos=eval(data);
            $("#id").val(datos[0]["idmodulos"]);
            $("#descrip").val(datos[0]["descripcion"]);
            $("#modulo").val(datos[0]["idpadre"]);

            $("#agrega_principal").hide();
            $("#nuevo").modal("show");

        }
    })
}

function eliminar(id){
    if(window.confirm("SEGURO QUE QUIERE ELIMINAR")){
        $.ajax({

            type: "POST",
            data: "id="+id,
            url: urlbase+'Modulos/eliminar',
            success: function(data){
                if(data=='Elinimado'){
                    new PNotify({text: 'ELIMINADO CORRECTAMENTE', type: 'success', styling: 'bootstrap3'});
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
        url: urlbase+'Modulos/activar',
        success: function(data){
            if (data=='A') {
                new PNotify({text: 'ACTIVADO CORRECTAMENTE', type: 'success', styling: 'bootstrap3'});
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