<?php
/**
 * IpsfaNet
 *
 *
 * @package Login
 * @author Carlos Peña
 * @copyright	Derechos Reservados (c) 2014 - 2015, MamonSoft C.A.
 * @link		http://www.mamonsoft.com.ve
 * @since Version 1.0
 *
 */
date_default_timezone_set ( 'America/Caracas' );
define ('__CONTROLADOR', 'Login');

class Login extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->model('logico/MCurl');
	}

	function index($msj = null) {
		$this->ingresar ();
	}

	/**
	 *Menu
	 */
  function ingresar() {
		// if(isset($_SESSION['usuario'])){
		// 	$this->inicio();
		// }else{
		// 	$this->load->view("login");
		// }
		echo "conectandome";
	}


	protected function inicio($token = ""){
		$this->session->set_userdata(array(
         'usuario' => "",
         'nombre' => "",
         'id' => ""
       )
     );
		header('Location: ' . base_url() . 'index.php/panel/Panel/index/' . $token);
	}
	/*
	| ------------------------------------------------------------
	|	Control de Acciones
	| ------------------------------------------------------------
	*/

	/**
	 * Validar y sincronizar el usuario de conexión
	 *
	 * @access  public
	 * @return mixed
	 */
	public function validarUsuario($token = ""){
		$arr['url'] = 'http://192.168.6.45:8080/ipsfa/api/wusuario/validarphp';
		if($token != ""){
			// print_r($arr);
			$arr['token'] = $token;
			$api = $this->MCurl->Cargar_API($arr);
			$data['rs'] = $api['obj'];
			// print_r($data['rs']);
			if ($data['rs']->tipo == 1 ){
				$this->inicio($token);
			}else {
				header('Location: /SSSIFANB/' );
			}

		}

		// curl_setopt($tk, CURLOPT_HTTPHEADER, array('Authorization: Basic '.$basic_credentials, 'Content-Type: application/x-www-form-urlencoded;charset=UTF-8'));

		// if(isset($_POST['usuario']) && $_POST['usuario'] != ""){
		//
		// 	$this->load->model('usuario/Iniciar');
		//
		// 	$valores["usuario"] = $_POST['usuario'];
		// 	$valores["clave"] = $_POST['clave'];
		// 	$resultado = $this->Iniciar->validarCuenta($valores);
		// 	if ( $resultado == 1){
		// 		$this->inicio();
		// 	}else{
		// 		echo "Error en el usuario con la base de datos";
		// 	}
		// }else{
		// 	$this->salir();
		// }

	}




	/**
	* Establecer politicas para la recuperacion de clave
	*
	* @access public
	* @return mixed
	*/
	public function recuperar($msj = ''){
		$data['msj'] = $msj;
		$this->load->view('login/afiliacion/frmRecuperar', $data);
	}

	/**
	* Registar y asignar tipo al usuario
	*
	* @access public
	* @return mixed
	*/
	public function registrarUsuario(){
		$this -> load -> model("usuario/usuario","usuario");
		$usuario = new $this -> usuario;
		$usuario->cedula = $_SESSION['cedula'];
		$usuario->tipo = 1;
		$usuario->nombre = $_SESSION['nombreRango'];
		$usuario->sobreNombre = $_POST['usuario'];
		$usuario->correo = $_POST['correo'];
		$usuario->clave = $_POST['clave'];
		$usuario->respuesta = $_SESSION['APIkey'];
		$usuario->perfil = $_SESSION['situacion'];
		if($usuario->existe() == -1){
			$usuario->registrar();
			$this->load->model('comun/Dbipsfa');
			$arr = array(
		      'cedu' => $usuario->cedula,
		      'obse' => 'Creación de Usuario',
		      'fech' => 'now()',
		      'app' => 'Login',
		      'tipo' => 0
			);

    		$this->Dbipsfa->insertarArreglo('traza', $arr);
			$_SESSION['correo'] = $_POST['correo'];
			$_SESSION['estatus'] = 0;
    		$this->enviarCorreoCertificacion();
			$this->load->view('login/afiliacion/frmOk');
		}else{
			$msj = "El usuario se encuentra registrado, intente recuperar la contraseña";
			$this->identificacion($msj);
		}
	}




	/**
	* Permite validar la ultima conexion
	*
	* @access public
	* @return mixed
	*/
	public function ultimaConexion(){
		print_r($_SESSION);
	}

  	public function salir(){
  		session_destroy();
  		$this->load->view ( 'login');
  	}






	function __destruct(){
	}
}
