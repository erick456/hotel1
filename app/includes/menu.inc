<div class="col-md-3 left_col">
  <div class="left_col scroll-view">
    <div class="navbar nav_title" style="border: 0;">
      <a href="<?php echo base_url(); ?>Login/sistema.php" class="site_title"><i class="fa fa-paw"></i> <span><?php echo $nombres.' '.$apellidos; ?></span></a>
    </div>

    <div class="clearfix"></div>

    <!-- menu profile quick info -->
    <div class="profile">
      <div class="profile_pic">
        <img src="<?php echo base_url(); ?>librerias/production/images/img.jpg" alt="..." class="img-circle profile_img">
      </div>
      <div class="profile_info">

        <span>Bienvenido,</span>
        <h2><?php echo $apellidos; ?></h2>
      </div>
    </div>
    <!-- /menu profile quick info -->

    <br />

    <!-- sidebar menu -->
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
      <div class="menu_section">
        <h3><?php echo $apodo; ?></h3>
        <ul class="nav side-menu">
          <?php
            foreach($data["permisos_usuario"] as $value){

              $modulos_padre= $this->db->get_where('modulos', array('mod_id' => $value->per_modulos, 'mod_estado' => 1));
              $data["modulos_padres"] = $modulos_padre->result();




                if( ($data["modulos_padres"][0]->mod_padre == 1) and ($data["modulos_padres"][0]->mod_estado == 1)){

                ?>

                <li><a><i class="<?php echo $data['modulos_padres'][0]->mod_icono; ?>"></i> <?php echo $data['modulos_padres'][0]->mod_descripcion; ?> <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <?php

                      $modulos_hijos = $this->db->get_where ("modulos", array("mod_padre"=>$data["modulos_padres"][0]->mod_id ,"mod_estado"=>'1'));

                      $data["modulos_hijos"] = $modulos_hijos->result();

                      foreach( $data["modulos_hijos"] as $row ){

                        $validar= $this->db->get_where("permisos", array("per_modulos" =>$row->mod_id , "per_perfil" => $idperfil))->result();

                        if(COUNT($validar)!=0){    ?>
                        <li><a href="<?php echo base_url().$row->mod_url; ?>"><?php echo $row->mod_descripcion; ?></a></li>

                          <?php
                        }
                      }
                        ?>
                  </ul>
                </li>
                <?php
                }
            }
          ?>
        </ul>
      </div>
    </div>
    <!-- /sidebar menu -->
  </div>
</div>

<!-- top navigation -->
<div class="top_nav" >
  <div class="nav_menu" >
    <nav>
      <div class="nav toggle">
        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
      </div>

      <ul class="nav navbar-nav navbar-right">
        <li class="">
          <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <img src="<?php echo base_url(); ?>librerias/production/images/img.jpg" alt=""><?php echo $nombres; ?>
            <span class=" fa fa-angle-down"></span>
          </a>
          <ul class="dropdown-menu dropdown-usermenu pull-right">
            <li><a href="javascript:;"> Perfil</a></li>
            <li><a href="<?php echo base_url().'Login/Logout' ?>"><i class="fa fa-sign-out pull-right"></i>Salir</a></li>
          </ul>
        </li>

        <li role="presentation" class="dropdown">
          <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
            <i class="fa fa-envelope-o"></i>
            <span class="badge bg-green">6</span>
          </a>
          <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
            <li>
              <a>
                <span class="image"><img src="<?php echo base_url(); ?>librerias/production/images/img.jpg" alt="Profile Image" /></span>
                <span>
                  <span>John Smith</span>
                  <span class="time">3 mins ago</span>
                </span>
                <span class="message">
                  Comentario
                </span>
              </a>
            </li>
            <li>
              <div class="text-center">
                <a>
                  <strong>Vea todas las alertas</strong>
                  <i class="fa fa-angle-right"></i>
                </a>
              </div>
            </li>
          </ul>
        </li>
      </ul>
    </nav>
  </div>
</div>
<!-- /top navigation -->