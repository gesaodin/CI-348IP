<?php

/**
*
*/
class KMedidaJudicial extends CI_Model{


	function __construct(){
		parent::__construct();
		if(!isset($this->Dbpace)) $this->load->model('comun/Dbpace');
    }

	
	public function Cargar($tipoNomina = ""){
		$arr = array();
		$donde = '';
		$tipo = 1;
		switch ($tipoNomina) {
			case 'NOMINA MENSUAL':
				$tipo = 1;
				break;
			case 'PAGO ESPECIAL':
				$tipo = 4;
				break;
			case 'BONO RECREACIONAL':
				$tipo = 3;
				break;
			case 'AGUINALDOS':
				$tipo = 5;
				break;
			default:
				
				break;
		}
        $query = 'SELECT cedula, nomb, pare, cben, bene,  caut, auto, ncue,  inst, tcue, ncue, tpag, fnxm
		FROM space.medidajudicial mj
		LEFT JOIN space.medidajudicialtipo mjt ON mj.tipo=mjt.oid 
		WHERE mj.estatus = 1 AND mj.tipo=' . $tipo;
        $obj = $this->Dbpace->consultar($query);

		$rs = $obj->rs;

		foreach ($rs as $c => $v) {
            $medida = array(
				'cedula' => $v->cedula, //Cedula del titula de la medida
				'nomb' => $v->nomb,	//Descripcion de la medidaa
				'pare' => $v->pare, //Parentesco
				'cben' => $v->cben, //Cedula Beneficiario
				'bene' => $v->bene, //Nombre Beneficiario
                'caut' => $v->caut, //Cedula Autorizado
				'auto' => $v->auto, //Nombre del autorizado
				'tpag' => $v->tpag, 
				'inst' => $v->inst, // Institucion bancaria
				'tcue' => $v->tcue, // Tipo de cuenta
				'ncue' => $v->ncue, // Numero de Cuenta
				'fnxm' => $v->fnxm, // Formula monto
            );
            $arr[$v->cedula][] = $medida;
        }
		return $arr;
	}


	public function Ejecutar($sb = 0.00, $estatus = 0, $fnx = ''){
		$aguinaldos = 0;
		$bono_recreacional = 0;
		$sueldo_mensual = $sb;

		if ($fnx != '') {
			try {
				$sueldo_base = $sb;
				eval('$valor = ' . $fnx);
			} catch (Throwable $t) {
				$valor = 0;
			}			
			//print_r($sueldo_mensual);
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
