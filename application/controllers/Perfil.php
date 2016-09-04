<?php
if( ! defined('BASEPATH'))  exit('No direct script access allowed');

class Perfil extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->database('default');
		$this->load->model('perfil_model');
	}

	public function index(){
		$perfil = $this->perfil_model->MostrarPerfil();
		$eliminados=$this->perfil_model->VerEliminados();
		$this->load->view("Perfil/index.php",compact("perfil","eliminados"));
	}

	public function nuevo(){
		$id=$_POST["id"];
		$descripcion=$_POST["descripcion"];
		$result = $this->perfil_model->insertar($id,$descripcion);
		echo $result;
	}

	public function VerEditar(){
		$editar=$this->perfil_model->TraerDatos($this->input->post("id"));
		echo json_encode($editar);
	}

	public function eliminar(){
		$eliminar=$this->perfil_model->Eliminar($this->input->post("id"));
		echo $eliminar;
	}

	public function activar(){
		$id=$this->input->post("id");
		$resul=$this->perfil_model->activar($id);
		echo $resul;
	}
}