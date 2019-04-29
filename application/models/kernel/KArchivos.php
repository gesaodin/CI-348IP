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
		if ( $tipoNomina == 'FCP' ){
			$query = "SELECT llav, cedu, fami, conc, mont, tipo from space.nomina_archivo WHERE fami != ''  AND fami = '533320';"; // --WHERE fech BETWEEN '2019-04-01' AND '2019-04-30'";
		}else{
			$query = "SELECT llav, cedu, fami, conc, mont, tipo from space.nomina_archivo;"; // --WHERE fech BETWEEN '2019-04-01' AND '2019-04-30'";			
		}
        $obj = $this->Dbpace->consultar($query);

		$rs = $obj->rs;

		foreach ($rs as $c => $v) {
			// $mnt_aux = 0;
			// if(isset($arr[$v->conc][$v->cedu])){
			// 	$mnt_aux = $arr[$v->conc][$v->cedu];
			// }   
			// $resultado = 0;        
			if($v->tipo == 1){
				$resultado = $v->mont;
			}else  if($v->tipo == 2){				
				$resultado = $v->mont * -1 ;
			}
			$cedula = $v->cedu;
			if($v->fami != '')$cedula = $v->fami;

            $arr[$v->conc][$cedula] = $resultado;
        }
		return $arr;
	}


	public function Ejecutar($cedula = '', $concepto = '', $arr){		
		$monto = isset($arr[$concepto][$cedula])?$arr[$concepto][$cedula]:0;
		
        return $monto;
	}


}
