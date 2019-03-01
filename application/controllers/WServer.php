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
        $this->KCargador->_MapWNomina = $this->post();
        $this->KCargador->IniciarLote($data, $firma, "SSSIFANB");
        $segmentoincial = '';
        
        
        $this->response($segmentoincial);

    }

}
	
