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
		// $this->load->model('beneficiario/MEstado');
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
		// echo "<pre>";
		// print_r($estado);
		// foreach ($estado as $k => $v) {
		//  if ($v->codigo == "VE-X" ){
		// 	 foreach ($v->ciudad as $key => $value) {
		// 	 	echo $value->nombre . "<br>";
		// 	 }
		//  }
		// }
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
		// if($token != ""){
		//
		// 	$arr['token'] = $token;
		// 	$api = $this->MCurl->Cargar_API($arr);
		// 	$data['rs'] = $api['obj'];
		// 	if ($data['rs']->tipo == 1 ){
		$this->MBeneficiario->obtenerID($cedula, $fecha);
		echo json_encode($this->MBeneficiario);
		// 	}else {
		// 		// header('Location: http://192.168.6.45/SSSIFANB/' );
		// 		echo "No posee Acceso";
		// 	}
		// }else{
		// 	echo "No posee Acceso";
		// }



		//print_r( $Militar->Pension->DatoFinanciero);
		// print_r($this->MBeneficiario);
		// $this->load->model('beneficiario/MOrdenPago'); //MedidaJudicial
		// $this->MBeneficiario->HistorialOrdenPagos = $this->MOrdenPago->listarPorCedula($cedula);
		//$this->MBeneficiario->HistorialDetalleMovimiento = $this->MHistorialMovimiento->listarDetalle($cedula);

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
		$this->load->model('kernel/KSensor');
		$fecha = date('d/m/Y H:i:s');
		$firma = md5($fecha);

		$this->load->model('kernel/KCargador');
		$data['id'] = 69; //Directiva


 		$this->KCargador->IniciarLote($data, $firma, "SSSIFANB");

	}
	public function GenerarCalculoAporteCapitalEstudiar(){
		//ini_set('memory_limit', '1024M');
		echo "<pre>";
		$this->load->model('kernel/KSensor');
		$fecha = date('d/m/Y H:i:s');
		$firma = md5($fecha); //PID

		$this->load->model('kernel/KCargador');
 		$this->KCargador->IniciarLoteEstudiar(48, '2017-03-01', $firma, $_SESSION['usuario'], 100);
 		//$mnt = $this->KCargador->Resultado['l'] - 1;
	}

	public function ConsultarGrupos(){
		header('Content-Type: application/json');
		$this->load->model('kernel/KSensor');
		$fecha = date('d/m/Y H:i:s');
		$firma = md5($fecha);

		$this->load->model('kernel/KCargador');

		$json = json_decode($_POST['data']);
 		$lst = $this->KCargador->ConsultarGrupos($json);

 		echo json_encode($lst);

	}



	function LoteGarantiaDiasAdicionales($archivo = ''){
		header('Content-Type: application/json');
		$data = json_decode($_POST['data']);
		if($archivo == '' || $data->tipo < 0 || $data->tipo > 3){
			echo 'Está intentando acceder a un área restringida.';
		}else{
			$this->load->model("kernel/KCargador");
			$respuesta = $this->KCargador->GarantiasDiasAdicionales($archivo, $data->tipo, $data->porc);
			echo json_encode($this->KCargador->Resultado);
		}

	}

	public function crearMedidaJudicial($id = ''){

		$this->load->model('beneficiario/MMedidaJudicial');


		$data = json_decode($_POST['data']);
		$this->MMedidaJudicial->cedula = $data->MedidaJudicial->cedula;
		$this->MMedidaJudicial->estatus = '220';
		$this->MMedidaJudicial->numero_oficio = $data->MedidaJudicial->numero_oficio;
		$this->MMedidaJudicial->numero_expediente = $data->MedidaJudicial->numero_expediente;

		$this->MMedidaJudicial->tipo = $data->MedidaJudicial->tipo;
		$this->MMedidaJudicial->fecha = $data->MedidaJudicial->fecha;
		$this->MMedidaJudicial->observacion =  $data->MedidaJudicial->observacion;


		$this->MMedidaJudicial->porcentaje = $data->MedidaJudicial->porcentaje;
		$this->MMedidaJudicial->salario = $data->MedidaJudicial->salario;
		$this->MMedidaJudicial->mensualidades = $data->MedidaJudicial->mensualidades;
		$this->MMedidaJudicial->unidad_tributaria = $data->MedidaJudicial->ut;
		$this->MMedidaJudicial->monto = $data->MedidaJudicial->monto;

		$this->MMedidaJudicial->forma_pago = $data->MedidaJudicial->forma_pago;
		$this->MMedidaJudicial->institucion = $data->MedidaJudicial->institucion;
		$this->MMedidaJudicial->nombre_autoridad = $data->MedidaJudicial->autoridad;
		$this->MMedidaJudicial->tipodecuenta = $data->MedidaJudicial->tipodecuenta;
		$this->MMedidaJudicial->numerocuenta = $data->MedidaJudicial->numerocuenta;
		$this->MMedidaJudicial->cargo = $data->MedidaJudicial->cargo;


		$this->MMedidaJudicial->estado = $data->MedidaJudicial->estado;
		$this->MMedidaJudicial->ciudad = $data->MedidaJudicial->ciudad;
		$this->MMedidaJudicial->municipio = $data->MedidaJudicial->municipio;
		$this->MMedidaJudicial->descripcion_institucion = $data->MedidaJudicial->descripcion_institucion;

		$this->MMedidaJudicial->nombre_beneficiario = $data->MedidaJudicial->nombre_beneficiario;
		$this->MMedidaJudicial->cedula_beneficiario = $data->MedidaJudicial->cedula_beneficiario;
		$this->MMedidaJudicial->parentesco = $data->MedidaJudicial->parentesco;

		$this->MMedidaJudicial->cedula_autorizado = $data->MedidaJudicial->cedula_autorizado;
		$this->MMedidaJudicial->nombre_autorizado = $data->MedidaJudicial->nombre_autorizado;

		$this->MMedidaJudicial->fecha_creacion =  date("Y-m-d H:i:s");
		//$this->MMedidaJudicial->usuario_creacion = $_SESSION['usuario'];
		$this->MMedidaJudicial->fecha_modificacion =  date("Y-m-d H:i:s");
		//$this->MMedidaJudicial->usuario_modificacion = $_SESSION['usuario'];
		$this->MMedidaJudicial->ultima_observacion = '';

		if($id == ''){
			$this->MMedidaJudicial->salvar();
		}else{
			$this->MMedidaJudicial->id = $id;
			$this->MMedidaJudicial->actualizar();
		}
		//print_r($this->MMedidaJudicial);
		echo "Se registro nueva Medida Judicial en estatus de activo";
	}

  ///Para permitir consultar la medida 22112017
	function ConsultarMedidaEjecutada(){
		header('Content-Type: application/json');
		$this->load->model("beneficiario/MMedidaJudicial");
		echo json_encode($this->MMedidaJudicial->listarTodo($_POST['ced'], $_POST['id']));
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
