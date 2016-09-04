<?php
	class Login_model extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		function comprobar($usuario,$clave){
			$consulta=$this->db->get_where('personal', array('per_usuario' => $usuario,
															'per_clave' => $clave,
															'per_estado' => 1));
			return $consulta->result();
		}

	}
?>