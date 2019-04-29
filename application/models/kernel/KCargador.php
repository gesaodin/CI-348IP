<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * MamonSoft
 *
 * Kernel
 *
 * @package pace\application\modules\panel\model\beneficiario
 * @subpackage utilidad
 * @author Carlos Peña
 * @copyright Derechos Reservados (c) 2015 - 2016, MamonSoft C.A.
 * @link http://www.mamonsoft.com.ve
 * @since version 1.0
 */

class KCargador extends CI_Model{

  /**
  * @var Nomina
  */
  var $OidNomina = 0;

  /**
  * @var MBeneficiario
  */
  var $Beneficiario = null;


  /**
  * @var KMedidaJudicial
  */
  var $MedidaJudicial = null;


  /**
  * @var KArchivos
  */
  var $Archivos = null;

  /**
  * @var KResumenPresupuestario
  */
  var $ResumenPresupuestario = array();

  

  

  /**
  * @var Complejidad del Manejador (Driver)
  */
  var $Nivel = 0;

  /**
  * @var array
  */
  var $Resultado = array();

  /**
  * @var double
  */
  var $SSueldoBase = 0.00;

 /**
  * @var double
  */
  var $Neto = 0.00;

  /**
  * @var double
  */
  var $Asignacion = 0.00;

  /**
  * @var double
  */
  var $Deduccion = 0.00;
  

  /**
  * @var double
  */
  var $Incidencias = array();


  /**
  * @var double
  */
  var $Cantidad = 0;

   /**
  * @var double
  */
  var $CantidadSobreviviente = 0;

  /**
  * @var double
  */
  var $Registros = 0;

  /**
  * @var double
  */
  var $Anomalia = 0;

    /**
  * @var double
  */
  var $SinPagos = 0;

    /**
  * @var double
  */
  var $AnomaliaSobreviviente = 0;

  /**
  * @var double
  */
  var $TotalRegistros = 0;

  /**
  * @var double
  */
  var $Paralizados = 0;

    /**
  * @var double
  */
  var $ParalizadosSobrevivientes = 0;

    /**
  * @var double
  */
  var $OperarBeneficiarios = 0;

  /**
  * @var double
  */
  var $SQLMedidaJudicial = "";

  /**
  * @var double
  */
  var $CantidadMedida = 0;

  /**
  * @var double
  */
  var $ComaMedida = "";

    /**
  * @var double
  */
  var $ComaFallecidos = "";
  
  /**
   * @var WNomina
   */
  var $_MapWNomina;



    /**
   * @var Funcion para reflexionar
   */
  var $functionRefelxion;




  /**
   * @var Fallecidos Con Pension (Sobrevivientes)
   */
  var $FCP = array();

  /**
  * Iniciando la clase, Cargando Elementos Pensiones
  *
  * @access public
  * @return void
  */
  public function __construct(){
    parent::__construct();
    if(!isset($this->DBSpace)) $this->load->model('comun/DBSpace');
    $this->load->model('kernel/KCalculo');
    $this->load->model('kernel/KGenerador');
    $this->load->model('kernel/KRecibo');
    
  }


  function ConsultarBeneficiario($id = '', $param = array()){
    $this->load->model('fisico/MBeneficiario');
    $this->MBeneficiario->ObtenerID('');
    $this->KCalculo->Ejecutar($this->MBeneficiario);
    return $this->MBeneficiario;
  }

  /**
   *  Generar archivos para procesos de lotes (Activos)
   *
   *  Creación de tablas para los esquemas space
   *  ---------------------------------------------
   *  INICIANDO PROCESOS POR LOTES
   *  ---------------------------------------------
   *
   * @return  void
   */
  public function IniciarLote($arr, $archivo, $autor){
    ini_set('memory_limit', '2024M'); //Aumentar el limite de PHP

    $this->load->model('comun/Dbpace');
    $this->load->model('kernel/KSensor');
    
    $this->load->model('fisico/MBeneficiario');
    $this->load->model('kernel/KMedidaJudicial');
    $this->load->model('kernel/KArchivos');
    
    $this->MedidaJudicial = $this->KMedidaJudicial->Cargar($this->_MapWNomina["nombre"]);
    $this->Archivos = $this->KArchivos->Cargar($this->_MapWNomina["nombre"],  $this->_MapWNomina["tipo"]);
    
    $sConsulta = "
      SELECT
        bnf.nombres, bnf.apellidos,
        bnf.cedula, fecha_ingreso,f_ult_ascenso, grado.codigo,grado.nombre as gnombre,
        bnf.componente_id, n_hijos, st_no_ascenso, bnf.status_id,
        st_profesion, monto_especial, anio_reconocido, mes_reconocido,dia_reconocido,bnf.status_id as status_id, 
        bnf.porcentaje, f_retiro, bnf.tipo, bnf.banco, bnf.numero_cuenta, bnf.situacion
        FROM
          beneficiario AS bnf
        JOIN
          grado ON bnf.grado_id=grado.codigo AND bnf.componente_id= grado.componente_id
        WHERE 
        bnf.situacion = '" . $this->_MapWNomina["tipo"] . "'
        AND
        bnf.status_id = 201
        -- AND bnf.cedula='15579924' --FCP='15236250' 
        -- grado.codigo NOT IN(8450, 8510, 8500, 8460, 8470, 8480, 5320) 
        ORDER BY grado.codigo
        -- AND grado.codigo IN( 10, 15)
        -- LIMIT 10
        ";
    //echo $sConsulta;
    $con = $this->DBSpace->consultar($sConsulta);
    $this->functionRefelxion = "generarConPatrones";
    if($this->_MapWNomina["tipo"] == "FCP"){
      $this->cargarFamiliaresFCP();
      if($this->_MapWNomina["nombre"]=="DIFERENCIA DE SUELDO"){
        $this->functionRefelxion = "generarConPatronesFCPDIF";
      }else{
        $this->functionRefelxion = "generarConPatronesFCP";
      }
      
    }else{
      if($this->_MapWNomina["nombre"]=="DIFERENCIA DE SUELDO"){
        $this->functionRefelxion = "generarConPatronesRCPDIF";
      }
    }
    $this->asignarBeneficiario($con->rs, $arr['id'], $arr['fecha'], $archivo, $autor);
  }


  public function asignarBeneficiario($obj, $id, $fecha, $archivo, $autor){
    $this->load->model('kernel/KCalculoLote');
    $this->load->model('kernel/KDirectiva');
    $this->load->model('kernel/KNomina');
    $Directivas = $this->KDirectiva->Cargar($id); //Directivas
    $this->load->model('kernel/KPerceptron'); //Red Perceptron Aprendizaje de patrones
    $this->KNomina->Cargar( $this->_MapWNomina );

    $file = fopen("tmp/" . $archivo . ".csv","a") or die("Problemas");//Para Generar archivo csv 04102017
    $file_sqlCVS = fopen("tmp/" . $archivo . "-SQL.sql","a") or die("Problemas");//Para Generar archivo csv 04102017
    $file_log = fopen("tmp/" . $archivo . "-ERR.csv","a") or die("Problemas");
    $file_medida = fopen("tmp/" . $archivo . "-MJ.sql","a") or die("Problemas");
    $file_cajas = fopen("tmp/" . $archivo . "-CA.sql","a") or die("Problemas");

    $linea = 'CEDULA;APELLIDOS;NOMBRES;TIPO;BANCO;NUMERO CUENTA;FECHA INGRESO;FECHA ASCENSO;FECHA RETIRO;COMPONENTE;GRADO;GRADO DESC.;TIEMPO DE SERV.;';
    $linea .= 'ANTIGUEDAD;NUM. HIJOS;PORCENTAJE;';
    
    

    $sqlMJ = "INSERT INTO space.medidajudicial_detalle ( nomi, cedu, cben, bene, caut, naut, inst, tcue, ncue, pare, crea, usua, esta, mont ) VALUES ";
    $sqlCVS = "INSERT INTO space.pagos ( nomi, did, cedu, nomb, calc, fech, banc, nume, tipo, situ, esta, usua, neto, base, grad, caut ) VALUES ";
    
    $cant = count($this->_MapWNomina['Concepto']);
    $map = $this->_MapWNomina['Concepto'];
    $medida_str = "";
    $cajaahorro_str = "";
    for ($i= 0; $i < $cant; $i++){
      if( $map[$i]['codigo'] == "MJ-00001" ){
        $medida_str = "MEDIDA JUDICIAL;";
      }else if( substr($map[$i]['codigo'], 0, 2) == "CA" ){
        $cajaahorro_str = "CAJA DE AHORRO;";
      }else{
        $rs = strtoupper($map[$i]['codigo']);
        $linea .= $rs . ";";
      }
    }
    $linea .= $medida_str . $cajaahorro_str . 'ASIGNACION;DEDUCCION;NETO';
    if($this->_MapWNomina['tipo'] == "FCP"){
      $linea = 'CEDULA;APELLIDOS;NOMBRES;GRADO DESC.;ASIGNACION;PORCENTAJE;SUELDO BASE;PENSION;';
      $linea .= 'CEDULA;APELLIDOS;NOMBRES;PARENTESCO;TIPO;BANCO;NUMERO CUENTA;PENSION MIL;';
      $linea .= 'PORCENTAJE;ASIGNACION;DEDUCCION;NETO';
    }
    fputs($file,$linea);//Para Generar archivo csv 04102017
    fputs($file,"\n");//Salto de linea

    fputs($file_log, $linea . ";DESCRIPCION");//Para Generar archivo de log
    fputs($file_log, "\n");//Salto de linea


    fputs($file_sqlCVS, $sqlCVS);//INSERT SPACE.PAGOS
    fputs($file_medida, $sqlMJ);//INSERT SPACE.MEDIDAJUDICIALES    
    
    $funcion = $this->functionRefelxion;
    //print_r($Directivas);
    $coma = "";
    $linea = '';
    foreach ($obj as $k => $v) {
      $Bnf = new $this->MBeneficiario;
      $this->KCalculoLote->Instanciar($Bnf, $Directivas);
      $linea = $this->$funcion($Bnf,  $this->KCalculoLote, $this->KPerceptron, $fecha, $Directivas, $v, $this->KNomina->ID);
      //print_r($linea);
      if( $Bnf->estatus_activo != '201' ){
        $this->Paralizados++;
      }

      $this->Cantidad++;
      $this->CantidadMedida++;
      
      if($linea["csv"] != ""){
        if($this->_MapWNomina['tipo'] == "FCP"){
          fputs($file, $linea["csv"]); //Generacion CSV -> EXCEL
        }else{
          fputs($file,$linea["csv"]); //Generacion CSV -> EXCEL
          fputs($file,"\n");
        }
        
        /** INSERT PARA POSTGRES CIERRE DE LA NOMINA  */
        if ( $this->Cantidad > 1 ){
          $coma = ",";
        }
        if( $this->CantidadMedida > 1){
          $this->ComaMedida = ",";
        }
        if($this->_MapWNomina['tipo'] == "FCP"){
          $lineaSQL = $linea["sql"]; //INSERT PARA SPACE.PAGOS
        }else{
          $lineaSQL = $coma . $linea["sql"]; //INSERT PARA SPACE.PAGOS
        }
        fwrite( $file_sqlCVS, $lineaSQL);
        fputs( $file_medida, $this->SQLMedidaJudicial); //INSERT PARA SPACE.MEDIDAJUDICIAL_DETALLES
        $this->SQLMedidaJudicial = "";

        
       
        
      }else{
        if($linea["log"] != "" && $this->_MapWNomina['tipo'] == "FCP"){
          //$lin = $Bnf->cedula . ';' . $Bnf->apellidos . ';' . $Bnf->nombres . ';CON FAMILIARES EN CERO' . PHP_EOL;
          //fputs($file_log, $lin); //CREACION DE INCIDENCIAS
          fputs($file_log, $linea["log"]); //CREACION DE INCIDENCIAS
        }else{
          $lin = $Bnf->cedula . ';' . $Bnf->apellidos . ';' . $Bnf->nombres . PHP_EOL;
          fputs($file_log, $lin); //CREACION DE INCIDENCIAS
        }      
      }
      if ($Bnf->grado_codigo == 0){
        $linea = $Bnf->cedula . ';' . $Bnf->apellidos . ';' . $Bnf->nombres ;
        fputs($file_log, $linea); //CREACION DE INCIDENCIAS
        fputs($file_log, "\n");
      }

    }
    
    //echo "Sueldo Base Total: " . $this->Neto;
    $this->OidNomina = $this->KNomina->ID;
    $this->KNomina->Nombre = $archivo;
    $this->KNomina->Monto = $this->Neto;
    $this->KNomina->Tipo = $this->_MapWNomina["tipo"];
    $this->KNomina->Estatus = 1;
    $this->KNomina->Asignacion = $this->Asignacion;
    $this->KNomina->Deduccion = $this->Deduccion;
    $this->KNomina->Cantidad = $this->Cantidad;
    if($this->_MapWNomina['tipo'] == "FCP"){
      $this->KNomina->Cantidad = $this->OperarBeneficiarios;
      $this->Cantidad = $this->OperarBeneficiarios;
      $this->Anomalia = $this->AnomaliaSobreviviente;
      $this->Paralizados = $this->ParalizadosSobrevivientes;
    }
    $this->KNomina->Actualizar();

    $this->KNomina->RegistrarDetalle($this->OidNomina , $this->ResumenPresupuestario);
    fclose($file);//Para Generar archivo csv 04102017
    return true;
  }
  /**
  * Generar Codigos por Patrones en la Red de Inteligencia
  *
  * @param MBeneficiario
  * @param KCalculoLote
  * @param KPerceptron
  * @param KDirectiva
  * @param object
  * @return void
  */
  private function generarConPatrones(MBeneficiario &$Bnf, KCalculoLote &$CalculoLote, KPerceptron &$Perceptron, $fecha, $Directivas, $v, $sqlID){
      $Bnf->cedula = $v->cedula;
      $Bnf->deposito_banco = ""; //$v->cap_banco; //Individual de la Red
      $Bnf->apellidos = $v->apellidos; //Individual del Objeto
      $Bnf->nombres = $v->nombres; //Individual del Objeto
      
      $Bnf->fecha_ingreso = $v->fecha_ingreso;
      $Bnf->numero_hijos = $v->n_hijos;
      $Bnf->tipo = $v->tipo;
      $Bnf->banco = $v->banco;
      $Bnf->numero_cuenta = $v->numero_cuenta;
      $Bnf->situacion = $v->situacion;
      $Bnf->no_ascenso = $v->st_no_ascenso;
      $Bnf->componente_id = $v->componente_id;
      $Bnf->componente_nombre = $Directivas['com'][$v->componente_id];
      $Bnf->grado_codigo = $v->codigo;
      $Bnf->grado_nombre = $v->gnombre;
      $Bnf->fecha_ultimo_ascenso = $v->f_ult_ascenso;
      $Bnf->fecha_retiro = $v->f_retiro;
      $Bnf->prima_profesionalizacion_mt =  $v->st_profesion;
      $Bnf->estatus_profesion = $v->st_profesion;
      $Bnf->porcentaje = $v->porcentaje;
      

      $Bnf->prima_especial = $v->monto_especial;
      $Bnf->ano_reconocido = $v->anio_reconocido;
      $Bnf->mes_reconocido = $v->mes_reconocido;
      $Bnf->dia_reconocido = $v->dia_reconocido;
      $Bnf->estatus_activo = $v->status_id;
      $asignacion = 0;
      $deduccion = 0;
      $neto = 0;
      $medida_str = "";
      $cajaahorro_str = "";
      $abreviatura = "";
      $linea = '';
      $registro = '';
      $log = '';
      $patron = md5($v->fecha_ingreso.$v->f_retiro.$v->n_hijos.$v->st_no_ascenso.$v->componente_id.
        $v->codigo.$v->f_ult_ascenso.$v->st_profesion.
        $v->anio_reconocido.$v->mes_reconocido.$v->dia_reconocido.$v->porcentaje);

      $cant = count($this->_MapWNomina['Concepto']);
      $map = $this->_MapWNomina['Concepto'];
      $recibo_de_pago = array(); // Contruir el recibo de pago para un JSON

      //GENERADOR DE CALCULOS DINAMICOS
      if(!isset($Perceptron->Neurona[$patron])){
        $CalculoLote->Ejecutar();
        
        

        $segmentoincial = '';        
        
        $medida = $this->calcularMedidaJudicial($this->KMedidaJudicial,  $Bnf, $sqlID);
        $cajaahorro = $this->obtenerCajaAhorro( $Bnf );
        
        //Aplicar conceptos de Asignación
        for ($i= 0; $i < $cant; $i++){
          $rs = $map[$i]['codigo'];
          if (isset($Bnf->Concepto[$rs])) {            
            if( $Bnf->Concepto[$rs]['TIPO'] == 99 ){
              $medida_str = $medida[0] . ";";
              $deduccion +=  $medida[0]; 
              $abreviatura = $Bnf->Concepto[$rs]['ABV'];
              if($medida[0] != 0)$recibo_de_pago[] = array('desc' =>  $medida[1], 'tipo' => 99,'mont' => $medida[0]);
              $this->asignarPresupuesto($rs, $medida[0], '99', $abreviatura, $Bnf->Concepto[$rs]['part']);            
            }else if ( $Bnf->Concepto[$rs]['TIPO'] == 98 ){
              $cajaahorro_str = $cajaahorro . ";";
              $deduccion +=  $cajaahorro;
              $abreviatura = $Bnf->Concepto[$rs]['ABV'];
              if($cajaahorro != 0)$recibo_de_pago[] = array('desc' =>  $abreviatura, 'tipo' => 98,'mont' => $cajaahorro);  
              $this->asignarPresupuesto( $rs, $cajaahorro, '99', $abreviatura, $Bnf->Concepto[$rs]['part']);        
            }else{
              $monto_aux = $Bnf->Concepto[$rs]['mt'];
              $segmentoincial .=  $monto_aux . ";";
              $asignacion += $Bnf->Concepto[$rs]['TIPO'] == 1? $monto_aux: 0;
              $deduccion += $Bnf->Concepto[$rs]['TIPO'] == 0? $monto_aux: 0;
              $deduccion += $Bnf->Concepto[$rs]['TIPO'] == 2? $monto_aux: 0;        
              if($monto_aux != 0)$recibo_de_pago[] = array('desc' =>  $rs, 'tipo' => $Bnf->Concepto[$rs]['TIPO'],'mont' => $monto_aux);
              //asgnar prepuesto
              $this->asignarPresupuesto($rs, $Bnf->Concepto[$rs]['mt'], $Bnf->Concepto[$rs]['TIPO'], $Bnf->Concepto[$rs]['ABV'], $Bnf->Concepto[$rs]['part']);
               
            }
            
            //

          }else{
            $segmentoincial .= "0;";
          }
        }        
        
        
        
        
        $segmentoincial = $Bnf->fecha_ingreso . ';' . $Bnf->fecha_ultimo_ascenso . 
            ';' . $Bnf->fecha_retiro . ';' . $Bnf->componente_nombre . ';' . $Bnf->grado_codigo . 
            ';' . $Bnf->grado_nombre . ';' . $Bnf->tiempo_servicio . ';' . $Bnf->antiguedad_grado . 
            ';' . $Bnf->numero_hijos . ';' . $Bnf->porcentaje . ';' . $segmentoincial;

        $Perceptron->Aprender($patron, array(
          'RECUERDO' => $segmentoincial,
          'ASIGNACION' => $asignacion,
          'DEDUCCION' => $deduccion,
          'SUELDOBASE' => $Bnf->sueldo_base,
          'PENSION' => $Bnf->pension,
          'PORCENTAJE' => $Bnf->porcentaje,
          'CONCEPTO' => $Bnf->Concepto,
          'RECIBO' => $recibo_de_pago
          ) );
               
        $neto = $asignacion - $deduccion;
        
        if ($Bnf->sueldo_base > 0 && $Bnf->porcentaje > 0 ){
          $linea = $Bnf->cedula . ';' . trim($Bnf->apellidos) . ';' . trim($Bnf->nombres) . 
           ';' .  $Bnf->tipo . ";'" . $Bnf->banco . ";'" . $Bnf->numero_cuenta . 
           ";" . $this->generarLinea($segmentoincial) . $medida_str . 
           $cajaahorro_str . $asignacion . ';' . $deduccion . ';'  . $neto;
        
        
        }else{
          $log = $Bnf->cedula . ';' . $Bnf->apellidos . ';' . $Bnf->nombres . ';';
         
        }

        
        $this->KRecibo->conceptos = $recibo_de_pago;        
        $this->KRecibo->asignaciones = $asignacion;
        $this->KRecibo->deducciones = $deduccion;
        //Insert a Postgres
        $base = $Bnf->porcentaje . "|" . $Bnf->componente_id . "|" . $Bnf->grado_codigo . "|" . $Bnf->grado_nombre; 
        $registro = "(" . $sqlID . "," . $Directivas['oid'] . ",'" . $Bnf->cedula . 
        "','" . trim($Bnf->apellidos) . ", " . trim($Bnf->nombres) . "','" . 
        json_encode($this->KRecibo) . "',Now(),'" . $Bnf->banco . "','" . $Bnf->numero_cuenta . 
        "','" . $Bnf->tipo . "','" . $Bnf->situacion . "'," . $Bnf->estatus_activo . 
        ",'SSSIFANB'," . $neto . ", '" . $base . "','" . $Bnf->grado_nombre . "','')";

      }else{      //En el caso que exista el recuerdo en la memoria   
        $medida = $this->calcularMedidaJudicial($this->KMedidaJudicial,  $Bnf,  $sqlID);
        $cajaahorro = $this->obtenerCajaAhorro(  $Bnf );

        $deduccion = $Perceptron->Neurona[$patron]["DEDUCCION"];
        $asignacion = $Perceptron->Neurona[$patron]["ASIGNACION"];
        $NConcepto = $Perceptron->Neurona[$patron]["CONCEPTO"];

        for ($i= 0; $i < $cant; $i++){
          $result = $map[$i]['codigo'];
          if (isset($NConcepto[$result])) {                    
            if( $NConcepto[$result]['TIPO'] == 99 ){ //MEDIDA JUDICIAL
              $medida_str = $medida[0] . ";";
              $deduccion +=  $medida[0];
              $abreviatura = $NConcepto[$result]['ABV'];
              if($medida[0] != 0)$recibo_de_pago[] = array('desc' =>  $medida[1], 'tipo' => 99,'mont' => $medida[0]);
              $this->asignarPresupuesto( $result, $medida[0], '99', $abreviatura, $NConcepto[$result]['part']);            
            }else if ( $NConcepto[$result]['TIPO'] == 98 ){ //CAJAS DE AHORRO
              $cajaahorro_str = $cajaahorro . ";";
              $deduccion +=  $cajaahorro;
              $abreviatura = $NConcepto[$result]['ABV'];
              if($cajaahorro != 0)$recibo_de_pago[] = array('desc' =>  $abreviatura, 'tipo' => 98,'mont' => $cajaahorro);
              $this->asignarPresupuesto($result, $cajaahorro, '98', $abreviatura, $NConcepto[$result]['part']); 
            }else{
              $monto_aux = $NConcepto[$result]['mt'];
              $abreviatura_aux = $NConcepto[$result]['ABV'];
              if($monto_aux != 0)$recibo_de_pago[] = array('desc' =>  $abreviatura_aux, 'tipo' => $NConcepto[$result]['TIPO'],'mont' => $monto_aux);
              $this->asignarPresupuesto($result, $monto_aux, $NConcepto[$result]['TIPO'], $abreviatura_aux, $NConcepto[$result]['part']);
            }
          }
        }        

        $neto = $asignacion - $deduccion;
        if($Perceptron->Neurona[$patron]["SUELDOBASE"] > 0   && $Perceptron->Neurona[$patron]["PORCENTAJE"] > 0  ){
          $linea = $Bnf->cedula . ';' . trim($Bnf->apellidos) . ';' . trim($Bnf->nombres) . 
          ';' .  $Bnf->tipo . ";\"" . $Bnf->banco . "\";\"" . $Bnf->numero_cuenta . 
          "\";" . $this->generarLineaMemoria($Perceptron->Neurona[$patron]) .
          $medida_str . $cajaahorro_str . $asignacion . ';' . $deduccion . ';' . $neto;
        }else{
          $log = $Bnf->cedula . ';' . $Bnf->apellidos . ';' . $Bnf->nombres . ';';
        
        }
        
        $this->KRecibo->conceptos = $recibo_de_pago;
        $this->KRecibo->asignaciones = $asignacion;
        $this->KRecibo->deducciones = $deduccion;
        //Insert a Postgres
        $base = $Bnf->porcentaje . "|" . $Bnf->componente_id . "|" . $Bnf->grado_codigo . "|" . $Bnf->grado_nombre;
        $registro = "(" . $sqlID . "," . $Directivas['oid'] . ",'" . $Bnf->cedula . 
        "','" . trim($Bnf->apellidos) . ", " . trim($Bnf->nombres) . "','" . 
        json_encode($this->KRecibo) . "',Now(),'" . $Bnf->banco . "','" . $Bnf->numero_cuenta . 
        "','" . $Bnf->tipo . "', '" . $Bnf->situacion . "', " . $Bnf->estatus_activo . 
        ", 'SSSIFANB'," . $neto . ",'" . $base . "','" . $Bnf->grado_nombre . "','')";
        
      }

      $this->SSueldoBase += $Bnf->sueldo_base;
      $this->Asignacion += $asignacion;
      $this->Deduccion += $deduccion;
      $this->Neto += $neto;
      $obj["csv"] = $linea;
      $obj["sql"] = $registro;
      $obj["log"] = $log;
      return $obj;

  }













  /**
  * DIFERENCIAS DE SUELDO PARA RETIRADOS CON PENSION
  *
  * @param MBeneficiario
  * @param KCalculoLote
  * @param KPerceptron
  * @param KDirectiva
  * @param object
  * @return void
  */
  private function generarConPatronesRCPDIF(MBeneficiario &$Bnf, KCalculoLote &$CalculoLote, KPerceptron &$Perceptron, $fecha, $Directivas, $v, $sqlID){
    $Bnf->cedula = $v->cedula;
    $Bnf->deposito_banco = ""; //$v->cap_banco; //Individual de la Red
    $Bnf->apellidos = $v->apellidos; //Individual del Objeto
    $Bnf->nombres = $v->nombres; //Individual del Objeto
    
    $Bnf->fecha_ingreso = $v->fecha_ingreso;
    $Bnf->numero_hijos = $v->n_hijos;
    $Bnf->tipo = $v->tipo;
    $Bnf->banco = $v->banco;
    $Bnf->numero_cuenta = $v->numero_cuenta;
    $Bnf->situacion = $v->situacion;
    $Bnf->no_ascenso = $v->st_no_ascenso;
    $Bnf->componente_id = $v->componente_id;
    $Bnf->componente_nombre = $Directivas['com'][$v->componente_id];
    $Bnf->grado_codigo = $v->codigo;
    $Bnf->grado_nombre = $v->gnombre;
    $Bnf->fecha_ultimo_ascenso = $v->f_ult_ascenso;
    $Bnf->fecha_retiro = $v->f_retiro;
    $Bnf->prima_profesionalizacion_mt =  $v->st_profesion;
    $Bnf->estatus_profesion = $v->st_profesion;
    $Bnf->porcentaje = $v->porcentaje;
    

    $Bnf->prima_especial = $v->monto_especial;
    $Bnf->ano_reconocido = $v->anio_reconocido;
    $Bnf->mes_reconocido = $v->mes_reconocido;
    $Bnf->dia_reconocido = $v->dia_reconocido;
    $Bnf->estatus_activo = $v->status_id;
    $asignacion = 0;
    $deduccion = 0;
    $neto = 0;
    $medida_str = "";
    $cajaahorro_str = "";
    $abreviatura = "";
    $linea = '';
    $registro = '';
    $log = '';
   
    $cant = count($this->_MapWNomina['Concepto']);
    $map = $this->_MapWNomina['Concepto'];
    //    print_r($this->Archivos);
    $recibo_de_pago = array(); // Contruir el recibo de pago para un JSON

    //GENERADOR DE CALCULOS DINAMICOS
    $segmentoincial = '';        
    
    //$medida = $this->calcularMedidaJudicial($this->KMedidaJudicial,  $Bnf, $sqlID);
    
    $asignacion = 0;
    $deduccion = 0;
    $sueldo_mensual = 0;
    $monto_str = '';
    
    for ($i= 0; $i < $cant; $i++){
      $rs = $map[$i]['codigo'];
      $monto = $this->obtenerArchivos($Bnf, $rs);      
      if($monto > 0 ){
        $monto_str .= $monto . ';';
        $asignacion += $monto;
        $this->asignarPresupuesto( $rs,$asignacion,  '1', $map[$i]['nombre'], $map[$i]['partida']);         
      }else{
        $valor = $monto * -1 ;
        $monto_str .= $valor . ';';
        $deduccion +=  $valor;
        $this->asignarPresupuesto( $rs, $deduccion, '2', $map[$i]['nombre'], $map[$i]['partida']);
      }
    } 
  
      
    $segmentoincial = $Bnf->fecha_ingreso . ';' . $Bnf->fecha_ultimo_ascenso . 
        ';' . $Bnf->fecha_retiro . ';' . $Bnf->componente_nombre . ';' . $Bnf->grado_codigo . 
        ';' . $Bnf->grado_nombre . ';' . $Bnf->tiempo_servicio . ';' . $Bnf->antiguedad_grado . 
        ';' . $Bnf->numero_hijos . ';' . $Bnf->porcentaje . ';' . $monto_str;


    $neto = $asignacion - $deduccion;
    
    if ($asignacion > 0 ){
      $linea = $Bnf->cedula . ';' . trim($Bnf->apellidos) . ';' . trim($Bnf->nombres) . 
        ';' .  $Bnf->tipo . ";'" . $Bnf->banco . ";'" . $Bnf->numero_cuenta . 
        ";" . $segmentoincial  . $asignacion . ';' . $deduccion . ';'  . $neto;
      
        $this->KRecibo->conceptos = $recibo_de_pago;        
        $this->KRecibo->asignaciones = $asignacion;
        $this->KRecibo->deducciones = $deduccion;
        
        //Insert a Postgres
        $base = $Bnf->porcentaje . "|" . $Bnf->componente_id . "|" . $Bnf->grado_codigo . "|" . $Bnf->grado_nombre; 
        $registro = "(" . $sqlID . "," . $Directivas['oid'] . ",'" . $Bnf->cedula . 
        "','" . trim($Bnf->apellidos) . ", " . trim($Bnf->nombres) . "','" . 
        json_encode($this->KRecibo) . "',Now(),'" . $Bnf->banco . "','" . $Bnf->numero_cuenta . 
        "','" . $Bnf->tipo . "','" . $Bnf->situacion . "'," . $Bnf->estatus_activo . 
        ",'SSSIFANB'," . $neto . ", '" . $base . "', '" . $Bnf->grado_nombre . "','')";
        
    
    }else{
      $log = $Bnf->cedula . ';' . $Bnf->apellidos . ';' . $Bnf->nombres . ';';
      
    }

    $this->SSueldoBase += $Bnf->sueldo_base;
    $this->Asignacion += $asignacion;
    $this->Deduccion += $deduccion;
    $this->Neto += $neto;
    $obj["csv"] = $linea;
    $obj["sql"] = $registro;
    $obj["log"] = $log;
    return $obj;

}











  /**
  * Generar Codigos por Patrones en la Red de Inteligencia Pensionados Sobrevivientes
  *
  * @param MBeneficiario
  * @param KCalculoLote
  * @param KPerceptron
  * @param KDirectiva
  * @param object
  * @return void
  */
  private function generarConPatronesFCP(MBeneficiario &$Bnf, KCalculoLote &$CalculoLote, KPerceptron &$Perceptron, $fecha, $Directivas, $v, $sqlID){
    $Bnf->cedula = $v->cedula;
    $Bnf->deposito_banco = ""; //$v->cap_banco; //Individual de la Red
    $Bnf->apellidos = $v->apellidos; //Individual del Objeto
    $Bnf->nombres = $v->nombres; //Individual del Objeto
    
    $Bnf->fecha_ingreso = $v->fecha_ingreso;
    $Bnf->numero_hijos = $v->n_hijos;
    $Bnf->tipo = $v->tipo;
    $Bnf->banco = $v->banco;
    $Bnf->numero_cuenta = $v->numero_cuenta;
    $Bnf->situacion = $v->situacion;
    $Bnf->no_ascenso = $v->st_no_ascenso;
    $Bnf->componente_id = $v->componente_id;
    $Bnf->componente_nombre = $Directivas['com'][$v->componente_id];
    $Bnf->grado_codigo = $v->codigo;
    $Bnf->grado_nombre = $v->gnombre;
    $Bnf->fecha_ultimo_ascenso = $v->f_ult_ascenso;
    $Bnf->fecha_retiro = $v->f_retiro;
    $Bnf->prima_profesionalizacion_mt =  $v->st_profesion;
    $Bnf->estatus_profesion = $v->st_profesion;
    $Bnf->porcentaje = $v->porcentaje;
    

    $Bnf->prima_especial = $v->monto_especial;
    $Bnf->ano_reconocido = $v->anio_reconocido;
    $Bnf->mes_reconocido = $v->mes_reconocido;
    $Bnf->dia_reconocido = $v->dia_reconocido;
    $Bnf->estatus_activo = $v->status_id;
    $asignacion = 0;
    $deduccion = 0;
    $neto = 0;
    $medida_str = "";
    $cajaahorro_str = "";
    $abreviatura = "";
    $linea = '';
    $registro = '';
    $log = '';
    $anomalia = 0;
    $this->CantidadSobreviviente++;

    $cant = count($this->_MapWNomina['Concepto']);
    $map = $this->_MapWNomina['Concepto'];
    $recibo_de_pago = array(); // Contruir el recibo de pago para un JSON

    //GENERADOR DE CALCULOS DINAMICOS
    // if(!isset($Perceptron->Neurona[$patron])){
    $CalculoLote->Ejecutar();

    $segmentoincial = '';

     //Aplicar conceptos de Asignación
    // for ($i= 0; $i < $cant; $i++){
    //   $rs = $map[$i]['codigo'];
    //   if (isset($Bnf->Concepto[$rs])) {            
    //     if( $Bnf->Concepto[$rs]['TIPO'] == 99 ){
    //     }else if ( $Bnf->Concepto[$rs]['TIPO'] == 98 ){
    //     }else{
    //       $monto_aux = $Bnf->Concepto[$rs]['mt'];
    //       $segmentoincial .=  $monto_aux . ";";
    //       $asignacion += $Bnf->Concepto[$rs]['TIPO'] == 1? $monto_aux: 0;
    //       $deduccion += $Bnf->Concepto[$rs]['TIPO'] == 0? $monto_aux: 0;
    //       $deduccion += $Bnf->Concepto[$rs]['TIPO'] == 2? $monto_aux: 0;        
    //       if($monto_aux != 0)$recibo_de_pago[] = array('desc' =>  $rs, 'tipo' => $Bnf->Concepto[$rs]['TIPO'],'mont' => $monto_aux);

    //       $this->asignarPresupuesto($rs, $Bnf->Concepto[$rs]['mt'], $Bnf->Concepto[$rs]['TIPO'], $Bnf->Concepto[$rs]['ABV'], $Bnf->Concepto[$rs]['part']) ;     
    //     }

    //   }else{
    //     $segmentoincial .= "0;";
    //   }
    // }    



    //$Bnf->pension = $asignacion;
    //print_r( $Bnf->pension );

    $segmentoincial = $Bnf->cedula . ';' . $Bnf->apellidos . ';' . $Bnf->nombres . 
    ';' . $Bnf->grado_nombre . ';' . round($Bnf->total_asignacion,2) . ';' . $Bnf->porcentaje . 
    ';' . $Bnf->sueldo_base . ';' . round($Bnf->pension,2) ;
    $asignaciont = 0;
    $deducciont = 0;
    $netot = 0;
    $linea = "";
    $i = 0;
    
    if(isset($this->FCP[$Bnf->cedula])){
      $PS = $this->FCP[$Bnf->cedula];
      foreach ($PS as $clv => $val) {
        $medida_str = "";
        $cajaahorro_str = "";
        
        $asignacionp = (round($Bnf->pension,2) * round($PS[$i]['porcentaje'],2) )/100 ;
        $deduccionp = round(($asignacionp * 6.5) / 100, 2);
        $neto = $asignacionp - $deduccionp;

        
        
        if( $PS[$i]['estatus'] == 201  ){
          if ($neto > 0 ){            
            $linea .= $segmentoincial . 
            ';' . $PS[$i]['cedula'] . ';' . $PS[$i]['apellidos'] . ';' . $PS[$i]['nombres'] . 
            ';' . $PS[$i]['parentesco'] . ';' . $PS[$i]['tipo'] . ";'" . $PS[$i]['banco'] . ";'" . $PS[$i]['numero'] . 
            ';' . round($Bnf->pension,2) . ';' . round($PS[$i]['porcentaje'],2) . 
            ";" . round($asignacionp,2) . ';' . round($deduccionp,2) . ';' . round($neto,2) . PHP_EOL;

            $asignaciont += $asignacionp;
            $deducciont += $deduccionp;
            $netot +=  $asignacionp - $deduccionp;
            $this->OperarBeneficiarios++;
            $recibo_de_pago[] = array(
              'desc' =>  'PENSION SOBREVIVIENTE', 
              'tipo' => 97,
              'mont' => $asignacionp
            );
            $recibo_de_pago[] = array(
              'desc' =>  'COTIZ 6.5% PENSIONES (FONDO CIS)', 
              'tipo' => 0,
              'mont' => $deducciont
            );
            $this->KRecibo->conceptos = $recibo_de_pago;        
            $this->KRecibo->asignaciones = $asignacion;
            $this->KRecibo->deducciones = $deduccion;
            $base = $Bnf->porcentaje . "|" . $Bnf->componente_id . "|" . $Bnf->grado_codigo . "|" . $Bnf->grado_nombre;
            $registro .= $this->ComaFallecidos . "(" . $sqlID . "," . $Directivas['oid'] . ",'" . $Bnf->cedula . 
            "','" . trim($Bnf->apellidos) . ", " . trim($Bnf->nombres) . "','" . 
            json_encode($this->KRecibo) . "',Now(),'" . $Bnf->banco . "','" . $Bnf->numero_cuenta . 
            "','" . $Bnf->tipo . "', '" . $Bnf->situacion . "', " . $Bnf->estatus_activo . 
            ", 'SSSIFANB'," . $neto . ", '" . $base . "', '" . $Bnf->grado_nombre . "','" . $PS[$i]['autorizado'] . "')";

          }else{
            $this->SinPagos++;
            $log .= $segmentoincial . 
            ';' . $PS[$i]['cedula'] . ';' . $PS[$i]['apellidos'] . ';' . $PS[$i]['nombres'] . 
            ';' . $PS[$i]['parentesco'] . ';' . $PS[$i]['tipo'] . ";'" . $PS[$i]['banco'] . ";'" . $PS[$i]['numero'] . 
            ';' . round($Bnf->pension,2) . ';' . round($PS[$i]['porcentaje'],2) . 
            ';0;0;0;Sin monto a cobrar' . PHP_EOL;            
          }
          
        }else{
          
          $log .= $segmentoincial . 
          ';' . $PS[$i]['cedula'] . ';' . $PS[$i]['apellidos'] . ';' . $PS[$i]['nombres'] . 
          ';' . $PS[$i]['parentesco'] . ';' . $PS[$i]['tipo'] . ";'" . $PS[$i]['banco'] . ";'" . $PS[$i]['numero'] . 
          ';' . round($Bnf->pension,2) . ';' . round($PS[$i]['porcentaje'],2) . 
          ";" . round($asignacionp,2) . ';' . round($deduccionp,2) . ';' . round($neto,2) . ';Paralizado (' . $PS[$i]['estatus'] . 
          ')' . PHP_EOL;

          $this->ParalizadosSobrevivientes++;
        }
        $i++;
        
      }
  
      
    }else{
      $log .=  $Bnf->cedula . ";Militar fallecido sin familiares " . PHP_EOL;
      //$this->ParalizadosSobrevivientes++;
    }
    
    $this->asignarPresupuesto( "FCIS-00001", $deducciont , '0', 'FONDO CIS 6.5%', '40700000000');
    $this->asignarPresupuesto( "PSV0001", $asignaciont , '0', 'PENSION MILITAR', '40700000000');

    // }else{ //Recordando calculos

    // }
    //$this->Cantidad += $i;
    //$this->SSueldoBase += $Bnf->pension;
    $this->Asignacion += $asignaciont;
    $this->Deduccion += $deducciont;
    $this->Neto += $netot;

    $obj["csv"] = $linea;
    $obj["sql"] = "";
    $obj["log"] = $log;
    return $obj;

  }





  /**
  * DIFERENCIAS DE SUELDO PARA PENSIONADOS SOBREVIVIENTES
  *
  * @param MBeneficiario
  * @param KCalculoLote
  * @param KPerceptron
  * @param KDirectiva
  * @param object
  * @return void
  */
private function generarConPatronesFCPDIF(MBeneficiario &$Bnf, KCalculoLote &$CalculoLote, KPerceptron &$Perceptron, $fecha, $Directivas, $v, $sqlID){
  $Bnf->cedula = $v->cedula;
  $Bnf->deposito_banco = ""; //$v->cap_banco; //Individual de la Red
  $Bnf->apellidos = $v->apellidos; //Individual del Objeto
  $Bnf->nombres = $v->nombres; //Individual del Objeto
  
  $Bnf->fecha_ingreso = $v->fecha_ingreso;
  $Bnf->numero_hijos = $v->n_hijos;
  $Bnf->tipo = $v->tipo;
  $Bnf->banco = $v->banco;
  $Bnf->numero_cuenta = $v->numero_cuenta;
  $Bnf->situacion = $v->situacion;
  $Bnf->no_ascenso = $v->st_no_ascenso;
  $Bnf->componente_id = $v->componente_id;
  $Bnf->componente_nombre = $Directivas['com'][$v->componente_id];
  $Bnf->grado_codigo = $v->codigo;
  $Bnf->grado_nombre = $v->gnombre;
  $Bnf->fecha_ultimo_ascenso = $v->f_ult_ascenso;
  $Bnf->fecha_retiro = $v->f_retiro;
  $Bnf->prima_profesionalizacion_mt =  $v->st_profesion;
  $Bnf->estatus_profesion = $v->st_profesion;
  $Bnf->porcentaje = $v->porcentaje;
  

  $Bnf->prima_especial = $v->monto_especial;
  $Bnf->ano_reconocido = $v->anio_reconocido;
  $Bnf->mes_reconocido = $v->mes_reconocido;
  $Bnf->dia_reconocido = $v->dia_reconocido;
  $Bnf->estatus_activo = $v->status_id;
  $asignacion = 0;
  $deduccion = 0;
  $neto = 0;
  $medida_str = "";
  $cajaahorro_str = "";
  $abreviatura = "";
  $linea = '';
  $registro = '';
  $log = '';
 
  $cant = count($this->_MapWNomina['Concepto']);
  $map = $this->_MapWNomina['Concepto'];
  //    print_r($this->Archivos);
  $recibo_de_pago = array(); // Contruir el recibo de pago para un JSON

  //GENERADOR DE CALCULOS DINAMICOS
  $segmentoincial = '';        
  $i = 0;
  if(isset($this->FCP[$Bnf->cedula])){
    $PS = $this->FCP[$Bnf->cedula];
    
    foreach ($PS as $clv => $val) {
      $asignacion = 0;
      $deduccion = 0;
      $sueldo_mensual = 0;
      $monto_str = '';
      for ($j= 0; $j < $cant; $j++){
        $rs = $map[$j]['codigo'];
        $monto = $this->obtenerArchivosFCP($PS[$i]['cedula'], $rs); 
        //print_r($PS[$i]['cedula'] . "   Ca\n");
        if($monto > 0 ){
          $monto_str .= $monto . ';';
          $asignacion += $monto;
          $this->asignarPresupuesto( $rs,$asignacion,  '1', $map[$j]['nombre'], $map[$j]['partida']);         
        }else if($monto < 0) {
          $valor = $monto * -1 ;
          $monto_str .= $valor . ';';
          $deduccion +=  $valor;
          $this->asignarPresupuesto( $rs, $deduccion, '2', $map[$j]['nombre'], $map[$j]['partida']);
        }
      } 

      $segmentoincial = $Bnf->cedula . ';' . $Bnf->apellidos . ';' . $Bnf->nombres . 
      ';' . $Bnf->grado_nombre . ';' . round($Bnf->total_asignacion,2) . 
      ';' . $Bnf->porcentaje . ';' . $Bnf->sueldo_base . ';' . round($Bnf->pension,2); // . ';' . $monto_str;   
            



      
      $neto = $asignacion - $deduccion;
      
      if ($neto > 0 ){

        $linea .= $segmentoincial . 
            ';' . $PS[$i]['cedula'] . ';' . $PS[$i]['apellidos'] . ';' . $PS[$i]['nombres'] . 
            ';' . $PS[$i]['parentesco'] . ';' . $PS[$i]['tipo'] . ";'" . $PS[$i]['banco'] . ";'" . $PS[$i]['numero'] . 
            ';' . round($Bnf->pension,2) . ';' . round($PS[$i]['porcentaje'],2) . 
            ";" . round($asignacion,2) . ';' . round($deduccion,2) . ';' . round($neto,2) . PHP_EOL;
          $this->OperarBeneficiarios++;
          $this->KRecibo->conceptos = $recibo_de_pago;        
          $this->KRecibo->asignaciones = $asignacion;
          $this->KRecibo->deducciones = $deduccion;
          $coma = "";
          if($this->OperarBeneficiarios > 1){
            $coma = ",";
          }

          //Insert a Postgres
          $base = $Bnf->porcentaje . "|" . $Bnf->componente_id . "|" . $Bnf->grado_codigo . "|" . $Bnf->grado_nombre; 
          $registro .= $coma . "(" . $sqlID . "," . $Directivas['oid'] . ",'" . $Bnf->cedula . 
          "','" . trim($Bnf->apellidos) . ", " . trim($Bnf->nombres) . "','" . 
          json_encode($this->KRecibo) . "',Now(),'" .  $PS[$i]['banco']  . "','" . $PS[$i]['numero'] . 
          "','" . $PS[$i]['tipo'] . "','" . $Bnf->situacion . "'," . $Bnf->estatus_activo . 
          ",'SSSIFANB'," . $neto . ", '" . $base . "', '" . $Bnf->grado_nombre . "','" . $PS[$i]['autorizado'] . "')";
          $this->Asignacion += $asignacion;
          $this->Deduccion += $deduccion;
          
      }else{
        $log = $Bnf->cedula . ';' . $Bnf->apellidos . ';' . $Bnf->nombres . ';' . PHP_EOL;;
        
      }
      $i++;
  
    }
  }
      
      
      
        //$medida = $this->calcularMedidaJudicial($this->KMedidaJudicial,  $Bnf, $sqlID);
        
       
 
  $this->SSueldoBase += $Bnf->sueldo_base;
  
  $this->Neto += $neto;
  $obj["csv"] = $linea;
  $obj["sql"] = $registro;
  $obj["log"] = $log;
  return $obj;

}



































  //MEDIDA JUDICIAL INDIVIDUAL
  private function calcularMedidaJudicial( KMedidaJudicial &$KMedida, MBeneficiario &$Bnf,  $sqlID ){
    $monto = 0;
    $nombre = "";
    $cuenta = "";
    $autorizado = "";
    $cedula = "";
    if(isset($this->MedidaJudicial[$Bnf->cedula])){          
      $MJ = $this->MedidaJudicial[$Bnf->cedula];
      //( cedu, cben, bene, caut, naut, inst, tcue, ncue, pare, crea, usua, esta, mont ) VALUES ";

      $cantMJ = count($MJ);
      for($i = 0; $i < $cantMJ; $i++){
        $monto += $KMedida->Ejecutar($Bnf->pension, 1, $MJ[$i]['fnxm']);
        $nombre = $MJ[$i]['nomb'];
        $parentesco = $MJ[$i]['pare'];
        $cbenef = $MJ[$i]['cben'];
        $nbenef = $MJ[$i]['bene'];
        
        $cedula = $MJ[$i]['caut'];        
        $autorizado = $MJ[$i]['auto'];
        $instituto = $MJ[$i]['auto'];
        $tipobanco = $MJ[$i]['tcue'];
        $cuenta = $MJ[$i]['ncue'];

        $this->SQLMedidaJudicial .= $this->ComaMedida . "('" . $sqlID . "','" . $Bnf->cedula . "','" .
        $cbenef . "','" . $nbenef . "','" . $cedula . "','" . $autorizado . "','" . $instituto . 
        "','" . $tipobanco . "','" . $cuenta . "','" . $parentesco . 
        "',Now(),'SSSIFAN',1," . $monto . ")";

      }   
      
    }
    return [ $monto, $nombre, $cuenta, $autorizado, $cedula];
  }

  private function obtenerArchivosFCP( $cedula, $concepto  ){
    
    $monto = $this->KArchivos->Ejecutar($cedula, $concepto, $this->Archivos);
    
    return $monto;
  }
  private function obtenerArchivos( MBeneficiario &$Bnf, $concepto  ){
    $monto = $this->KArchivos->Ejecutar($Bnf->cedula, $concepto, $this->Archivos);
    return $monto;
  }

  private function obtenerCajaAhorro( MBeneficiario &$Bnf ){
    return $this->KArchivos->Ejecutar($Bnf->cedula, "CA-00001", $this->Archivos);
  }

  private function generarLinea($Recuerdo){
        return $Recuerdo;
  }

  private function generarLineaMemoria($Recuerdo){
    return $Recuerdo['RECUERDO'];

  }

  private function asignarPresupuesto($rs, $mt, $tp, $ab, $part){
    
    if (isset($this->ResumenPresupuestario[$rs])){
      $mt_aux = $this->ResumenPresupuestario[$rs]['mnt'];
      if($mt_aux > 0){
        $this->ResumenPresupuestario[$rs] =  array( 
          'mnt' => $mt_aux + $mt, 
          'tp' => $tp, 
          'abv' => $ab,
          'estr' => '',
          'part' => $part
        );
      }
    }else{
      if($mt > 0){
        $this->ResumenPresupuestario[$rs] = array( 
          'mnt' => $mt, 
          'tp' => $tp, 
          'abv' => $ab,
          'estr' => '',
          'part' => $part
        );
      }
    }
  }
 
  private function validarEstatusParalizado(MBeneficiario &$Bnf){
    switch ($Bnf->estatus_id) {
      case 201:
        
        break;
      case 202:

        break;
      default:
        
        break;
    }
  }
  /**
  * Crear Txt Para los bancos e insertar movimientos
  *
  * @param string
  * @param int
  * @return array
  */
  function CrearInsertPostgresql( $archivo =  '', $oid = 0, $estatus = 0, $llave = '' ){
    //  Habilitar permisos en linux Centos 7
    //  /sbin/restorecon -v /var/www/html/CI-3.1.10/tmp/script.sh
    // getsebool -a | grep httpd  
    // setsebool -P httpd_ssi_exec=1
    // ausearch -c 'psql' --raw | audit2allow -M mi-psql
    // semodule -i mi-psql.pp
    $fecha = Date("Y-m-d");


    $ruta = explode("/", BASEPATH);
    $c = count($ruta)-2;
    $r = '/';
    for ($i=1; $i < $c; $i++) {
      $r .= $ruta[$i] . '/';
    }

    $r .= 'tmp/' . $archivo . '-SQL';
    $comando = 'cd tmp/; time ./load.sh ' . $r . ' 2>&1';
    exec($comando, $bash);
    $res[] = $bash;

    $r .= 'tmp/' . $archivo . '-MJ';
    $comando = 'cd tmp/; time ./load.sh ' . $r . ' 2>&1';
    exec($comando, $bash);
    $res[] = $bash;

    $sUpdate = 'UPDATE  space.nomina SET esta=4, llav = \'' . $llave . '\'  WHERE oid=' . $oid . ';';
    $rs = $this->DBSpace->consultar($sUpdate);

    $this->Resultado = array(
      'a' => $archivo,
      'll' => $llave,
      'rs' => $bash
    );
    
    return $this->Resultado;
  }












  public function cargarFamiliaresFCP(){
    $sConsulta = "SELECT bnf.cedula AS cedu, fam.cedula, fam.nombres, fam.apellidos, 
      fam.parentesco, fam.autorizado, fam.tipo, fam.banco, fam.numero,
      fam.porcentaje, fam.motivo, fam.estatus
    FROM beneficiario bnf  JOIN familiar fam ON bnf.cedula=fam.titular";
    $obj = $this->DBSpace->consultar($sConsulta);
    foreach($obj->rs as $c => $v ){      
        $this->FCP[$v->cedu][] = array(
          "cedula" => $v->cedula, 
          "nombres" => $v->nombres,
          "apellidos" => $v->apellidos,
          "parentesco" => $v->parentesco,
          "autorizado" => $v->autorizado,
          "tipo" => $v->tipo,
          "estatus" => $v->estatus,
          "banco" => $v->banco,
          "numero" => $v->numero,
          "porcentaje" => $v->porcentaje,
          "motivo" => $v->motivo
        );
    }
  }

  public function distribuirFamiliares($Bnf){
    $segmentoincial = '';        

  }

  
  //MEDIDA JUDICIAL INDIVIDUAL
  private function calcularMedidaJudicialFamiliar( KMedidaJudicial &$KMedida, $strCedula = "", $sueldo = 0.00  ){
    $monto = 0;
    $nombre = "";
    $cuenta = "";
    $autorizado = "";
    $cedula = "";
    if(isset($this->MedidaJudicial[$strCedula])){          
      $MJ = $this->MedidaJudicial[$strCedula];
      //( cedu, cben, bene, caut, naut, inst, tcue, ncue, pare, crea, usua, esta, mont ) VALUES ";

      $cantMJ = count($MJ);
      for($i = 0; $i < $cantMJ; $i++){
        $monto += $KMedida->Ejecutar($sueldo, 1, $MJ[$i]['fnxm']);
        $nombre = $MJ[$i]['nomb'];
        $parentesco = $MJ[$i]['pare'];
        $cbenef = $MJ[$i]['cben'];
        $nbenef = $MJ[$i]['bene'];
        
        $cedula = $MJ[$i]['caut'];        
        $autorizado = $MJ[$i]['auto'];
        $instituto = $MJ[$i]['auto'];
        $tipobanco = $MJ[$i]['tcue'];
        $cuenta = $MJ[$i]['ncue'];

        $this->SQLMedidaJudicial .= $this->ComaMedida . "('" . $strCedula . "','" .
        $cbenef . "','" . $nbenef . "','" . $cedula . "','" . $autorizado . "','" . $instituto . 
        "','" . $tipobanco . "','" . $cuenta . "','" . $parentesco . 
        "',Now(),'SSSIFAN',1," . $monto . ")";

      }   
      
    }
    return [ $monto, $nombre, $cuenta, $autorizado, $cedula];
  }



/**
   *  Generar archivos para procesos de lotes (Activos)
   *
   *  Creación de tablas para los esquemas space
   *  ---------------------------------------------
   *  INICIANDO PROCESOS POR LOTES
   *  ---------------------------------------------
   *
   * @return  void
   */
  public function IniciarIndividual($arr){
    

    $this->load->model('comun/Dbpace');
    $this->load->model('fisico/MBeneficiario');
    
     
    $sConsulta = "
      SELECT
        bnf.nombres, bnf.apellidos,
        bnf.cedula, fecha_ingreso,f_ult_ascenso, grado.codigo,grado.nombre as gnombre,
        bnf.componente_id, n_hijos, st_no_ascenso, bnf.status_id,
        st_profesion, monto_especial, anio_reconocido, mes_reconocido,dia_reconocido,bnf.status_id as status_id, 
        bnf.porcentaje, f_retiro, bnf.tipo, bnf.banco, bnf.numero_cuenta, bnf.situacion
        FROM
          beneficiario AS bnf
        JOIN
          grado ON bnf.grado_id=grado.codigo AND bnf.componente_id= grado.componente_id
        WHERE 
        bnf.cedula='" . $arr['id'] . "' 
        ";
    $con = $this->DBSpace->consultar($sConsulta);    
    return $this->asignarBeneficiarioIndividual($con->rs, $arr['id']);
  }


 /**
  * Generar Codigos por Patrones en la Red de Inteligencia Pensionados Sobrevivientes
  *
  * @param MBeneficiario
  * @param KCalculoLote
  * @param KPerceptron
  * @param KDirectiva
  * @param object
  * @return void
  */


  public function asignarBeneficiarioIndividual($obj, $id){
    $this->load->model('kernel/KCalculoLote');
    $this->load->model('kernel/KDirectiva');
    $this->load->model('kernel/KNomina');
    $fecha = date('Y-m-d');
    $Directivas = $this->KDirectiva->Cargar($id, $fecha); //Directivas
   
    foreach ($obj as $k => $v) {
      $Bnf = new $this->MBeneficiario;
      $this->KCalculoLote->Instanciar($Bnf, $Directivas);
      $lst = $this->generarCalculoIndividual($Bnf,  $this->KCalculoLote, $fecha, $Directivas, $v);
    }
      
    
    return $Bnf;
  }

 

  /**
  * Generar Codigos por Patrones en la Red de Inteligencia
  *
  * @param MBeneficiario
  * @param KCalculoLote
  * @param KPerceptron
  * @param KDirectiva
  * @param object
  * @return void
  */
  private function generarCalculoIndividual(MBeneficiario &$Bnf, KCalculoLote &$CalculoLote, $fecha, $Directivas, $v){
    $Bnf->cedula = $v->cedula;
    $Bnf->deposito_banco = ""; //$v->cap_banco; //Individual de la Red
    $Bnf->apellidos = $v->apellidos; //Individual del Objeto
    $Bnf->nombres = $v->nombres; //Individual del Objeto
    
    $Bnf->fecha_ingreso = $v->fecha_ingreso;
    $Bnf->numero_hijos = $v->n_hijos;
    $Bnf->tipo = $v->tipo;
    $Bnf->banco = $v->banco;
    $Bnf->numero_cuenta = $v->numero_cuenta;
    $Bnf->situacion = $v->situacion;
    $Bnf->no_ascenso = $v->st_no_ascenso;
    $Bnf->componente_id = $v->componente_id;
    $Bnf->componente_nombre = $Directivas['com'][$v->componente_id];
    $Bnf->grado_codigo = $v->codigo;
    $Bnf->grado_nombre = $v->gnombre;
    $Bnf->fecha_ultimo_ascenso = $v->f_ult_ascenso;
    $Bnf->fecha_retiro = $v->f_retiro;
    $Bnf->prima_profesionalizacion_mt =  $v->st_profesion;
    $Bnf->estatus_profesion = $v->st_profesion;
    $Bnf->porcentaje = $v->porcentaje;
    

    $Bnf->prima_especial = $v->monto_especial;
    $Bnf->ano_reconocido = $v->anio_reconocido;
    $Bnf->mes_reconocido = $v->mes_reconocido;
    $Bnf->dia_reconocido = $v->dia_reconocido;
    $Bnf->estatus_activo = $v->status_id;
    
    $CalculoLote->Ejecutar();
    return $Bnf;

  }

}
