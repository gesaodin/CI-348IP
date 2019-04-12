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

class KNomina extends CI_Model{
  
  var $ID = '';

  var $Nombre = '';
  var $Descripcion = '';
  var $Monto = 0.00;
  var $Asignacion = 0.00;
  var $Deduccion = 0.00;
  var $Cantidad = 0;
  var $Tipo = ''; //RCP | FCP | I | GRACIA
  var $estatus = true;
  
  var $fecha = '';
  /**
  * Iniciando la clase, Cargando Elementos Pace
  *
  * @access public
  * @return void
  */
  public function __construct(){
    parent::__construct();  

  }

  public function Cargar(){
    

    $sConsulta = "INSERT INTO space.nomina ( nomb,obse, fech,tipo,m onto,asig, dedu, cant, estatus ) VALUE (
    '" . $this->Nombre . "','" . $this->Descripcion . "',Now(),'" . $this->Tipo . 
    "','" . $this->Monto . "''" . $this->Asignacion . "','" . $this->Deduccion . "','" . $this->Cantidad  . ",1) RETURNING oid";
    $obj = $this->DBSaman->consultar($sConsulta);

    return json_encode($obj->rs);
  }


  
}
