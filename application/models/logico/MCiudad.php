<?php 
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * MamonSoft 
 *
 * Ciudad
 *
 * @package pace\application\modules\panel\model\beneficiario
 * @subpackage utilidad
 * @author Carlos Peña
 * @copyright Derechos Reservados (c) 2015 - 2016, MamonSoft C.A.
 * @link http://www.mamonsoft.com.ve
 * @since version 1.0
 */

class MCiudad extends CI_Model{


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
    if(!isset($this->DBSpace)) $this->load->model('comun/DBSpace');
  }




  /**
  * 
  *
  * @access public
  * @return void
  */
  function listarID($estado_id = 0){
    $sConsulta = 'SELECT * FROM ciudad WHERE estado_id=' . $estado_id;
    $obj = $this->DBSpace->consultar($sConsulta);
    $arr = array();
    if($obj->code == 0 ){
      foreach ($obj->rs as $clv => $val) {
        $ciudad = new $this;
        $ciudad->id = $val->id;
        $ciudad->nombre = strtoupper($val->nombre);
        $ciudad->descripcion = $val->descripcion;
        $arr[] = $ciudad;
      }
    }
    return $arr;

  }


}