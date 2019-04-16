<?php

/**
*
*/
class KArchivos extends CI_Model{


	function __construct(){
		parent::__construct();
		if(!isset($this->Dbpace)) $this->load->model('comun/Dbpace');
    }

	
	public function Cargar($tipoNomina = ""){
		$arr = array();
		$donde = '';
		$tipo = 1;
		
        $query = "SELECT cedu, conc, mont from space.nomina_archivo WHERE tipo ='2' AND fech BETWEEN '2019-04-01' AND '2019-04-30'";
        $obj = $this->Dbpace->consultar($query);

		$rs = $obj->rs;

		foreach ($rs as $c => $v) {            
            $arr[$v->conc][$v->cedu] = $v->mont;
        }
		return $arr;
	}


	public function Ejecutar($cedula = '', $concepto = '', $arr){
        return isset($arr[$concepto][$cedula])?$arr[$concepto][$cedula]:0;		
	}


}
