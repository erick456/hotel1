<?php
if( ! defined('BASEPATH'))  exit('No direct script access allowed');

class Modulos extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->database('default');
		$this->load->model('modulos_model');
	}

	public function index(){
		$modulos=$this->modulos_model->MostrarModulos();
		$idpadre=$this->modulos_model->MostrarPrincipal();
		//$inactivos=$this->modulos_model->MostarInactivos();
		$this->load->view("Modulos/index.php",compact("modulos","idpadre","inactivos"));
	}

	public function AgregaPrincipal(){
		$id=$this->input->post("id");
		$descrip=$this->input->post("descripcion");
		$descripcion=ucwords($descrip);
		$icono=$this->input->post("icono");

		$insertPrin=$this->modulos_model->insertPrincipal($id,$descripcion,$icono);
		$dato = explode("|",$insertPrin);
		$data["code"] = $dato[0];
		$data["id"] = $dato[1];
		$idpadre=$this->modulos_model->MostrarPrincipal();
		$html = "<option>Seleccione</option>";
		foreach ($idpadre as $key => $value) {
			$html .= '<option value="'.$value->mod_id.'">'.$value->mod_descripcion.'</option>';
		}
		$data["html"] = $html;

		echo json_encode($data);

	}

	public function guardar(){
		$id=$this->input->post("id");
		$modulo=$this->input->post("modulo");
		$descri=$this->input->post("descrip");
		$descripc=ucwords($descri);

		$inserta=$this->modulos_model->InsertarModulos($id,$modulo,$descripc);
		echo $inserta;
	}

	public function VerEditar(){
		$mostar=$this->modulos_model->traer($this->input->post("id"));
		echo json_encode($mostar);
	}

	/*public function eliminar(){
		$eliminar=$this->modulos_model->EliminarMo($this->input->post("id"));
		echo $eliminar;
	}

	public function activar(){
		$activando=$this->modulos_model->ActivarEli($this->input->post("id"));
		echo $activando;
	}*/

}
?>