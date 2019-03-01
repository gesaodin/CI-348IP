<?php

/**
* 
*/
class MMedidaJudicial extends CI_Model{
	
	/**
	*	@var int
	*/
	var $id = 0;

	/**
	* @var date
	*/
	var $fecha = '';
	
	/**
	*	1 : Asignacion de Antiguedad | 2 : Intereses
	*	@var int
	*/
	var $tipo = 0;

	/**
	* @var string
	*/
	var $numero_oficio = '';

	/**
	* @var string
	*/
	var $descripcion_embargo = '';

	/**
	* @var string
	*/
	var $institucion = '';

	/**
	* @var string
	*/
	var $forma_pago = 0;

	/**
	* @var string
	*/
	var $forma_pago_text = '';

	/**
	* @var string
	*/
	var $cedula_beneficiario = '';

	/**
	* @var string
	*/
	var $nombre_beneficiario = '';

	/**
	* @var string
	*/
	var $numero_beneficiario = 0;


	/**
	* @var integer
	*/
	var $estaus = 0;
	
	/**
	* @var string
	*/
	var $estatus_nombre = 0;

	/**
	* @var string
	*/
	var $tipo_nombre = 0;

	/**
	* @var string
	*/
	var $parentesco = 0;


	/**
	* @var string
	*/
	var $parentesco_nombre = '';

	/**
	* @var string
	*/
	var $tipo_medida = 0;

	/**
	* @var string
	*/
	var $salario = 0;

	/**
	* @var string
	*/
	var $unidad_tributaria = 0;

	/**
	* @var string
	*/
	var $nombre_autoridad = '';

	/**
	* @var string
	*/
	var $cargo = '';

	/**
	* @var string
	*/
	var $motivo = 1;

	/**
	* @var string
	*/
	var $cedula = '';

	/**
	* @var string
	*/
	var $cedula_autorizado = '';

	/**
	* @var string
	*/
	var $nombre_autorizado;

	/**
	* @var string
	*/
	var $fecha_creacion = '';

	/**
	* @var string
	*/
	var $usuario_creacion = '';

	/**
	* @var string
	*/
	var $fecha_modificacion = '';

	/**
	* @var string
	*/
	var $usuario_modificacion = '';

	/**
	* @var string
	*/
	var $ultima_observacion = '';


	/**
	* @var string
	*/
	var $estado = 0;

	/**
	* @var string
	*/
	var $ciudad = 0;

	/**
	* @var string
	*/
	var $municipio = 0;

	/**
	* @var string
	*/
	var $numero_expediente = '';

	/**
	* @var int
	*/
	var $porcentaje = 0;

	/**
	* @var double
	*/
	var $monto = 0;

	/**
	* @var double
	*/
	var $estatus = 0;

	function __construct(){
		parent::__construct();
	}

	public function listar($cedula = '', $fecha_r = '', $estaus = false){
		$arr = array();

		$estatus_val = $fecha_r == '' ? 'status_id = 220' : 'status_id=223';
		
		$sEstatus = 'status_id IN(220, 223)';

		if($estaus == true){
			$sEstatus = 'status_id = 220';
		}

		$sConsulta = 'SELECT porcentaje, total_monto, tipo_medida_id 
		FROM medida_judicial 
		WHERE cedula=\'' . $cedula . '\' AND ' . $sEstatus . ' AND tipo_medida_id=1     ';
		$obj = $this->DBSpace->consultar($sConsulta);
		
		$rs = $obj->rs;
		foreach ($rs as $c => $v) {
			$mdj = new $this->MMedidaJudicial();
			//$mdj->fecha = $v->f_documento;
			
			$mdj->porcentaje = $v->porcentaje;
			$mdj->monto = $v->total_monto;
			//$mdj->numero_expediente = $v->nro_expediente;
			$mdj->tipo = $v->tipo_medida_id;
			
			$arr[$v->tipo_medida_id] = $mdj;
		}
		return $arr;
	}

	public function listarTodo($cedula = ''){
		$arr = array();
		$sConsulta = 'select *,medida_judicial.id AS medida_id, medida_judicial.status_id AS estatus, status.nombre as estatus_nombre, 
			tipo_medida.nombre AS tipo_nombre, 			
			estado.nombre AS estado_nombre
			from medida_judicial
			JOIN status ON status.id=medida_judicial.status_id
			JOIN tipo_medida ON tipo_medida.id=medida_judicial.tipo_medida_id			
			JOIN municipio ON municipio.id=medida_judicial.municipio_id
			JOIN ciudad ON municipio.ciudad_id=ciudad.id
			JOIN estado ON ciudad.estado_id=estado.id
			WHERE cedula=\'' . $cedula . '\'';
			
		//echo $sConsulta;
		$obj = $this->DBSpace->consultar($sConsulta);		

		$rs = $obj->rs;
		foreach ($rs as $c => $v) {
			$mdj = new $this->MMedidaJudicial();
			$mdj->id = $v->medida_id;
			$mdj->fecha = $v->f_documento;
			$mdj->numero_oficio = $v->nro_oficio;
			$mdj->numero_expediente = $v->nro_expediente;
			$mdj->descripcion_embargo = $v->desc_embargo;
			$mdj->forma_pago = $v->forma_pago_id;
			$mdj->municipio = $v->municipio_id;
			$mdj->institucion = $v->institucion;
			$mdj->cedula_beneficiario = $v->ci_beneficiario;
			$mdj->cedula = $v->cedula;
			$mdj->nombre_beneficiario = strtoupper($v->n_beneficiario);
			$mdj->parentesco = $v->parentesco_id;
			$mdj->estatus_nombre = $v->estatus_nombre;
			$mdj->tipo_nombre = strtoupper($v->tipo_nombre);
			$mdj->porcentaje = $v->porcentaje;
			$mdj->monto = $v->total_monto;
			$mdj->tipo = $v->tipo_medida_id;
			$mdj->estatus = $v->estatus;
			$mdj->estado = strtoupper($v->estado_nombre);
			$mdj->nombre_autoridad = $v->nombre_autoridad;
			$mdj->cargo = $v->cargo_autoridad;
			$mdj->descripcion_institucion = $v->desc_institucion;
			$mdj->cedula_autorizado = $v->ci_autorizado;
			$mdj->unidad_tributaria = $v->unidad_tributaria;
			$mdj->ultima_observacion = $v->observ_ult_modificacion;
			
			
			$arr[$v->medida_id] = $mdj;
		}

		return $arr;
	}


	public function salvar(){
    	$sInsert = 'INSERT INTO medida_judicial (
	      	f_documento,
			nro_oficio,
			nro_expediente,
			total_monto,
			porcentaje,
			desc_embargo,
			forma_pago_id,
			municipio_id,
			institucion,
			desc_institucion,
			ci_beneficiario,
			n_beneficiario,
			n_autorizado,
			status_id,
			parentesco_id,
			tipo_medida_id,
			cantidad_salario,
			unidad_tributaria,
			nombre_autoridad,
			cargo_autoridad,
			motivo_id,
			cedula,
			ci_autorizado,
			f_creacion,
			usr_creacion,
			f_ult_modificacion,
			usr_modificacion,
			observ_ult_modificacion,
		) VALUES (';

	    $sInsert .=
	      '\'' . $this->fecha . '\',
	      \'' . $this->numero_oficio . '\',
	      \'' . $this->numero_expediente . '\',
	      \'' . $this->monto . '\',
	      \'' . $this->porcentaje . '\',
	      \'' . $this->observacion . '\',
	      \'' . $this->forma_pago . '\',
	      \'' . $this->municipio . '\',
	      \'' . $this->institucion . '\',
	      \'' . $this->descripcion_institucion . '\',
	      \'' . $this->cedula_beneficiario . '\',
	      \'' . $this->nombre_beneficiario . '\',
	      \'' . $this->nombre_autorizado . '\',
	      \'' . $this->estatus . '\',
	      \'' . $this->parentesco . '\',
	      \'' . $this->tipo . '\',
	      \'' . $this->salario . '\',
	      \'' . $this->unidad_tributaria . '\',
	      \'' . $this->nombre_autoridad . '\',
	      \'' . $this->cargo . '\',
	      \'' . $this->motivo . '\',
	      \'' . $this->cedula . '\',
	      \'' . $this->cedula_autorizado . '\',      
	      \'' . $this->fecha_creacion . '\',
	      \'' . $this->usuario_creacion . '\',
	      \'' . $this->fecha_modificacion . '\',
	      \'' . $this->usuario_modificacion . '\',
	      \'' . $this->ultima_observacion . '\',)';
	    
	    echo $sInsert;
	    $obj = $this->DBSpace->consultar($sInsert);


  }

  	public function listarPorCodigo($cedula = '', $id){
		$arr = array();
		$sConsulta = 'select *,medida_judicial.id AS medida_id, 
			ciudad.nombre AS ciudad_nombre,
			medida_judicial.status_id AS estatus, status.nombre as estatus_nombre, 
			tipo_medida.nombre AS tipo_nombre, tipo_pago.nombre AS tipo_pago_nombre, 
			parentesco.nombre AS parentesco_nombre,
			estado.nombre AS estado_nombre
			from medida_judicial
			LEFT JOIN status ON status.id=medida_judicial.status_id
			LEFT JOIN tipo_medida ON tipo_medida.id=medida_judicial.tipo_medida_id
			LEFT JOIN tipo_pago ON medida_judicial.forma_pago_id=tipo_pago.id
			LEFT JOIN municipio ON municipio.id=medida_judicial.municipio_id
			LEFT JOIN ciudad ON municipio.ciudad_id=ciudad.id
			LEFT JOIN estado ON ciudad.estado_id=estado.id
			LEFT JOIN parentesco ON medida_judicial.parentesco_id=parentesco.id
			WHERE cedula=\'' . $cedula . '\' AND medida_judicial.id = ' . $id;
			
		//echo $sConsulta;
		$obj = $this->DBSpace->consultar($sConsulta);		

		$rs = $obj->rs;
		foreach ($rs as $c => $v) {

			$mdj = new $this->MMedidaJudicial();
			$mdj->id = $v->medida_id;
			$mdj->fecha = $v->f_documento;
			$mdj->numero_oficio = $v->nro_oficio;
			$mdj->numero_expediente = $v->nro_expediente;
			$mdj->descripcion_embargo = $v->desc_embargo;
			$mdj->forma_pago = $v->forma_pago_id;
			$mdj->forma_pago_text = $v->tipo_pago_nombre;

			$mdj->municipio = $v->municipio_id;
			$mdj->institucion = $v->institucion;

			$mdj->cedula_beneficiario = $v->ci_beneficiario;
			$mdj->cedula = $v->cedula;
			$mdj->nombre_beneficiario = strtoupper($v->n_beneficiario);
			$mdj->parentesco = $v->parentesco_id;
			$mdj->parentesco_nombre = $v->parentesco_nombre;
			$mdj->estatus_nombre = $v->estatus_nombre;
			$mdj->tipo_nombre = strtoupper($v->tipo_nombre);
			
			if ($v->porcentaje > 0 && $v->total_monto >0){
				$mdj->porcentaje = $v->porcentaje;
				$mdj->monto = ($v->total_monto * $v->porcentaje)/100;	
			}else{
				$mdj->porcentaje = $v->porcentaje;
				$mdj->monto = $v->total_monto;
			}
			

			$mdj->tipo = $v->tipo_medida_id;
			$mdj->estatus = $v->estatus;
			$mdj->estado = strtoupper($v->estado_nombre);
			$mdj->ciudad = strtoupper($v->ciudad_nombre);
			$mdj->nombre_autoridad = $v->nombre_autoridad;
			$mdj->cargo = $v->cargo_autoridad;
			$mdj->descripcion_institucion = $v->desc_institucion;
			$mdj->cedula_autorizado = $v->ci_autorizado;
			$mdj->unidad_tributaria = $v->unidad_tributaria;
			$mdj->ultima_observacion = $v->observ_ult_modificacion;
			$arr[$v->medida_id] = $mdj;
		}
		return $arr;
	}
	/**
		*f_documento date,
		*nro_oficio character varying(30),
		*nro_expediente character varying(30),
		*total_monto numeric,
		*porcentaje numeric,
		*desc_embargo text,
		*forma_pago_id smallint,
		*municipio_id smallint,
		*institucion character varying(200),
		*desc_institucion text,
		*ci_beneficiario character varying(20),
		*n_beneficiario character varying(100),
		n_autorizado character varying(100),
		*status_id integer,
		parentesco_id integer,
		tipo_medida_id integer,
		cantidad_salario integer,
		unidad_tributaria integer,
		*nombre_autoridad character varying(100),
		*cargo_autoridad character varying(100),
		motivo_id integer,
		*cedula character varying(12),
		*id integer NOT NULL DEFAULT nextval('medida_judicial_id_seq'::regclass),
		*ci_autorizado character varying(20),
		f_creacion timestamp without time zone,
		usr_creacion character varying(30),
		f_ult_modificacion timestamp without time zone,
		usr_modificacion character varying(30),
		observ_ult_modificacion character varying(400),
	**/


	public function ejecutarMedidas($ced = '', $estatus = 0, $codigo = '', $monto = 0){
		if ($ced != ''){
			$est = 220;
			if($estatus == 220){
				$est = 223;
			}
			//$sModificar = 'UPDATE medida_judicial SET total_monto= ' . $monto . ', status_id = ' . $estatus . ', observ_ult_modificacion=\'' . $codigo . '\'  WHERE cedula=\'' . $ced . '\' AND status_id = ' . $est . ' AND tipo_medida_id=1';
			$sModificar = 'UPDATE medida_judicial SET status_id = ' . $estatus . ', observ_ult_modificacion=\'' . $codigo . '\'  WHERE cedula=\'' . $ced . '\' AND status_id = ' . $est . ' AND tipo_medida_id=1';
			echo $sModificar;
			$this->DBSpace->consultar($sModificar);	

		}
	}
}