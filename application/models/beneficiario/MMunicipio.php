<?php 
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * MamonSoft 
 *
 * Municipio
 *
 * @package pace\application\modules\panel\model\beneficiario
 * @subpackage utilidad
 * @author Carlos Peña
 * @copyright Derechos Reservados (c) 2015 - 2016, MamonSoft C.A.
 * @link http://www.mamonsoft.com.ve
 * @since version 1.0
 */

class MMunicipio extends CI_Model{


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
  * @return array
  */
  function listarID($ciudad_id = 0){
    $sConsulta = 'SELECT * FROM municipio WHERE ciudad_id=' . $ciudad_id;
    $obj = $this->Dbpace->consultar($sConsulta);
    $arr = array();
    if($obj->code == 0 ){
      foreach ($obj->rs as $clv => $val) {
        $municipio = new $this;
        $municipio->id = $val->id;
        $municipio->nombre = strtoupper($val->nombre);
        $municipio->descripcion = $val->descripcion;
        $arr[] = $municipio;
      }
    }
    return $arr;

  }

}