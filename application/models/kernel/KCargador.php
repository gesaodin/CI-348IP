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
   * @var WNomina
   */
  var $_MapWNomina;

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
    ini_set('memory_limit', '1024M'); //Aumentar el limite de PHP

    $this->load->model('comun/Dbpace');
    $this->load->model('kernel/KSensor');
    
    $this->load->model('fisico/MBeneficiario');
    $this->load->model('kernel/KMedidaJudicial');
    $this->load->model('kernel/KArchivos');
    
    $this->MedidaJudicial = $this->KMedidaJudicial->Cargar($this->_MapWNomina["nombre"]);
    $this->Archivos = $this->KArchivos->Cargar($this->_MapWNomina["nombre"]);
   
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
        -- bnf.cedula='11845656' 
        -- AND
        grado.codigo NOT IN(8450, 8510, 8500, 8460, 8470, 8480, 5320) 
        ORDER BY grado.codigo
        -- AND grado.codigo IN( 10, 15)
        -- LIMIT 10
        ";
    $con = $this->DBSpace->consultar($sConsulta);
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
    $file_log = fopen("tmp/" . $archivo . ".log","a") or die("Problemas");
    $file_medida = fopen("tmp/" . $archivo . "-MJ.sql","a") or die("Problemas");

    $linea = 'CEDULA;APELLIDOS;NOMBRES;TIPO;BANCO;NUMERO CUENTA;FECHA INGRESO;FECHA ASCENSO;FECHA RETIRO;COMPONENTE;GRADO;GRADO DESC.;TIEMPO DE SERV.;';
    $linea .= 'ANTIGUEDAD;NUM. HIJOS;PORCENTAJE;';
    
    

    $sqlCVS = "INSERT INTO space.pagos ( nomi, did, cedu, nomb, calc, fech, banc, nume, tipo, situ, esta, usua, neto, base ) VALUES ";
    $sqlMJ = "INSERT INTO space.medidajudicial_detalle ( cedu, cben, bene, caut, naut, inst, tcue, ncue, pare, crea, usua, esta, mont ) VALUES ";
    
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
    fputs($file,$linea);//Para Generar archivo csv 04102017
    fputs($file,"\n");//Salto de linea

    fputs($file_log, "  REPORTE CON LAS INCIDENCIAS EN LA NOMINA EN GENERAL ");//Para Generar archivo de log
    fputs($file_log,"\n");//Salto de linea


    fputs($file_sqlCVS, $sqlCVS);//INSERT SPACE.PAGOS
    fputs($file_medida, $sqlMJ);//INSERT SPACE.MEDIDAJUDICIALES    

    //print_r($Directivas);
    $coma = "";
    foreach ($obj as $k => $v) {
      $Bnf = new $this->MBeneficiario;
      $this->KCalculoLote->Instanciar($Bnf, $Directivas);
      $linea = $this->generarConPatrones($Bnf,  $this->KCalculoLote, $this->KPerceptron, $fecha, $Directivas, $v, $this->KNomina->ID);
      $this->Cantidad++;
      $this->CantidadMedida++;
      if($linea["csv"] != ""){
        fputs($file,$linea["csv"]); //Generacion CSV -> EXCEL
        fputs($file,"\n");
        /** INSERT PARA POSTGRES CIERRE DE LA NOMINA  */
        if ( $this->Cantidad > 1 ){
          $coma = ",";
        }
        if( $this->CantidadMedida > 1){
          $this->ComaMedida = ",";
        }
        $lineaSQL = $coma . $linea["sql"]; //INSERT PARA SPACE.PAGOS
        fputs( $file_sqlCVS, $lineaSQL);

         
        fputs( $file_medida, $this->SQLMedidaJudicial); //INSERT PARA SPACE.MEDIDAJUDICIAL_DETALLES
        $this->SQLMedidaJudicial = "";

        fputs($file_log, $linea["log"]); //CREACION DE INCIDENCIAS
        fputs($file_log, "\n");
      }
    }
    
    //echo "Sueldo Base Total: " . $this->Neto;
    $this->OidNomina = $this->KNomina->ID;
    $this->KNomina->Nombre = $archivo;
    $this->KNomina->Monto = $this->Neto;
    $this->KNomina->Asignacion = $this->Asignacion;
    $this->KNomina->Tipo = $this->_MapWNomina["tipo"];
    $this->KNomina->Estatus = 1;
    $this->KNomina->Deduccion = $this->Deduccion;
    $this->KNomina->Cantidad = $this->Cantidad;
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
        
        $medida = $this->calcularMedidaJudicial($this->KMedidaJudicial,  $Bnf);
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
          $linea = $Bnf->cedula . ';' . $Bnf->apellidos . ';' . $Bnf->nombres . 
           ';' .  $Bnf->tipo . ";" . $Bnf->banco . ";" . $Bnf->numero_cuenta . 
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
        "','" . $Bnf->apellidos . " " . $Bnf->nombres . "','" . 
        json_encode($this->KRecibo) . "',Now(),'" . $Bnf->banco . "','" . $Bnf->numero_cuenta . 
        "','" . $Bnf->tipo . "','" . $Bnf->situacion . "'," . $Bnf->estatus_activo . 
        ",'SSSIFANB'," . $neto . ", '" . $base . "')";

      }else{      //En el caso que exista el recuerdo en la memoria   
        $medida = $this->calcularMedidaJudicial($this->KMedidaJudicial,  $Bnf);
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
              if($monto_aux != 0)$recibo_de_pago[] = array('desc' =>  abreviatura_aux, 'tipo' => $NConcepto[$result]['TIPO'],'mont' => $monto_aux);
              $this->asignarPresupuesto($result, $monto_aux, $NConcepto[$result]['TIPO'], $abreviatura_aux, $NConcepto[$result]['part']);
            }
          }
        }        

        $neto = $asignacion - $deduccion;
        if($Perceptron->Neurona[$patron]["SUELDOBASE"] > 0   && $Perceptron->Neurona[$patron]["PORCENTAJE"] > 0  ){
          $linea = $Bnf->cedula . ';' . $Bnf->apellidos . ';' . $Bnf->nombres . 
          ';' .  $Bnf->tipo . ";" . $Bnf->banco . ";" . $Bnf->numero_cuenta . 
          ';' . $this->generarLineaMemoria($Perceptron->Neurona[$patron]) .
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
        "','" . $Bnf->apellidos . " " . $Bnf->nombres . "','" . 
        json_encode($this->KRecibo) . "',Now(),'" . $Bnf->banco . "','" . $Bnf->numero_cuenta . 
        "','" . $Bnf->tipo . "', '" . $Bnf->situacion . "', " . $Bnf->estatus_activo . 
        ", 'SSSIFANB'," . $neto . ", '" . $base . "')";
        
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

  //MEDIDA JUDICIAL INDIVIDUAL
  private function calcularMedidaJudicial( KMedidaJudicial &$KMedida, MBeneficiario &$Bnf ){
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

        $this->SQLMedidaJudicial .= $this->ComaMedida . "('" . $Bnf->cedula . "','" .
        $cbenef . "','" . $nbenef . "','" . $cedula . "','" . $autorizado . "','" . $instituto . 
        "','" . $tipobanco . "','" . $cuenta . "','" . $parentesco . 
        "',Now(),'SSSIFAN',1," . $monto . ")";

      }   
      
    }
    return [ $monto, $nombre, $cuenta, $autorizado, $cedula];
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
  private function generarConPatronesPS(MBeneficiario &$Bnf, KCalculoLote &$CalculoLote, KPerceptron &$Perceptron, $fecha, $Directivas, $v, $sqlID){
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
      
      $medida = $this->calcularMedidaJudicial($this->KMedidaJudicial,  $Bnf);
      $cajaahorro = $this->obtenerCajaAhorro( $Bnf );

      //Aplicar conceptos de Asignación
      for ($i= 0; $i < $cant; $i++){
        $rs = $map[$i]['codigo'];
        if (isset($Bnf->Concepto[$rs])) {
          
          if( $Bnf->Concepto[$rs]['TIPO'] == 99 ){
            $medida_str = $medida[0] . ";";
            $deduccion +=  $medida[0]; 
            $abreviatura = $Bnf->Concepto[$rs]['ABV'];
            $recibo_de_pago[] = array('desc' =>  $medida[1], 'tipo' => 99,'mont' => $medida[0]);
            $this->asignarPresupuesto($rs, $medida[0], '99', $abreviatura, $Bnf->Concepto[$rs]['part']);            
          }else if ( $Bnf->Concepto[$rs]['TIPO'] == 98 ){
            $cajaahorro_str = $cajaahorro . ";";
            $deduccion +=  $cajaahorro;
            $abreviatura = $Bnf->Concepto[$rs]['ABV'];
            $recibo_de_pago[] = array('desc' =>  $abreviatura, 'tipo' => 98,'mont' => $cajaahorro);  
            $this->asignarPresupuesto( $rs, $cajaahorro, '99', $abreviatura, $Bnf->Concepto[$rs]['part']);        
          }else{
            $segmentoincial .=  $Bnf->Concepto[$rs]['mt'] . ";";
            $asignacion += $Bnf->Concepto[$rs]['TIPO'] == 1? $Bnf->Concepto[$rs]['mt']: 0;
            $deduccion += $Bnf->Concepto[$rs]['TIPO'] == 0? $Bnf->Concepto[$rs]['mt']: 0;
            $deduccion += $Bnf->Concepto[$rs]['TIPO'] == 2? $Bnf->Concepto[$rs]['mt']: 0;
            
            $recibo_de_pago[] = array('desc' =>  $rs, 'tipo' => $Bnf->Concepto[$rs]['TIPO'],'mont' => $Bnf->Concepto[$rs]['mt']);
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
        $linea = $Bnf->cedula . ';' . $Bnf->apellidos . ';' . $Bnf->nombres . 
         ';' .  $Bnf->tipo . ";" . $Bnf->banco . ";" . $Bnf->numero_cuenta . 
         ";" . $this->generarLinea($segmentoincial) . $medida_str . 
         $cajaahorro_str . $asignacion . ';' . $deduccion . ';'  . $neto;
      
      
      }else{
        $log = $Bnf->cedula . ';' . $Bnf->apellidos . ';' . $Bnf->nombres . ';';
      }

      
      $this->KRecibo->Conceptos = $recibo_de_pago;
      
      $this->KRecibo->Asignacion = $asignacion;
      $this->KRecibo->Deduccion = $deduccion;

      $registro = "(" . $sqlID . "," . $Directivas['oid'] . ",'" . $Bnf->cedula . 
      "','" . $Bnf->apellidos . " " . $Bnf->nombres . "','" . 
      json_encode($this->KRecibo) . "',Now(),'" . $Bnf->banco . "','" . $Bnf->numero_cuenta . 
      "','" . $Bnf->tipo . "','" . $Bnf->situacion . "'," . $Bnf->estatus_activo . ",'SSSIFANB'," . $neto . ")";
    }else{      //En el caso que exista el recuerdo en la memoria   
      $medida = $this->calcularMedidaJudicial($this->KMedidaJudicial,  $Bnf);
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
            $recibo_de_pago[] = array('desc' =>  $medida[1], 'tipo' => 99,'mont' => $medida[0]);
            $this->asignarPresupuesto( $result, $medida[0], '99', $abreviatura, $NConcepto[$result]['part']);            
          }else if ( $NConcepto[$result]['TIPO'] == 98 ){ //CAJAS DE AHORRO
            $cajaahorro_str = $cajaahorro . ";";
            $deduccion +=  $cajaahorro;
            $abreviatura = $NConcepto[$result]['ABV'];
            $recibo_de_pago[] = array('desc' =>  $abreviatura, 'tipo' => 98,'mont' => $cajaahorro);
            $this->asignarPresupuesto($result, $cajaahorro, '98', $abreviatura, $NConcepto[$result]['part']); 
          }else{
            $this->asignarPresupuesto($result, $NConcepto[$result]['mt'], $NConcepto[$result]['TIPO'], $NConcepto[$result]['ABV'], $NConcepto[$result]['part']);
          }
        }
      }        

      $neto = $asignacion - $deduccion;
      if($Perceptron->Neurona[$patron]["SUELDOBASE"] > 0   && $Perceptron->Neurona[$patron]["PORCENTAJE"] > 0  ){
        $linea = $Bnf->cedula . ';' . $Bnf->apellidos . ';' . $Bnf->nombres . 
        ';' .  $Bnf->tipo . ";" . $Bnf->banco . ";" . $Bnf->numero_cuenta . 
        ';' . $this->generarLineaMemoria($Perceptron->Neurona[$patron]) .
        $medida_str . $cajaahorro_str . $asignacion . ';' . $deduccion . ';' . $neto;
      }else{
        $log = $Bnf->cedula . ';' . $Bnf->apellidos . ';' . $Bnf->nombres . ';';
      }
      
      $this->KRecibo->Conceptos = $recibo_de_pago;
      $this->KRecibo->Asignacion = $asignacion;
      $this->KRecibo->Deduccion = $deduccion;

      $registro = "(" . $sqlID . "," . $Directivas['oid'] . ",'" . $Bnf->cedula . 
      "','" . $Bnf->apellidos . " " . $Bnf->nombres . "','" . 
      json_encode($this->KRecibo) . "',Now(),'" . $Bnf->banco . "','" . $Bnf->numero_cuenta . 
      "','" . $Bnf->tipo . "', '" . $Bnf->situacion . "', " . $Bnf->estatus_activo . ", 'SSSIFANB'," . $neto . ")";
      
    }


    $this->SSueldoBase += $Bnf->sueldo_base;
    $this->Asignacion += $asignacion;
    $this->Deduccion += $deduccion;
    $this->Neto += $neto;
    // echo ("<pre>");
    // print_r(count($Perceptron->Neurona));
    $obj["csv"] = $linea;
    $obj["sql"] = $registro;
    $obj["log"] = $log;
    return $obj;

}

  
}
