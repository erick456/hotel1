<?php
if( ! defined('BASEPATH'))  exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->database('default');
		$this->load->model('login_model');
	}
	public function index()
	{
		$this->load->view('Login/index.php');


	}

	public function sistema(){

		if(isset($_SESSION["idpersonal"])){
			$this->load->view('Login/sistema.php');
		}
		else{
			redirect("Login", "refresh");
		}
	}

	public function login(){
		$usuario=$this->input->post("usuario");
		$clave=$this->input->post("clave");
		$query=$this->login_model->comprobar($usuario,$clave);

		$data["personal"]=$query;

		if(count($query)>0){
			$_SESSION["idpersonal"]=$data["personal"][0]->per_id;
			$_SESSION["personal_id"]=$data["personal"][0]->per_id;

			echo "1";
		}else{
			echo "0";
		}
	}

	public function Logout(){
		session_destroy();
		redirect("Login","refresh");
	}
}
