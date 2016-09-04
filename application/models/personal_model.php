<?php
	class Personal_model extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		function MostrarPersonal(){
			$query=$this->db->query("select p.idpersonal,p.nombres,p.apellidos,p.usuario,pe.descripcion from personal as p inner join  perfil as pe on (p.idperfil=pe.idperfil) where p.estado='1'");
			return $query->result();
		}
		function MostrarTipo(){
			$consul=$this->db->get_where('perfil',  array('estado' => '1' ));
			return $consul->result();
		}

		function insertar($id,$nombre,$apellidos,$usuario,$clave,$tipo_personal){
			$data = array(
				'nombres' => $nombre,
				'apellidos' => $apellidos,
				'usuario' => $usuario,
				'clave' => $clave,
				'idperfil' => $tipo_personal
				);
			if($id==""){
				$inserta=$this->db->insert('personal', $data);
				if($inserta==1){
					return 'I';
				}else{
					return 'EI';
				}
			}else{
				$this->db->where('idpersonal',$id);
				$modifica=$this->db->update('personal', $data);
				if($modifica==1){
					return 'M';
				}else{
					return 'NM';
				}
			}
			
		}

		function ver($id){
			$consulta=$this->db->get_where('personal', array('idpersonal' => $id ));
			return $consulta->result();
		}

		function elimina($id){
			$this->db->where('idpersonal',$id);
			$elimina=$this->db->update('personal', array('estado' => '0'));
			if($elimina==1){
				return 'E';
			}else{
				return 'EI';
			}
		}

		function MostrarInactivos(){
			$query=$this->db->query("select p.idpersonal,p.nombres,p.apellidos,p.usuario,pe.descripcion from personal as p inner join  perfil as pe on (p.idperfil=pe.idperfil) where p.estado='0'");
			return $query->result();
		}

		function activar($id){
			$this->db->where('idpersonal',$id);
			$consulta=$this->db->update('personal', array('estado' => 1));
			if($consulta==1){
				return 'A';
			}else{
				return 'EA';
			}
		}
	}

?>