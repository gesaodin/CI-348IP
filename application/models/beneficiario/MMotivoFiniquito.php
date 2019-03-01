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

class MMotivoFiniquito extends CI_Model{


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


  /**
  * Obtener el listado de los Motivos
  *
  * @access public
  * @return void
  */
  public function listarTodo(){
    $sConsulta = 'SELECT id, nombre, descripcion FROM motivo';
    
    $obj = $this->Dbpace->consultar($sConsulta);
    $lst = array();

    if($obj->code == 0 ){
      foreach ($obj->rs as $clv => $val) {
       $lst[] = array(
        'id' => $val->id, 
        'nomb' => $val->nombre,
        'desc' => $val->descripcion,
        );
      }
    }
    return $lst;

  }

}