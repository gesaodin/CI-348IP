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

class KSensor extends CI_Model{
  
  /**
  * @var MBeneficiario
  */
  var $Tiempo = null;

  /**
  * Iniciando la clase
  *
  * @access public
  * @return void
  */
  public function __construct(){
    parent::__construct();
    $this->Tiempo = microtime(true);

  }


  private function microtime_float() {
      list($useg, $seg) = explode(" ", microtime());
      return ((float)$useg + (float)$seg);
  }

  public function Duracion(){
    $tiempo_fin = microtime(true);
    $tiempo = bcsub($tiempo_fin, $this->Tiempo, 4);
     
    return "Tiempo empleado: " . $tiempo . " seg" ;
  }
}
