<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set ( 'America/Caracas' );
define ('__CONTROLADOR', 'panel');
class Test extends MY_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');		
	}

	public function index(){
		echo 'Test de Carga';
	}



	public function consultarBeneficiario($cedula = '', $fecha = ''){		
		$this->load->model('beneficiario/MBeneficiario');
		$this->MBeneficiario->obtenerID($cedula, $fecha);
		echo json_encode($this->MBeneficiario);
	}
	public function consultarHistorialBeneficiario($id = ''){		
		$this->load->model('beneficiario/MBeneficiario');
		$lst = $this->MBeneficiario->consultarHistorial($id);
		echo json_encode($lst);
	}

	public function consultarBeneficiarios($cedula = '', $fecha = ''){		
		$this->load->model('beneficiario/MBeneficiario');
		$this->load->model('beneficiario/MHistorialMovimiento');

		$this->MBeneficiario->obtenerID($cedula, $fecha);
		

		$this->MBeneficiario->HistorialDetalleMovimiento = $this->MHistorialMovimiento->listarDetalle($cedula);
		

		echo "<pre>";
		print_r($this->MBeneficiario);
		//echo json_encode($this->MBeneficiario);
	}

	/*function saman_prueba(){
		$this->load->model('comun/DbSaman');
		$rs=$this->DbSaman->consultar("select * from personas limit 1");
		print_r($rs);
	}*/

	function xorC(){
		echo "<pre>";
		$this->load->model('comun/DbSaman');
		$s = 'SELECT * FROM personas WHERE codnip=\'10007781\'';
		print_r($this->DbSaman->consultar($s));

	}
	
	function init(){
		phpinfo();
	}

}
