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

            <div class="col-md-16">
              <div class="x-panel">
                <form class="form-horizontal" role="form" id="form_ventas">
                  <div class="form-group">
                    <input type="hidden" name="id" id="id">
                    <label class="col-md-1 "><h4>Cliente:</h4></label>
                    <div class="col-md-3">
                      <input type="hidden" name="idcliente" id="idcliente" class="form-control">
                      <input type="text" name="nombres_cliente" id="nombres_cliente" class="form-control">
                    </div>
                    <div class="col-md-2">
                      <button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" data-original-title="Buscar Cliente" onclick="select_clientes();"><i class="fa fa-search"></i></button>
                      <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" data-original-title="Agregar Cliente" onclick="agregar_clientes();"><i class="fa fa-plus-square-o"></i></button>
                    </div>
                    <div class="col-md-2">
                      <select class="form-control" name="mesa" id="mesa">
                        <option value="0">Selecione Mesa</option>
                         <?php foreach($mesas as $value) { ?>
                            <option value="<?php echo $value->idmesa?>">
                              <?php echo $value->mesa?>
                            </option>
                          <?php } ?>
                      </select>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-3">
                      <select class="form-control" name="tipo_transaccion" id="tipo_transaccion">
                        <option value="0">TipoTransaccion</option>
                         <?php foreach($tipo_transaccion as $value) { ?>
                            <option value="<?php echo $value->idtipotransaccion?>">
                              <?php echo $value->descripcion?>
                            </option>
                          <?php } ?>
                      </select>
                    </div>
                  </div>

                  <div class="form-group" id="credito">
                    <div class="col-md-1"></div>
                    <div class="col-md-4">
                      <button type="button" onclick="historial_cliente();" class="btn btn-dark"><i class="fa fa-male"></i> Historial Cliente</button>
                      <button type="button" onclick="scoring();" class="btn btn-dark"><i class="fa fa-bar-chart"></i> Scoring</button>
                    </div>
                    <label class="col-md-1">Números de cuotas</label>
                    <div class="col-md-2">
                      <input type="text" name="num_cuotas" id="num_cuotas" class="form-control">
                    </div>
                    <label class="col-md-1">Intervalos de Dias</label>
                    <div class="col-md-2">
                      <input type="text" name="intervalo_dias" id="intervalo_dias" class="form-control">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-md-1"><h4>Producto:</h4></label>
                    <div class="col-md-3">
                      <input type="hidden" name="idproducto" id="idproducto" class="form-control">
                      <input type="text" name="producto" id="producto" class="form-control">
                    </div>
                    <div class="col-md-2">
                      <button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top" data-original-title="Buscar Producto" onclick="select_productos();"><i class="fa fa-search"></i></button>
                    </div>
                    <div class="col-md-2">
                      <select class="form-control" name="unidad_medida" id="unidad_medida">
                        <option value="0">Unidad Medida</option>
                      </select>
                    </div>
                    <!--<label class="col-md-1"><h4>Precio: </h4></label>-->
                    <div class="col-md-1">
                      <input type="text" name="precio" readonly="readonly" id="precio" class="form-control" placeholder="precio">
                    </div>
                    <label class="col-md-1"><h4>Cantidad: </h4></label>
                    <div class="col-md-1">
                      <input type="text" name="cantidad" id="cantidad" class="form-control">
                    </div>
                    <!--<div class="col-md-1">
                      <button type="button" class="btn btn-warning" onclick="return ver_ventas(this.form)"><i class="fa fa-floppy-o"></i> Agregar</button>
                    </div>
                    <div class="col-md-1">
                      <div class="checkbox" >
                        <label>IGV<input type="checkbox" class="flat" id="igv_estado" value="0">
                        </label>
                      </div>
                    </div>-->
                  </div>
                  <br>
                  <div class="form-group">
                    <div class="col-md-4"></div>
                    <div class="col-md-1">
                      <button type="button" class="btn btn-warning" onclick="return ver_ventas(this.form)"><i class="fa fa-floppy-o"></i> Agregar</button>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-2">
                      <div class="checkbox" >
                        <label>IGV <input type="checkbox" class="flat" id="igv_estado" value="0">
                        </label>
                      </div>
                    </div>
                  </div>

                  <div>
                    <table class="table">
                      <thead>
                        <tr>
                          <th>Producto</th>
                          <th>Unidad Medida</th>
                          <th>Precio</th>
                          <th>Cantidad</th>
                          <th>Sub Total</th>
                          <th>IGV</th>
                          <th>Total</th>
                          <th>Quitar</th>
                        </tr>
                      </thead>

                      <tbody id="cargar_ventas"></tbody>
                    </table>
                  </div>

                  <div class="form-group">
                    <div class="col-md-3"></div>
                    <label class="col-md-1"><h2>Subtotal</h2></label>
                    <div class="col-md-2">
                      <input type="text" class="form-control" readonly="readonly" id="subtotal_venta" name="subtotal_venta">
                    </div>
                    <label class="col-md-1"><h2>Impuestos </h2></label>
                    <div class="col-md-2">
                      <input type="text" class="form-control" readonly="readonly" id="imp_venta" name="imp_venta">
                    </div>
                    <label class="col-md-1"><h2>Total</h2></label>
                    <div class="col-md-2">
                      <input type="text" class="form-control" readonly="readonly" name="total_venta" id="total_venta">
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="col-md-5"></div>
                    <div class="col-md-3">
                      <a href="http://localhost/vacacionesProyect/Ventas" class="btn btn-default">Cancelar</a>
                      <button type="button" class="btn btn-success" onclick="return Guardar_venta(this.form);"><i class="fa fa-floppy-o"></i> Guardar</button>
                      
                    </div>
                  </div>


                  <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" id="ver_cronograma">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title" id="myModalLabel">Cronograma</h4>
                        </div>
                        <div class="modal-body">
                          <div class="x_panel">
                            <div class="x_content">
                                <table  class="table table-striped table-bordered">
                                  <thead>
                                    <tr>
                                      <th>N° Cuota</th>
                                      <th>Monto</th>
                                      <th>Fecha Vencimiento</th>
                                    </tr>
                                  </thead>
                                        
                                  <tbody id="editar_conograma"></tbody>
                                </table>
                                <div class="modal-footer"><center>
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                  <button type="button" class="btn btn-primary" onclick="return guardar_credito(this.form);"><i class="fa fa-floppy-o"></i> Guardar</button></center>
                                </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>

            <!-- fin contenido -->
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





    <!-- Seleccionar Clientes -->
    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" id="select_clientes">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Clientes</h4>
          </div>
          <div class="modal-body">
            <div class="x_panel">
              <div class="x_content">
                <table id="datatable-fixed-header" class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>Id</th>
                      <th>Nombres / Razón social</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>

                  <tbody>
                  <?php
                    foreach ($verclientes as $value){ ?>
                      <tr>
                        <td><?php echo $value->idcliente?></td>
                        <td><?php echo $value->nombres.' '.$value->apellidos?></td>
                        <td>

                          <button type="button" class="btn btn-warning btn-xs" onclick="Selecion_cliente('<?php echo $value->idcliente?>','<?php echo $value->nombres?>','<?php echo $value->apellidos  ?>')"><i class="fa fa-pencil"></i> Seleccionar</button>
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
    </div>

    <!-- Seleccionar Productos -->
    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" id="select_productos">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Productos</h4>
          </div>
          <div class="modal-body">
            <div class="x_panel">
              <div class="x_content">
                <table id="datatable-fixed-header" class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>Id</th>
                      <th>Producto</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>

                  <tbody>
                  <?php
                    foreach ($verproducto as $value){ ?>
                      <tr>
                        <td><?php echo $value->idproducto?></td>
                        <td><?php echo $value->descripcion?></td>
                        <td>
                          <button type="button" class="btn btn-warning btn-xs" onclick="Selecion_producto('<?php echo $value->idproducto?>','<?php echo $value->descripcion?>')"><i class="fa fa-pencil"></i> Seleccionar</button>
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
    </div>

    <!-- Historial de Clientes -->
    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" id="historial_cliente">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Historial de Clientes</h4>
          </div>
          <div class="modal-body">
            <div class="x_panel">
              <div class="x_content">
                <div class="col-md-12 col-sm-8 ">
                
                  <div class="x_content">


                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
                      <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Principal</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">1 Semana</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">1 Mes</a>
                        </li>
                      </ul>
                      <div id="myTabContent" class="tab-content">
                        <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
                          <div id="principal"></div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
                          <div id="secundario"></div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab">
                          <div id="terciario"></div>
                        </div>
                      </div>
                    </div>

                  </div>
                
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