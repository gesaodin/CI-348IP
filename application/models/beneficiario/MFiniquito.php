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

class MFiniquito extends CI_Model{


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

  function listarCodigo($cedula, $codigo){
    $sConsulta = 'SELECT * FROM movimiento where cedula=\'' . $cedula . '\' AND  codigo =\'' . $codigo . '\';';
    
    $obj = $this->Dbpace->consultar($sConsulta);
    $lst = array();

    if($obj->code == 0 ){
      foreach ($obj->rs as $clv => $val) {
       $lst[] = array(
          'id' => $val->id, 
          'cedula' => $val->cedula,
          'monto' => $val->monto,
          'tipo_movimiento_id' => $val->tipo_movimiento_id,
          'codigo' => $val->codigo,
          'observaciones' => $val->observaciones,
          'f_contable' => $val->f_contable,
          'status_id' => $val->status_id,
          'motivo_id' => $val->motivo_id,
          'f_creacion' => $val->f_creacion,
          'usr_creacion' => $val->usr_creacion,
          'f_ult_modificacion' => $val->f_ult_modificacion,
          'usr_modificacion' => $val->usr_modificacion,
          'observ_ult_modificacion' => $val->observ_ult_modificacion,
          'partida_id' => $val->partida_id
        );
      }
    }
    return $lst;
  }

  /**
  * Obtener el listado de los Motivos
  *
  * @access public
  * @return void
  */
  public function listarMotivos(){
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