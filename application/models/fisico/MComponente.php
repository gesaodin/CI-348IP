<?php 
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * MamonSoft 
 *
 * Componente
 *
 * @package pace\application\modules\panel\model\beneficiario
 * @subpackage utilidad
 * @author Carlos Peña
 * @copyright Derechos Reservados (c) 2015 - 2016, MamonSoft C.A.
 * @link http://www.mamonsoft.com.ve
 * @since version 1.0
 */

class MComponente extends CI_Model{

  /**
  * @var striing
  */
  var $id = null;

  /**
  * @var striing
  */
  var $nombre = '';

  /**
  * @var striing
  */
  var $descripcion = '';

  /**
  * @var MGrado
  */
  var $Grado;

  /**
  * @var MGrado
  */
  var $ListadoGrado = array();

  /**
  * Iniciando la clase, Cargando Elementos Pace
  *
  * @access public
  * @return void
  */
  public function __construct(){
    parent::__construct();
    $this->load->model('fisico/MGrado');
    $this->Grado = new $this->MGrado();
    if(!isset($this->DBSpace)) $this->load->model('comun/DBSpace');
  }

  /**
  * @return MComponete  Array
  */
  public function listarTodo(){
    $lst = array();
    $sConsulta = 'SELECT * FROM componente';

    $obj = $this->DBSpace->consultar($sConsulta);
    if($obj->code == 0 ){
      foreach ($obj->rs as $clv => $val) {
        $lst[] = array(
            'id' => $val->codigo,
            'nomb' => $val->nombre,
            'desc' => $val->descripcion
        );        
      }
    }
    return $lst;
  }


  /**
  * @param int | Componente ID
  * @param int | Grado ID
  * @return MComponete 
  */
  public function ObtenerConGrado($cid, $gid){
    $sConsulta = 'SELECT grado.id AS gid, grado.codigo AS gcod, grado.nombre AS gnomb, grado.descripcion AS gdesc,
      componente_id AS cid, componente.nombre as cnomb, componente.descripcion as cdesc 
      FROM componente 
      JOIN grado ON componente.id = grado.componente_id
      WHERE componente.id=' . $cid . ' AND grado.id=' . $gid;
    //echo  $sConsulta;
    $obj = $this->DBSpace->consultar($sConsulta);
    if($obj->code == 0 ){
      foreach ($obj->rs as $clv => $val) {
        $this->id = $val->cid;
        $this->nombre = $val->cnomb;
        $this->descripcion = $val->cdesc;
        $this->Grado->id = $val->gid;
        $this->Grado->codigo = $val->gcod;
        $this->Grado->nombre = $val->gnomb;
        $this->Grado->descripcion = $val->gdesc;
      }
    }
  }

  /**
  * @param int | Componente ID
  * @return array 
  */
  public function Listar($id){

    

    $sConsulta = 'SELECT grado.id AS gid, grado.codigo AS gcod, grado.nombre AS gnomb, grado.descripcion AS gdesc,
      componente_id AS cid, componente.nombre as cnomb, componente.descripcion as cdesc 
      FROM componente 
      JOIN grado ON componente.id = grado.componente_id
      WHERE componente.id=' . $id;
    
    $obj = $this->DBSpace->consultar($sConsulta);
    $lstComponente = array();

    if($obj->code == 0 ){
      foreach ($obj->rs as $clv => $val) {
        $this->id = $val->cid;
        $this->nombre = $val->cnomb;
        $this->descripcion = $val->cdesc;
        $Grado = new $this->MGrado();
        $Grado->id = $val->gid;
        $Grado->codigo = $val->gcod;
        $Grado->nombre = $val->gnomb;
        $Grado->descripcion = $val->gdesc;
        $this->ListadoGrado[] = $Grado;
      }
    }

    return $this;
     
  }

  
}