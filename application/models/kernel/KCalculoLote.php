<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * MamonSoft
 *
 * Calculos
 *
 * @package pace\application\modules\panel\model\beneficiario
 * @subpackage utilidad
 * @author Carlos Peña
 * @copyright Derechos Reservados (c) 2015 - 2016, MamonSoft C.A.
 * @link http://www.mamonsoft.com.ve
 * @since version 1.0
 */

class KCalculoLote extends CI_Model{

  /**
  * @var MBeneficiario
  */
  var $Beneficiario = null;

  var $Directiva = null;


  /**
  * @var array MBeneficiario
  */
  var $Lista = null;
  /**
  * Iniciando la clase, Cargando Elementos Pace
  *
  * @access public
  * @return void
  */
  public function __construct( ){
    parent::__construct();

  }


  function Instanciar(MBeneficiario & $Bnf, $Dir){
    $this->Directiva = $Dir;
    $this->Beneficiario = $Bnf;
  }
  /**
  * Consultar los beneficiario por componente, cargar diirectivas, instanciar las primas y ejeutar calculos
  *
  * @access public
  * @param string
  * @return DBSpace
  */
  function Ejecutar(){
    $this->AntiguedadGrado();
    $this->TiempoServicios();
    
    $cod = $this->Beneficiario->grado_codigo . $this->Beneficiario->antiguedad_grado;
    $sueldo = $this->Directiva['sb'];    
    if( $this->Beneficiario->situacion != "I" && $this->Beneficiario->situacion != "PG" ){     
      if($this->Beneficiario->antiguedad_grado < 0){
        $cod = $this->Beneficiario->grado_codigo . "0";
      }

      if ( isset( $sueldo[$this->Beneficiario->grado_codigo.'M']['sb'] )){
        $sueldo_maximo = $sueldo[$this->Beneficiario->grado_codigo.'M']['sb'];
      }else{
        $sueldo_maximo = 0;
      }
      $this->Beneficiario->sueldo_base = isset($sueldo[$cod])? $sueldo[$cod]['sb']: $sueldo_maximo;
    }else{
      $this->Beneficiario->sueldo_base = $this->Directiva['salario'];
    }


    // $this->Beneficiario->sueldo_base = ($this->Beneficiario->sueldo_base * $this->Beneficiario->porcentaje) / 100;
    $this->Beneficiario->Concepto['sueldo_base'] = array(
      'mt' => round($this->Beneficiario->sueldo_base,2), 
      'ABV' =>  'sueldo_base', 
      'TIPO' => 97,
      'part' => '40701010101'
    );
    $this->OperarCalculos();
    $this->OperarConceptos();
    $this->SueldoMensual();

  }

  function GenerarProfesionalizacion(){
    $sueldo = ($sueldo_base * 12) / 100;
  }


  function OperarCalculos(){

    if ( isset ( $this->Directiva['sb'][$this->Beneficiario->grado_codigo.'M']['mt']) ){
      $lst =  $this->Directiva['sb'][$this->Beneficiario->grado_codigo.'M']['mt'];
   
      

      $valor = 0;
      $this->Beneficiario->monto_total_prima = 0;
      $automatico = 0;
      $grado = $this->Beneficiario->grado_codigo;
      $componente = $this->Beneficiario->componente_id;
      $tiempo_servicio = $this->Beneficiario->tiempo_servicio;
      $sueldo_base = $this->Beneficiario->sueldo_base;
      $sueldo_basico = $this->Beneficiario->sueldo_base;
      $sueldo_minimo = $this->Directiva['salario'];
      $unidad_tributaria = $this->Directiva['ut'];
      $porcentaje_pension = $this->Beneficiario->porcentaje;
      $no_ascenso = $this->Beneficiario->no_ascenso;
      $numero_hijos = $this->Beneficiario->numero_hijos;
      $prima_profesionalizacion_mt = $this->Beneficiario->prima_profesionalizacion_mt;
      $porcentaje_profesionalizacion = $this->Beneficiario->prima_profesionalizacion_mt; 
      $total_primas = 0;
      $sueldo_mensual = $sueldo_base;
      $pension = $sueldo_base;
      $this->Beneficiario->total_asignacion = $sueldo_base;
      if( $this->Beneficiario->situacion != "PG" ){
        //Establecer Primras
        foreach ($lst as $c => $v) {
          $monto_nominal = $v;
          $rs =  $this->Directiva['fnx'][$c]['rs']; // Como se llama la variable
          $rs_mt =  $this->Directiva['fnx'][$c]['rs'] . '_mt';
          $fnx =  $this->Directiva['fnx'][$c]['fn'];
          eval('$valor = ' . $fnx);
          $this->Beneficiario->$rs = round($valor,2);
          $this->Beneficiario->$rs_mt = $monto_nominal;
          $this->Beneficiario->monto_total_prima += $this->Beneficiario->$rs;
          $this->Beneficiario->Concepto[$rs] = array(
            'mt' => round($valor,2), 
            'ABV' =>  $rs, 
            'TIPO' => 97,
            'part' => '40701010101'
          );
        }
        //$this->Beneficiario->Concepto[$rs] =  array('mt' => round($prima_profesionalizacion_mt,2), 'ABV' =>  "prima_profesionalizacion", 'TIPO' => 1 );
        $total_primas = $this->Beneficiario->monto_total_prima + $prima_profesionalizacion_mt;
        $pension = (( $sueldo_basico +  $total_primas ) * $porcentaje_pension  ) / 100;
        $this->Beneficiario->total_asignacion =  $sueldo_basico +  $total_primas;

        $sueldo_mensual = $pension;
      }

      $this->Beneficiario->pension = $pension;
      $this->Beneficiario->sueldo_mensual = $pension;
      $this->Beneficiario->Concepto["sueldo_mensual"] = array(
        'mt' => round($sueldo_mensual,2), 
        'ABV' =>  "PENSION MILITAR", 
        'TIPO' => 1,
        'part' => '40701010101'
      );
      //Formular Conceptos
      foreach ( $this->Directiva['fnxC'] as $Con => $obj ){
        $fnx = $obj['fn'];
        $rs = $obj['rs'];     
        eval('$valor = ' . $fnx);
        $this->Beneficiario->Concepto[$rs] = array(
          'mt' => round($valor,2), 
          'ABV' =>  $obj['abv'], 
          'TIPO' => $obj['tipo'],
          'part' => $obj['part']
        );
        $valor = 0;
      }  
    }
    
  }


  function OperarCalculosFallecidos($spension = 0.00, $porc = 0.00){

      $valor = 0;      
      $automatico = 0;
      $grado = $this->Beneficiario->grado_codigo;
      $componente = $this->Beneficiario->componente_id;
      $tiempo_servicio = $this->Beneficiario->tiempo_servicio;
      $sueldo_minimo = $this->Directiva['salario'];
      $unidad_tributaria = $this->Directiva['ut'];
      $porcentaje_pension = $this->Beneficiario->porcentaje;
      $no_ascenso = 0;
      $numero_hijos = 0;
   
      $sueldo_base = $spension;
      $sueldo_basico = $spension;
      $prima_profesionalizacion_mt = 0;
      $porcentaje_profesionalizacion = 0; 
      $total_primas = 0;
      $sueldo_mensual = $sueldo_base;
      $pension = ($sueldo_base * $porc)/100; //Pension asignada por familiar con porcentaje
      $this->Beneficiario->total_asignacion = $sueldo_base;
       
      $total_primas = 0;
      
      $this->Beneficiario->total_asignacion =  $sueldo_basico;

      $sueldo_mensual = $pension;     
      $this->Beneficiario->Concepto["sueldo_mensual"] = array(
        'mt' => round($sueldo_mensual,2), 
        'ABV' =>  "PENSION MILITAR", 
        'TIPO' => 1,
        'part' => '40701010101'
      );
      //Formular Conceptos
      foreach ( $this->Directiva['fnxC'] as $Con => $obj ){
        $fnx = $obj['fn'];
        $rs = $obj['rs'];     
        eval('$valor = ' . $fnx);
        $this->Beneficiario->Concepto[$rs] = array(
          'mt' => round($valor,2), 
          'ABV' =>  $obj['abv'], 
          'TIPO' => $obj['tipo'],
          'part' => $obj['part']
        );
        $valor = 0;
      }  
    
    
  }

  function OperarConceptos(){
 
  }


  function SueldoMensual(){
    $this->Beneficiario->sueldo_mensual = $this->Beneficiario->sueldo_base + $this->Beneficiario->monto_total_prima;
  }



  /**
  * Permite restar fechas exactas en el caso de los reconocidos antes de Calcular
  *
  * @access public
  * @param Date
  * @return int
  */
  private function __fechaReconocida($ano_reconocido = 0, $mes_reconocido = 0, $dia_reconocido = 0){

    list($ano,$mes,$dia) = explode("-",$this->Beneficiario->fecha_ingreso);
    $anoR = $ano - $this->Beneficiario->ano_reconocido;
    $mesR = $mes - $this->Beneficiario->mes_reconocido;
    $diaR = $dia - $this->Beneficiario->dia_reconocido;

    if($diaR < 0) {
      $mesR--;
      $diaR = 30 + $diaR;
    }

    if($mesR < 0){
      $anoR--;
      $mesR = 12 + $mesR;
    }

    $fecha = $anoR .'-' . $mesR  . '-' . $diaR;
    $this->Beneficiario->fecha_ingreso_reconocida = $fecha;
    $anos = $this->__restarFecha($fecha, $this->Beneficiario->fecha_retiro);
    return $anos;
  }

  /**
  * Permite restar fechas exactas
  *
  * @access public
  * @param Date
  * @return int
  */
  private function __restarFecha($fecha = '', $fecha_r = '', $ant = FALSE){



    if($fecha_r == ''){
      $fecha_retiro = date('Y-m-d');
    }else{
      $fecha_retiro =  $fecha_r;

    }

    $fecha_r = explode("-", $fecha_retiro);
    $ano_r = $fecha_r[0];
    $mes_r = $fecha_r[1];
    $dia_r = $fecha_r[2];
    list($ano,$mes,$dia) = explode("-",$fecha);


    if ($dia_r < $dia){
      $dia_dif =  ($dia_r+30) - $dia; //27 -5
      $mes_r--;
    }else{
      $dia_dif =  $dia_r - $dia; //27 -5
    }

    if ($mes_r < $mes){
       $mes_dif =  ($mes_r + 12) - $mes; //27 -5
       $ano_r--;
    }else{
      $mes_dif =  $mes_r - $mes;
    }



    $ano_dif = $ano_r - $ano;
    $arr['e'] = $ano_dif;

    if($mes_dif > 5) {
      $arr['n'] = $ano_dif + 1;
    }else{
      $arr['n'] = $ano_dif;
    }
    return $arr;

  }



  /**
  * Permite calular el tiempo en la antiguedad del cargo bajo la ultima fecha de ascenso
  *
  * @access public
  * @param Date
  * @return int
  */
  function AntiguedadGrado(){
      $anos = $this->__restarFecha($this->Beneficiario->fecha_ultimo_ascenso, $this->Beneficiario->fecha_retiro, TRUE);
      $this->Beneficiario->antiguedad_grado = $anos['e'];
  }

  /**
  * Permite calular el tiempo en de servicio de una persona bajo su fecha de Ingreso
  *
  * @access public
  * @param Date
  * @param array
  * @return int
  */
  function TiempoServicios(){
      //echo "Fechas ", $this->Beneficiario->fecha_ingreso, "   ", $this->Beneficiario->fecha_retiro ;
      //echo "<br>";
      if($this->Beneficiario->ano_reconocido != 0){
        $anos = $this->__fechaReconocida();
        $this->Beneficiario->tiempo_servicio = $anos['e'];
        $this->Beneficiario->tiempo_servicio_aux = $anos['n'];
      }else{
        $anos = $this->__restarFecha($this->Beneficiario->fecha_ingreso, $this->Beneficiario->fecha_retiro);
        $this->Beneficiario->tiempo_servicio = $anos['e'];
        $this->Beneficiario->tiempo_servicio_aux = $anos['n'];
      }
      //print_r($this->Beneficiario->tiempo_servicio);
      //print_r("<br>");
  }

  /**
  * Sueldo Global #007
  * X = PTR + PAS + PDE + PNA + PES + PPR
  *
  * PTR = Prima Transporte
  * PAS = Prima Ano Servicio
  * PDE = Prima Descendecia
  * PNA = Prima No Ascenso
  * PES = Prima Especial
  * PPR = Prima Profesionalizacion
  *
  * @access public
  * @param double
  * @param int
  * @return double
  */
  public function SueldoGlobal($primas = array(), $sueldo_global = 0.00){
    $sum = 0;
    $primas = $this->Beneficiario->Prima;
    $sueldo_global = $this->Beneficiario->sueldo_base;
    foreach ($primas as $key => $value) {
     foreach ($value as $k => $v) {
       $sum += $v;

     }
    }
    $cal = round($sum + $sueldo_global, 2);
    return  $cal;
  }

  /**
  * Alicuota Bono Aguinaldo #00
  * X = ((90 * SG)/30)/12
  *
  * SG = Sueldo Global
  *
  * @access public
  * @return double
  */
  public function AlicuotaAguinaldo($sueldo_global = 0){
    //Se agrego las condiciones para evaluar cuando se debe calcular con 90/105/120 dias
     $dia = 0;
       if(isset($this->Beneficiario) && ($this->Beneficiario->fecha_retiro == '')){
        $sueldo_global = $this->Beneficiario->sueldo_global;
        $cal =  round(((120 * $sueldo_global)/30)/12, 2);
        $this->Beneficiario->aguinaldos = $cal;
        $this->Beneficiario->aguinaldos_aux = number_format($cal, 2, ',','.');

      }else{ if($this->Beneficiario->fecha_retiro >= '2016-10-29' && $this->Beneficiario->fecha_retiro <= '2016-12-31'){
        $sueldo_global = $this->Beneficiario->sueldo_global;
        $cal =  round(((120 * $sueldo_global)/30)/12, 2);
        $this->Beneficiario->aguinaldos = $cal;
        $this->Beneficiario->aguinaldos_aux = number_format($cal, 2, ',','.');

      }else{ if($this->Beneficiario->fecha_retiro < '2016-10-29'){
        $sueldo_global = $this->Beneficiario->sueldo_global;
        $cal =  round(((90 * $sueldo_global)/30)/12, 2);
        $this->Beneficiario->aguinaldos = $cal;
        $this->Beneficiario->aguinaldos_aux = number_format($cal, 2, ',','.');

      }else{
        $sueldo_global = $this->Beneficiario->sueldo_global;
        $cal = ((120 * $sueldo_global)/30)/12;
        $this->Beneficiario->aguinaldos = $cal;
        $this->Beneficiario->aguinaldos_aux = number_format($cal, 2, ',','.');
      }
    }
  }

  }


 /**
  * SE USA PARA LOS PROCESOS POR LOTES
*/

public function GenerarAlicuotaAguinaldo(){
     $sm = $this->Beneficiario->sueldo_mensual;

     if($this->Beneficiario->fecha_retiro == ''){
       $cal =  round(((120 * $sm)/30)/12, 2);

     }else if($this->Beneficiario->fecha_retiro < '2016-10-29'){
       $cal =  round(((90 * $sm)/30)/12, 2);

     }else if($this->Beneficiario->fecha_retiro >= '2016-10-29' && $this->Beneficiario->fecha_retiro <= '2016-12-31'){
        $cal =  round(((105 * $sm)/30)/12, 2);

     }else{
        $cal =  round(((120 * $sm)/30)/12, 2);
     }

     $this->Beneficiario->aguinaldos = $cal;

 }



  /**
  * Alicuota Bono Vacaciones #00
  * X =  ((NDV * SG)/30)/12
  *
  * NDV = Numero de Dias de Vaciones que goza el Millitar
  * SG = Sueldo Global
  *
  * @access public
  * @return double
  */
  public function AlicuotaVacaciones($sueldo_global = 0){
    //Fecha auxiliar utiliza aux - Menor Robando Tiempo y Antigueddad
      $dia = 0;
      $TM = $this->Beneficiario->tiempo_servicio;
     if ($TM > 0 && $TM <= 14) {
        $dia = 50;
      }else if($TM > 14 && $TM <= 24){
        $dia = 50;
      }else if($TM > 24){
        $dia = 50;
      }


      $sueldo_global = $this->Beneficiario->sueldo_global;
      $cal = round((($dia * $sueldo_global)/30)/12, 2);
      $this->Beneficiario->vacaciones = $cal;
      $this->Beneficiario->vacaciones_aux = number_format($cal, 2, ',','.');

  }

/*
  function GenerarAlicuotaVacaciones(){
    $dia = 0;
    $TM = $this->Beneficiario->tiempo_servicio;
    if ($TM > 0 && $TM <= 14) {
      $dia = 50;
    }else if($TM > 14 && $TM <= 24){
      $dia = 50;
    }else if($TM > 24){
      $dia = 50;
    }
    $this->Beneficiario->dia_vacaciones = $dia;
    $this->Beneficiario->vacaciones = round((($dia * $this->Beneficiario->sueldo_mensual)/30)/12, 2);
    }

*/

function GenerarAlicuotaVacaciones(){
 $dia = 0;
 $sm = $this->Beneficiario->sueldo_mensual;

      if($this->Beneficiario->fecha_retiro == '' || $this->Beneficiario->fecha_retiro > '2016-12-31'){
            $dia = 50;
            $cal = round((($dia * $sm)/30)/12, 2);
            $this->Beneficiario->vacaciones = $cal;
            $this->Beneficiario->dia_vacaciones = $dia;

       }else if($this->Beneficiario->fecha_retiro <= '2016-12-31'){
        $TM = $this->Beneficiario->tiempo_servicio;
          if ($TM > 0 && $TM <= 14) {
            $dia = 40;
          }else if($TM > 14 && $TM <= 24){
           $dia = 45;
          }else if($TM > 24){
            $dia = 50;
          }

        $cal = round((($dia * $sm)/30)/12, 2);
        $this->Beneficiario->dia_vacaciones = $dia;
        $this->Beneficiario->vacaciones = $cal;
      }
 }

  /**
  * Sueldo Integral #007
  * X = SUM(SG + AV + AA)
  *
  * SUM = Sumatoria Total
  * SG = Sueldo Global
  * AV = Alicuota Vacaciones
  * AA = Alicuota Aguinaldo
  *
  * @access public
  * @return double
  */
  public function SueldoIntegral(){

      $sueldo_integral = $this->Beneficiario->sueldo_global + $this->Beneficiario->vacaciones + $this->Beneficiario->aguinaldos;
      $this->Beneficiario->sueldo_integral = $sueldo_integral;
      $this->Beneficiario->sueldo_integral_aux = number_format($sueldo_integral, 2, ',','.');

  }

  public function GenerarSueldoIntegral(){
       $this->Beneficiario->sueldo_integral = $this->Beneficiario->sueldo_mensual + $this->Beneficiario->vacaciones + $this->Beneficiario->aguinaldos;
  }


  /**
  * Asignacion de Antiguedad #007
  * X = SI * TS
  *
  * SI = Sueldo Integral
  * TS = Prima Tiempo de Servicio
  *
  * @access public
  * @return double
  */
  public function AsignacionAntiguedad(){
    $this->Beneficiario->asignacion_antiguedad = $this->Beneficiario->sueldo_integral * $this->Beneficiario->tiempo_servicio;
    $this->Beneficiario->asignacion_antiguedad_aux = number_format($this->Beneficiario->asignacion_antiguedad, 2, ',','.');
    return $this->Beneficiario->asignacion_antiguedad;
  }


  public function GenerarAsignacionAntiguedad(){
    $this->Beneficiario->asignacion_antiguedad = $this->Beneficiario->sueldo_integral * $this->Beneficiario->tiempo_servicio;
    if($this->Beneficiario->estatus_activo == 203)
      $this->Beneficiario->asignacion_antiguedad = $this->Beneficiario->sueldo_integral * $this->Beneficiario->tiempo_servicio_aux;


  }

 /**
  * Asignacion de Antiguedad #007
  * X = SI * TS
  *
  * SI = Sueldo Integral
  * TS = Prima Tiempo de Servicio
  *
  * @access public
  * @return double
  */
  public function AsignacionFiniquito(){
    $this->Beneficiario->asignacion_antiguedad_fin = $this->Beneficiario->sueldo_integral * $this->Beneficiario->tiempo_servicio_aux;
    $this->Beneficiario->asignacion_antiguedad_fin_aux = number_format($this->Beneficiario->asignacion_antiguedad_fin, 2, ',','.');
    return $this->Beneficiario->asignacion_antiguedad_fin;
  }

   /**
  * Comision de Servicio
  * CODIGO MOVIMIENTO: 28
  *
  * @access public
  * @return double
  */
  public function ComisionServicio(){
    $ComisionServicio = isset($this->Beneficiario->HistorialMovimiento[28]) ? $this->Beneficiario->HistorialMovimiento[28]->monto : 0;

    return $ComisionServicio;
  }

  /**
  * Capital en Banco
  * CODIGO MOVIMIENTO: 3
  *
  * @access public
  * @return double
  */
  public function DepositoBanco(){
    $DepositoBanco = isset($this->Beneficiario->HistorialMovimiento[3]) ? $this->Beneficiario->HistorialMovimiento[3]->monto : 0;

    return $DepositoBanco;
  }


  /**
  * Fecha del Ultimo deposito es tomada de la ultima garantia o Aporte capital
  * CODIGO MOVIMIENTO: 32 y 3
  * Se toma la fecha mayor entre los dos movimientos
  * @access public
  * @return double
  */
  public function Fecha_Ultimo_Deposito(){
    $fecha = '';
    $fecha_aux1 = isset($this->Beneficiario->HistorialMovimiento[32]) ? $this->Beneficiario->HistorialMovimiento[32]->fecha : '';
    $fecha_aux2 = isset($this->Beneficiario->HistorialMovimiento[3]) ? $this->Beneficiario->HistorialMovimiento[3]->fecha : '';

    if($fecha_aux1 != '' or $fecha_aux2 != ''){
      $f1 = explode('-', $fecha_aux1);
      $f2 = explode('-', $fecha_aux2);
      if($fecha_aux1 > $fecha_aux2){
        $fecha = $f1[2] . '-' . $f1[1] . '-' . $f1[0];
      }
      else{
        $fecha = $f2[2] . '-' . $f2[1] . '-' . $f2[0];
      }
    }else{
         $fecha = '';
      }
    return $fecha;
  }

  /**
  * No Depositado
  *
  * @access public
  * @return double
  */
  public function NoDepositadoBanco(){
    return $this->Beneficiario->asignacion_antiguedad - $this->Beneficiario->Calculos['deposito_banco'];
  }

  public function GenerarNoDepositadoBanco(){
    $this->Beneficiario->no_depositado_banco = $this->Beneficiario->asignacion_antiguedad - $this->Beneficiario->deposito_banco - $this->Beneficiario->garantias_acumuladas  - $this->Beneficiario->dias_adicionales_acumulados;
  }


  /**
  * Garantias (Acumuladas en tabla Movimiento)
  * CODIGO MOVIMIENTO: 32
  *
  * @access public
  * @return double
  */
  public function Garantias(){
    $garantias = isset($this->Beneficiario->HistorialMovimiento[32]) ? $this->Beneficiario->HistorialMovimiento[32]->monto : 0;
    return $garantias;
  }

  /**
  * Calculo de Garantias
  * (SI/30) * 15D
  * SI : Sueldo Integral
  * D: DIAS
  *
  * @access public
  * @return double
  */
  public function GenerarGrarantias(){
    $this->Beneficiario->garantias = round(($this->Beneficiario->sueldo_integral /30) * 15,2);
  }

  /**
  * Dias Adiciaonales (Acumuladas en la tabla Movimiento)
  * CODIGO MOVIMIENTO: 31
  *
  * @access public
  * @return double
  */
  public function Dias_Adicionales(){
    $diasA = isset($this->Beneficiario->HistorialMovimiento[31]) ? $this->Beneficiario->HistorialMovimiento[31]->monto : 0;
    return $diasA;
  }


/**
  * Calculo de Dias Adicionales
  * (SM / 30 * 2) * TS
  * SM : Sueldo Mensual
  * TS: Tiempo de Servicio
  *
  * @access public
  * @return double
  */
  public function GenerarDiasAdicionales(){
    $ts = $this->Beneficiario->tiempo_servicio;
    $factor = 15;
    if ( $ts > 0 && $ts < 16 )$factor = $ts;
    $this->Beneficiario->dias_adicionales = round(($this->Beneficiario->sueldo_mensual / 30 * 2) * $factor,2);
  }

  /**
  * Total Aportados
  *
  * @access public
  * @return double
  */
  public function Total_Aportados(){
    return $this->DepositoBanco() + $this->Garantias() + $this->Dias_Adicionales();
  }

  /**
  * Anticipos
  * CODIGO MOVIMIENTO: 5
  *
  * @access public
  * @return double
  */
  public function Anticipos(){

    $anticipos = isset($this->Beneficiario->HistorialMovimiento[5]) ? $this->Beneficiario->HistorialMovimiento[5]->monto : 0;
    $anticipos_reversado = isset($this->Beneficiario->HistorialMovimiento[25]) ? $this->Beneficiario->HistorialMovimiento[25]->monto : 0;
    return $anticipos - $anticipos_reversado;
  }

  /**
  * Fecha del Ultimo deposito es tomada de la ultima garantia
  * CODIGO MOVIMIENTO: 32
  *
  * @access public
  * @return double
  */
  public function Fecha_Ultimo_Anticipo(){
    $fecha = '';
    $fecha_aux = isset($this->Beneficiario->HistorialMovimiento[5]) ? $this->Beneficiario->HistorialMovimiento[5]->fecha : '';
    if($fecha_aux != ''){
      $f = explode('-', $fecha_aux);
      $fecha = $f[2] . '-' . $f[1] . '-' . $f[0];
    }
    return $fecha;
  }

  /**
  * Saldo Disponible
  *
  * @access public
  * @return double
  */
  public function Saldo_Disponible(){
    $total = ($this->DepositoBanco() - $this->Anticipos()) + $this->Garantias();

    return $total;
  }

  /**
  * Saldo Disponible Finiquito
  *
  * @access public
  * @return double
  */
  public function Saldo_DisponibleFiniquito(){
    /** se agrego el monto de comision de servicio al total en banco  **/
    $total = (($this->DepositoBanco() - $this->Anticipos()) + $this->Garantias() + $this->ComisionServicio()) - ($this->Embargos() + $this->Monto_Recuperar());
    return $total;
  }



  public function Diferencia_Asignacion(){
    $monto = (($this->Beneficiario->asignacion_antiguedad - $this->DepositoBanco()) -  $this->Dias_Adicionales()) - $this->Garantias();
    return $monto;
  }


  public function Embargos(){
    $monto = 0;
    if(isset($this->Beneficiario->MedidaJudicial[1])){
      if($this->Beneficiario->MedidaJudicial[1]->monto > 0){
        $monto = $this->Beneficiario->MedidaJudicial[1]->monto;
      }else{
       $monto = ($this->Beneficiario->asignacion_antiguedad * $this->Beneficiario->MedidaJudicial[1]->porcentaje)/100;
      }
    }

    return round($monto, 2);
  }

  public function MedidaJudicialActiva(){
    return isset($this->Beneficiario->MedidaJudicialActiva[1])? $this->Beneficiario->MedidaJudicialActiva[1]->monto : 0;
  }



  public function FiniquitoEmbargo(){
    $monto = isset($this->Beneficiario->HistorialMovimiento[27]) ? $this->Beneficiario->HistorialMovimiento[27]->monto : '0';

    return $monto;
  }

  public function Porcentaje_Cancelado(){
    //print_r($this->Beneficiario->asignacion_antiguedad);
    $cancelado = 0;
    if( $this->Beneficiario->asignacion_antiguedad > 0)
      $cancelado = ($this->DepositoBanco() + $this->Garantias() + $this->Dias_Adicionales() )/ $this->Beneficiario->asignacion_antiguedad;

    return $cancelado * 100;
  }

  /**
  * Asignacion Depositada para Finiquito
  *
  * @access public
  * @return double
  */
  public function Asignacion_Depositada(){
    return $this->DepositoBanco() + $this->Garantias();
  }


  /**
  * Asignacion Depositada para Finiquito
  *
  * @access public
  * @return double
  */
  public function Monto_Recuperar(){
    $resta = $this->AsignacionFiniquito() - ($this->Asignacion_Depositada() + $this->Dias_Adicionales());
    $valor = 0.00;
    if($resta < 0) $valor = $resta * -1;

    return $valor;
  }



  /**
  * Asignacion Depositada para Finiquito
  *
  * @access public
  * @return double
  */
  public function Asignacion_Diferencia(){
    $resta = $this->AsignacionFiniquito() - $this->Total_Aportados();
    $valor = $resta;
    return $valor;
  }

  /**
  * Fallecimiento en Actos de Servicio
  * X = SG * 36
  *
  * @access public
  * @return double
  */
  public function Fallecimiento_Acto_Servicio(){
    return $this->Beneficiario->sueldo_global * 36;
  }



  /**
  * Fallecimiento en Fuera de Servicio
  * X = SG * 24
  *
  * @access public
  * @return double
  */
  public function Fallecimiento_Fuera_Servicio(){
    return $this->Beneficiario->sueldo_global * 24;
  }


  /**
  * Intereses Capitalizados
  * X = SG * 24
  *
  * @access public
  * @return double
  */
  public function Interes_Capitalizado_Banco(){
    $monto = isset($this->Beneficiario->HistorialMovimiento[10]) ? $this->Beneficiario->HistorialMovimiento[10]->monto : '0';

    return $monto;
  }


  /**
  * Calcular dias del Mes
  *
  * @param int
  * @param int
  * @access public
  * @return double
  */
  public function ObtenerDiasDelMes($mes, $anio){
    return is_callable("cal_days_in_month")?cal_days_in_month(CAL_GREGORIAN, $mes, $anio):date("d",mktime(0,0,0,$mes+1,0,$anio));
  }




}
