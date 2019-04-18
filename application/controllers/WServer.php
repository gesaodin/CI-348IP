<?php


// This can be removed if you use __autoload() in config.php OR use Modular Extensions
/** @noinspection PhpIncludeInspection */
require APPPATH . '/libraries/REST_Controller.php';
// use namespace
use Restserver\Libraries\REST_Controller;
/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */

 date_default_timezone_set ( 'America/Caracas' );
class WServer extends REST_Controller{
    
    public function __construct(){
        parent::__construct();
        $this->load->helper('url'); 
        
    }

    public function index_get($id){
        $this->load->model("fisico/MBeneficiario");
        $this->MBeneficiario->obtenerID($id);
        $ano = explode('-', $this->MBeneficiario->fecha_ingreso);

        if($ano[0] < 2010) {
            $p = $this->CasoMenor2010($this->MBeneficiario->tiempo_servicio);
        }else{
            $p = $this->Casos($this->MBeneficiario->tiempo_servicio);
        }
        $rs = (array)$this->MBeneficiario;
        $this->response($rs);
        
    }

    public function AccessForbiden(){
        $this->response(['acceso no permitido'],404);
    }

    public function Casos($t){
        $v = 0;
        switch ($t) {
            case 15:
                $v = 50;
                break;
            case 16:
                $v = 52;
                break;
            case 17:
                $v = 54;
                break;
            case 18:
                $v = 56;
                break;
            case 19:
                $v = 59;
                break;
            case 20:
                $v = 62;
                break;
            case 21:
                $v = 65;
                break;
            case 22:
                $v = 68;
                break;
            case 23:
                $v = 72;
                break;
            case 24:
                $v = 76;
                break;
            case 25:
                $v = 80;
                break;
            case 26:
                $v = 84;
                break;
            case 27:
                $v = 89;
                break;
            case 28:
                $v = 94;
                break;
            case 29:
                $v = 99;
                break;
            case 30:
                $v = 100;
                break;
            default:
                if ($t>30) $v = 100;
                # code...
                break;
        }

        return $v;

            
    }

    public function CasoMenor2010($t){
        $v = 0;
        switch ($t) {
            case 15:
                $v = 60;
                break;
            case 16:
                $v = 63;
                break;
            case 17:
                $v = 66;
                break;
            case 18:
                $v = 69;
                break;
            case 19:
                $v = 72;
                break;
            case 20:
                $v = 75;
                break;
            case 21:
                $v = 80;
                break;
            case 22:
                $v = 84;
                break;
            case 23:
                $v = 88;
                break;
            case 24:
                $v = 92;
                break;
            case 25:
                $v = 99;
                break;
            
            default:
                if ($t>25) $v = 100;
                # code...
                break;
        }

        return $v;
    }

    public function book_get($id,$o){
        $this->response([
			'returned from delete:' => $o,
		]);
    }

    public function index_options($id){
        $this->load->model("fisico/MBeneficiario");
        $this->MBeneficiario->obtenerID($id);
        $ano = explode('-', $this->MBeneficiario->fecha_ingreso);

        if($ano[0] < 2010) {
            $p = $this->CasoMenor2010($this->MBeneficiario->tiempo_servicio);
        }else{
            $p = $this->Casos($this->MBeneficiario->tiempo_servicio);
        }
        $rs = (array)$this->MBeneficiario;
        $this->response($rs);       
    }

    public function index_put($id){
        $this->load->model("fisico/MBeneficiario");
        $this->MBeneficiario->obtenerID($id);
        $ano = explode('-', $this->MBeneficiario->fecha_ingreso);

        if($ano[0] < 2010) {
            $p = $this->CasoMenor2010($this->MBeneficiario->tiempo_servicio);
        }else{
            $p = $this->Casos($this->MBeneficiario->tiempo_servicio);
        }
        $rs = (array)$this->MBeneficiario;
        $this->response($rs);       
    }

	public function directiva_get(){
		$this->load->model('kernel/KDirectiva');
		$this->load->model('beneficiario/MComponente');
		$rs = $this->KDirectiva->listarTodo();
		$this->response($rs);
    }
    
    public function dtdirectiva_get($id){
        $this->load->model('kernel/KDirectiva');
		$Directivas = $this->KDirectiva->Cargar($id);
		$this->response($Directivas);
    }
        
    public function gnomina_post(){
        $this->load->model('kernel/KSensor');
        $fecha = date('d/m/Y H:i:s');
        $firma = md5($fecha);
        $this->load->model('kernel/KCargador');
        $data['id'] = $this->post("id"); //Directiva
        $data['fecha'] = $this->post("fechainicio");

        $this->KCargador->_MapWNomina = $this->post();

        //print_r($this->KCargador->_MapWNomina);
        $this->KCargador->IniciarLote($data, $firma, "SSSIFANB");
        $neto = round( $this->KCargador->Neto, 2 );
        $asig = round( $this->KCargador->Asignacion, 2 );
        $dedu = round( $this->KCargador->Deduccion, 2 );

        $segmento = array(
            'neto' => number_format($neto, 2, ',','.'),
            'asignacion' => number_format($asig, 2, ',','.'),
            'deduccion' => number_format($dedu, 2, ',','.'),
            'registros' => $this->KCargador->Cantidad,
            'md5' => $firma,
            'paralizados' => 0,
            'desde' => $this->post("fechainicio"),
            'hasta' => $this->post("fechafin"),
            'archivo' => 'tmp/' . $firma . '.csv',
            'oid' => $this->KCargador->OidNomina,
            'tipo' => $this->post("tipo"),
            'nombre' => $this->post("nombre"),
            'url' => base_url(),           
            'resumen' => $this->KCargador->ResumenPresupuestario
        );        
        $this->response($segmento);
    }
    
	function ldirectiva_get($id){
        $this->load->model("beneficiario/MDirectiva");
        $dt = $this->MDirectiva->listarTodo($id);    
		$this->response($dt);
	}
	
	function clonardirectiva_post(){	
		$this->load->model("beneficiario/MDirectiva");
        $data = $this->post();
        
        $result = $this->MDirectiva->crearDirectiva($data);
        $segmento = array(
            'msj' => "Creación de directivas lista",
            'ok' => "200 OK",
            'rs' => $result
        );
        $this->response($segmento);
	}

	function eliminardirectiva_get($id){
		$this->load->model("beneficiario/MDirectiva");
		$data = $this->post();
        $this->MDirectiva->Eliminar($id);
        $segmento = array(
            'msj' => "Eliminación exitosa",
            'ok' => "200 OK"
        );
        $this->response($segmento);
    }
    
    function actualizarprima_post(){	
		$this->load->model("beneficiario/MPrima");
        $data = $this->post();
        $result = $this->MPrima->ActualizarPrima($data);
        $segmento = array(
            'msj' => "Actualizando prima",
            'ok' => "200 OK",
            'rs' => $result
        );
        $this->response($segmento);
	}

    function actualizardirectiva_post(){	
		$this->load->model("beneficiario/MDirectiva");
        $data = $this->post();
        $result = $this->MDirectiva->ActualizarDetalle($data);
        $segmento = array(
            'msj' => "Actualizando prima",
            'ok' => "200 OK",
            'rs' => $result
        );
        $this->response($segmento);
	}

    function ccpensionados_get(){
        $this->load->model('kernel/KNomina');
		$Contar = $this->KNomina->Contar();
		$this->response($Contar);
    }

    function listartpendientes_get($id){
        $this->load->model('kernel/KNomina');
		$lst = $this->KNomina->Listar($id);
		$this->response($lst);
    }
    function listarpagos_get(){
        $this->load->model('kernel/KNomina');
		$lst = $this->KNomina->ListarPagos();
		$this->response($lst);
    }
    function cuadrebanco_get($id){
        $this->load->model('kernel/KNomina');
		$lst = $this->KNomina->ListarCuadreBanco($id);
		$this->response($lst);
    }


    function nominacerrar_get($nomina, $estatus){
        $this->load->model('kernel/KNomina');
        $this->KNomina->ID = $nomina;
        $this->KNomina->Estatus = $estatus;
		$lst = $this->KNomina->Procesar( );
		$this->response($lst);
    }

    function nominaprocesar_post(){
        $resp = array();
        $this->load->model('kernel/KNomina');
        $this->load->model('kernel/KCargador');
        $fecha = date('d/m/Y H:i:s');
        $llave = md5($fecha);
        $arr = $this->post();        
        foreach ($arr as $c => $v) {
            $oid = $v["id"];
            $esta = $v["estatus"];
            $nomb = $v["nombre"];
            $this->KNomina->ID = $v["id"];
            $this->KNomina->Estatus = $v["estatus"];
            $this->KNomina->Procesar( );            
            $resp[] = $this->KCargador->CrearInsertPostgresql( $nomb, $oid, $esta, $llave );
        }
        $this->response($resp);
    }
    
    function verpartida_get($id) {
        $this->load->model('kernel/KNomina');
        $this->KNomina->ID = $id;
        $this->response($this->KNomina->VerDetalles());
    }

}
	
