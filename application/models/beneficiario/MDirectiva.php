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

class MDirectiva extends CI_Model{

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
  * @var MDirectivaDetalle
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
    $this->load->model('beneficiario/MDirectivaDetalle');
    if(!isset($this->Dbpace)) $this->load->model('comun/Dbpace');
    //$this->_obtener();
  }

  /**
  * Obtener el Objeto Directiva Asociado a un Grado
  * El codigo de grado es la relacion entre grado y detalles de la directiva
  *
  * @param int
  */
  public function iniciar($id = ''){
    //$fecha = date("Y-m-d");
    
    $fecha = '2019-01-01';
    $where = 'f_inicio < \'' . $fecha . '\'  AND f_vigencia > \'' . $fecha . '\'';
    if($id != ''){
      $where = 'directiva_sueldo.id=' . $id;
    }
    $lst = array();
    $sConsulta = 'SELECT
        A.id, A.nombre, A.numero, A.f_vigencia,
        A.f_inicio, udad_tributaria, detalle_directiva.grado_id,
        detalle_directiva.anio, detalle_directiva.sueldo_base
        FROM (SELECT * FROM directiva_sueldo
          WHERE ' . $where . ' ORDER BY f_inicio desc LIMIT 1) AS A
      JOIN
        detalle_directiva ON A.id=detalle_directiva.directiva_sueldo_id
      ORDER BY grado_id, anio;';

   //echo $sConsulta;
    //$this->load->model('beneficiario/MGrado');
    //$Grado = $this->MGrado->obtenerSegunDirectiva($this->id);

    $obj = $this->Dbpace->consultar($sConsulta);
		if($obj->code == 0 ){

      $this->id = $obj->rs[0]->id;
      //$Grado = $this->MGrado->obtenerSegunDirectiva($this->id);
      $this->nombre = $obj->rs[0]->nombre;
      $this->numero = $obj->rs[0]->numero;
      $this->fecha_inicio = $obj->rs[0]->f_inicio;
      $this->fecha_vigencia = $obj->rs[0]->f_vigencia;
      $this->unidad_tributaria = $obj->rs[0]->udad_tributaria;
      $grado = $obj->rs[0]->grado_id;
      $list = array('ut' => $obj->rs[0]->udad_tributaria,
        'fnx' => array()
        );

      $lst = array();
      $codigoop = 0;
      $rs = $obj->rs;
			foreach ($rs as $clv => $val) {
        if($grado != $val->grado_id){
          $this->Detalle[$grado . 'M'] = $Detalle;
          $grado = $val->grado_id;
        }
        $Detalle = new $this->MDirectivaDetalle();
        $Detalle->grado_id = $val->grado_id;
        $Detalle->ano_servicio = $val->anio;
        $Detalle->sueldo_base = $val->sueldo_base;

        //$Detalle->Prima = $Grado[$val->grado_id];
        $codigo = $val->grado_id . $val->anio;
        $this->Detalle[$codigo] = $Detalle;


        $lst[$codigo] = array('sb' => $val->sueldo_base,'mt' => 0);

      }

      $list['sb'] = $lst;
      $this->Detalle[$grado . 'M'] = $Detalle;

    }
    //echo '<pre>';
    //print_r($list);
    return $this;

  }


  public function obtener(MBeneficiario &$Beneficiario){
    $codigo_grado = $Beneficiario->Componente->Grado->codigo;
    $antiguedad_grado = $Beneficiario->antiguedad_grado;
    $no_ascenso =  $Beneficiario->no_ascenso;

    //echo $codigo_grado;
    //echo $Beneficiario->fecha_retiro . ' Retiro';

    $fecha = date("Y-m-d"); //$Beneficiario->fecha_retiro == '' ? date("Y-m-d") : $Beneficiario->fecha_retiro;

    //echo "<br><br>";// . $no_ascenso . ' ' . $antiguedad_grado . ' G: ' . $codigo_grado . "<br><br>";


    //Seleccion
    //Se cambio el signo de menor a signo igual en la fecha de vigencia directiva para que la leyera correctamente cuando no_ascenso>0

    $sGradoMaximo = '(SELECT max(detalle_directiva.anio) FROM
    ( SELECT * FROM directiva_sueldo WHERE f_inicio >= \'' . $fecha . '\'  AND f_vigencia > \'' . $fecha . '\' ORDER BY f_inicio desc LIMIT 1) AS A
    JOIN
            detalle_directiva ON detalle_directiva.directiva_sueldo_id=A.id
   WHERE detalle_directiva.grado_id = \'' . $codigo_grado . '\')';

   //echo $sGradoMaximo;
    if($no_ascenso > 0){
     //echo $sGradoMaximo;
     $antiguedad =  $sGradoMaximo;

    }else{

      $maximo = $this->maximoAscenso($fecha, $codigo_grado);

      if ($antiguedad_grado > $maximo){
        $antiguedad = $maximo;
      }else{
        $antiguedad = $antiguedad_grado;
      }
    }

   //$antiguedad = $no_ascenso > 0 ? $sGradoMaximo : $antiguedad_grado;

    if($antiguedad < 0) $antiguedad = 0;

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

    //echo $sConsulta;

    $obj = $this->Dbpace->consultar($sConsulta);
    $Directiva = new $this->MDirectiva();
		if($obj->code == 0 ){
      $Directiva->id = $obj->rs[0]->id;
      $Directiva->nombre = $obj->rs[0]->nombre;
      $Directiva->numero = $obj->rs[0]->numero;
      $Directiva->unidad_tributaria = $obj->rs[0]->udad_tributaria;
			foreach ($obj->rs as $clv => $val) {
        $Detalle = new $this->MDirectivaDetalle();
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

    // echo $sConsulta;

    $obj = $this->Dbpace->consultar($sConsulta);
    if($obj->code == 0 ){
      $antiguedad = $obj->rs[0]->maximo;
    }
    return $antiguedad;

  }



  public function listarTodo($id = '', $fecha = ''){
      $this->load->model('kernel/KPrimas');
      $this->load->model('kernel/KFunciones');
      $this->load->model('kernel/KConceptos');   
      
      $donde = $fecha != ''? 'f_inicio < \'' . $fecha . '\' AND f_vigencia > \'' . $fecha . '\'': 'directiva_sueldo.id=' . $id ;
  
      $lst = array();
      $sConsulta = '
        SELECT A.id, A.nombre, A.numero, A.f_vigencia, A.f_inicio,
        udad_tributaria, detalle_directiva.grado_id,
              detalle_directiva.anio, detalle_directiva.sueldo_base,
              gc.descripcion AS gnombre,
              factor, detalle_directiva.id AS iddt,salario_minimo
        FROM (SELECT * FROM directiva_sueldo
          WHERE ' . $donde . ' ORDER BY f_inicio desc LIMIT 1)
              AS A
        JOIN
          detalle_directiva ON A.id=detalle_directiva.directiva_sueldo_id
        JOIN
          grado_codigo AS gc ON detalle_directiva.grado_id=gc.codigo 
        ORDER BY grado_id, anio DESC;';  
      $obj = $this->DBSpace->consultar($sConsulta);
      if($obj->code == 0 ){
  
        $this->fecha_inicio = $obj->rs[0]->f_inicio;
        $this->fecha_vigencia = $obj->rs[0]->f_vigencia;
        $this->unidad_tributaria = $obj->rs[0]->udad_tributaria;
        $grado = $obj->rs[0]->grado_id;
        $gnombre = $obj->rs[0]->gnombre;
        $list = array(
          'oid'=>$obj->rs[0]->id,
          'salario' => $obj->rs[0]->salario_minimo,
          'f_ini' => $obj->rs[0]->f_inicio,
          'f_ven' => $obj->rs[0]->f_vigencia,
          'ut' => $obj->rs[0]->udad_tributaria,
          'fnx' => array(),
          'fnxC' => array()
        );  
        $rs = $obj->rs;
        foreach ($rs as $clv => $val) {  
          $lst[] = array(
            'cd' =>  $val->grado_id . $val->anio,
            'an' => $val->anio,
            'sb' => $val->sueldo_base,
            'ft' => $val->factor,
            'id' => $val->iddt,
            'gr' => $val->gnombre
          );
        }
        $list['sueldo'] = $lst;
      }

      $this->KFunciones->CargarDos($list);
      //$this->KPrimas->Cargar($list);
      $this->KConceptos->Cargar($list);

      return $list;
  
    
  }


  public function Actualizar($arr){
    $sConsulta = 'UPDATE detalle_directiva SET anio=' . $arr->an . ', sueldo_base=' . $arr->sb . ' WHERE id=' . $arr->id;
    return $this->Dbpace->consultar($sConsulta);
  }


  public function crearDirectiva($obj){
    $intID = $obj['id'] + 1;
    $sConsulta = 'INSERT INTO directiva_sueldo(
        id, nombre, numero, f_vigencia, udad_tributaria, observaciones,
        status_id, f_inicio, f_creacion, usr_creacion, f_ult_modificacion,
        usr_modificacion, observ_ult_modificacion, tipo_directiva, salario_minimo)
      select ' . $intID . ',\'' . $obj['nombre'] . '\' as nombre, \'' . $obj['numero'] . '\' as numero, 
        \'' . $obj['fechavigencia'] . '\' as f_vigencia, ' . $obj['unidadtributaria'] . ',
        \'' . $obj['observacion'] . '\' as observaciones,
        status_id,\'' . $obj['fechainicio'] . '\' as f_inicio,Now(),\'' . $obj['usuario'] . '\', Now(),
        \'' . $obj['usuario'] . '\',\'' . $obj['id'] . '\' as observ_ult_modificacion, tipo_directiva,
          ' . $obj['salariominimo'] . '
      FROM directiva_sueldo
      WHERE id=' . $obj['id'] . ' RETURNING id';

      $id = 0;
      $rs = $this->Dbpace->consultar($sConsulta);

      if($rs->code == 0 ){
        foreach ($rs->rs as $clv => $val) {
         $id = $val->id;
        }
      }
      $monto = 0;
      if ($obj['porcentaje'] > 0){
        $monto = 'sueldo_base  + ((sueldo_base * ' . $obj['porcentaje'] . ')/100)';
      }else if($obj['salariominimo'] > 0){
        $monto = ' factor * ' . $obj['salariominimo'];
      }
       $sConsulta = '
              INSERT INTO detalle_directiva(
                          directiva_sueldo_id, grado_id, sueldo_base, anio, status_id,
                          f_creacion, usr_creacion, f_ult_modificacion, usr_modificacion,
                          observ_ult_modificacion, factor)
              select ' . $id . ', grado_id,
              ' . $monto . ', anio, status_id,
                          Now() as f_creacion, \'' . $obj['usuario'] . '\', Now(), \'' . $obj['usuario'] . '\',
                          \'' . $obj['id'] . '\' as obser_ult_modificacion, factor
              from detalle_directiva
              where directiva_sueldo_id=' .  $obj['id'] . ' ORDER BY grado_id, anio DESC';
      
      $rs = $this->Dbpace->consultar($sConsulta);
  

      $sConsulta = 'UPDATE directiva_sueldo SET 
        f_vigencia = \'' . substr($obj['fechavigencia'],0,10) . ' 00:00:00\'::TIMESTAMP - interval \'1 day\' 
        WHERE id=' .  $obj['id'];
      $query = $sConsulta;
      $rs = $this->Dbpace->consultar($sConsulta);
      

      $sConsulta = '
      INSERT INTO prima_directiva(
        prima_id, grado_id,directiva_id,monto_nominal,monto_ut,
        status_id,f_creacion,usr_creacion,f_ult_modificacion,
        usr_modificacion,  observ_ult_modificacion)
      select 
        prima_id, grado_id,' . $id . ',monto_nominal,monto_ut,
        status_id,f_creacion,Now(),f_ult_modificacion,
        \'' . $obj['usuario'] . '\',\'' . $obj['observacion'] . '\'
      from prima_directiva where directiva_id = ' .  $obj['id'];

      $rs = $this->Dbpace->consultar($sConsulta);


      $sConsulta = 'INSERT INTO space.fnprima (oid, oidd, func)
      SELECT nextval(\'detalle_directiva_id_seq\'::regclass),' . $id . ',func 
      FROM space.fnprima where oidd='  .  $obj['id'];
      $rs = $this->Dbpace->consultar($sConsulta);

      return $query;
  }


  /**
  * Eliminar directivas
  *
  * @var int
  * @return rs
  */
  function Eliminar($id){
    $sConsulta = 'select * from directiva_sueldo where id =70;
    select * from detalle_directiva where directiva_sueldo_id =70;
    select * from prima_directiva where directiva_id=70;
    select * from space.fnprima where oidd=70;';

    $sConsulta = '
    DELETE FROM directiva_sueldo where id = ' . $id . ';
    DELETE FROM detalle_directiva where directiva_sueldo_id = ' . $id . ';
    DELETE FROM prima_directiva where directiva_id= ' . $id . ';
    DELETE FROM space.fnprima where oidd= ' . $id;

    $rs = $this->Dbpace->consultar($sConsulta);
    return $rs;
  }
    
  function ActualizarDetalle($arr){
    $cad = '';
    foreach ($arr as $key => $v) {
      $sConsulta = 'UPDATE detalle_directiva SET factor=' . $v['factor'] . ', sueldo_base =' . $v['monto'] . ' WHERE id =' . $v['id'];
      $obj = $this->Dbpace->consultar($sConsulta);
      $cad = $sConsulta; 
    }
    return $cad;

  }
}
