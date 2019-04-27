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
    "', mont = " . round($this->Monto,2) . ", asig =" . round($this->Asignacion,2) . 
    ", dedu=" . round($this->Deduccion,2) . ", cant=" . $this->Cantidad  . " WHERE oid =" . $this->ID;
    $obj = $this->DBSpace->consultar($sConsulta);
    //echo "AQUI";
    return true;
  }

  public function Contar(){
    $sConsulta = "SELECT count(*) as cantidad FROM familiar fam 
      JOIN beneficiario bnf ON fam.titular=bnf.cedula 
      WHERE fam.estatus = 201 AND bnf.grado_id != 0";
    $obj = $this->DBSpace->consultar($sConsulta);
    $sobrevive = 0;
    foreach($obj->rs as $c => $v ){
      $sobrevive = $v->cantidad;
    }


    $sConsulta = "SELECT situacion, count(situacion) AS cantidad FROM beneficiario WHERE
    grado_id != 0 AND
    status_id = 201 GROUP BY situacion";
    $obj = $this->DBSpace->consultar($sConsulta);
    $contar = array();
    foreach($obj->rs as $c => $v ){
      if($v->situacion != "FCP"){
        $contar[] = array(
                "situacion" => $v->situacion, 
                "cantidad" => $v->cantidad);
      }else{
        $contar[] = array(
          "situacion" => $v->situacion, 
          "cantidad" => $sobrevive);
      }
    }



    
    return $contar;
  }

  public function Listar($id){
    if ( $id != "4"){
      $sConsulta = "SELECT * FROM space.nomina WHERE esta IN ( 1, 2, 3) ";
    }else{
      $sConsulta = "SELECT * FROM space.nomina WHERE esta = 4 ";
    }
    $obj = $this->DBSpace->consultar($sConsulta);
    $lst = array();
    foreach($obj->rs as $c => $v ){
      $lst[] = $v;
    }
    return $lst;
  }

  public function ListarPagos(){
    
    $sConsulta = "select llav as firma, sum(mont) as monto, sum(asig) as asignacion, 
    sum(dedu) as deduccion, sum(cant) as cantidad from     
    space.nomina WHERE llav != '' group by llav; ";
   
    $obj = $this->DBSpace->consultar($sConsulta);
    $lst = array();
    foreach($obj->rs as $c => $v ){
      $lst[] = $v;
    }
    return $lst;
  }

  public function ListarCuadreBanco($firma){
    

    $sConsulta = "SELECT banc, bnc.nomb, cant, neto FROM (
    SELECT  pg.banc, count(pg.banc) AS cant, SUM(neto) AS neto FROM space.nomina nm JOIN space.pagos pg ON pg.nomi=nm.oid
    WHERE nm.llav='" . $firma . "'
    GROUP BY  pg.banc
    ORDER BY pg.banc) AS mt
    LEFT JOIN space.banco bnc ON mt.banc=bnc.codi";
    
    $obj = $this->DBSpace->consultar($sConsulta);
    $lst = array();
    foreach($obj->rs as $c => $v ){
      $lst[] = $v;
    }
    return $lst;
  }

  public function Procesar(){
    $sConsulta = "UPDATE space.nomina SET esta = " . $this->Estatus  . " WHERE oid =" . $this->ID;
    $obj = $this->DBSpace->consultar($sConsulta);
    return true;
  }

  public function RegistrarDetalle($oidn, $presupuesto){
    $i = 0;
    $coma = '';
    $insert = 'INSERT INTO space.nomina_detalle (oidn, part, estr, conc,  fech, tipo, mont  ) VALUES ';
    foreach ($presupuesto as $c => $v) {     
      if ($v['tp'] != 97 ) {
        $i++;
        $coma = $i > 1?",":"";      
        $insert .= $coma . "(" . $oidn . ",'" . $v['part'] . "','" . $v['estr'] . "','" . $v['abv'] . 
        "',Now()," . $v['tp'] . "," . round($v['mnt'],2) . ")";
      }

    }
    //print_r($insert);
    $obj = $this->DBSpace->consultar($insert);
    return true;
  }


  public function VerDetalles(){
    $sConsulta = "SELECT * FROM space.nomina_detalle WHERE oidn=" . $this->ID;
    $obj = $this->DBSpace->consultar($sConsulta);
    $lst = array();
    foreach($obj->rs as $c => $v ){
      $lst[] = $v;
    }
    return $lst;
  }
}
