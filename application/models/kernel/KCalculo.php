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

class KCalculo extends CI_Model{
  
  /**
  * @var MBeneficiario
  */
  var $Beneficiario = null;

  /**
  * Iniciando la clase, Cargando Elementos Pace
  *
  * @access public
  * @return void
  */
  public function __construct(){
    parent::__construct();
    //$this->load->model('beneficiario/MDirectiva');
   

  }


  function iniciarCalculosBeneficiario(MBeneficiario & $Beneficiario){
    $this->load->model('kernel/KDirectiva');
    $this->load->model('kernel/KPrimas');
    $this->Beneficiario = $Beneficiario;   
    $this->AntiguedadGrado();
    $this->TiempoServicios();
    $codigo_grado = $this->Beneficiario->Componente->Grado->codigo;
    $this->Beneficiario->Componente->Grado->Directiva = $this->KDirectiva->obtener($this->Beneficiario);
    $directiva_id = $this->Beneficiario->Componente->Grado->Directiva->id;
    $this->Beneficiario->Componente->Grado->Prima = $this->KPrimas->obtener($codigo_grado, $directiva_id,  $this->Beneficiario);


    $this->Beneficiario->sueldo_global = $this->SueldoGlobal();
    $this->Beneficiario->sueldo_global_aux = number_format($this->SueldoGlobal(), 2, ',','.');
    $this->AlicuotaAguinaldo();
    $this->AlicuotaVacaciones();
    $this->SueldoIntegral();
    $this->AsignacionAntiguedad();
    $this->AsignacionFiniquito(); //se agrego rutina para calcular AA para finiquito


    $this->Beneficiario->Calculo = array(
      'asignacion_antiguedad' => number_format($this->Beneficiario->asignacion_antiguedad, 2, ',','.'),
      'asignacion_antiguedad_fin' => number_format($this->Beneficiario->asignacion_antiguedad_fin, 2, ',','.'), //se agrego AA por el de la 
      'asignacion_antiguedad_fin_aux' => $this->Beneficiario->asignacion_antiguedad_fin, //se agrego AA por el de la rutina AsignacionFiniquito
      'asignacion_antiguedad_aux' => $this->Beneficiario->asignacion_antiguedad,
      'capital_banco' => number_format($this->DepositoBanco(), 2, ',','.'),
      'capital_banco_aux' => $this->DepositoBanco(),
      'asignacion_depositada' => number_format($this->Asignacion_Depositada(), 2, ',','.'),
      'asignacion_depositada_aux' => $this->Asignacion_Depositada(),
      'fecha_ultimo_deposito' => $this->Fecha_Ultimo_Deposito(),
      'garantias' => number_format($this->Garantias(), 2, ',','.'),
      'garantias_aux' => $this->Garantias(),
      'dias_adicionales' => number_format($this->Dias_Adicionales(), 2, ',','.'),
      'dias_adicionales_aux' => $this->Dias_Adicionales(),
      'anticipos' => number_format($this->Anticipos(), 2, ',','.'),
      'anticipos_aux' => $this->Anticipos(),
      'total_aportados' => number_format($this->Total_Aportados(), 2, ',','.'),
      'saldo_disponible' => number_format($this->Saldo_Disponible(), 2, ',','.'),
      'saldo_disponible_aux' => $this->Saldo_Disponible(),      
      'saldo_disponible_fini' => number_format($this->Saldo_DisponibleFiniquito(), 2, ',','.'),
      'saldo_disponible_fini_aux' => $this->Saldo_DisponibleFiniquito(),
      'diferencia_AA' => number_format($this->Diferencia_Asignacion(), 2, ',','.'),
      'fecha_ultimo_anticipo' => $this->Fecha_Ultimo_Anticipo(),
      'embargos' => number_format($this->Embargos(), 2, ',','.'),
      'embargos_aux' => $this->Embargos(),
      'finiquito_embargo' => number_format($this->FiniquitoEmbargo(), 2, ',','.'),
      'finiquito_embargo_aux' => $this->FiniquitoEmbargo(),
      'porcentaje_cancelado' => number_format($this->Porcentaje_Cancelado(), 2, ',','.'),
      'monto_recuperar' => number_format($this->Monto_Recuperar(), 2, ',','.'),
      'monto_recuperar_aux' => $this->Monto_Recuperar(),
      'asignacion_diferencia' => number_format($this->Asignacion_Diferencia(), 2, ',','.'),
      'asignacion_diferencia_aux' => $this->Asignacion_Diferencia(),
      //'comision_servicios' => '0,00', se cambion para que mostrara el monto de comision de servicio
      'comision_servicios' => number_format($this->ComisionServicio(), 2, ',','.'),
      'comision_servicios_aux' => $this->ComisionServicio(),
      'fallecimiento_actoservicio' => number_format($this->Fallecimiento_Acto_Servicio(), 2, ',','.'),
      'fallecimiento_fueraservicio' => number_format($this->Fallecimiento_Fuera_Servicio(), 2, ',','.'),
      'fallecimiento_actoservicio_aux' => $this->Fallecimiento_Acto_Servicio(),
      'fallecimiento_fueraservicio_aux' => $this->Fallecimiento_Fuera_Servicio(),
      'interes_capitalizado_banco' => $this->Interes_Capitalizado_Banco(),
      'medida_judicial_activas' => number_format($this->MedidaJudicialActiva(), 2, ',','.'),
      'medida_judicial_activas_aux' => $this->MedidaJudicialActiva()
    );

    
    $this->Beneficiario->prima_transporte_aux = number_format($this->Beneficiario->prima_transporte, 2, ',','.');
    $this->Beneficiario->prima_descendencia_aux = number_format($this->Beneficiario->prima_descendencia, 2, ',','.');
    $this->Beneficiario->prima_especial_aux = number_format($this->Beneficiario->prima_especial, 2, ',','.');
    $this->Beneficiario->prima_noascenso_aux = number_format($this->Beneficiario->prima_noascenso, 2, ',','.');
    $this->Beneficiario->prima_tiemposervicio_aux = number_format($this->Beneficiario->prima_tiemposervicio, 2, ',','.');
    $this->Beneficiario->prima_profesionalizacion_aux = number_format($this->Beneficiario->prima_profesionalizacion, 2, ',','.');
    
  }


  function iniciarCalculosLote( MBeneficiario & $Beneficiario, $HistorialMovimiento, MDirectiva $Directiva, MPrima $Prima){
    $this->Beneficiario = $Beneficiario;
    $this->AntiguedadGrado();
    $this->TiempoServicios();
    $grado_codigo = $this->Beneficiario->grado_codigo;
    $antiguedad_grado = $this->Beneficiario->antiguedad_grado;
    if(isset($Directiva->Detalle[$grado_codigo . $antiguedad_grado]->sueldo_base)){
      $sueldo_base = $Directiva->Detalle[$grado_codigo . $antiguedad_grado]->sueldo_base;
    }else{
      $sueldo_base = $Directiva->Detalle[$grado_codigo . 'M']->sueldo_base;
    }
    
    $this->Beneficiario->sueldo_base = $sueldo_base;
    $Prima->calcular($Beneficiario);
    $this->Beneficiario->sueldo_global = $this->SueldoGlobal();
    $this->Beneficiario->HistorialMovimiento = $HistorialMovimiento[$this->Beneficiario->cedula];
    $this->AlicuotaAguinaldo();
    $this->AlicuotaVacaciones();
    $this->SueldoIntegral();
    $this->AsignacionAntiguedad();
    /**
    $this->Beneficiario->Calculo = array(
      'asignacion_antiguedad' => number_format($this->Beneficiario->asignacion_antiguedad, 2, ',','.'),
      'capital_banco' => number_format($this->DepositoBanco(), 2, ',','.'),
      'asignacion_depositada' => number_format($this->Asignacion_Depositada(), 2, ',','.'),
      'asignacion_depositada_aux' => $this->Asignacion_Depositada(),
      'fecha_ultimo_deposito' => $this->Fecha_Ultimo_Deposito(),
      'garantias' => number_format($this->Garantias(), 2, ',','.'),
      'dias_adicionales' => number_format($this->Dias_Adicionales(), 2, ',','.'),
      'total_aportados' => number_format($this->Total_Aportados(), 2, ',','.'),
      'saldo_disponible' => number_format($this->Saldo_Disponible(), 2, ',','.'),
      'saldo_disponible_aux' => $this->Saldo_Disponible(),
      'diferencia_AA' => number_format($this->Diferencia_Asignacion(), 2, ',','.'),
      'fecha_ultimo_anticipo' => $this->Fecha_Ultimo_Anticipo(),
      'anticipos' => number_format($this->Anticipos(), 2, ',','.'),
      'embargos' => number_format($this->Embargos(), 2, ',','.'),
      'porcentaje_cancelado' => number_format($this->Porcentaje_Cancelado(), 2, ',','.'),
      'monto_recuperar' => number_format($this->Monto_Recuperar(), 2, ',','.'),
      'monto_recuperar_aux' => $this->Monto_Recuperar(),
      'asignacion_diferencia' => number_format($this->Asignacion_Diferencia(), 2, ',','.'),
      'asignacion_diferencia_aux' => $this->Asignacion_Diferencia(),
      'comision_servicios' => '0,00',
      'fallecimiento_actoservicio' => number_format($this->Fallecimiento_Acto_Servicio(), 2, ',','.'),
      'fallecimiento_fueraservicio' => number_format($this->Fallecimiento_Fuera_Servicio(), 2, ',','.'),
      'fallecimiento_actoservicio_aux' => $this->Fallecimiento_Acto_Servicio(),
      'fallecimiento_fueraservicio_aux' => $this->Fallecimiento_Fuera_Servicio()
    );

    **/
    
  }


  /**
  * Obtener detalles del Cargo
  *
  * @access public
  * @return void
  */
  function obtenerID(){

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

    //$mesR = $mes; //$this->Beneficiario->mes_reconocido;
    
    $diaR = $dia - $this->Beneficiario->dia_reconocido; 
    
    //$diaR = $dia; // - $this->Beneficiario->dia_reconocido; 
    

    if($diaR < 0) {
      $mesR--;
      $diaR = 30 + $diaR;
    }
    
    if($mesR < 0){
      $anoR--;
      //$mesR = $mesR - 12; // Se cambio por estar calculando con un numero negativo resultado errado
      $mesR = 12 + $mesR;
    } 
   
    $fecha = $anoR .'-' . $mesR  . '-' . $diaR;

    $this->Beneficiario->fecha_ingreso_reconocida = $fecha;
    $anos = $this->__restarFecha($fecha, $this->Beneficiario->fecha_retiro);
    //n | e __restarFecha
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

    //print_r($arr);

    /**
    $ano_dif = $ano - $ano_r; //26 Porbar los tiempos    
    $mes_dif = $mes - $mes_r; //10   
    $dia_dif = $dia - $dia_r; //22
    
    if ($dia_dif < 0  || $mes_dif < 0) 
      $ano_dif--;

    $arr['n'] = $ano_dif;

       if($ant != TRUE){
      if($fecha_r != ''){
        if($mes_dif > -2 && $mes_dif < 0){
          $arr['n']++;

        }
      }
    } 
    
    if($fecha_r != ''){
      if($mes_dif < -5) { //MAYOR > 5meses
        $ano_dif++;
      }
    }
    $arr['e'] = $ano_dif;
    **/

    return $arr;

  }



  /**
  * Permite calular el tiempo en la antiguedad del cargo bajo la ultima fecha de ascenso
  *
  * @access public
  * @param Date
  * @return int
  */
  function AntiguedadGrado($fechaUltimoAscenso = ''){
    if(isset($this->Beneficiario)){
      $anos = $this->__restarFecha($this->Beneficiario->fecha_ultimo_ascenso, $this->Beneficiario->fecha_retiro, TRUE);
      $this->Beneficiario->antiguedad_grado = $anos['e'];
    }else{
      $anos = $this->__restarFecha($fechaUltimoAscenso);
      return $anos['e'];
    }
    
  }

  /**
  * Permite calular el tiempo en de servicio de una persona bajo su fecha de Ingreso
  *
  * @access public
  * @param Date
  * @param array
  * @return int
  */
  function TiempoServicios($fechaIngreso = '', $tiempoReconocido = array()){
    if(isset($this->Beneficiario)){
      if($this->Beneficiario->ano_reconocido != 0){
        $anos = $this->__fechaReconocida();
        $this->Beneficiario->tiempo_servicio = $anos['e'];
        $this->Beneficiario->tiempo_servicio_aux = $anos['n'];
      }else{
        $anos = $this->__restarFecha($this->Beneficiario->fecha_ingreso, $this->Beneficiario->fecha_retiro);
        $this->Beneficiario->tiempo_servicio = $anos['e'];
        $this->Beneficiario->tiempo_servicio_aux = $anos['n'];
      }      
    }else{
      $anos = $this->__restarFecha($fechaIngreso);
      return $anos['e'];
    }
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
    
    if(isset($this->Beneficiario) && ($this->Beneficiario->fecha_retiro == '')){
        $sueldo_global = $this->Beneficiario->sueldo_global;
        $cal =  round(((120 * $sueldo_global)/30)/12, 2);
        $this->Beneficiario->aguinaldos = $cal;
        $this->Beneficiario->aguinaldos_aux = number_format($cal, 2, ',','.');

      }else{ if($this->Beneficiario->fecha_retiro >= '2016-10-29' && $this->Beneficiario->fecha_retiro <= '2016-12-31'){
        $sueldo_global = $this->Beneficiario->sueldo_global;
        $cal =  round(((105 * $sueldo_global)/30)/12, 2);
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
      if(isset($this->Beneficiario) && ($this->Beneficiario->fecha_retiro == '' || $this->Beneficiario->fecha_retiro > '2016-12-31')){
            $sueldo_global = $this->Beneficiario->sueldo_global;
            $cal = round(((50 * $sueldo_global)/30)/12, 2);
            $this->Beneficiario->vacaciones = $cal; 
            $this->Beneficiario->vacaciones_aux = number_format($cal, 2, ',','.'); 


       }else if($this->Beneficiario->fecha_retiro <= '2016-12-31'){   
        $TM = $this->Beneficiario->tiempo_servicio;
          if ($TM > 0 && $TM <= 14) {
            $dia = 40;
          }else if($TM > 14 && $TM <= 24){
           $dia = 45;
          }else if($TM > 24){
            $dia = 50;
          }

        $sueldo_global = $this->Beneficiario->sueldo_global;
        $cal = round((($dia * $sueldo_global)/30)/12, 2);
        $this->Beneficiario->vacaciones = $cal; 
        $this->Beneficiario->vacaciones_aux = number_format($cal, 2, ',','.'); 


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
    if(isset($this->Beneficiario)){
      $sueldo_integral = $this->Beneficiario->sueldo_global + $this->Beneficiario->vacaciones + $this->Beneficiario->aguinaldos;
      $this->Beneficiario->sueldo_integral = $sueldo_integral;
      $this->Beneficiario->sueldo_integral_aux = number_format($sueldo_integral, 2, ',','.');
    }
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
    //$this->Beneficiario->asignacion_antiguedad_fin = $this->Beneficiario->sueldo_integral * $this->Beneficiario->tiempo_servicio_aux;
    $this->Beneficiario->asignacion_antiguedad = $this->Beneficiario->sueldo_integral * $this->Beneficiario->tiempo_servicio;
    $this->Beneficiario->asignacion_antiguedad_aux = number_format($this->Beneficiario->asignacion_antiguedad, 2, ',','.');
    return $this->Beneficiario->asignacion_antiguedad;
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
    //$this->Beneficiario->asignacion_antiguedad = $this->Beneficiario->sueldo_integral * $this->Beneficiario->tiempo_servicio;
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
  * Fecha del Ultimo deposito es tomada de la ultima garantia
  * CODIGO MOVIMIENTO: 32
  *
  * @access public
  * @return double
  */
  /**public function Fecha_Ultimo_Deposito(){
    $fecha = '';
    $fecha_aux = isset($this->Beneficiario->HistorialMovimiento[32]) ? $this->Beneficiario->HistorialMovimiento[32]->fecha : '';

    if($fecha_aux != ''){
      $f = explode('-', $fecha_aux);
      $fecha = $f[2] . '-' . $f[1] . '-' . $f[0];
    }else{
      $fecha_aux = isset($this->Beneficiario->HistorialMovimiento[3]) ? $this->Beneficiario->HistorialMovimiento[3]->fecha : '';
      if($fecha_aux != ''){  
        $f = explode('-', $fecha_aux);      
        $fecha = $f[2] . '-' . $f[1] . '-' . $f[0];  
      }
    }
    return $fecha;
  }**/

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

  /**
  * Garantias 
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
  * Dias Adiciaonales
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
    //if ($monto < 0) $monto = 0;
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
    //$resta = $this->AsignacionAntiguedad() - ($this->Asignacion_Depositada() + $this->Dias_Adicionales());
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
    //$resta = $this->AsignacionAntiguedad() - $this->Total_Aportados();
    $resta = $this->AsignacionFiniquito() - $this->Total_Aportados();
    $valor = $resta;
    //if($resta < 0) $valor = 0.00;

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


  public function Interes_Capitalizado_Banco(){
    $monto = isset($this->Beneficiario->HistorialMovimiento[10]) ? $this->Beneficiario->HistorialMovimiento[10]->monto : '0';
  
    return $monto;
  }

}