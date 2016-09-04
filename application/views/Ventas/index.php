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
          <div class="row">
            <!-- TODO EL CONTENIDO  -->

            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Todos los Ventas &nbsp;</h2>
                    <div class="form-group">
                      <div class="col-md-8">
                        <button type="button" class="btn btn-success" id="nueva_venta"><i class="fa fa-plus"></i> Nueva Venta</button>
                      </div>
                      <div class="col-md-1">
                        <button type="button" class="btn btn-danger" onclick="inactivos();"><i class="fa fa-ban"></i> Ver Inactivos</button>
                      </div>
                    </div>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <table id="datatable-fixed-header" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th><center>Num</center></th>
                          <th><center>Id</center></th>
                          <th><center>Tipo Transaccion</center></th>
                          <th><center>Personal</center></th>
                          <th><center>Mesa</center></th>
                          <th><center>Fecha venta</center></th>
                          <th><center>Cliente</center></th>
                          <th><center>Total</center></th>
                          <th><center>Acciones</center></th>
                        </tr>
                      </thead>

                      <tbody>
                      <?php
                        $cont = 0;
                        foreach ($ventas as $value){ 
                          $cont = $cont + 1; ?> 
                          <tr>
                          <td><center><?php echo $cont ?></center></td>
                            <td><center><?php echo $value->idventas?></center></td>
                            <td><center><?php echo $value->descripcion?></center></td>
                            <td><center><?php echo $value->per_nombres.' '.$value->per_apellidos?></center></td>
                            <td><center><?php echo $value->mesa?></center></td>
                            <td><center><?php echo $value->fecha_venta?></center></td>
                            <td><center><?php echo $value->nombres.' '. $value->apellidos?></center></td>
                            <td><center><?php echo $value->total?></center></td>
                            <td><center>
                              <button type="button" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" data-original-title="Ver Cronograma" onclick="editar('<?php echo $value->idventas ?>')"><i class="fa fa-pencil"></i></button>
                              <button type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" data-original-title="Eliminar" onclick="eliminar('<?php echo $value->idventas ?>');"><i class=" fa fa-trash-o"></i></button>
                              </center>
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
  
    <!-- Ver Inactivos -->
    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" id="inactivos">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Perfiles Desabilitados</h4>
          </div>
          <div class="modal-body">
            <div class="x_panel">
              <div class="x_content">
                <table id="datatable-fixed-header" class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>Id</th>
                      <th>Perfil</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>

                  <tbody>
                  <?php
                    foreach ($eliminados as $value){ ?> 
                      <tr>
                        <td><?php echo $value->idperfil?></td>
                        <td><?php echo $value->descripcion?></td>
                        <td>
                          <button type="button" class="btn btn-warning " onclick="activar('<?php echo $value->idperfil ?>')"><i class="fa fa-pencil"></i> Activar</button>
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
    <script src="<?php echo base_url(); ?>app/js/ventas.js"></script>
    
  </body>
</html>

<?php } ?>