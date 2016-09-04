<?php

  $this->load->database('default');

  $query = $this->db->get_where('personal', array('per_id' => $_SESSION["idpersonal"]));
  $data["logueado"] = $query->result();

  $idperfil = $data["logueado"][0]->per_id;
  $nombres = $data["logueado"][0]->per_nombres;
  $apellidos = $data["logueado"][0]->per_apellidos;
  $apodo = $data["logueado"][0]->per_usuario;


  $entrar = $this->db->get_where('permisos', array('per_perfil' => $idperfil));

  $data["permisos_usuario"] = $entrar->result();

  

?>