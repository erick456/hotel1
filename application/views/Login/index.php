<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>LOGIN</title>

    <!-- Bootstrap -->
    <?php include("app/includes/link.inc"); ?>
</head>

<body class="login">
    <div>
        <a class="hiddenanchor" id="signup"></a>
        <a class="hiddenanchor" id="signin"></a>

        <div class="login_wrapper">
            <div class="animate form login_form">
                <section class="login_content">
                    <h1>Iniciar Sesion</h1>
                    <div>
                        <input type="text" class="form-control" placeholder="Usuario" required="" name="usuario" id="usuario" />
                    </div>
                    <br>
                    <div>
                        <input type="password" class="form-control" placeholder="Clave" required="" name="clave" id="clave" />
                    </div>
                    <br>
                    <div>
                        <button type="button" class="btn btn-default submit btn_login"  style="width: 200px;" onclick="ingresar();">Ingresar</button>
                    </div>

                    <div class="clearfix"></div>

                    <div class="separator">

                        <div class="clearfix"></div>
                        <br />

                        <div>
                            <h1><i class="fa fa-paw"></i> Mickey Alvarado Sangama</h1>
                            <p>©2016 Todos los derechos reservados. mmmmm. Terminos Privados</p>
                        </div>
                    </div>
                </section>
            </div>

        </div>
    </div>
</body>

<script>
    var urlbase="<?php echo base_url(); ?>";
</script>
<?php include("app/includes/js.inc"); ?>
<script type="text/javascript" src="<?php echo base_url();?>librerias/vendors/jquery/dist/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>app/includes/inicio.js"></script>

</html>