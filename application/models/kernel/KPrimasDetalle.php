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

class KPrimasDetalle extends CI_Model{


  /**
  * @var integer
  */
  var $id;

  /**
  * @var double
  */
  var $monto_nominal = 0;


  /**
  * @var double
  */
  var $monto_unidad_tributaria = 0;


  /**
  * Iniciando la clase, Cargando Elementos Pace
  *
  * @access public
  * @return void
  */
  public function __construct(){
    parent::__construct();

  }


  /**
  * Obtener detalles del Cargo
  *
  * @access public
  * @return void
  */
  function obtenerID(){

  }

}