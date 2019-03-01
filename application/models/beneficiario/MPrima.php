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


class MPrima extends CI_Model{


  /**
  * @var integer
  */
  var $id;


  /**
  * @var string
  */
  var $nombre = '';


  /**
  * @var string
  */
  var $descripcion = '';

 /**
  * @var integer
  */
  var $estatus;

  /**
  * @var array
  */
  var $Detalle = array();

 /**
  * @var double
  */
  var $unidad_tributaria = 0.00;

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
    $this->load->model('beneficiario/MPrimaDetalle');
    if(!isset($this->Dbpace)) $this->load->model('comun/Dbpace');
  }



  /**
  * Obtener detalles de las prima por Directiva Especifica
  *
  * @access public
  * @param int
  * @return array
  */
  public function obtenerSegunDirectiva($id){
    $sConsulta = 'SELECT directiva_id, grado_id, prima_id, prima.nombre, monto_nominal, monto_ut
                  FROM prima_directiva
                  JOIN prima ON prima.id=prima_directiva.prima_id
                  WHERE directiva_id =\'' . $id . '\' order by grado_id ';
	  $obj = $this->Dbpace->consultar($sConsulta);
		$lstH = array();
		$gra = 0;
		$i = 0;
		foreach ($obj->rs as $clv => $val) {
			if($gra != $val->grado_id){
				$lstH = array();
				$gra = $val->grado_id;
			}
			$lstH[] = array($val->nombre => $val->monto_nominal);
			$this->Detalle[$gra] = $lstH;
			$i++;
		}
		return $this;

  }


  /**
  * Obtener detalles de la prima por grado
  *
  * @access public
  * @param int
  * @param int
  * @return void
  */
  public function obtener($id_grado = 0, $directiva_id = 0, MBeneficiario &$Beneficiario){
    $this->Beneficiario = $Beneficiario;
    $this->unidad_tributaria =  $this->Beneficiario->Componente->Grado->Directiva->unidad_tributaria;

    $sConsulta = 'SELECT prima.id, prima_id,nombre,descripcion,monto_nominal,monto_ut,fnx,rs FROM
    (
      SELECT prima_directiva.id, prima_directiva.prima_id, prima.nombre,
      prima.descripcion, monto_nominal, monto_ut,directiva_id AS oidd
      FROM prima_directiva
      JOIN prima ON prima_directiva.prima_id=prima.id
      WHERE prima_directiva.grado_id = ' . $id_grado . ' AND directiva_id= ' . $directiva_id . '
    ) AS prima
    JOIN
    (
      SELECT oidd, refe,fnx,rs FROM space.fnprima AS fn
      JOIN space.fnformula AS fx ON fn.func=fx.oid
    ) fn ON prima.oidd=fn.oidd AND prima.prima_id=fn.refe;';

    $obj = $this->Dbpace->consultar($sConsulta);
    $listaPrima = array();
		if($obj->code == 0 ){
			foreach ($obj->rs as $clv => $val) {
        $Prima = new $this->MPrima();
        $Detalle = new $this->MPrimaDetalle();
        $Prima->id = $val->prima_id;
        $Prima->nombre = $val->nombre;
        $NM = $val->nombre;

        $valor = $this->ejecutarfnx($val->fnx, $val->monto_nominal);

        //$this->Beneficiario->Prima[$val->prima_id] = array($NM => $this->$NM($val->monto_nominal));
        $this->Beneficiario->Prima[$val->prima_id] = array($NM => $valor);
        $Prima->descripcion = $val->descripcion;
        $Detalle->id = $val->id;
        $Detalle->monto_nominal = $val->monto_nominal;
        $Detalle->monto_unidad_tributaria = $val->monto_ut;
        $Prima->Detalle[] = $Detalle;
        $listaPrima[$val->prima_id] = $Prima;

       $metodo = $val->rs;
       $this->Beneficiario->$metodo = $valor;
      }
    }

    $this->Beneficiario->Prima[8] = array(
      //'P_PROFESIONALIZACION' => $this->Beneficiario->profesionalizacion == 1 ? $this->Profesionalizacion() : 0.00
      'P_PROFESIONALIZACION' => $this->Beneficiario->profesionalizacion > 0 ? $this->Profesionalizacion() : 0.00
      );


    return $listaPrima;
  }

  private function ejecutarfnx($fnx, $monto_nominal){
    $tiempo_servicio = $this->Beneficiario->tiempo_servicio;
    $unidad_tributaria = $this->unidad_tributaria;
    $sueldo_base = $this->Beneficiario->sueldo_base;
    $no_ascenso = $this->Beneficiario->no_ascenso;
    $numero_hijos = $this->Beneficiario->numero_hijos;
    $prima_profesionalizacion_mt = $this->Beneficiario->prima_profesionalizacion;
    eval('$valor = ' . $fnx);
    return round($valor,2);
  }

  /**
  * Efecctivo para el procesamiento por lotes
  *
  * @access public
  * @param MBeneficiario
  * @return array
  */
  public function calcular(MBeneficiario & $Beneficiario){
    $this->Beneficiario = $Beneficiario;
    $Detalle  = $this->Detalle[$this->Beneficiario->grado_codigo];
    foreach ($Detalle as $key => $val) {
      $lst = $val;
      foreach ($lst as $k => $v) {
        $this->Beneficiario->Prima[] = array( $k => $this->$k());
      }
    }
    $this->Beneficiario->Prima[8] = array(
      //'P_PROFESIONALIZACION' => $this->Beneficiario->profesionalizacion == 1 ? $this->Profesionalizacion() : 0.00
      'P_PROFESIONALIZACION' => $this->Beneficiario->profesionalizacion > 0 ? $this->Profesionalizacion() : 0.00
      );

  }

  /**
  * Profecionalizacion #005
  * X = (SB * 12,14,16,18,20) Se modificaron los porcentajes/100
  * SB = Sueldo Base
  *
  * @access public
  * @param double
  * @param int
  * @return double
  */


  public function Profesionalizacion($monto_nominal = 0,  $sueldo_base = 0.00){
         $pprof = $this->Beneficiario->profesionalizacion;
         $sueldo_base = $this->Beneficiario->sueldo_base;

      if(isset($this->Beneficiario) && ($this->Beneficiario->fecha_retiro == '')){
         $sueldo = (($sueldo_base * $pprof) / 100);
      }else{
        if($this->Beneficiario->fecha_retiro > '2015-12-31'){
          $sueldo = (($sueldo_base * $pprof) / 100);
      }else{
        if($this->Beneficiario->fecha_retiro <= '2015-12-31'){
          $sueldo = (($sueldo_base * 12) / 100);
          }
        }
       }
       $valor = round($sueldo, 2);
       $this->Beneficiario->prima_profesionalizacion = $valor;
       return $valor;
  }


}
