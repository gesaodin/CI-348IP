<?php 
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * MamonSoft 
 *
 * Anomalias
 * La semilla, simiente o pepita es cada uno de los cuerpos que forman 
 * parte del fruto que da origen a una nueva planta; es la estructura mediante 
 * la cual realizan la propagación las plantas que por ello se llaman 
 * espermatofitas (plantas con semilla). 
 *
 * @package ipsfa-bss\application\model
 * @subpackage utilidad
 * @author Carlos Peña
 * @copyright Derechos Reservados (c) 2015 - 2016, MamonSoft C.A.
 * @link http://www.mamonsoft.com.ve
 * @since version 1.0
 */


class Utilidad extends CI_Model{

	var $__SISTEM = NULL;

	var $esq = 'bss';

	var $esq_sess = 'session';
	
	function __construct(){
		parent::__construct();
		$this->load->model('comun/Dbpace', 'Dbpace');
	}



	function __destruct(){

	}

	

}