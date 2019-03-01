<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * MamonSoft C.A
 *
 * Directiva de Sueldos Establece las reglas para la base del calculo
 *
 * @package pace\application\modules\panel\model\beneficiario
 * @subpackage utilidad
 * @author Carlos Peña
 * @copyright Derechos Reservados (c) 2015 - 2016, MamonSoft C.A.
 * @link http://www.mamonsoft.com.ve
 * @since version 1.0
 */

class KDirectiva extends CI_Model{

  /**
  * @var string
  */
  var $id = null;

  /**
  * @var string
  */
  var $nombre = '';

  /**
  * @var string
  */
  var $numero = '';

  /**
  * @var string
  */
  var $fecha_inicio = '';

  /**
  * @var string
  */
  var $fecha_vigencia = '';

  /**
  * @var double
  */
  var $unidad_tributaria = 0;

  /**
  * @var KDirectivaDetalle
  */
  var $Detalle = array();
  /**
  * Iniciando la clase, Cargando Elementos Pace
  *
  * @access public
  * @return void
  */
  public function __construct(){
    parent::__construct();
    if(!isset($this->DBSpace)) $this->load->model('comun/DBSpace');
    $this->load->model('kernel/KDirectivaDetalle');
  }

  /**
  * Obtener el Objeto Directiva Asociado a un Grado
  * El codigo de grado es la relacion entre grado y detalles de la directiva
  *
  * @param int
  */
  public function Cargar($id = '', $fecha = ''){
    $this->load->model('kernel/KPrimas');
    $this->load->model('kernel/KFunciones');
    $this->load->model('kernel/KConceptos');   
    
    $donde = $fecha != ''? 'f_inicio < \'' . $fecha . '\' AND f_vigencia > \'' . $fecha . '\'': 'id=' . $id ;

    $lst = array();
    $sConsulta = '
        SELECT A.id, A.nombre, A.numero, A.f_vigencia, A.f_inicio,
          udad_tributaria, detalle_directiva.grado_id,
                detalle_directiva.anio, detalle_directiva.sueldo_base,
                grado.nombre AS gnombre,componente.id AS compid,
                componente.descripcion AS cnombre
        FROM (SELECT * FROM directiva_sueldo
          WHERE ' . $donde . ' ORDER BY f_inicio desc LIMIT 1)
              AS A
        JOIN
          detalle_directiva ON A.id=detalle_directiva.directiva_sueldo_id

        JOIN
          grado ON detalle_directiva.grado_id=grado.codigo
        JOIN
          componente ON grado.componente_id=componente.id
        ORDER BY grado_id, anio;';




    $obj = $this->DBSpace->consultar($sConsulta);
    if($obj->code == 0 ){

      $this->fecha_inicio = $obj->rs[0]->f_inicio;
      $this->fecha_vigencia = $obj->rs[0]->f_vigencia;
      $this->unidad_tributaria = $obj->rs[0]->udad_tributaria;
      $grado = $obj->rs[0]->grado_id;
      $gnombre = $obj->rs[0]->gnombre;
      $componente = array();
      $list = array(
        'oid'=>$obj->rs[0]->id,
        'ut' => $obj->rs[0]->udad_tributaria,
        'fnx' => array(),
        'com' => array(),
        'fnxC' => array()
        );

      $rs = $obj->rs;
        //print_r($rs);
      foreach ($rs as $clv => $val) {
        if($grado != $val->grado_id){
          $lst[$grado . 'M'] = array('sb' => $sueldo,'mt' => array(), 'gr' => $gnombre);
          $grado = $val->grado_id;
          $gnombre = $val->gnombre;
        }
        $codigo = $val->grado_id . $val->anio;
        $sueldo = $val->sueldo_base;
        $lst[$codigo] = array('sb' => $sueldo);
        $componente[$val->compid] = $val->cnombre;
      }
      $lst[$grado . 'M'] = array('sb' => $sueldo,'mt' => array(), 'gr' =>  $gnombre);
      $list['sb'] = $lst;
    }
    $list['com'] = $componente;
    $this->KFunciones->Cargar($list);
    //print_r($this->KFunciones);
    $this->KPrimas->Cargar($list);
    $this->KConceptos->Cargar($list);
    // print_r($list);
    return $list;

  }


  public function obtener(MBeneficiario &$Beneficiario){
    $codigo_grado = $Beneficiario->Componente->Grado->codigo;
    $antiguedad_grado = $Beneficiario->antiguedad_grado;
    $no_ascenso =  $Beneficiario->no_ascenso;
    $fecha = $Beneficiario->fecha_retiro == '' ? date("Y-m-d") : $Beneficiario->fecha_retiro;
    $sGradoMaximo = '(SELECT max(detalle_directiva.anio) FROM
    ( SELECT * FROM directiva_sueldo WHERE f_inicio < \'' . $fecha . '\'
    AND f_vigencia > \'' . $fecha . '\' ORDER BY f_inicio desc LIMIT 1) AS A
    JOIN detalle_directiva ON detalle_directiva.directiva_sueldo_id=A.id
    WHERE detalle_directiva.grado_id = \'' . $codigo_grado . '\')';


    if($no_ascenso > 0){
     $antiguedad =  $sGradoMaximo;
    }else{

      $maximo = $this->maximoAscenso($fecha, $codigo_grado);

      if ($antiguedad_grado > $maximo){
        $antiguedad = $maximo;
      }else{
        $antiguedad = $antiguedad_grado;
      }
    }


    $sConsulta = 'SELECT A.id, A.nombre, A.numero, A.f_vigencia,
        A.f_inicio, udad_tributaria, detalle_directiva.grado_id,
        detalle_directiva.anio, detalle_directiva.sueldo_base
        FROM (SELECT * FROM directiva_sueldo
              WHERE f_inicio <= \'' . $fecha . '\'  AND f_vigencia >= \'' . $fecha . '\'    ORDER BY f_inicio desc LIMIT 1) AS A
        JOIN
          detalle_directiva ON A.id=detalle_directiva.directiva_sueldo_id
        WHERE
          grado_id = ' . $codigo_grado . ' AND anio= ' . $antiguedad . '
        ORDER BY grado_id;';


    $obj = $this->DBSpace->consultar($sConsulta);
    $Directiva = new $this->KDirectiva();
		if($obj->code == 0 ){
      $Directiva->id = $obj->rs[0]->id;
      $Directiva->nombre = $obj->rs[0]->nombre;
      $Directiva->numero = $obj->rs[0]->numero;
      $Directiva->unidad_tributaria = $obj->rs[0]->udad_tributaria;
			foreach ($obj->rs as $clv => $val) {
        $Detalle = new $this->KDirectivaDetalle();
        $Detalle->grado_id = $val->grado_id;
        $Detalle->ano_servicio = $val->anio;
        $Detalle->sueldo_base = $val->sueldo_base;
        $Beneficiario->sueldo_base = $val->sueldo_base;
        $Beneficiario->sueldo_base_aux = number_format($val->sueldo_base, 2, ',','.');
        $Beneficiario->grado_codigo = $val->grado_id;
        $codigo = $val->grado_id . $antiguedad_grado;
        $Directiva->Detalle[$codigo] = $Detalle;
      }

    }
    return $Directiva;
  }


  /**
  * Establece el máximo año por grado en el asceso
  *
  * @var date
  * @var int
  * @return int
  */
  private function maximoAscenso($fecha, $grado){
    $antiguedad = 0;
    $sConsulta = 'SELECT max(detalle_directiva.anio) AS maximo, detalle_directiva.grado_id FROM
    ( SELECT * FROM directiva_sueldo WHERE f_inicio <= \'' . $fecha . '\'  AND f_vigencia >= \'' . $fecha . '\' ORDER BY f_inicio desc LIMIT 1) AS A
    JOIN
            detalle_directiva ON detalle_directiva.directiva_sueldo_id=A.id
    WHERE detalle_directiva.grado_id = \'' . $grado . '\'
            GROUP BY detalle_directiva.grado_id';


    $obj = $this->DBSpace->consultar($sConsulta);
    if($obj->code == 0 ){
      $antiguedad = $obj->rs[0]->maximo;
    }
    return $antiguedad;

  }

  /**
  * Listar para el FrameWork
  **/
  function listarTodo(){
    $sConsulta = 'SELECT id,nombre,numero FROM directiva_sueldo ORDER BY id DESC;';
    $obj = $this->DBSpace->consultar($sConsulta);

    return $obj->rs;
  }

}
