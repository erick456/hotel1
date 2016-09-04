<?php
	class Perfil_model extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		function MostrarPerfil(){
			$consulta=$this->db->get_where('perfil', array('estado' => '1') );
			return $consulta->result();
		}

		function insertar($id,$descripcion){
			$data = array('descripcion' => $descripcion	,
			);

			if($id==""){
				$estado=$this->db->insert('perfil',$data);
				if($estado==1){
					return 'I';
				}else{
					return 'EI';
				}
			}else{
				$this->db->where('idperfil',$id);
				$estado=$this->db->update('perfil',$data);
				if($estado==1){
					return 'M';
				}else{
					return 'EM';
				}
			}
		}

		function TraerDatos($cod){
			$query=$this->db->get_where('perfil',  array('idperfil' => $cod));
			return $query->result();
		}

		function Eliminar($cod){
			$this->db->where('idperfil',$cod);
			$eliminar=$this->db->update('perfil', array('estado' => '0' ));
			if($eliminar==1){
				return 'E';
			}else{
				return 'EE';
			}
		}

		function VerEliminados(){
			$ver=$this->db->get_where('perfil', array('estado' => '0' ));
			return $ver->result();
		}

		function activar($id){
			$this->db->where('idperfil', $id);
			$consulta=$this->db->update('perfil', array('estado' => '1' ));
			if($consulta==1){
				return 'A';
			}else{
				return 'EA';
			}
		}

	}
?>