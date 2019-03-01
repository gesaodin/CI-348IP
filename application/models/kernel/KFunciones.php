<?php 
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * MamonSoft 
 *
 * Kernel
 *
 * @package pace\application\modules\panel\model\beneficiario
 * @subpackage utilidad
 * @author Carlos Peña
 * @copyright Derechos Reservados (c) 2015 - 2016, MamonSoft C.A.
 * @link http://www.mamonsoft.com.ve
 * @since version 1.0
 */

class KFunciones extends CI_Model{
  
  /**
  * Iniciando la clase, Cargando Elementos Pace
  *
  * @access public
  * @return void
  */
  public function __construct(){
    parent::__construct();
  }
  

  function Calcular(MBeneficiario & $Beneficiario){

  }

  /**
  * Obtener detalles de las prima por Directiva Especifica
  *
  * @access public
  * @param int
  * @return array
  */
  public function Cargar(&$Dir){
    $sConsulta = '
      SELECT refe,fnx,rs FROM space.fnprima AS fn 
      JOIN space.fnformula AS fx ON fn.func=fx.oid
      WHERE oidd= ' . $Dir['oid'] . '  ORDER BY refe';
    
    $obj = $this->DBSpace->consultar($sConsulta);    
    foreach ($obj->rs as $clv => $v) {    
        $Dir['fnx'][$v->refe] = array('fn' => $v->fnx, 'rs' => $v->rs); 

    }
    return true;

  }


}
