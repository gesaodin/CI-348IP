<?php

/**
*
*/
class KRecibo extends CI_Model{
    var $conceptos = array();
    var $asignaciones = 0.00;
    var $deducciones = 0.00;

	function __construct(){
		parent::__construct();
		if(!isset($this->Dbpace)) $this->load->model('comun/Dbpace');
    }

	


}
