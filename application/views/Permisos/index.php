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
	<link rel="stylesheet" href="">
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
							<div class="x_content">
								<div class="col-md-4 col-md-offset-3">
									<select name="perfil" id="perfil" class="form-control">
										<option value="0">Seleccione</option>
										<?php
											foreach ($perfiles as $key => $perfil) {
												echo '
													<option value="'.$perfil->idperfil.'">'
														.$perfil->descripcion.'
													</option>';
											}
										?>
									</select>
								</div>
								<div class="col-md-5">
									<div>
										<button type="button" class="btn btn-success" id="guardar"><i class="fa fa-floppy-o"></i> Guardar</button>
									</div>
								</div>
								<form class="form-horizontal form-label-left " id="form_permisos">
									<?php
									foreach ($modulos as $key => $value) {
										echo '<div class="col-md-3 col-sm-3 col-xs-3 hijos">';
										echo '<h3>'.$value["descripcion"].'</h3>';
										foreach ($value["hijos"] as $hijo) {
											echo '
											<div class="form-group">

												<div class="checkbox">
													<label>
														<input type="checkbox" class="flat" id="permisos" name="permisos[]" value="'.$hijo["idmodulos"].'"> '.$hijo["descripcion"].'
													</label>
												</div>
											</div>
											';
										}
										echo '</div>';
									}

									?>



								</form>


							</div>
						</div>
					</div>


				</div>
			</div>
			<!-- /page content -->

          <!--     <div class="x_content">
                <form class="form-horizontal form-label-left" id="permisos">
                  <div class="col-md-5 col-md-offset-2">
                    <select name="perfil" id="perfil" class="form-control">
                      <option value="0">Seleccione</option>
                      <?php
                        foreach ($perfiles as $key => $perfil) {
                          echo '<option value="'.$perfil->idperfil.'">'.$perfil->descripcion.'</option>';
                      }
                      ?>
                    </select>

                  </div>
                  <div>
                      <button type="button" class="btn btn-success" id="guardar"><i class="fa fa-floppy-o"></i> Guardar</button>
                  </div>

                  <div id="marcar_permisos"></div>

                </form>
              </div>
            </div>
          </div>
        </div>
    </div> -->
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



<script>

	var urlbase = "<?php echo base_url(); ?>";
</script>

<?php include("app/includes/js.inc"); ?>

<script src="<?php echo base_url(); ?>app/includes/datatable.js"></script>
<script src="<?php echo base_url(); ?>app/includes/estilo.js"></script>
<script src="<?php echo base_url(); ?>app/js/permisos.js"></script>



<script>

</script>

</body>
</html>

<?php } ?>