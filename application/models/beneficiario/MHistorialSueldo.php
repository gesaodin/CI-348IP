<?php

/**
* 
*/
class MHistorialSueldo extends CI_Model{
	var $fecha = '';
	var $sueldo_base = 0;
	var $sueldo_global = 0;	
	
	function __construct(){
		parent::__construct();
		if(!isset($this->Dbpace)) $this->load->model('comun/Dbpace');
	}

	function listar($cedula = ''){
		$arr = array();
		$sConsulta = 'SELECT * FROM historial_sueldo WHERE cedula=\'' . $cedula . '\'';
		$obj = $this->Dbpace->consultar($sConsulta);
		
		$rs = $obj->rs;
		foreach ($rs as $c => $v) {
			$hs = new $this->MHistorialSueldo();
			$hs->fecha = $v->fecha;
			$hs->sueldo_base = $v->sueldo_base;
			$hs->sueldo_global = $v->sueldo_global;
			$arr[] = $hs;
		}
		return $arr;
	}

	public function listarPorComponente($idComponente = 0){
		$sConsulta = 'SELECT 
										beneficiario.cedula AS cedula, movimiento.tipo_movimiento_id, 
										SUM(movimiento.monto) AS monto, MAX(f_contable) AS f_contable FROM beneficiario 
										JOIN movimiento ON beneficiario.cedula=movimiento.cedula
									WHERE beneficiario.status_id=201 AND movimiento.tipo_movimiento_id != 99
									AND beneficiario.componente_id = ' . $idComponente . '
									 GROUP BY beneficiario.cedula, movimiento.tipo_movimiento_id';
	  $obj = $this->Dbpace->consultar($sConsulta);
		$lst = array();
		$lstH = array();
		$ced = 0;
		$i = 0;
		foreach ($obj->rs as $clv => $val) {		
			if($ced != $val->cedula){
				$lstH = array();
				$ced = $val->cedula;
			}
			$lstH[$val->tipo_movimiento_id] = array('monto' => $val->monto, 'fecha' => $val->f_contable ); 
			$lst[$ced] = $lstH;
			$i++;				
		}
		/**
		echo '<pre>';		
		print_r($lst);
		echo 'Registros Consultados: ' . $i . '<br><br>';
		**/
		return $lst;
	}


}