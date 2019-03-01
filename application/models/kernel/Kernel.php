<?php 
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * MamonSoft 
 *
 * Calculos
 *
 * @package pace\application\modules\panel\model\beneficiario
 * @subpackage utilidad
 * @author Carlos Peña
 * @copyright Derechos Reservados (c) 2015 - 2016, MamonSoft C.A.
 * @link http://www.mamonsoft.com.ve
 * @since version 1.0
 */

class Kernel extends CI_Model{
  
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
    $this->load->model('beneficiario/MDirectiva');
   

  }
  
}
