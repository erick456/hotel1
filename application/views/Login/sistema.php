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

    <script>
        var urlbase="<?php echo base_url(); ?>";
    </script>

    <?php include("app/includes/js.inc"); ?>

    <?php include("app/includes/estilo.inc"); ?>

    
  </body>
</html>
<?php }?>
