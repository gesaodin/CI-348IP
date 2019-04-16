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
  var $Tipo = 'SD'; //RCP | FCP | I | GRACIA
  var $Estatus = 0;
  
  var $fecha = '';
  /**
  * Iniciando la clase, Cargando Elementos Pace
  *
  * @access public
  * @return void
  */
  public function __construct(){
    parent::__construct();  
    if(!isset($this->DBSpace)) $this->load->model('comun/DBSpace');
  }

  public function Cargar($info = ""){
    $oid = 0;
    $p = json_encode($info["Concepto"]);
    $sConsulta = "INSERT INTO space.nomina ( nomb,obse,fech,desd,hast,tipo,mont,asig, dedu, cant, esta, info, url ) VALUES (
    '" . $this->Nombre . "','" . $info["nombre"] . "',Now(),'" . $info["fechainicio"] . "','" . $info["fechafin"] . 
    "','" .  $info["tipo"] . 
    "'," . $this->Monto . "," . $this->Asignacion . "," . $this->Deduccion . 
    "," . $this->Cantidad  . "," . $this->Estatus  . ",'"  . $p . "','"  . base_url() . "') RETURNING oid";

    $obj = $this->DBSpace->consultar($sConsulta);
    foreach ($obj->rs as $clv => $val) {
        $oid = $val->oid;
    }
    $this->ID = $oid;
  }

  public function Actualizar(){
    $sConsulta = "UPDATE space.nomina SET nomb = '" .  $this->Nombre . "', esta = " . $this->Estatus . ", tipo='" . $this->Tipo .  
    "', mont = " . $this->Monto . ", asig =" . $this->Asignacion . 
    ", dedu=" . $this->Deduccion . ", cant=" . $this->Cantidad  . " WHERE oid =" . $this->ID;
    $obj = $this->DBSpace->consultar($sConsulta);
    //echo "AQUI";
    return true;
  }

  public function Contar(){
    $sConsulta = "SELECT situacion, count(situacion) AS cantidad FROM beneficiario GROUP BY situacion";
    $obj = $this->DBSpace->consultar($sConsulta);
    $contar = array();
    foreach($obj->rs as $c => $v ){
      $contar[] = array(
              "situacion" => $v->situacion, 
              "cantidad" => $v->cantidad);
    }
    return $contar;
  }

  public function Listar(){
    $sConsulta = "SELECT * FROM space.nomina WHERE esta=1";
    $obj = $this->DBSpace->consultar($sConsulta);
    $lst = array();
    foreach($obj->rs as $c => $v ){
      $lst[] = $v;
    }
    return $lst;
  }

  
}
