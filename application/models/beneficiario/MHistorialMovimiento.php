<?php

/**
* 
*/
class MHistorialMovimiento extends CI_Model{
	var $id = '';
	
	var $tipo = 0;
	
	var $transaccion_id = 0;

	var $fecha = '';
	
	var $motivo = 0;

	var $detalle = '';

	var $observacion = '';

	var $monto = 0.00;	

	var $monto_aux = '0,00';	
	
	var $fecha_creacion = 0;

	var $partida = '';

	var $partida_des = '';

	var $codigo = '';



	function __construct(){
		parent::__construct();
		if(!isset($this->Dbpace)) $this->load->model('comun/Dbpace');
	}


	 /**
  * 
  *
  * @access public
  * @return void
  */
  function listarTodo(){
    $sConsulta = 'SELECT * FROM tipo_movimiento WHERE status_id != 0';

    $obj = $this->Dbpace->consultar($sConsulta);
    //echo $sConsulta;
    $arr = array();
    if($obj->code == 0 ){
      foreach ($obj->rs as $clv => $val) {        
        $arr[] = array(
        	'id' => $val->id,
         	'nomb' => strtoupper($val->nombre), 
         	'desc' => $val->descripcion
         );
      }
    }
    return $arr;

  }

	function listar($cedula = ''){
		$arr = array();
		$sConsulta = 'select tipo_movimiento_id, sum(monto) AS monto, MAX(f_contable) AS f_contable from movimiento where cedula =\'' . $cedula . '\' GROUP BY tipo_movimiento_id';
		$obj = $this->Dbpace->consultar($sConsulta);
		//echo $sConsulta;
		$rs = $obj->rs;
		foreach ($rs as $c => $v) {
			$hm = new $this->MHistorialMovimiento();
			$hm->id = $v->tipo_movimiento_id;
			$hm->fecha = substr($v->f_contable, 0, 10);
			$hm->monto = $v->monto;
			$arr[$hm->id] = $hm;
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

		return $lst;
	}


	function listarDetalle($cedula = '', $tipo = 0){
		$arr = array();
		$Detalle = array();
		$Comparacion = array();
		$sDonde = '';
		if($tipo > 0) $sDonde = ' AND tipo_movimiento_id=\'' . $tipo . '\' ';
		$sConsulta = 'SELECT movimiento.id, movimiento.codigo, movimiento.motivo_id, partida_id, tipo_movimiento_id, 
			transaccion_id, monto, observaciones, f_contable, f_creacion, partida.codigo AS partida, tipo_movimiento.nombre AS movnombre
			FROM movimiento 
				LEFT JOIN tipo_movimiento ON movimiento.tipo_movimiento_id=tipo_movimiento.id 
				LEFT JOIN partida ON movimiento.partida_id=partida.id
 			WHERE cedula =\'' . $cedula . '\'' .  $sDonde . '
			ORDER BY tipo_movimiento_id';
		$obj = $this->Dbpace->consultar($sConsulta);	
		//print_r($obj);

		$rs = $obj->rs;		
		if(count($rs) > 0){
			$id_aux = $rs[0]->tipo_movimiento_id;
			foreach ($rs as $c => $v) {
				$hm = new $this->MHistorialMovimiento();
				$hm->id = $v->id;
				$hm->tipo = $v->tipo_movimiento_id;
				$hm->motivo = $v->motivo_id;
				$hm->codigo = $v->codigo;
				$hm->fecha = substr($v->f_contable, 0, 10);
				$hm->fecha_creacion = substr($v->f_creacion, 0, 10);
				//echo $v->observaciones . "<br>";
				$hm->detalle = $v->movnombre;
				$hm->observacion = $v->observaciones;
				$hm->monto = $v->monto;	
				$hm->monto_aux =  number_format($v->monto, 2, ',','.');	
				$hm->partida = $v->partida_id;	
				$hm->partida_des = $v->partida;

				if($hm->tipo != $id_aux){				
					$Detalle[$id_aux] = $arr;
					$arr = array();
					$id_aux = $hm->tipo;
				}
				$arr[] = $hm;
			}		
			$Detalle[$id_aux] = $arr;
			$Comparacion = $this->compararDetalles($Detalle);
		}
		$data = array('Detalle' => $Detalle, 'Comparacion' => $Comparacion);
		return $data;
	}


	function compararDetalles($arr = array()){
		$Padre = array();
		$Auxiliar = array();
		$valores = array(5, 9,10,12,13,14,15,16,17,27);
		$cant = count($valores);
		for ($i=0; $i < $cant; $i++) { 
			$pos = $valores[$i];
			
			if(isset($arr[$pos])){
				foreach ($arr[$pos] as $clave => $valor) {
					$cont = $this->__conversion($pos);	
					$A['id'] =  $valor->id;
					$A['monto'] =  $valor->monto;
					$A['fecha_contable'] =  $valor->fecha;
					$A['fecha_creacion'] =  $valor->fecha_creacion;
					$A['observacion'] =  $valor->observacion;
					$A['motivo'] =  $valor->motivo;

					$A['codigo'] =  $valor->codigo;
					$A['tipo_texto'] = $pos == 5? 'Activo' : 'Finiquito';
					$A['partida'] = $valor->partida;
					$A['partida_des'] = $valor->partida_des;

					if(isset($arr[$cont])){					
						foreach ($arr[$cont] as $c => $v) {
							
							if($valor->monto == $v->monto && $valor->codigo == $v->codigo){ 
								$A['tipo_texto'] = 'Reverso';
							}//Fin Si

						} //Fin Foreach

					}//Fin Si (isset)
					$Auxiliar[] = $A;

				}//Fin foreach
				$Padre[$pos] = $Auxiliar;
				$Auxiliar = null;
			}//Fin de (isset)

		}//Fin de Repita Para
		return $Padre;
	}

	
	/**
	*	Permite realizar comparacion entre conceptos con sus reversos 
	*	tabla(movimiento | tipo_movimiento)
	*
	*	@param int
	*	@return int
	*/
	private function __conversion($id = 0){
		$valor = 0;
		switch ($id) {
			case 5: 
				$valor = 25;
				break;
			case 9:
				$valor = 18;
				break;
			case 10:
				$valor = 19;
				break;
			case 12:
				$valor = 20;
				break;
			case 13:
				$valor = 21;
				break;
			case 14:
				$valor = 22;
				break;
			case 15:
				$valor = 23;
				break;
			case 16:
				$valor = 24;
				break;
			case 17:
				$valor = 26;
				break;
			case 27:
				$valor = 34;
				break;
			case 28:
				$valor = 36;
				break;
			case 35:
				$valor = 37;
				break;
			default:
				# code...
				break;
		}
		return $valor;
	}

	function Insertar($obj)
	{
		
		$sInsert_aux = 'INSERT INTO public.movimiento 
			(
				tipo_movimiento_id,
				monto,
				cedula, 
				observaciones, 
				f_contable, 
				status_id,				 
				motivo_id, 
				f_creacion, 
				usr_creacion, 
				f_ult_modificacion, 
				usr_modificacion, 
				observ_ult_modificacion
				
			) VALUES ';
		$sInsert_aux .= '(' . 
					$obj['tipo_movimiento'] . ',' . 
					$obj['monto'] . ',\'' . 
					$obj['cedula'] .'\',\'' . 
					$obj['o_b'] . '\',\''  .  
					$obj['f_contable'] . 
					'\',280,' . 
					$obj['motivo_id'] . ',\''  .  
					date("Y-m-d H:i:s") . '\',\''  .  
					$_SESSION['usuario'] . '\',\''  .  
					date("Y-m-d H:i:s") . '\',\''  .  
					$_SESSION['usuario'] . '\',\'' . 
					$obj['o_b'] . '\')'; 
		//print_r($sInsert_aux);
	 	$obj = $this->Dbpace->consultar($sInsert_aux);		
		return $sInsert_aux;


	}

	function InsertarDetalle($obj){
		//ID - AUTOINCREMENT
		//status_id - 280
		//$sInsert
		$sInsert = '';

		$this->codigo = substr(md5($obj->i_d . date("Y-m-d H:i:s")), 0, 20);

		$sInsert_aux = 'INSERT INTO public.movimiento 
			(
				tipo_movimiento_id,
				monto,
				cedula, 
				observaciones, 
				f_contable, 
				status_id,				 
				motivo_id, 
				f_creacion, 
				usr_creacion, 
				f_ult_modificacion, 
				usr_modificacion, 
				observ_ult_modificacion, 
				partida_id,
				codigo			
			) VALUES ';


		//5
		if($obj->t_an != 0)$sInsert = $sInsert_aux . $this->valorRepetido(5, $obj, $obj->t_an) . ';';

		//9
		//if($obj->t_bx != 0)$sInsert .= $this->valorRepetido(9, $obj, $obj->t_bx);
		if($obj->t_bx != 0)$sInsert = $sInsert_aux . $this->valorRepetido(9, $obj, $obj->t_bx) . ';';


		//10
		//if($obj->a_i != 0) $sInsert .= ',' . $this->valorRepetido(10, $obj, $obj->a_i);
		if($obj->a_i != 0)$sInsert .= $sInsert_aux . $this->valorRepetido(10, $obj, $obj->a_i) . ';';

		//12 CAUSA MUERTE
		if($obj->m_f == 9){
			if($obj->m_asaf != 0)$sInsert .= $sInsert_aux . $this->valorRepetido(12, $obj, $obj->m_asaf) . ';';
		}

		//13 ACTOS DE SERVICIO
		if($obj->m_f == 10){
			if($obj->m_asaf != 0)$sInsert .= $sInsert_aux . $this->valorRepetido(13, $obj, $obj->m_asaf) . ';';
		}

		//14
		//if($obj->a_ax != 0)$sInsert .= ',' . $this->valorRepetido(14, $obj, $obj->a_ax);
		if($obj->a_ax != 0)$sInsert .= $sInsert_aux . $this->valorRepetido(14, $obj, $obj->a_ax) . ';';

		//15
		//if($obj->m_d != 0) $sInsert .= ',' . $this->valorRepetido(15, $obj, $obj->m_d);
		if($obj->m_d != 0)$sInsert .= $sInsert_aux . $this->valorRepetido(15, $obj, $obj->m_d) . ';';

		//16
		//if($obj->m_r != 0)$sInsert .= ',' . $this->valorRepetido(16, $obj, $obj->m_r);
		if($obj->m_rx != 0)$sInsert .= $sInsert_aux . $this->valorRepetido(16, $obj, $obj->m_rx) . ';';
		
		if(isset($obj->t_e)){
			if($obj->t_e != 0)$sInsert .= $sInsert_aux . $this->valorRepetido(27, $obj, $obj->t_e) . ';';
		}



		//echo $sInsert;
		$obj = $this->Dbpace->consultar($sInsert);		
		return $this->codigo;

	}


 	private function valorRepetido($cod, $obj, $mnt){
	 	$sCodigo = '(' . $cod . ',' . $mnt . ',\'' . $obj->i_d . '\',\'' . 
							strtoupper($obj->m_ft) . '\',\''  .  $obj->f_r . '\',280,' . $obj->m_f . ',\''  .  date("Y-m-d H:i:s") . '\',\''  .  
							$_SESSION['usuario'] . '\',\''  .  date("Y-m-d H:i:s") . '\',\''  .  $_SESSION['usuario'] . '\',\'' . $obj->o_b . '\',' . 
							$obj->p_p . ',\'' . $this->codigo . '\')'; 
	 	return $sCodigo;

	}

	function isertarReverso($listado){

		$sInsert = '';
        

		$sInsert_aux = 'INSERT INTO public.movimiento 
			(
				tipo_movimiento_id,
				monto,
				cedula, 
				observaciones, 
				f_contable, 
				status_id,				 
				motivo_id, 
				f_creacion, 
				usr_creacion, 
				f_ult_modificacion, 
				usr_modificacion, 
				observ_ult_modificacion, 
				partida_id,
				codigo			
			) VALUES ';
			
			$cant = count($listado) - 1;
			for($i = 0; $i <= $cant; $i++) {
				$sInsert .= $sInsert_aux . '(' . 
					$this->__conversion($listado[$i]['tipo_movimiento_id']) . ',' . 
					$listado[$i]['monto'] . ',\'' . 
					$listado[$i]['cedula'] . '\',\'REVERSADO - ' . 
					$listado[$i]['observaciones'] . '\',\''  .  
					$listado[$i]['f_contable'] . '\',280,' . 
					$listado[$i]['motivo_id'] . ',\''  .  
					date("Y-m-d H:i:s") . '\',\''  .  
					$_SESSION['usuario'] . '\',\''  .  
					date("Y-m-d H:i:s") . '\',\''  .  
					$_SESSION['usuario'] . '\',\'' . 
					$listado[$i]['observ_ult_modificacion'] . '\',' . 
					$listado[$i]['partida_id']. ',\'' . 
					$listado[$i]['codigo'] . '\');'; 
			}

		
		$obj = $this->Dbpace->consultar($sInsert);

	}

	function mapearObjetoLote() {
	    $data = array(
	    	'cedula' => $this -> identificador, 
	    	'transaccion_id' => $this -> nombre, 
	    	'status_id' => $this -> ubicacion, 
	    	'tipo_movimiento_id' => $this -> observacion
	    );
		return $data;
	}

}