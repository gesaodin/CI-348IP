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

class MTasabcv extends CI_Model{
  
  /**
  * @var MBeneficiario
  */
  var $BCV = null;

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
  * Obtener el listado de las tasas del banco central de venezuela
  * Tipo  1 Activa 2 Pasiva
  * @access public
  * @return void
  */
  public function listarTodo(){
    $sConsulta = 'SELECT id, tipo_tasa_id, interes, f_tasa,f_creacion FROM tasa_bcv';
    
    $obj = $this->Dbpace->consultar($sConsulta);
    $lst = array();

    if($obj->code == 0 ){
      foreach ($obj->rs as $clv => $val) {
       $lst[] = array(
        'id' => $val->id, 
        'tipo' => $val->tipo_tasa_id, 
        'interes' => $val->interes,
        'f_tasa' => $val->f_tasa,
        'f_creacion' => $val->f_creacion
        );
      }
    }
    return $lst;

  }


}

?>