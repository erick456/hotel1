<?php
if( ! defined('BASEPATH'))  exit('No direct script access allowed');

class Personal extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->database('default');
		$this->load->model('personal_model');
	}

	public function index(){
		$personal=$this->personal_model->MostrarPersonal();
		$tipo=$this->personal_model->MostrarTipo();
		$inactivos=$this->personal_model->MostrarInactivos();
		$this->load->view("Personal/index.php",compact("personal","tipo","inactivos"));
	}

	public function guardar(){

		$id=$this->input->post("id");
		$nombre=$this->input->post("nombres");
		$apellidos=$this->input->post("apellidos");
		$usuario=$this->input->post("usuario");
		$clave=$this->input->post("clave");
		$tipo_personal=$this->input->post("tipo_personal");

		$resultado=$this->personal_model->insertar($id,$nombre,$apellidos,$usuario,$clave,$tipo_personal);
		echo $resultado;
	}

	public function VerEditar(){
		$id=$this->input->post("id");
		$editar= $this->personal_model->Ver($id);
		echo json_encode($editar);
	}

	public function eliminar(){
		$id=$this->input->post("id");
		$eliminar=$this->personal_model->elimina($id);
		echo $eliminar;
	}


	public function activar(){
		$id=$this->input->post("id");
		$activar=$this->personal_model->activar($id);
		echo $activar;
	}

}