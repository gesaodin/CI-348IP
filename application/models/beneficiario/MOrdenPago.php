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

class MOrdenPago extends CI_Model{


  /**
  * @var integer
  */
  var $id = NULL;

  /**
  * @var string
  */
  var $cedula_beneficiario = '';

  /**
  * @var string
  */
  var $nombre = '';

  /**
  * @var string
  */
  var $apellido = '';

  /**
  * @var string
  */
  var $emisor = '';
  
  /**
  * @var string
  */
  var $revision = '';

  /**
  * @var string
  */
  var $autoriza = '';

  /**
  * @var string
  */
  var $motivo = '';

  /**
  * @var double
  */
  var $porcentaje = 0;//se agrega para mostrar el porcentaje otorgado en el punto de cuenta

  /**
  * 100: EJECUTADA | 101: PENDIENTE | 102: RECHAZADA | 103: REVERSADA
  * @var integer
  */
  var $estatus = 101;

  /**
  * @var integer
  */
  var $movimiento = 0;

  /**
  * @var double
  */
  var $monto = '';

  /**
  * @var date
  */
  var $fecha = '';

  /**
  * @var string
  */
  var $observacion = '';

  /**
  * @var string
  */
  var $tipo = 1;

/**
  * @var string
  */
  var $tipoan = 0;

  /**
  * @var string
  */
  var $cedula_afiliado = '';

  /**
  * @var date
  */
  var $fecha_creacion = '';  

  /**
  * @var string
  */
  var $usuario_creacion = '';

  /**
  * @var date
  */
  var $fecha_modificacion = '';  

  /**
  * @var string
  */
  var $usuario_modificacion = '';

  /**
  * @var string
  */
  var $ultima_observacion = '';

  /**
  * @var string
  */
  var $grado = '';



  /**
    id integer NOT NULL DEFAULT nextval('orden_pago_id_seq'::regclass),
    cedula_beneficiario character varying(12) NOT NULL,
    nombres_beneficiario character varying(50) NOT NULL,
    apellidos_beneficiario character varying(50) NOT NULL,
    emisor character varying(50),
    revision character varying(50),
    autoriza character varying(50),
    motivo character varying(100),
    status_id integer NOT NULL,
    movimiento_id integer,
    monto numeric,
    fecha date NOT NULL,
    observacion character varying(300),
    tipo_id integer NOT NULL,
    cedula_afiliado character varying(12) NOT NULL,
    f_creacion timestamp without time zone,
    usr_creacion character varying(30),
    f_ult_modificacion timestamp without time zone,
    usr_modificacion character varying(30),
    observ_ult_modificacion character varying(400),
  **/

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
  * Obtener detalles del Cargo
  *
  * @access public
  * @return void
  */
  function obtener($id){
    
    $sConsulta = 'SELECT * FROM orden_pago WHERE id=' . $id . ';';

    $obj = $this->Dbpace->consultar($sConsulta);
    if($obj->code == 0 ){
      foreach ($obj->rs as $clv => $val) {
        $this->id = $val->id;
        $this->cedula_beneficiario = $val->cedula_beneficiario;
        $this->nombre = $val->nombres_beneficiario;
        $this->apellido = $val->apellidos_beneficiario;
        $this->emisor = $val->emisor;
        $this->revision = $val->revision;
        $this->autoriza = $val->autoriza;
        $this->motivo = $val->motivo;
        $this->porcentaje = $val->porcentaje;//se agrega para mostrar el porcentaje otorgado en el punto de cuenta
        $this->estatus = $val->status_id;
        $this->movimiento = $val->movimiento_id;
        $this->monto = $val->monto;
        $this->fecha = $val->fecha;
        $this->observacion = $val->observacion;
        $this->tipo = $val->tipo_id;
        $this->cedula_afiliado = $val->cedula_afiliado;
        $this->fecha_creacion = $val->f_creacion;
        $this->usuario_creacion = $val->usr_creacion;
        $this->fecha_modificacionc = $val->f_ult_modificacion;
        $this->usuario_modificacion = $val->usr_modificacion;
        $this->ultima_observacion = $val->observ_ult_modificacion;
      }
    }
    return $this;
  }

  public function salvar(){
    $sInsert = 'INSERT INTO orden_pago (
      cedula_beneficiario,
      nombres_beneficiario,
      apellidos_beneficiario,
      emisor,
      revision,
      autoriza,
      motivo,
      porcentaje,
      status_id,
      movimiento_id,
      monto,
      fecha,
      observacion,
      tipo_id,
      cedula_afiliado,
      f_creacion,
      usr_creacion,
      f_ult_modificacion,
      usr_modificacion,
      observ_ult_modificacion,
      tipoan
    ) VALUES (';

    $sInsert .=
      '\'' . $this->cedula_beneficiario . '\',
      \'' . $this->nombre . '\',
      \'' . $this->apellido . '\',
      \'' . $this->emisor . '\',
      \'' . $this->revision . '\',
      \'' . $this->autoriza . '\',
      \'' . $this->motivo . '\',
      \'' . $this->porcentaje . '\',
      \'' . $this->estatus . '\',
      \'' . $this->movimiento . '\',
      \'' . $this->monto . '\',
      \'' . $this->fecha . '\',
      \'' . $this->observacion . '\',' . $this->tipo . ',\'' . $this->cedula_afiliado . '\',
      \'' . $this->fecha_creacion . '\',
      \'' . $this->usuario_creacion . '\',
      \'' . $this->fecha_modificacion . '\',
      \'' . $this->usuario_modificacion . '\',
      \'' . $this->ultima_observacion . '\',' . $this->tipoan . ')';
    
    //echo $sInsert;
    $obj = $this->Dbpace->consultar($sInsert);


  }


  function actualizar(){
    $sConsulta = 'UPDATE  orden_pago SET 
        cedula_beneficiario = \'' . $this->cedula_beneficiario . '\',
        nombres_beneficiario = \'' . $this->nombre . '\',
        apellidos_beneficiario = \'' . $this->apellido . '\',
        emisor = \'' . $this->emisor . '\',
        revision = \'' . $this->revision . '\',
        autoriza = \'' . $this->autoriza . '\',
        motivo = \'' . $this->motivo . '\',
        porcentaje = \'' . $this->porcentaje . '\',
        status_id = \'' . $this->estatus . '\',
        movimiento_id = \'' . $this->movimiento . '\',
        monto = \'' . $this->monto . '\',
        fecha = \'' . $this->fecha . '\',
        observacion = \'' . $this->observacion . '\',
        tipo_id = \'' . $this->tipo . '\',
        cedula_afiliado \'' . $this->cedula_afiliado . '\',
        f_creacion = \'' . $this->fecha_creacion . '\',
        usr_creacion = \'' . $this->usuario_creacion . '\',
        f_ult_modificacion = \'' . $this->fecha_modificacionc . '\',
        usr_modificacion = \'' . $this->usuario_modificacion . '\',
        observ_ult_modificacion = \'' . $this->ultima_observacion . '\'
      WHERE 
        cedula_beneficiario = \'' . $this->cedula_beneficiario . '\';';
    $obj = $this->Dbpace->consultar($sConsulta);
  }


  public function ejecutar(){
    
    

    $sConsulta = 'UPDATE  orden_pago SET 
          status_id = \'' . $this->estatus . '\', 
          observ_ult_modificacion =\'' . $this->ultima_observacion . '\',
          emisor = \'' . $this->emisor . '\',
          revision = \'' . $this->revision . '\',
          autoriza = \'' . $this->autoriza . '\',
          f_creacion = now()
        WHERE 
          id = \'' . $this->id . '\';';
    $obj = $this->Dbpace->consultar($sConsulta);
    

  }

  public function rechazar(){

    $sConsulta = 'UPDATE  orden_pago SET 
          status_id = \'' . $this->estatus . '\'
        WHERE 
          id = \'' . $this->id . '\';';
    $obj = $this->Dbpace->consultar($sConsulta);

  }

  public function reversar(){
    $sConsulta = 'UPDATE  orden_pago SET 
          status_id = \'' . $this->estatus . '\'
        WHERE 
         cedula_afiliado = \'' . $this->cedula_afiliado . '\' AND observ_ult_modificacion = \'' . $this->ultima_observacion . '\';';
    
    $obj = $this->Dbpace->consultar($sConsulta);
  }


  /**
  * Obtener el listado de los Motivos
  *
  * @access public
  * @return void
  */
  public function listarPorCedula($id = ''){
    $lst = array();
    $sConsulta = 'SELECT * FROM orden_pago WHERE cedula_beneficiario=\'' . $id . '\' ORDER BY fecha;';
    
    $obj = $this->Dbpace->consultar($sConsulta);
    
    if($obj->code == 0 ){

      foreach ($obj->rs as $clv => $val) {
        $Orden = new $this;
        $Orden->id = $val->id;
        $Orden->cedula_beneficiario = $val->cedula_beneficiario;
        $Orden->nombre = $val->nombres_beneficiario;
        $Orden->apellido = $val->apellidos_beneficiario;
        $Orden->emisor = $val->emisor;
        $Orden->revision = $val->revision;
        $Orden->autoriza = $val->autoriza;
        $Orden->motivo = $val->motivo;
        $Orden->porcentaje = $val->porcentaje;
        $Orden->estatus = $val->status_id;
        $Orden->movimiento = $val->movimiento_id;
        $Orden->monto = $val->monto;
        $Orden->fecha = $val->fecha;
        $Orden->observacion = $val->observacion;
        $Orden->tipo = $val->tipo_id;
        $Orden->cedula_afiliado = $val->cedula_afiliado;
        $Orden->fecha_creacion = $val->f_creacion;
        $Orden->usuario_creacion = $val->usr_creacion;
        $Orden->fecha_modificacionc = $val->f_ult_modificacion;
        $Orden->usuario_modificacion = $val->usr_modificacion;
        $Orden->ultima_observacion = $val->observ_ult_modificacion;
        $lst[] = $Orden;
      }
    }
    return $lst;

  }


   /**
  * Obtener el listado de los Motivos
  *
  * @access public
  * @return void
  */
  public function listarPorFecha($desde = '', $hasta = '', $componente = ''){
    $lst = array();
    $texto = 'beneficiario.componente_id=' . $componente  . ' AND ';
    if($componente == '') $texto = '';

    $sConsulta = 'select orden_pago.id, orden_pago.cedula_beneficiario, 
    orden_pago.motivo,
    orden_pago.porcentaje,
    orden_pago.status_id,
    orden_pago.movimiento_id,
    orden_pago.monto,
    orden_pago.fecha,
    orden_pago.observacion,
    orden_pago.tipo_id,
    orden_pago.cedula_afiliado,
    orden_pago.f_creacion,
    orden_pago.usr_creacion,
    orden_pago.f_ult_modificacion,
    orden_pago.usr_modificacion,
    orden_pago.observ_ult_modificacion,
    orden_pago.nombres_beneficiario,
    orden_pago.apellidos_beneficiario,
    grado.nombre AS grado, nombres, apellidos, beneficiario.cedula from orden_pago 
      JOIN beneficiario on orden_pago.cedula_afiliado=beneficiario.cedula 
      JOIN grado ON grado.id=beneficiario.grado_id
    where ' . $texto . '
      orden_pago.f_creacion BETWEEN \'' . $desde . ' 00:00:00\' AND  \'' . $hasta . ' 23:59:59\' AND
      orden_pago.tipoan != 5 AND orden_pago.status_id = 100';

    //echo $sConsulta;

    $obj = $this->Dbpace->consultar($sConsulta);
    
    if($obj->code == 0 ){

      foreach ($obj->rs as $clv => $val) {
        $Orden = new $this;
        $Orden->id = $val->id;
        //$Orden->cedula_beneficiario = $val->cedula_beneficiario;
        $Orden->nombre = $val->nombres_beneficiario;
        $Orden->apellido = $val->apellidos_beneficiario;
        //$Orden->emisor = $val->emisor;
        //$Orden->revision = $val->revision;
        //$Orden->autoriza = $val->autoriza;
        $Orden->motivo = $val->motivo;
        $Orden->porcentaje = $val->porcentaje;
        $Orden->estatus = $val->status_id;
        $Orden->movimiento = $val->movimiento_id;
        $Orden->monto = $val->monto;
        $Orden->fecha = $val->fecha;
        $Orden->observacion = $val->observacion;
        $Orden->tipo = $val->tipo_id;
        $Orden->cedula_afiliado = $val->cedula_afiliado;
        $Orden->fecha_creacion = $val->f_creacion;
        $Orden->usuario_creacion = $val->usr_creacion;
        $Orden->grado = $val->grado;
        $Orden->fecha_modificacionc = $val->f_ult_modificacion;
        $Orden->usuario_modificacion = $val->usr_modificacion;
        $Orden->ultima_observacion = $val->observ_ult_modificacion;
        $lst[] = $Orden;
      }
    }
    return $lst;

  }

}