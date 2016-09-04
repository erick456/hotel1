<?php
if( ! defined('BASEPATH'))  exit('No direct script access allowed');

class Ventas extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->database('default');
		$this->load->model('ventas_model');
	}

	public function index(){
		$ventas=$this->ventas_model->VerVentas();
		$this->load->view("Ventas/index.php",compact("ventas"));
	}

	public function nuevo(){
		$verclientes=$this->ventas_model->VerClientes();
		$mesas=$this->db->get_where('mesa', array('estado'=> '1'))->result();
		$tipo_transaccion = $this->db->get_where('tipo_transaccion', array('estado' => '1')) ->result();
		$verproducto=$this->ventas_model->TraerProducto();
		$this->load->view("Ventas/nuevo.php",compact("verclientes","mesas","tipo_transaccion","verproducto"));
	}

	public function MostraUnidades($id){
		$unidades=$this->ventas_model->Unidades($id);
		echo json_encode($unidades);
	}

	public function TraerPrecio(){
		$idunidad=$this->input->post("idunidad");
		$idproducto = $this->input->post("idproducto");
		$consulta = $this->db->get_where('producto_unidad',array('idunidad'=>$idunidad,						'idproducto' => $idproducto, 'estado' => '1' )) -> result();
		echo json_encode($consulta);
	}

	public function guardar_venta(){
		$venta=$this->ventas_model->GuardarVentas();
		echo $venta;
	}

	public function historial(){
		$idcliente = $this->input->post("idcliente");
		$fecha_actual = date('Y-m-d');

		$fecha_cliente = $this->db->query('select MIN(fecha_venta) as fecha_minima,MAX(fecha_venta) as fecha_maxima from ventas as v 
		inner join cliente as c on (v.idcliente = c.idcliente) where c.idcliente ='.$idcliente)->result();

		$fecha_ingreso =  $fecha_cliente[0]->fecha_minima;
		$fecha_fin = $fecha_cliente[0]->fecha_maxima;

		$fecha_inicio = new DateTime($fecha_ingreso);
		$fecha_fin = new DateTime($fecha_fin);
		$intervalo = $fecha_inicio->diff($fecha_fin);
		$num_semanas = floor(($intervalo->format('%a')) / 7);
		$dias_restantes = ($intervalo->format('%a') % 7);

		$var = ($intervalo->format('%a'));


		echo json_encode($dias_restantes);
	}

}