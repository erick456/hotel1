<?php
if( ! defined('BASEPATH'))  exit('No direct script access allowed');

class Permisos extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->database('default');
		$this->load->model('permisos_model');
	}
	public function index()
	{
		$data["perfiles"] = $this->db->get_where("perfil",array("estado"=>"1"))->result();
		$padres = $this->db->get_where("modulos",array("idpadre"=>"1","estado"=>"1"))->result_array();

		foreach ($padres as $key => $value) {
			$padres[$key]["hijos"] = $this->db->get_where("modulos", array("idpadre"=>$value["idmodulos"],"estado"=>"1"))->result_array();
		}

		$data["modulos"] = $padres;
		$this->load->view('Permisos/index.php',$data);
	}

	public function traerPermisos() {
		$permisos = $this->db->get_where("permisos",array("idperfil"=>$_POST["idperfil"]))->result();

		if(count($permisos)>0) {
			$data["ok"] = "yes";
			$data["permisos"] = $permisos;
		} else {
			$data["ok"] = "nothing";
		}
		echo json_encode($data);
	}

	public function guardar() {

		$perfil= $this->input->post("perfil");
		$modulo=$this->input->post("permisos");
		$this->db->where('idperfil', $perfil);
		$this->db->delete('permisos');

		for ($i=0; $i < count($modulo) ; $i++) {

			$modulo_principal= $this->db->get_where('modulos', array('idmodulos'=>$modulo[$i]));
			$data["idmodulos"] = $modulo_principal->result();
			$idpadre_principal = $data["idmodulos"][0]->idpadre;
			if(count($modulo_principal) > 0){
				$consulta_permisos = $this->db->get_where('permisos', array('idperfil' => $perfil , 'idmodulos' => $idpadre_principal ))->result();
				if(count($consulta_permisos) == 0){
					$data_padre = array('idperfil' => $perfil,
						  		  'idmodulos' => $idpadre_principal);
					$this->db->insert('permisos', $data_padre);
				}
				
			}
			$data = array('idperfil' => $perfil,
						  'idmodulos' => $modulo[$i]);
			$this->db->insert('permisos', $data);
		}
		echo "inserto";
	}










	public function VerPermisos(){
		$id=$this->input->post("id");
		$modulos = $this->db->get_where("modulos",array("idpadre"=>"1","estado"=>"1"))->result_array();
		$permisos = $this->db->get_where("permisos",array("idperfil"=>$id))->result_array();

		$array= array();
		foreach ($permisos as $key => $value) {
			$array[]=  $value["idmodulos"];
		}


		foreach ($modulos as $key => $value) {
			if (in_array($value["idmodulos"],$array)) {
					$attr= "checked";
				}else{
					$attr="";
				}
			$html = "<div class='col-md-3 col-sm-3 col-xs-3 hijos'>";
			$html .= "<h3><input type='checkbox' name='permisos[]' class='flat' value='".$value["idmodulos"]."' $attr> ".$value["descripcion"]."";
			$html .= "</h3>";

			$padres = $this->db->get_where("modulos", array("idpadre"=>$value["idmodulos"],"estado"=>"1"))->result_array();
			foreach ($padres as $hijos) {
				$html .=" <div class='form-group'>";
				$html .=" <div class='checkbox'>";
				$html .="  <label>";
				if (in_array($hijos["idmodulos"],$array)) {
					$attr= "checked";
				}else{
					$attr="";
				}
				$html .="   <input type='checkbox' name='permisos[]' class='flat' value='".$hijos["idmodulos"]."' $attr> ".$hijos["descripcion"]." ";
				$html .="</label> </div> </div>";
			}
			$html .= "</div>";
			echo $html;
		}


	}

	

}
