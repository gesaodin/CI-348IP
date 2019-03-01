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

class KTasa extends CI_Model{
  

  var $Tasa;
  /**
  * Iniciando la clase, Cargando Elementos Pace
  *
  * @access public
  * @return void
  */
  public function __construct(){
    parent::__construct();  

  }

  public function Cargar($fecha){
    $sConsulta = 'SELECT * FROM space.crosstab(
        \'SELECT f_tasa,tipo_tasa_id,interes FROM tasa_bcv ORDER BY f_tasa,tipo_tasa_id\'
      ) AS intereses (fecha date, activa numeric, promedio numeric)
      WHERE intereses.fecha > \'' . $fecha . '\'';
    $obj = $this->DBSaman->consultar($sConsulta);

  }


  
}
