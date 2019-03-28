<?php

/**
*
*/
class KMedidaJudicial extends CI_Model{


	function __construct(){
		parent::__construct();
		if(!isset($this->Dbpace)) $this->load->model('comun/Dbpace');
    }

	
	public function Cargar(){
		$arr = array();
		$donde = '';
        $query = 'SELECT cedula, tpag, fnxm, caut, auto, ncue  FROM space.medidajudicial';
        $obj = $this->Dbpace->consultar($query);

		$rs = $obj->rs;

		foreach ($rs as $c => $v) {
            $medida = array(
                'tpag' => $v->tpag,
                'fnxm' => $v->fnxm,
                'caut' => $v->caut,
                'auto' => $v->auto,
                'ncue' => $v->ncue
            );
            $arr[$v->cedula][] = $medida;
        }
		return $arr;
	}


	public function Ejecutar($sb = 0.00, $estatus = 0, $fnx = ''){
		if ($fnx != '') {
			try {
				$sueldo_base = $sb;
				eval('$valor = ' . $fnx);
			} catch (Throwable $t) {
				$valor = 0;
			}			
			return round($valor,2);
		}else{
			return 0;
		}


		
	}

	public function Suspender($id = '', $estatus = 0){
		if ($id != ''){
			$sModificar = 'UPDATE space.medidajudicial SET status_id = ' . $estatus . '  WHERE id=' . $id;
			$this->Dbpace->consultar($sModificar);
		}
	}
}
