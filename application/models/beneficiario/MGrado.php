<?php 
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * MamonSoft 
 *
 * Grado
 *
 * @package pace\application\modules\panel\model\beneficiario
 * @subpackage utilidad
 * @author Carlos Peña
 * @copyright Derechos Reservados (c) 2015 - 2016, MamonSoft C.A.
 * @link http://www.mamonsoft.com.ve
 * @since version 1.0
 */

class MGrado extends CI_Model{


  /**
  * @var integer
  */
  var $id;


  /**
  * @var string
  */
  var $nombre = '';


  /**
  * @var string
  */
  var $descripcion = '';

 /**
  * @var integer
  */
  var $codigo;



  /**
  * Iniciando la clase, Cargando Elementos Pace
  *
  * @access public
  * @return void
  */
  public function __construct(){
    parent::__construct();
    if(!isset($this->Dbpace)) $this->load->model('comun/Dbpace');
  }




  /**
  * Obtener detalles del Cargo
  *
  * @access public
  * @return void
  */
  function obtenerID(){

  }

  function porComponente($id){
    $sConsulta = 'SELECT * FROM grado WHERE componente_id=\'' . $id . '\' ORDER BY id ASC';
    $obj = $this->Dbpace->consultar($sConsulta);
    $arr = array();
    if($obj->code == 0 ){
      foreach ($obj->rs as $clv => $val) {
        $grado = new $this;
        $grado->id = $val->id;
        $grado->nombre = $val->nombre;
        $grado->descripcion = $val->descripcion;
        $grado->codigo = $val->codigo;
        $arr[] = $grado;
      }
    }
    return $arr;
  }

}