<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * MamonSoft C.A
 *
 * Directiva de Sueldos Establece las reglas para la base del calculo
 *
 * @package pace\application\modules\panel\model\beneficiario
 * @subpackage utilidad
 * @author Carlos Peña
 * @copyright Derechos Reservados (c) 2015 - 2016, MamonSoft C.A.
 * @link http://www.mamonsoft.com.ve
 * @since version 1.0

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

		$this->Componente = new $this->MComponente();

	}

	private function InsertarSigesp(){
		$sConsulta = 'SELECT * FROM beneficiario'
		$obj = $this->Dbpace->consultar($sConsulta);
		$i = 0;
		$coma = '';
		$sInsertar = 'INSERT INTO sno_personal (
			  codper,
			  cedper,
			  nomper,
			  apeper,
			  dirper,
			  fecnacper,
			  telhabper,
			  sexper,
			  numhijper,
			  fecingper,
			  nacper,
			  codpro ,
			  nivacaper,
			  codcom,
			  codran,
			  fecingadmpubper,
			  edocivper)'
			  
		foreach ($obj as $clv => $val) {
			if ($i>0){
				$coma = ',';
			}
			
		}
		$sInsertar += $coma + '(\'' . $this->estatus_activo . '\',
			\'' . $this->cedula . '\',
			\'' . $this->cedper . '\',
			\'' . $this->nomper . '\',
			\'' . $this->apeper . '\',
			\'' . $this->dirper . '\',
			\'' . $this->fecnacper . '\',
			\'' . $this->telhabper . '\',
			\'' . $this->sexper . '\',
			\'' . $this->numhijper . '\',
			\'' . $this->fecingper . '\',
			\'' . $this->nacper . '\',
			\'' . $this->codpro . '\',
			\'' . $this->nivacaper . '\',
			\'' . $this->codcom . '\',
			\'' . $this->codran . '\',
			\'' . $this->fecingadmpubper . '\',
			\'' . $this->edocivper . '\')';

		$obj = $this->Dbpace->consultar($sInsertar);

	}
/*
	
	private function InsertarSigespNomina(){
		$sConsulta = 'SELECT * FROM beneficiario'
		$obj = $this->Dbpace->consultar($sConsulta);
		$i = 0;
		$coma = '';
		$sInsertar = 'INSERT INTO sno_personalnomina (
			  codnom,
			  codper,
			  minorguniadm,
  			  ofiuniadm,
              uniuniadm,
              depuniadm,
              prouniadm,
			  codcar,
			  apeper,
			  dirper,
			  fecnacper,
			  telhabper,
			  sexper,
			  numhijper,
			  fecingper,
			  nacper,
			  codpro ,
			  nivacaper,
			  codcom,
			  codran,
			  fecingadmpubper,
			  edocivper)'
		
		foreach ($obj as $clv => $val) {
			if ($i>0){
				$coma = ',';
			}
		$sInsertar += $coma + '(\'' . $this->estatus_activo . '\',
			\'' . $this->cedula . '\',
			\'' . $this->cedper . '\',
			\'' . $this->nomper . '\',
			\'' . $this->apeper . '\',
			\'' . $this->dirper . '\',
			\'' . $this->fecnacper . '\',
			\'' . $this->telhabper . '\',
			\'' . $this->sexper . '\',
			\'' . $this->numhijper . '\',
			\'' . $this->fecingper . '\',
			\'' . $this->nacper . '\',
			\'' . $this->codpro . '\',
			\'' . $this->nivacaper . '\',
			\'' . $this->codcom . '\',
			\'' . $this->codran . '\',
			\'' . $this->fecingadmpubper . '\',
			\'' . $this->edocivper . '\')';

		$obj = $this->Dbpace->consultar($sInsertar);

	}

func (P *Pension) Exportar() {
    fmt.Println("Cargando Componente")
    consultarComponentes()
    fmt.Println("Cargando Militares")
    consultarPensionados()
    //
    i := 0
    coma := ""
    cuerpo := ""
    insert := `INSERT INTO beneficiario (cedula,nombres,apellidos, grado_id, componente_id, fecha_ingreso, f_ult_ascenso, f_retiro,
        f_retiro_efectiva, porcentaje)    VALUES `
    fmt.Println("Creando lote...")
    for _, v := range lstMilitares {
        if i > 0 {
            coma = ","
        }

        grado, componente := obtenerGrado(v.Pension.ComponenteCodigo, v.Pension.GradoCodigo)
        np := v.Persona.DatoBasico.NombrePrimero
        ap := v.Persona.DatoBasico.ApellidoPrimero
        porcentaje := strconv.FormatFloat(v.Pension.PorcentajePrestaciones, 'f', 2, 64)
        cuerpo += coma + `(
                '` + v.Persona.DatoBasico.Cedula + `',
                '` + strings.Replace(np, "'", " ", -1) + `',
                '` + strings.Replace(ap, "'", " ", -1) + `',
                ` + grado + `,` + strconv.Itoa(componente) + `,
                '` + v.FechaIngresoComponente.String()[0:10] + `',
                '` + v.FechaAscenso.String()[0:10] + `',
                '` + v.FechaRetiro.String()[0:10] + `','` + v.FechaRetiro.String()[0:10] + `',` + porcentaje + `)`
        i++

        // fmt.Println(" Situacion: ", v.Situacion, " Componente: ", v.Pension.ComponenteCodigo, " Grado Codigo: ", v.Pension.GradoCodigo)
    }
    fmt.Println("Preparando para insertar")
    query := insert + cuerpo
    // fmt.Println("Consultar ", query)
    _, err := sys.PostgreSQLPENSION.Exec(query)
    if err != nil {
        fmt.Println("Error en el query: ", err.Error())
    }

}*/
