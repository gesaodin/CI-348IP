<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * MamonSoft
 *
 * Beneficiario
 *
 * @package pace\application\modules\model
 * @subpackage utilidad
 * @author Carlos Peña
 * @copyright Derechos Reservados (c) 2015 - 2016, MamonSoft C.A.
 * @link http://www.mamonsoft.com.ve
 * @since version 1.0
 */

class MBeneficiario extends CI_Model{

	/**
	* @var string
	*/
	var $cedula = '';

	/**
	* @var string
	*/
	var $nombres = '';

	/**
	* @var string
	*/
	var $apellidos = '';

	/**
	* @var string
	*/
	var $estado_civil = '';

	/**
	* @var string
	*/
	var $sexo = '';

	/**
	* @var int
	*/
	var $numero_hijos = 0;

	/**
	* @var string
	*/
	var $numero_cuenta = '';

	/**
	* @var date
	*/
	var $fecha_ingreso;

	/**
	* @var date
	*/
	var $fecha_ingreso_sistema = '';

	/**
	* @var date
	*/
	var $fecha_ingreso_reconocida = '';

	/**
	* @var string
	*/
	var $tiempo_servicio = 0;

	/**
	* @var string
	*/
	var $tiempo_servicio_aux = 0;

	/**
	* @var string
	*/
	var $tiempo_servicio_db = 0;


	/**
	* @var date
	*/
	var $fecha_ultimo_ascenso = '';

	/**
	* @var int
	*/
	var $antiguedad_grado = 0;

	/**
	* @var int
	*/
	var $grado_codigo = 0;

	/**
	* @var double
	*/
	var $porcentaje = 0.00;

	/**
	* @var string
	*/
	var $ano_reconocido;

	/**
	* @var string
	*/
	var $mes_reconocido;

	/**
	* @var int
	*/
	var $dia_reconocido;

	/**
	* @var int
	*/
	var $estatus_descripcion;

	/**
	* @var int
	*/
	var $estatus_activo;

	/**
	* @var int
	*/
	var $no_ascenso;

	/**
	* @var date
	*/
	var $fecha_retiro = '';

	/**
	* @var date
	*/
	var $fecha_retiro_efectiva = '';


	/**
	* @var date
	*/
	var $fecha_creacion = '';
	/**
	* @var string
	*/
	var $usuario_creador = '';

	/**
	* @var string
	*/
	var $usuario_modificacion = '';

	/**
	* @var date
	*/
	var $fecha_ultima_modificacion = '';

	/**
	* @var date
	*/
	var $fecha_reincorporacion = '';

	/**
	* @var double
	*/
	var $profesionalizacion;

  /**
  * Valor de la prima especial por reconocimiento en el grado de Cnel Técnico
	* @var double
	*/
	var $exrcnelt;


	/**
	* @var string
	*/
	var $motivo_paralizacion = '';

	/**
	* @var string
	*/
	var $observacion = '';

	/**
	* @var double
	*/
	var $sueldo_base = 0.00;

	/**
	* @var double
	*/
	var $sueldo_global = 0.00;

	/**
	* @var double
	*/
	var $aguinaldos = 0.00;

	/**
	* @var double
	*/
	var $sueldo_integral = 0.00;

	/**
	* @var double
	*/
	var $asignacion_antiguedad = 0.00;

	/**
	* @var double
	*/
	var $vacaciones = 0.00;

	/**
	* @var double
	*/
	var $ano_antiguedad = 0.00;

	/**
	* @var double
	*/
	var $no_depositado_banco = 0.00;

	/**
	* @var double
	*/
	var $prima_descendencia = 0.00;

	/**
	* @var double
	*/
	var $prima_transporte = 0.00;

	/**
	* @var double
	*/
	var $prima_especial = 0.00;

  /**
	* @var double
	*/
	var $prima_noascenso = 0.00;

	/**
	* @var double
	*/
	var $prima_tiemposervicio = 0.00;

	/**
	* @var double
	*/
	var $prima_profesionalizacion = 0.00;

	/**
	* @var double
	*/
	var $prima_profesionalizacion_mt = 0.00;

	/**
	* @var MPrima
	*/
	var $Prima = array();

	/**
	* @var MComponente
	*/
	var $Componente = null;

	/**
	* @var MHistorialMovimiento
	*/
	var $HistorialMovimiento = array();

	/**
	* @var MHistorialSueldo
	*/
	var $HistorialSueldo = array();

	/**
	* @var MHistorialAnticipos
	*/
	var $HistorialAnticipo = array();

	/**
	* @var MMedidaJudicial
	*/
	var $MedidaJudicial = array();

	/**
	* @var MMedidaJudicial
	*/
	var $MedidaJudicialActiva = array();

	/**
	* @var MHistorialMovimiento
	*/
	var $HistorialDetalleMovimiento = array();

	/**
	* @var MCalculo
	*/
	var $Calculo = array();

	/**
	* @var Concepto
	*/
	var $Concepto = array();

	/**
	* @var MOrdenPago
	*/
	var $HistorialOrdenPagos = array();

	/**
	* Iniciando la clase, Cargando Elementos Pace
	*
	* @access public
	* @return void
	*/
	public function __construct(){
		parent::__construct();
		if(!isset($this->Dbpace)) $this->load->model('comun/Dbpace');
		$this->load->model('beneficiario/MComponente');
		$this->load->model('beneficiario/MHistorialSueldo');
		$this->load->model('beneficiario/MHistorialAnticipo');
		$this->load->model('beneficiario/MHistorialMovimiento');
		$this->load->model('beneficiario/MMedidaJudicial');
		$this->load->model('beneficiario/MDirectiva');
		$this->load->model('beneficiario/MCalculo');
		$this->load->model('kernel/KCalculoLote');
    $this->load->model('kernel/KDirectiva');
    

		$this->Componente = new $this->MComponente();

	}

	public function guardar(){

		$sActualizar = 'UPDATE beneficiario SET
			grado_id = ' . $this->grado_id .  ',
			nombres = \'' . $this->nombres .  '\',
			apellidos = \'' . $this->apellidos .  '\',
			tiempo_servicio = ' . $this->tiempo_servicio_db .  ',
			fecha_ingreso = \'' . $this->fecha_ingreso .  '\',
			n_hijos = ' . $this->numero_hijos .  ',
			f_ult_ascenso = \'' . $this->fecha_ultimo_ascenso .  '\',
			anio_reconocido = ' . $this->ano_reconocido .  ',
			mes_reconocido = ' . $this->mes_reconocido .  ',
			dia_reconocido = ' . $this->dia_reconocido .  ',
			f_ingreso_sistema = \'' . $this->fecha_ingreso .  '\',
			st_no_ascenso = ' . $this->no_ascenso .  ',
			st_profesion = ' . $this->profesionalizacion .  ',
			sexo = \'' . $this->sexo .  '\',
			f_creacion = \'' . $this->fecha_creacion .  '\',
			usr_creacion = \'' . $this->usuario_creador .  '\',
			f_ult_modificacion = \'' . $this->fecha_ultima_modificacion .  '\',
			usr_modificacion = \'' . $this->usuario_modificacion .  '\',
			observ_ult_modificacion=\'MODIFICACION DATOS BASICOS\'
		WHERE cedula = \'' . $this->cedula .  '\'';
		//echo $sActualizar;
		return $this->Dbpace->consultar($sActualizar);

	}

	public function actualizaCuenta(){

		$sActualizar = 'UPDATE beneficiario SET
			numero_cuenta = \'' . $this->numero_cuenta .  '\',
			f_ult_modificacion = \'' . $this->fecha_ultima_modificacion .  '\',
			usr_modificacion = \'' . $this->usuario_modificacion .  '\',
			observ_ult_modificacion=\'MODIFICACION DE CUENTA\'
		WHERE cedula = \'' . $this->cedula .  '\'';
		//echo $sActualizar;
		$this->Dbpace->consultar($sActualizar);

		$sActualizar = 'UPDATE beneficiario_calc SET
			numero_cuenta = \'' . $this->numero_cuenta .  '\'
		WHERE cedula = \'' . $this->cedula .  '\'';
		//echo $sActualizar;
		$this->Dbpace->consultar($sActualizar);

	}


	public function eliminar(){

	}

	public function obtenerID($id, $fecha = ''){
		$obj = $this->_consultar($id);
    // echo "<pre>";
    // print_r($obj);
		if($obj->cant == 1 ){
      $fecha = "";
			foreach ($obj->rs as $clv => $val) {
				$this->cedula = $val->cedula;
				$this->nombres = $val->nombres;
				$this->apellidos = $val->apellidos;
				$this->estado_civil = $val->edo_civil;
				$this->estatus_activo = $val->status_id;
				$this->estatus_descripcion = $val->estatus_descripcion;
				$this->numero_hijos = $val->n_hijos;
				$this->tiempo_servicio_db = $val->tiempo_servicio; //El tiempo es una herencia referencial al Beneficiario en MCalculo
				$this->fecha_ingreso = $val->fecha_ingreso;
				$this->fecha_ingreso_sistema = $val->f_ingreso_sistema;
				$this->ano_reconocido = $val->anio_reconocido;
				$this->mes_reconocido = $val->mes_reconocido;
				$this->dia_reconocido = $val->dia_reconocido;
				$this->sexo = $val->sexo;
				$this->usuario_creador = $val->usr_creacion;
				$this->usuario_modificacion = $val->usr_modificacion;
				$this->fecha_ultima_modificacion = $val->f_ult_modificacion;
				$this->fecha_creacion = $val->f_creacion;
				$this->fecha_ultimo_ascenso = $val->f_ult_ascenso;
				$this->no_ascenso = $val->st_no_ascenso;
				$this->profesionalizacion = $val->st_profesion;
        $this->monto_especial = $val->monto_especial;
				$this->fecha_retiro = $val->f_retiro;
				$this->grado_codigo = $val->grado_id;
        $fecha = $val->f_retiro;
				$this->fecha_retiro_efectiva = $val->f_retiro_efectiva;
				$this->numero_cuenta = $val->numero_cuenta;
				$this->motivo_paralizacion = $val->motivo_paralizacion;
				$this->fecha_reincorporacion = $val->f_reincorporacion;
				$this->observacion = $val->observ_ult_modificacion;
				$this->porcentaje = $val->porcentaje;

				$this->Componente->ObtenerConGrado($val->componente_id, $val->grado_id, $val->st_no_ascenso);

			}
			$this->HistorialMovimiento = $this->MHistorialMovimiento->listar($id);
			$this->MedidaJudicial = $this->MMedidaJudicial->listar($id, $this->fecha_retiro);
			$this->MedidaJudicialActiva = $this->MMedidaJudicial->listar($id, $this->fecha_retiro, true);
			$this->HistorialAnticipo = $this->MHistorialAnticipo->listar($id);

			if($fecha != '') $this->fecha_retiro = $fecha; //En el caso de calcular finiquitos
			$Directivas = $this->KDirectiva->Cargar('',  date("Y-m-d")); //Directivas
			//print_r($this->MBeneficiario);
			$this->KCalculoLote->Instanciar($this->MBeneficiario, $Directivas);
			$this->KCalculoLote->Ejecutar();

		}else{
      $arr['id'] = $id;
      $arr['url'] = 'http://192.168.6.45:8080/devel/api/militar/crud/' . $arr['id'];
      $api = $this->MCurl->Cargar_API($arr);
      $Militar = $api['obj'];
      $this->cedula = $Militar->Persona->DatoBasico->cedula;
      $this->nombres = $Militar->Persona->DatoBasico->nombreprimero;
      $this->apellidos = $Militar->Persona->DatoBasico->apellidoprimero;
      $this->estado_civil = $Militar->Persona->DatoBasico->estadocivil;
      $this->sexo = $Militar->Persona->DatoBasico->sexo;
      $this->estatus_activo = "201";
      $this->estatus_descripcion = "ACTIVO";
      $this->numero_hijos = 3;
      // $this->no_ascenso = $Militar->pxnoascenso;
      // $this->profesionalizacion = $Militar->pprof;
      // $this->exrcnelt = $Militar->pespecial;
      $this->ano_reconocido = 0;
      $this->mes_reconocido = 0;
      $this->dia_reconocido = 0;
      $this->fecha_ingreso = date( "Y-m-d", strtotime($Militar->fingreso) );
      $this->fecha_ultimo_ascenso = date( "Y-m-d", strtotime($Militar->fascenso) );

      $this->Componente->ObtenerConGrado($Militar->Pension->componente,$Militar->Pension->grado);
      $this->observacion = "IMPORTANDO DATO DE SSSIFANB";
      $this->fecha_retiro = $fecha;
      if($fecha == '') $this->fecha_retiro = date( "Y-m-d" ); //En el caso de calcular finiquitos

			$this->MCalculo->iniciarCalculosBeneficiario($this->MBeneficiario);
    }
	}

	/**
	* Consultar un beneficiario por cedula
	*
	* @access private
	* @param string
	* @return Dbpace
	*/
	private function _consultar($cedula = '', $tabla = ''){
		$tbl = $tabla == ''? 'beneficiario' : $tabla;
		$sConsulta = '
			SELECT
				' . $tbl . '.cedula,
				' . $tbl . '.nombres,
				' . $tbl . '.apellidos,
				' . $tbl . '.grado_id,
				' . $tbl . '.componente_id,
				' . $tbl . '.tiempo_servicio,
				' . $tbl . '.fecha_ingreso,
				' . $tbl . '.edo_civil,
				' . $tbl . '.n_hijos,
				' . $tbl . '.f_ult_ascenso,
				' . $tbl . '.anio_reconocido,
				' . $tbl . '.mes_reconocido,
				' . $tbl . '.f_ult_modificacion,
				' . $tbl . '.usr_creacion,
				' . $tbl . '.usr_modificacion,
				' . $tbl . '.dia_reconocido,
				' . $tbl . '.f_ingreso_sistema,
				' . $tbl . '.f_retiro,
				' . $tbl . '.f_creacion,
				' . $tbl . '.f_retiro_efectiva,
				' . $tbl . '.status_id,
				' . $tbl . '.st_no_ascenso,
				' . $tbl . '.f_reincorporacion,
				' . $tbl . '.numero_cuenta,
				' . $tbl . '.st_profesion,
				' . $tbl . '.sexo,
				' . $tbl . '.observ_ult_modificacion,
				' . $tbl . '.motivo_paralizacion,
				' . $tbl . '.monto_especial,
				' . $tbl . '.porcentaje,
				status.descripcion AS estatus_descripcion
			FROM
				' . $tbl . '
				LEFT JOIN status ON
					' . $tbl . '.status_id=status.id
			WHERE
				beneficiario.cedula=\'' . $cedula . '\'';
		//echo $sConsulta;
		$obj = $this->Dbpace->consultar($sConsulta);

		return $obj;

	}


	/**
	* Consultar los beneficiario por componente, cargar diirectivas,
  * instanciar las primas y ejeutar calculos
	*
	* @access public
	* @param string
	* @return Dbpace
	*/
	public function listarPorComponente($idComponente = 0){
		$this->load->model('beneficiario/MCalculo');
		$this->load->model('beneficiario/MDirectiva');
    $Directiva = $this->MDirectiva->iniciar();
    $this->load->model('beneficiario/MPrima');
	}

	function CargarFamiliares($id = ''){
		$this->load->model('comun/DbSaman');
		$familiar = array();
		$sConsulta = 'SELECT A.codnip, A.nombrecompleto, A.sexocod, A.persrelstipcod  FROM personas JOIN
			( SELECT pers_relaciones.nropersona, personas.nombrecompleto, personas.sexocod, personas.codnip,pers_relaciones.persrelstipcod  FROM pers_relaciones
				INNER JOIN pers_relacs_tipo ON pers_relaciones.persrelstipcod=pers_relacs_tipo.persrelstipcod
				INNER JOIN personas ON pers_relaciones.nropersonarel=personas.nropersona
				LEFT JOIN edo_civil ON personas.edocivilcod=edo_civil.edocivilcod
				LEFT JOIN direcciones ON personas.nropersona=direcciones.nropersona) AS A ON personas.nropersona = A.nropersona
			WHERE personas.codnip = \'' . $id . '\' AND tipnip=\'V\'';
		$obj = $this->DbSaman->consultar($sConsulta);
		foreach ($obj->rs as $clv => $val) {
			$familiar[] = array(
				'cedula' => $val->codnip,
				'nombre'=> $val->nombrecompleto,
				'parentesco' => $this->Parentesco($val->sexocod, $val->persrelstipcod)
				);
		}
		return $familiar;
	}


	function Parentesco($sexo, $tipo){
		switch ($tipo) {
			case 'PD':
				$valor = 'MADRE';
				$tipo = '200';
				if($sexo == 'M')$valor = 'PADRE';
				$tipo = '100';
				break;
			case 'HJ':
				$valor = 'HIJA';
				$tipo = '400';
				if($sexo == 'M')$valor = 'HIJO';
				break;
			case 'HO':
				$valor = 'HERMANA';
				$tipo = '500';
				if($sexo == 'M')$valor = 'HERMANO';
				break;
			case 'EA':
				$valor = 'ESPOSA';
				$tipo = '300';
				if($sexo == 'M')$valor = 'ESPOSO';
				break;
			case 'CON':
				$tipo = '300';
				$valor = 'CONCUBINA';
				if($sexo == 'M')$valor = 'CONCUBINO';
				break;
			case 'SOBR':
				$tipo = '600';
				$valor = 'SOBRINA';
				if($sexo == 'M')$valor = 'SOBRINO';
				break;
			default:
				# code...
				break;
		}

		return $valor;
	}

	/**
	*	Cargar una Datos de una persona desde SAMAN
	*
	*/
	function CargarPersona($id){
		$this->load->model('comun/DbSaman');
		$familiar = array();

		$sConsulta = 'SELECT
			nropersona, personas.nombrecompleto, personas.sexocod, personas.codnip
			FROM personas WHERE personas.codnip = \'' . $id . '\' AND tipnip=\'V\' LIMIT 1';

		$obj = $this->DbSaman->consultar($sConsulta);
		foreach ($obj->rs as $clv => $val) {
			$familiar = array(
				'cedula' => $val->codnip,
				'nombre'=> $val->nombrecompleto,
				'parentesco' => 'OTRO'
			);


		}
		return $familiar;
	}

	/**
	*	Cargar una Datos de una persona desde SAMAN
	*
	*/
	function CargarPersonaMilitar($id, $valor){
		$this->load->model('comun/DbSaman');
		$militar = array();

		$sConsulta = 'SELECT
			personas.nropersona,
			personas.nombreprimero,
			personas.nombresegundo,
			personas.apellidoprimero,
			personas.apellidosegundo,
			personas.nombrecompleto,
			personas.sexocod,
			personas.codnip,
			pers_dat_militares.fchingcomponente,
			pers_dat_militares.fchultimoascenso,
			pers_dat_militares.gradocod,
			ipsfa_grados.gradocodrangoid,
			ipsfa_componentes.componentepriorpt
			FROM personas
			JOIN pers_dat_militares ON pers_dat_militares.nropersona=personas.nropersona
			INNER JOIN ipsfa_grados ON pers_dat_militares.gradocod=ipsfa_grados.gradocod
			INNER JOIN ipsfa_componentes ON pers_dat_militares.componentecod=ipsfa_componentes.componentecod
			WHERE personas.codnip = \'' . $id . '\' LIMIT 1';

		$obj = $this->DbSaman->consultar($sConsulta);
		foreach ($obj->rs as $clv => $val) {
			$militar = array(
				'cedula' => $val->codnip,
				'nombre'=> $val->nombreprimero . ' ' . $val->nombresegundo,
				'apellido'=> $val->apellidoprimero . ' ' . $val->apellidosegundo,
				'parentesco' => 'OTRO',
				'grado' => $val->gradocod,
				'componente' => $val->componentepriorpt,
				'fecha_ingreso' => $val->fchingcomponente,
				'fecha_ultimo_ascenso' => $val->fchultimoascenso
			);


		}
		if($valor != 0) $this->_insertarPersonaMilitar($militar);
		return $militar;
	}

	private function _insertarPersonaMilitar($Militar = array()){
		$SELECT_ = '(SELECT id FROM grado WHERE
			REPLACE(nombre, \'.\', \'\') LIKE \'' . $Militar['grado'] . '\' AND componente_id=' . $Militar['componente'] . ' LIMIT 1)';
		$sInsertar = 'INSERT INTO beneficiario (
			  cedula,
			  nombres,
			  apellidos,
			  grado_id,
			  componente_id,
			  fecha_ingreso,
			  f_ult_ascenso,
			  f_ingreso_sistema,
			  status_id,
			  st_no_ascenso,
			  st_profesion,
			  f_creacion ,
			  usr_creacion,
			  f_ult_modificacion,
			  usr_modificacion,
			  observ_ult_modificacion,
              n_hijos)
			  VALUES ';

		$sInsertar .= '(
			\'' . $Militar['cedula'] . '\',
			\'' . $Militar['nombre'] . '\',
			\'' . $Militar['apellido'] . '\',
			' . $SELECT_ . ',
			' . $Militar['componente'] . ',
			\'' . $Militar['fecha_ingreso'] . '\',
			\'' . $Militar['fecha_ultimo_ascenso'] . '\',
			\'' . date("Y-m-d") . '\',
			201,
			0,
			0,
			\'' . date("Y-m-d H:i:s") . '\',
			\'' . $_SESSION['usuario'] . '\',
			\'' . date("Y-m-d H:i:s") . '\',
			\'' . $_SESSION['usuario'] . '\',
			\'INSERTADO DESDE SAMAN\',
			0
		)';
		//echo $sInsertar;

		$obj = $this->Dbpace->consultar($sInsertar);

	}



	function ActualizarPorMovimiento(){
		$fecha_r = 'f_retiro=\'' . $this->Beneficiario->fecha_retiro . '\',
			f_retiro_efectiva=\'' . $this->Beneficiario->fecha_retiro . '\',';

		if ($this->Beneficiario->fecha_retiro == ''){
			$fecha_r = 'f_retiro=null, f_retiro_efectiva=null, ';
		}
		$sActualizar = 'UPDATE beneficiario SET  ' . $fecha_r . '
			status_id=\'' . $this->Beneficiario->estatus_activo . '\',
			usr_modificacion=\'' . $_SESSION['usuario'] . '\',
			observ_ult_modificacion=\'' . $this->Beneficiario->observacion . '\',
			f_ult_modificacion=\'' . date("Y-m-d H:i:s") . '\'
		WHERE cedula=\'' . $this->Beneficiario->cedula . '\'';
		//echo $sActualizar;
		$obj = $this->Dbpace->consultar($sActualizar);
	}

	function ParalizarDesparalizar(){
		$fecha_r = 'f_retiro=\'' . $this->fecha_retiro . '\',
			f_retiro_efectiva=\'' . $this->fecha_retiro . '\',';

		if ($this->fecha_retiro == ''){
			$fecha_r = 'f_retiro=null, f_retiro_efectiva=null, ';
		}
		$sActualizar = 'UPDATE beneficiario SET
			motivo_paralizacion=\'' . $this->motivo_paralizacion . '\',
			'. $fecha_r.'
			status_id=\'' . $this->estatus_activo . '\',
			usr_modificacion=\'' . $_SESSION['usuario'] . '\',
			observ_ult_modificacion=\'' . $this->observacion . '\',
			f_ult_modificacion=\'' . date("Y-m-d H:i:s") . '\'
		WHERE cedula=\'' . $this->cedula . '\'';
		//echo $sActualizar;
		$obj = $this->Dbpace->consultar($sActualizar);
	}




	function InsertarHistorial(){
		$sInsertar = 'INSERT INTO hist_beneficiario (
			status_id,
			componente_id,
			grado_id,
			cedula,
			nombres,
			apellidos,
			tiempo_servicio,
			fecha_ingreso,
			edo_civil,
			n_hijos,
			f_ult_ascenso,
			anio_reconocido,
			mes_reconocido,
			dia_reconocido,
			f_ingreso_sistema,
			f_retiro,
			f_retiro_efectiva,
			st_no_ascenso,
			numero_cuenta,
			st_profesion,
			sexo,
			f_creacion,
			usr_creacion,
			f_ult_modificacion,
			usr_modificacion,
			observ_ult_modificacion,
			motivo_paralizacion,
			f_reincorporacion
		) VALUES ';

		$sInsertar .= '(
			\'' . $this->estatus_activo . '\',
			\'' . $this->Componente->id . '\',
			\'' . $this->Componente->Grado->id . '\',
			\'' . $this->cedula . '\',
			\'' . $this->nombres . '\',
			\'' . $this->apellidos . '\',
			\'' . $this->tiempo_servicio_db . '\',
			\'' . $this->fecha_ingreso . '\',
			\'' . $this->estado_civil . '\',
			\'' . $this->numero_hijos . '\',
			\'' . $this->fecha_ultimo_ascenso . '\',
			\'' . $this->ano_reconocido . '\',
			\'' . $this->mes_reconocido . '\',
			\'' . $this->dia_reconocido . '\',
			\'' . $this->fecha_ingreso_sistema . '\',
			\'' . $this->fecha_retiro . '\',
			\'' . $this->fecha_retiro_efectiva . '\',
			\'' . $this->no_ascenso . '\',
			\'' . $this->numero_cuenta . '\',
			\'' . $this->profesionalizacion . '\',
			\'' . $this->sexo . '\',
			\'' . $this->fecha_creacion . '\',
			\'' . $this->usuario_creador . '\',
			\'' . $this->fecha_ultima_modificacion . '\',
			\'' . $this->usuario_modificacion . '\',
			\'' . $this->observacion . '\',
			\'' . $this->motivo_paralizacion . '\',
			\'' . $this->fecha_reincorporacion . '\'
		)';
		//echo $sInsertar;

		$obj = $this->Dbpace->consultar($sInsertar);


	}

	public function insertarDetalle($familia, $codigo = ''){


		$sInsertar = '';
		$sInsertar_a = 'INSERT INTO space.mov_familia (
			cedu,
			cedf, --Cedula del familiar beneficiado
  			nomb, --Cedula del familiar beneficiado
  			pocb, -- Porcentaje
  			cban, -- Capital en Banco
			mdaa, -- Monto por diferencia de Asignacion de Antiguedad
  			cmue, -- Monto causa o muerte
  			pasfs, -- Porcentaje Acto de Servicio / Fuera de Servicio
  			masfs, -- Monto Acto de Servicio / Fuera de Servicio
  			usur,
  			esta, -- Estus del proceso 1:Activo 0:Reversado
  			posi, --
  			fech, --
  			codi --
		) VALUES ';
		foreach ($familia->fami as $c => $v) {



			$sInsertar .= $sInsertar_a . '(
				\'' . $familia->i_d . '\',
				\'' . $v->ced . '\',
				\'' . $v->nom . '\',
				\'' . $v->pcb . '\',
				\'' . $v->cab . '\',
				\'' . $v->maa . '\',
				\'' . $v->cmu . '\',
				\'' . $v->pac . '\',
				\'' . $v->mcm . '\',
				\'' . $familia->u_s . '\',
				1,
				' . $c . ',
				\''  .  date("Y-m-d H:i:s") . '\',
				\'' . $codigo . '\'
			);';

		}

		//echo $sInsertar;
		$obj = $this->Dbpace->consultar($sInsertar);

	}

	public function consultarHistorial($id = ''){
		$lst = array();
		$obj = $this->_consultar($id, 'hist_beneficiario');
		$i = 0;

		foreach ($obj->rs as $clv => $val) {
			$Beneficiario = new $this->MBeneficiario();
			$Beneficiario->cedula = $val->cedula;
			$Beneficiario->nombres = $val->nombres;
			$Beneficiario->apellidos = $val->apellidos;
			$Beneficiario->estado_civil = $val->edo_civil;
			$Beneficiario->estatus_activo = $val->status_id;
			$Beneficiario->estatus_descripcion = $val->estatus_descripcion;
			$Beneficiario->numero_hijos = $val->n_hijos;

			$Beneficiario->tiempo_servicio_db = $val->tiempo_servicio;
			$Beneficiario->fecha_ingreso = $val->fecha_ingreso;
			$Beneficiario->fecha_ingreso_sistema = $val->f_ingreso_sistema;

			$Beneficiario->ano_reconocido = $val->anio_reconocido;
			$Beneficiario->mes_reconocido = $val->mes_reconocido;
			$Beneficiario->dia_reconocido = $val->dia_reconocido;
			$Beneficiario->sexo = $val->sexo;
			$Beneficiario->usuario_creador = $val->usr_creacion;

			$Beneficiario->usuario_modificacion = $val->usr_modificacion;

			$Beneficiario->fecha_ultima_modificacion = $val->f_ult_modificacion;
			$Beneficiario->fecha_creacion = $val->f_creacion;

			$Beneficiario->fecha_ultimo_ascenso = $val->f_ult_ascenso;

			$Beneficiario->no_ascenso = $val->st_no_ascenso;
			$Beneficiario->profesionalizacion = $val->st_profesion;
			$Beneficiario->fecha_retiro = $val->f_retiro;
			$Beneficiario->fecha_retiro_efectiva = $val->f_retiro_efectiva;
			$Beneficiario->numero_cuenta = $val->numero_cuenta;
			$Beneficiario->motivo_paralizacion = $val->motivo_paralizacion;
			$Beneficiario->fecha_reincorporacion = $val->f_reincorporacion;
			$Beneficiario->observacion = $val->observ_ult_modificacion;
			$lst[] = $Beneficiario;
			$i++;
		}
		return $lst;
	}

	function detalleMovimientoFamiliar($ced = '', $cod){
		$lst = array();
		$sConsulta = 'SELECT * FROM space.mov_familia where cedu=\'' . $ced . '\' AND codi =\'' . $cod . '\'';
		$obj = $this->Dbpace->consultar($sConsulta);
		foreach ($obj->rs as $clv => $val) {
			$lst[] = array(
				'codigo' => $val->posi,
				'nombre' => $val->nomb,
				'cedula' => $val->cedf,
				'monto' => $val->cban,
				'masfs' => $val->masfs,
				'mdaa' => $val->mdaa,
				'cmue' => $val->cmue
			);
		}
		return $lst;
	}
}
