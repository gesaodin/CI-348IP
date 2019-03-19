<?php
defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set ( 'America/Caracas' );
define ('__CONTROLADOR', 'panel');
class Panel extends CI_Controller {


	var $_DIRECTIVA = array();

	/**
	* CONSTRUCTOR DEL PANEL
	*
	*/
	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->model('logico/MCurl');

		//if(!isset($_SESSION['usuario']))$this->salir();
	}


	/**
	* 	----------------------------------
	*	Sección de la GUI
	* 	----------------------------------
	*/
	public function index($token = ""){

		// if ($token != ""){
		// 	$data['token'] = $token;
			// $this->load->view("view_home", $data);
			$this->load->view("view_home");
		// }else{
		// 	header('Location: /SSSIFANB/' );
		// }

	}

	public function beneficiario(){
		$arr['url'] = 'http://192.168.12.150:8080/devel/api/estado';
		$api = $this->MCurl->Cargar_API($arr);
		$data['estado'] = $api['json'];
		$this->load->model('beneficiario/MHistorialMovimiento');
		$data['Movimientos'] = $this->MHistorialMovimiento->listarTodo();

		$this->load->view("menu/beneficiario/beneficiario", $data);
	}
	public function pensiones(){
		$this->load->view("menu/beneficiario/finiquito");
	}
	public function medidajudicial(){
		$this->load->model('beneficiario/MParentesco');
		$this->load->model('beneficiario/MFormaPago');
		$arr['url'] = 'http://192.168.12.150:8080/devel/api/estado';
		$api = $this->MCurl->Cargar_API($arr);
		$estado = $api['obj'];
		$data['Estado'] = $estado; //$this->MEstado->listar();
		$data['Parentesco'] = $this->MParentesco->listar();
		$data['FormaPago'] = $this->MFormaPago->listar();
		$this->load->view("menu/beneficiario/medidajudicial", $data);
	}

	function ObtenerEstados(){
		header('Content-Type: application/json');
		$arr['url'] = 'http://192.168.12.150:8080/devel/api/estado';
		$api = $this->MCurl->Cargar_API($arr);
		echo $api['json'];
	}

	function obtenerCiudades($codigo){
		header('Content-Type: application/json');
		$arr['url'] = 'http://192.168.12.150:8080/devel/api/estado';
		$api = $this->MCurl->Cargar_API($arr);
		$estado = $api['obj'];
		$lst = array();
		// echo "<pre>";
		// print_r($estado);
		foreach ($estado as $k => $v) {
		 if ($v->codigo == $codigo ){
			 foreach ($v->ciudad as $key => $value) {
			 	$lst[] = array("id" => $value->capital, "nombre" => $value->nombre);
			 }
		 }
		}
		echo json_encode($lst);
	}

		function obtenerMunicipios($codigo){
			header('Content-Type: application/json');
			$arr['url'] = 'http://192.168.12.150:8080/devel/api/estado';
			$api = $this->MCurl->Cargar_API($arr);
			$estado = $api['obj'];
			$lst = array();
			// echo "<pre>";
			// print_r($estado);
			foreach ($estado as $k => $v) {
			 if ($v->codigo == $codigo ){
				 foreach ($v->municipio as $key => $value) {
				 	$lst[] = array("id" => $key, "nombre" => $value->nombre);
				 }
			 }
			}
			echo json_encode($lst);
		}
	public function actualizar(){
		$this->load->view("menu/beneficiario/actualizarbeneficiario");
	}

	/**
	*	---------------------------------------------
	*	FIN DE LOS REPORTES GENERALES DEL SISTEMA
	*	---------------------------------------------
	*/

	public function consultarBeneficiario($cedula = '', $fecha = '', $token = ''){
		//header('Content-Type: application/json');
		$this->load->model('beneficiario/MBeneficiario');
		$this->load->model('beneficiario/MHistorialMovimiento');
		$arr['url'] = 'http://192.168.12.150:8080/ipsfa/api/wusuario/validarphp';
		$this->MBeneficiario->obtenerID($cedula, $fecha);
		echo json_encode($this->MBeneficiario);

	}

	public function consultarBeneficiarioJudicial($cedula = '', $fecha = ''){
		$this->load->model('beneficiario/MBeneficiario');
		$this->load->model('beneficiario/MMedidaJudicial');

		$this->MBeneficiario->obtenerID($cedula, $fecha);
		$this->MBeneficiario->MedidaJudicial = $this->MMedidaJudicial->listarTodo($cedula);
		echo json_encode($this->MBeneficiario);
	}




	/**
	 * Generar Indices para procesos de lotes (Activos)
	 *
	 * Creación de tablas para los cruce en el esquema space como
	 * tablacruce permite ser indexada para evaluar la tabla movimiento
	 * tipos de movimiento [3,31,32] dando como resultado del crosstab
	 * cedula | Deposito AA | Deposito Dia Adicionales | Deposito Garantias
	 *
	 * -------------------------------------------------------------------
	 *	INICIANDO PROCESOS APORTE DE CAPITAL
	 * -------------------------------------------------------------------
	 *
	 * @return	void
	 */


	public function GenerarSueldos(){
		//ini_set('memory_limit', '1024M');
		//header('Content-Type: application/json');
		// $this->load->model('kernel/KSensor');
		// $fecha = date('d/m/Y H:i:s');
		// $firma = md5($fecha);

		// $this->load->model('kernel/KCargador');
		// $data['id'] = 69; //Directiva

		$this->load->model('kernel/KSensor');
		$fecha = date('d/m/Y H:i:s');
		$firma = md5($fecha);
		$this->load->model('kernel/KCargador');
        $data['id'] = 69; //Directiva
        $data['fecha'] = '2019-03-03';

        $this->KCargador->_MapWNomina = $this->post();
        $this->KCargador->IniciarLote($data, $firma, "SSSIFANB");
        $segmento = array(
            'total' => number_format($this->KCargador->SSueldoBase, 2, ',','.'),
            'registros' => 3,
            'md5' => $firma,
            'paralizados' => 0,
            'archivo' => 'http://localhost/CI-3.1.10/tmp/' . $firma . '.csv'
		);
		
 		$this->KCargador->IniciarLote($data, $firma, "SSSIFANB");

	}



	public function ConsultarDirectiva(){
		print("<pre>");
		$this->load->model('kernel/KDirectiva');
		$Directivas = $this->KDirectiva->Cargar(69);
		print_r ($Directivas);
	}
	public function salir(){
		redirect('panel/Login/salir');
	}


}
