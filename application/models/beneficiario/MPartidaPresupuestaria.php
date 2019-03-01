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

class MPartidaPresupuestaria extends CI_Model{


  /**
  * @var integer
  */
  var $id;


  /**
  * @var string
  */
  var $codigo = '';


  /**
  * @var string
  */
  var $descripcion = '';

  /**
  * @var string
  */
  var $codigo_unidad_ejecutora = '';

  /**
  * @var string
  */
  var $codigo_proyecto = '';

  /**
  * @var string
  */
  var $proyecto = '';

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
    }
    return $this;
  }


  /**
  * Obtener el listado de los Motivos
  *
  * @access public
  * @return void
  */
  public function listarTodo(){
    $sConsulta = 'SELECT id, codigo, descripcion,estatus,codigo_proyecto, codigo_unidad_ejecutora FROM partida;';
    
    $obj = $this->Dbpace->consultar($sConsulta);
    $lst = array();

    if($obj->code == 0 ){
      foreach ($obj->rs as $clv => $val) {
       $lst[] = array(
        'id' => $val->id, 
        'codi' => $val->codigo,
        'desc' => $val->descripcion,
        'codp' => $val->codigo_proyecto,
        'cuej' => $val->codigo_unidad_ejecutora,

        );
      }
    }
    return $lst;

  }

}