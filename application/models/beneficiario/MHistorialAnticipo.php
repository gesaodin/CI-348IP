<?php

/**
* 
*/
class MHistorialAnticipo extends CI_Model{
	var $fecha = '';
	var $monto = 0;
	
	
	function __construct(){
		parent::__construct();
	}

	function listar($cedula = ''){
		$arr = array();
		$sConsulta = 'SELECT f_contable, monto FROM movimiento 
		WHERE cedula=\'' . $cedula . '\' AND tipo_movimiento_id=5
		AND codigo is null
		ORDER BY f_contable ASC';
		

		$obj = $this->Dbpace->consultar($sConsulta);
		
		$rs = $obj->rs;
		foreach ($rs as $c => $v) {
			$hs = new $this->MHistorialAnticipo();
			$hs->fecha = substr($v->f_contable, 0,10);
			$hs->monto = $v->monto;
			$arr[] = $hs;
		}
		return $arr;
	}


}