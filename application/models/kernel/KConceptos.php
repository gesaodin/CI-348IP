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

class KConceptos extends CI_Model{


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
  var $estatus;

  /**
  * @var array
  */
  var $Detalle = array();

 /**
  * @var double
  */
  var $unidad_tributaria = 0.00;

  /**
  * @var MBeneficiario
  */
  var $Beneficiario = null;

  /**
  * Iniciando la clase, Cargando Elementos Pace
  *
  * @access public
  * @return void
  */
  public function __construct(){
    parent::__construct();
    if(!isset($this->DBSpace)) $this->load->model('comun/DBSpace');
    //$this->load->model('kernel/KPrimasDetalle');
  }



  /**
  * Obtener detalles de las prima por Directiva Especifica
  *
  * @access public
  * @param int
  * @return array
  */
  public function Cargar(&$Dir){

    $consultaConcepto = "SELECT * FROM space.conceptos WHERE componente = 'TODOS' AND estatus=1";
    $obj = $this->DBSpace->consultar($consultaConcepto);    
    foreach ($obj->rs as $clv => $v) {    
        $Dir['fnxC'][] = array(
          'fn' => $v->forumula, 
          'rs' => $v->codigo, 
          'abv' => $v->descripcion, 
          'tipo' => $v->tipo,
          'part' => $v->partida
        ); 

    }
    return true;
  }

  /**
  * Obtener detalles de las prima por Directiva Especifica
  *
  * @access public
  * @param int
  * @return array
  */
  public function CargarConceptos(){

    $consultaConcepto = "SELECT * FROM space.conceptos WHERE componente = 'TODOS' AND estatus=1";
    $obj = $this->DBSpace->consultar($consultaConcepto);    
    foreach ($obj->rs as $clv => $v) {    
      $Dir['fnxC'][] = array(
          'rs' => $v->codigo, 
          'fn' => $v->forumula, 
          'abv' => $v->descripcion, 
          'tipo' => $v->tipo,
          'part' => $v->partida
        ); 

    }
    return true;
  }


}