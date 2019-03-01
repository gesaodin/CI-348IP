<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * MamonSoft
 *
 * Estado
 *
 * @package pace\application\modules\panel\model\beneficiario
 * @subpackage utilidad
 * @author Carlos Peña
 * @copyright Derechos Reservados (c) 2015 - 2016, MamonSoft C.A.
 * @link http://www.mamonsoft.com.ve
 * @since version 1.0
 */

class MCurl extends CI_Model{


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
  var $abreviatura = '';

  /**
  * @var string
  */
  var $descripcion = '';

 /**
  * @var integer
  */
  var $codigo;



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
  * Obtener detalles del API
  *
  * @access public
  * @return void
  */
  function Cargar_API($arr){
    error_reporting(E_ALL);
    $curl = curl_init();
    $url = $arr['url'];

    curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => $url,
        CURLOPT_USERAGENT => 'Codular Sample cURL Request'
    ));
    if(isset($arr['token'])){
      curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Bearer '. $arr['token'], 'Content-Type: application/x-www-form-urlencoded;charset=UTF-8'));
    }

    $resp = curl_exec($curl);

    return ['json' => $resp, 'obj' => (object)json_decode($resp) ];
  }



}
