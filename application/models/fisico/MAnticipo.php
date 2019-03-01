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

class MAnticipo extends CI_Model{


  /**
  * @var integer
  */
  var $id;

  /**
  * @var string
  */
  var $descripcion = '';

  /**
  * @var integer
  */
  var $estatus = 0;

  /**
  * @var date
  */
  var $fecha = '';


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
  function obtenerID($id){
    /**
    $sConsulta = 'SELECT id, partida.codigo, proyecto.descripcion,estatus,codigo_proyecto, codigo_unidad_ejecutora FROM partida 
    JOIN proyecto ON partida.codigo_proyecto = proyecto.codigo
    WHERE id=' . $id . ';';
    $obj = $this->Dbpace->consultar($sConsulta);
    if($obj->code == 0 ){
      foreach ($obj->rs as $clv => $val) {
        $this->id = $val->id;
        $this->proyecto = $val->descripcion;
        $this->codigo_unidad_ejecutora = $val->codigo_unidad_ejecutora;
      }
    }**/
    return $this;
  }


  /**
  * Obtener el listado de los Motivos
  *
  * @access public
  * @return void
  */
  public function listarTodo(){
    $sConsulta = 'SELECT oid, nomb, esta, fech  FROM space.motivo_anticipo;';
    
    $obj = $this->Dbpace->consultar($sConsulta);
    $lst = array();

    if($obj->code == 0 ){
      foreach ($obj->rs as $clv => $val) {
       $lst[] = array(
        'oid' => $val->oid, 
        'nomb' => $val->nomb,
        'esta' => $val->esta,
        'fech' => $val->fech

        );
      }
    }
    return $lst;

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



}