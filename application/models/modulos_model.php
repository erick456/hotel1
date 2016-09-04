<?php
	class Modulos_model extends CI_Model{
		function __construct(){
			parent::__construct();
		}
		function MostrarModulos(){
			$modulos=$this->db->query("select mo.mod_id as id,mo.mod_descripcion as descripcion,mo.mod_url as url,mo.mod_icono as icono, m.mod_descripcion as padre
				from modulos as m inner join modulos as mo on(m.mod_id = mo.mod_padre) 
				where mo.mod_estado = 1 and m.mod_estado = 1");
			return $modulos->result();
		}

		function MostrarPrincipal(){
			$padre=$this->db->query("select mod_id , mod_descripcion from modulos where mod_estado = 1 and mod_padre = 1");
			return $padre->result();
		}

		function insertPrincipal($id,$descripcion,$icono){
			$data=array('mod_descripcion' => $descripcion,
				'mod_url' => $descripcion,
				'mod_icono' => $icono,
				'mod_padre' => 1 );

			if($id==""){
				$insert=$this->db->insert('modulos', $data);

				if($insert==1){
					return 'IP|'.$this->db->insert_id();
				}else{
					return 'EIP|'.$this->db->insert_id();
				}
			}
		}

		function InsertarModulos($id,$modulo,$descripc){
			$datas= array('mod_descripcion' => $descripc ,
					'mod_url' => $descripc ,
					'mod_padre' => $modulo);
			if($id==""){
				$insertar=$this->db->insert('modulos', $datas);
				if($insertar==1){
					return 'IM';
				}else{
					return 'EIM';
				}
			}else{
				$this->db->where('idmodulos', $id);
				$modifica=$this->db->update('modulos', $datas);
				if($modifica==1){
					return 'MM';
				}else{
					return 'EM';
				}
			}
		}

		function traer($id){
			$consulta=$this->db->get_where('modulos', array('mod_id' => $id));
			return $consulta->result();
		}

		/*function EliminarMo($id){
			$this->db->where('idmodulos', $id);
			$eliminando=$this->db->update('modulos', array('estado' => '0'));
			if($eliminando==1){
				return 'Elinimado';
			}else{
				return 'No';
			}
		}

		function MostarInactivos(){
			$inactivos=$this->db->query("select mo.idmodulos as idmodulos,mo.descripcion as descripcion,mo.url as url,mo.icono as icono,m.descripcion as idpadre from modulos as m inner join modulos as mo on (m.idmodulos=mo.idpadre) where mo.estado='0'");
			return $inactivos->result();
		}

		function ActivarEli($id){
			$this->db->where('idmodulos', $id);
			$activar=$this->db->update('modulos', array('estado' => '1'));
			if($activar==1){
				return 'A';
			}else{
				return 'EA';
			}
		}*/

	}
?>