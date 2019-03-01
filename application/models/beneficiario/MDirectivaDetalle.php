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

class MDirectivaDetalle extends CI_Model{


  /**
  * @var integer
  */
  var $grado_id = 0;

  /**
  * @var integer
  */
  var $ano_servicio = 0;

  /**
  * @var double
  */
  var $sueldo_base = 0;

  /**
  * @var array
  */
  var $Prima = array();

  /**
  * Iniciando la clase, Cargando Elementos Pace
  *
  * @access public
  * @return void
  */
  public function __construct(){
    parent::__construct();

  }

}
