<?php
  error_reporting(0);
  if(!isset($_SESSION["idpersonal"])){
    redirect("Login", "refresh");
  }else{
    include("app/includes/usuario.inc");

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SISTEMA</title>

    <!-- Bootstrap -->
    <?php include("app/includes/link.inc"); ?>
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">

        <?php include("app/includes/menu.inc"); ?>

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <!-- TODO EL CONTENIDO  -->

            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Todos los Personales</h2>
                    <div class="form-group">
                      <div class="col-md-8">
                        <button type="button" class="btn btn-success" onclick="nuevo();"><i class="fa fa-plus"></i> Nuevo</button>
                      </div>
                      <div class="col-md-1">
                        <button type="button" class=" btn btn-danger" onclick="inactivos();"><i class="fa fa-ban"></i> Ver Inactivos</button>
                      </div>
                    </div>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <table id="datatable-fixed-header" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Id</th>
                          <th>Nombres</th>
                          <th>Apellidos</th>
                          <th>Usuario</th>
                          <th>Perfil</th>
                          <th>Accion</th>
                        </tr>
                      </thead>

                      <tbody>
                        <?php foreach ($personal as  $value) { ?>                          
                          <tr>
                            <td><?php echo $value->idpersonal ?></td>
                            <td><?php echo $value->nombres ?></td>
                            <td><?php echo $value->apellidos ?></td>
                            <td><?php echo $value->usuario ?></td>
                            <td><?php echo $value->descripcion ?></td>
                            <td>
                              <button type="button" class="btn btn-info" onclick="editar('<?php echo $value->idpersonal ?>')"><i class="fa fa-pencil"></i> Editar</button>
                              <button type="button" class="btn btn-danger" onclick="eliminar('<?php echo $value->idpersonal ?>')"><i class="fa fa-trash-o"></i> Eliminar</button>
                            </td>
                          </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>


          </div>
        </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer>
          <div class="pull-right">
            Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" id="nuevo">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">

          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Personal</h4>
          </div>
          <div class="modal-body">
            <form class="form-horizontal" role="form" id="form_personal">
              <input type="hidden" name="id" id="id">
              <div class="form-group">
                <label class="col-md-1 control-label" >Nombres</label>
                <div class="col-md-5">
                  <input type="text" id="nombres" name="nombres" class="form-control" data-validate-length-range="6" data-validate-words="2" required="required" maxlength="30" onkeypress="return Letras(event);">
                </div>
                <label class="col-md-1 control-label" >Apellidos</label>
                <div class="col-md-5">
                  <input type="text" id="apellidos" name="apellidos" class="form-control" data-validate-length-range="6" data-validate-words="2" required="required" maxlength="40" onkeypress="return Letras(event);" >
                </div>                
              </div>
              
              <div class="form-group">
                <label class="col-md-1 control-label" >Usuario</label>
                <div class="col-md-5">
                  <input type="text" id="usuario" name="usuario" class="form-control" data-validate-length-range="6" data-validate-words="2" required="required" maxlength="30"  >
                </div>
                <label class="col-md-1 control-label" >Clave</label>
                <div class="col-md-2">
                  <input type="password" id="clave" name="clave" class="form-control" data-validate-length-range="6" data-validate-words="2" required="required" maxlength="40" >
                </div> 
                <label class="col-md-1 control-label" >Perfil</label>
                <div class="col-md-2">
                    <select class="form-control" name="tipo_personal" id="tipo_personal">
                      <option value="0" >Selecionar</option>
                      <?php foreach($tipo as $value) { ?>
                        <option value="<?php echo $value->idperfil?>">
                          <?php echo $value->descripcion?>
                        </option>
                      <?php } ?>  
                    </select>
                </div> 
              </div>

            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary" onclick="return guardar(this.form);"><i class="fa fa-floppy-o"></i> Guardar</button>
          </div>

        </div>
      </div>
    </div>

    <!-- Ver Inactivos -->
    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" id="inactivos">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Personales Desabilitados</h4>
          </div>
          <div class="modal-body">
            <div class="x_panel">
              <div class="x_content">
                <table id="datatable-fixed-header" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Id</th>
                          <th>Nombres</th>
                          <th>Apellidos</th>
                          <th>Usuario</th>
                          <th>Perfil</th>
                          <th>Accion</th>
                        </tr>
                      </thead>

                      <tbody>
                        <?php foreach ($inactivos as  $value) { ?>                          
                          <tr>
                            <td><?php echo $value->idpersonal ?></td>
                            <td><?php echo $value->nombres ?></td>
                            <td><?php echo $value->apellidos ?></td>
                            <td><?php echo $value->usuario ?></td>
                            <td><?php echo $value->descripcion ?></td>
                            <td>
                              <button type="button" class="btn btn-info" onclick="activar('<?php echo $value->idpersonal ?>')"><i class="fa fa-pencil"></i> Activar</button>
                            </td>
                          </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal" >Cerrar</button>
                </div>
              </div>
            </div>                
          </div>
        </div>
      </div>
    </div>


    <script>
        var urlbase="<?php echo base_url(); ?>";
    </script>

    <?php include("app/includes/js.inc"); ?>
    <script src="<?php echo base_url(); ?>app/includes/datatable.js"></script>
    <script src="<?php echo base_url(); ?>app/includes/estilo.js"></script>
    <script src="<?php echo base_url(); ?>app/js/personal.js"></script>
  </body>
</html>
<?php } ?>