<?php
	class Ventas_model extends CI_Model{
		function __construct(){
			parent::__construct();
		}

		function VerVentas(){
			$query=$this->db->query("select v.idventas,tt.idtipotransaccion,tt.descripcion,per.idpersonal,per.nombres as per_nombres,per.apellidos as per_apellidos,m.idmesa,m.mesa,v.fecha_venta,c.idcliente,c.nombres as nombres, c.apellidos as apellidos,v.total
				from ventas as v inner join tipo_transaccion as tt on (v.idtipotransaccion=tt.idtipotransaccion)  
				inner join personal as per on (v.idpersonal=per.idpersonal)
				inner join mesa as m on (v.idmesa=m.idmesa)
				inner join cliente as c on(v.idcliente=c.idcliente) ");
			return $query->result();
		}

		function VerClientes(){
			$consulta=$this->db->query("select idcliente,nombres,apellidos from cliente where estado='1'");
			return $consulta->result();
		}
		function TraerProducto(){
			$producto=$this->db->query("select p.idproducto,p.descripcion 
				from producto_unidad as pu inner join producto as p on(pu.idproducto = p.idproducto) group by p.idproducto ");
			return $producto->result();
		}

		function Unidades($id){
			$cons=$this->db->query('select u.idunidad as idunidad,u.descripcion as descripcion 
			from producto_unidad as pu inner join unidad_medida as u on (pu.idunidad=u.idunidad) 
			inner join producto as p on(pu.idproducto=p.idproducto)
			where  pu.idproducto= '.$id);
			return $cons->result();
		}

		function GuardarVentas(){
			$data = array('idpersonal' => $_SESSION["idpersonal"],
						 'idmesa' => $_POST["mesa"],
						 'idcliente' => $_POST["idcliente"],
						 'fecha_venta' => date("d-m-Y H:i:s"),
						 'idtipotransaccion' => $_POST["tipo_transaccion"],
						 'total' => $_POST["total_venta"]
						 );

			$insertar_venta = $this->db->insert('ventas', $data);
						
			$idventa = $this->db->insert_id();

			if($insertar_venta==1){
				foreach ($_POST["producto_lista"] as $key => $value) {
					$data_d = array('idventas' => $idventa,
									'idproducto' => $_POST["producto_lista"][$key],
									'idunidad' => $_POST["unidad_lista"][$key],
									'cantidad' => $_POST["cantidad_lista"][$key],
									'precio' => $_POST["precio_lista"][$key],
									'subtotal' => $_POST["subtotal_lista"][$key],
									'igv' => $_POST["igv_lista"][$key]);

					$this->db->insert('detalle_venta', $data_d);
				}
				
			}

			if( $_POST["tipo_transaccion"] == 2){
				
				$data_con = array('idventas' => $idventa,
								 'cuota' => 1,
								 'fecha_cuota' => date('Y-m-d'),
								 'monto' => $_POST["total_venta"],
								 'monto_pagado' => 0.00 ,
								 'monto_restante' => $_POST["total_venta"] );

				$cuota = $this->db->insert('cuota_venta', $data_con);
				

			}else{
				foreach ($_POST["idcouta"] as $key => $value) {
					$data_cre = array(
                        'idventas' => $idventa,
                        'cuota' => $_POST['idcouta'][$key],
                        'fecha_cuota' => $_POST['fecha_pago'][$key],
                        'monto' => $_POST['monto_cuota'][$key],
                        'monto_restante' => $_POST['monto_cuota'][$key],
                        'monto_pagado' => 0.00 );
					$cuota = $this->db->insert('cuota_venta', $data_cre);
				}
			}
			if($cuota == 1){
				return 1;
			}else{
				return 0;
			}
			

	}
}
?>