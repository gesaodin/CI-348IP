<?php
if (!defined('BASEPATH'))
  exit('No direct script access allowed');
/**
 * Seguridad MamonSoft C.A
 * 
 *
 * @package mamonsoft.modules.seguridad
 * @subpackage usuario
 * @author Carlos Peña
 * @copyright	Derechos Reservados (c) 2014 - 2015, MamonSoft C.A.
 * @link		http://www.mamonsoft.com.ve
 * @since Version 1.0
 *
 */
class Usuario extends CI_Model {

  var $id = NULL;

  /**
   * Cedula o Registro de Informacion Fiscal (RIF)
   * @var int(11)
   */
  var $cedula;

  /**
   * V- Venezolano,  J- Juridico, G- Gubernamental
   * @var char(1)
   */
  var $tipo;


  /**
   * 
   * @var string
   */
  var $nombre;


  /**
   * 
   * @var string
   */
  var $apellido;

  /**
   * 
   * @var string
   */
  var $direccion = '';

  /**
   * 
   * @var string
   */
  var $sobreNombre;

  /**
   * 
   * @var string
   */
  var $correo = '';

  /**
   * 
   * @var string
   */
  var $respuesta = '';

  /**
   * 
   * @var string
   */
  var $telefono = '';

  /**
   * 
   * @var string
   */
  var $empresa = '';

  /**
   * 
   * @var string
   */
  var $pagina = '';

  /**
   * 
   * @var string
   */
  var $clave;

  /**
   * 
   * @var integer
   */
  var $estatus = 0;

  /**
   * 
   * @var string
   */
  var $perfil;

  /**
   * 
   * @var array
   */
  var $listaRoles = array();

  /**
   * 
   * @var array
   */
  var $listaPrivilegios = array();

  /**
   * 
   * @var array
   */
  var $listaDependientes = array();



  function __construct() {
    parent::__construct();
    $this->load->model('comun/Dbpace');
  }

  /**
   *
   */
  function registrar() {
    $data = $this -> mapearObjeto();
    $this->Dbpace->insertarArreglo('usuario', $data);
    
    $val = FALSE;
    $codigo = $this -> existe();
    if ($codigo > 0){
      $this->Dbpace->insertarArreglo('bss._usuarioperfil', array('oidu' => $codigo, 'oidp' => 2));
      $val = TRUE;
    }
    return $val;
  }

  function actualizar(){

    $sActualizar = 'UPDATE space.usuario SET password=\'' . $this->_claveEncriptada() . '\' WHERE id = \'' . $this->id . '\'';
    //echo $sActualizar;
    $this->Dbpace->consultar($sActualizar);
  }

  /**
   * Definir el arreglo de la insercion a la base de datos
   *
   * @access private
   * @return array
   */
  private function mapearObjeto() {
    $data = array( //
      //'id' => $this -> identificador, //
      'tipo' => $this->tipo, //
      'cedu' => $this->cedula, //
      'nomb' => $this->nombre, //
      'seud' => $this->sobreNombre, //
      'clav' => md5($this->clave), //
      'corr' => $this->correo,
      'resp' => $this->respuesta,
      'empr' => $this->empresa, //
      'perf' => $this->perfil, //
      'pagi' => $this->pagina, //
      'esta' => $this->estatus
    );
    return $data;
  }

  /**
   * Verifica si exite un usuario y retorna su OID
   *
   * @access public
   * @param string
   * @param CI_DB
   * @return int
   */
  public function existe() {
    $codigo = -1;
    $consulta = 'SELECT id FROM space.usuario WHERE login =\'' . $this -> cedula . ' \' LIMIT 1';
    $obj = $this->Dbpace->consultar($consulta);
    foreach ($obj->rs as $clv => $val) {
      $codigo = $val -> oid;
    }
    return $codigo;
  }

  /**
   * Definir el arreglo de la insercion a la base de datos
   *
   * @access public
   * @return bool
   */
  public function validar() {
    $arr = array();
    $valor = FALSE;
    if ($this -> _evaluarSobreNombre() == TRUE && $this -> clave != '') {
      $rs = $this -> conectar();
      if ($rs->cant != 0) {
        foreach ($rs->rs as $fila => $valor) {
          $this->nombre = $valor->nombre;
          $this->apellido = $valor->apellido;
          $this->id = $valor->id;
          $this->correo = $valor->correo;
          $this->estatus = $valor->status_id;
          $this->login = $valor->login;
          $arr[] = $valor->rol_id;

        }
        $this->listaRoles = $arr;
        $valor = TRUE;
      }
    }
    return $valor;
  }
  /**
   * Verificar que el Sobre Nombre no tenga caracteres parentesis o corchetes
   *
   * @return boolean
   */  
  protected function _evaluarSobreNombre() {
    //return preg_match("/^([-a-z0-9_-])+$/i", $this -> sobreNombre);
    return $this -> sobreNombre;

  }

  function conectar() {    
    $consulta = 'SELECT 
        space.usuario.id, space.usuario.login, space.usuario.nombre, space.usuario.apellido, space.usuario.correo,
        space.usuario.status_id
      FROM space.usuario 
       
      WHERE login=\'' . $this -> sobreNombre . '\' AND password =\'' . $this -> _claveEncriptada() . '\';';
        
    $obj = $this->Dbpace->consultar($consulta);
    return $obj;
  }

  protected function _claveEncriptada() {
    return md5($this -> clave);
  }
  
  protected function _evaluarCorreo() {
  	return preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $this -> correo);
  }
  
  function cargarPrivilegios() {
    return $this -> listaPrivilegios;
  }

  function cargarDependientes() {
    return $this -> listaDependientes;
  }

  function validarCorreo($sha){
    $sConsulta = "UPDATE usuario_sistema SET esta=1 WHERE resp='" . $sha . "';";
    $obj = $this->Dbpace->consultar($sConsulta);
    return TRUE;
  }

  function obtener($id){
    $sConsulta = 'SELECT * FROM space.usuario WHERE id=\'' . $id . '\'';
    $obj = $this->Dbpace->consultar($sConsulta);
    return $obj->rs;
  }

  function listar(){   
    $sConsulta = "SELECT id, login, nombre, apellido, status_id FROM space.usuario WHERE status_id=292 ORDER BY id";
    $obj = $this->Dbpace->consultar($sConsulta);
    return $obj->rs;
  }


  function upsert($r){

    if($r->id == 0){
      $donde = ' login = \'' . $r->seu . '\' ';
    }else{
      $donde = ' id=  ' . $r->id;
    }

    $upsert = 'WITH UPSERT AS (
      UPDATE space.usuario 
      SET 
        correo=\'' . $r->cor . '\', 
        nombre=\'' . $r->nom . '\',
        apellido=\'\',
        pregunta_secreta=\'' . $r->tel . '\',
        status_id=' . $r->est . ',
        password=md5(\'' . $r->cla . '\'),
        f_ult_modificacion=now(),
        observ_ult_modificacion=\'' . $r->obs . '\'
      WHERE ' . $donde . ' 
      RETURNING *
    )
    INSERT INTO 
      space.usuario 
      (login,correo,nombre,apellido,pregunta_secreta,status_id,password,f_ult_modificacion, observ_ult_modificacion) 
    SELECT \'' . $r->seu . '\',\'' . $r->cor  . '\',\'' . 
    $r->nom . '\',\'\',\'' . $r->tel . '\',' . $r->est . ',md5(\'' . $r->cla . '\'), now(),\'' . $r->obs . '\'
    WHERE NOT EXISTS (SELECT * FROM upsert)';

    //echo $upsert;

    $obj = $this->Dbpace->consultar($upsert);
    //print_r($obj);
    return $obj->cant;
  }
  

  /**
  * Ver la ultima conexion de un usuario
  *
  * @access public
  * @return string
  */
  function ultimaConexion(){
    $sConsulta = 'SELECT * FROM bss.traza WHERE cedu=\'' . $this->cedula . '\' ORDER BY fech  DESC LIMIT 1;';
    $obj = $this->Dbpace->consultar($sConsulta);
    foreach ($obj->rs as $c => $v) {
      $fecha = $v->fech;
    }
    return substr($fecha, 0 ,19);
  }

  function __destruct() {

  }

}
?>
